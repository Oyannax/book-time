<?php
require_once './vendor/autoload.php';
require_once './includes/_functions.php';
include './includes/_db.php';

// header('content-type:application/json');
session_start();

$contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

if ($contentType === 'application/json') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['action'])) throwAsyncError('Aucune action.');

    checkCSRFAsync($data);
    checkXSS($data);

    // REGISTER
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data['action'] === 'register' && isset($data['username']) && isset($data['email']) && isset($data['password']) && isset($data['passwordCheck'])) {
        // All fields completed?
        if (strlen($data['username']) <= 0) throwAsyncError('Veuillez saisir un nom d\'utilisateur.');
        if (strlen($data['email']) <= 0) throwAsyncError('Veuillez saisir une adresse mail.');
        if (strlen($data['password']) <= 0) throwAsyncError('Veuillez saisir un mot de passe.');
        if (strlen($data['passwordCheck']) <= 0 || $data['password'] !== $data['passwordCheck']) throwAsyncError('Veuillez confirmer le mot de passe.');

        // Valid email?
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        if (!isEmailValid($data['email'])) throwAsyncError('Veuillez saisir une adresse mail valide.');

        // Valid password?
        if (!isPwdValid($data['password'])) throwAsyncError('Veuillez saisir un mot de passe valide.');

        try {
            $query = $dbCo->prepare('SELECT user_email FROM profile WHERE user_email = :email;');
            $query->execute([
                'email' => $email
            ]);
            $result = $query->fetchAll();
            if (isset($result[0])) throwAsyncError('Cette adresse mail existe déjà.');

            $register = $dbCo->prepare('INSERT INTO profile (username, user_email, user_password) VALUES (:username, :email, :password);');
            $isRegisterOk = $register->execute([
                'username' => $data['username'],
                'email' => $email,
                'password' => password_hash($data['password'], PASSWORD_DEFAULT)
            ]);

            if ($isRegisterOk) {
                $_SESSION['id_profile'] = $dbCo->lastInsertId();
                throwAsyncMsg('Votre compte a été créé avec succès ! Redirection...');
            }
        } catch (Exception $e) {
            throwAsyncError('Une erreur s\'est produite lors de la création du compte. ' . $e->getMessage());
        }
    }


    // LOGIN
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data['action'] === 'login' && isset($data['email']) && isset($data['password'])) {
        // All fields completed?
        if (strlen($data['email']) <= 0) throwAsyncError('Veuillez saisir une adresse mail.');
        if (strlen($data['password']) <= 0) throwAsyncError('Veuillez saisir un mot de passe.');

        try {
            $login = $dbCo->prepare('SELECT id_profile, user_password FROM profile WHERE user_email = :email;');
            $isLoginOk = $login->execute([
                'email' => $data['email']
            ]);

            if ($isLoginOk) {
                $result = $login->fetchAll();

                // Existing account?
                if (!isset($result[0])) throwAsyncError('Cette adresse mail n\'existe pas.');
                if (!password_verify($data['password'], $result[0]['user_password'])) throwAsyncError('Votre mot de passe est incorrect.');

                // If yes
                $_SESSION['id_profile'] = $result[0]['id_profile'];
                throwAsyncMsg('Vous êtes bien connecté(e) ! Redirection...');
            }
        } catch (Exception $e) {
            throwAsyncError('Une erreur s\'est produite lors de la connexion au compte. ' . $e->getMessage());
        }
    }
} else if (strpos($contentType, 'multipart/form-data') !== false) {
    $formData = $_POST;

    // ADD
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $formData['action'] === 'add' && isset($formData['title'])) {
        // All fields completed?
        if (strlen($formData['title']) <= 0) {
            header('content-type:application/json');
            throwAsyncError('Veuillez saisir le titre du livre.');
        }
        if (!isset($formData['status'])) {
            header('content-type:application/json');
            throwAsyncError('Veuillez définir le statut du livre.');
        }

        // Valid image upload?
        if (!empty($_FILES['image']['tmp_name'][0])) {

            $filePath = $_FILES['image']['tmp_name'];
            $fileSize = filesize($filePath);
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileType = finfo_file($fileInfo, $filePath);

            if ($fileSize === 0) {
                header('content-type:application/json');
                throwAsyncError('Le fichier est vide.');
            }

            if ($fileSize > 3145728) {
                header('content-type:application/json');
                throwAsyncError('Le fichier est trop volumineux.');
            }

            $allowedTypes = [
                'image/png' => 'png',
                'image/jpeg' => 'jpg'
            ];

            if (!in_array($fileType, array_keys($allowedTypes))) {
                header('content-type:application/json');
                throwAsyncError('Fichier non autorisé.');
            }
        }

        // Valid ISBN?
        if (strlen($formData['isbn']) > 0) {
            if (!preg_match('@(?=.*\d).{13}|(?=.*\d).{10}@', $formData['isbn'])) {
                header('content-type:application/json');
                throwAsyncError('Votre ISBN doit comporter soit 10 ou 13 chiffres.');
            }
        }

        // Valid size?
        if (strlen($formData['size']) > 0) {
            if (!preg_match('@(?=.*\d).{1,}@', $formData['size'])) {
                header('content-type:application/json');
                throwAsyncError('Veuillez saisir un nombre de pages.');
            }
        }

        // Valid status?
        $allowedStatus = [
            'En train de lire' => 'reading',
            'À lire' => 'to-read',
            'Liste de souhaits' => 'wish',
            'Préféré' => 'favorite',
            'En pause' => 'on-pause',
            'Abandonné' => 'abandoned',
            'Lu' => 'read'
        ];

        if (!in_array($formData['status'], array_values($allowedStatus))) {
            header('content-type:application/json');
            throwAsyncError('Statut inconnu.');
        }

        $dbCo->beginTransaction();

        try {
            $query1 = $dbCo->prepare('INSERT INTO book (book_title, book_summary) VALUES (:title, :summary);');
            $query1->execute([
                'title' => $formData['title'],
                'summary' => $formData['summary']
            ]);
            $idBook = $dbCo->lastInsertId();

            $query2 = $dbCo->prepare('INSERT INTO author (author_name) VALUES (:author);');
            $query2->execute([
                'author' => $formData['author']
            ]);
            $idAuthor = $dbCo->lastInsertId();

            $query3 = $dbCo->prepare('INSERT INTO writing (Id_book, Id_author) VALUES (:book, :author);');
            $query3->execute([
                'book' => $idBook,
                'author' => $idAuthor
            ]);

            $query4 = $dbCo->prepare('INSERT INTO editor (editor_name) VALUES (:editor);');
            $query4->execute([
                'editor' => $formData['editor']
            ]);
            $idEditor = $dbCo->lastInsertId();

            $query5 = $dbCo->prepare('INSERT INTO edition (book_ISBN, book_size, book_cover, Id_editor, Id_book) VALUES (:isbn, :size, :image, :editor, :book);');
            $query5->execute([
                'isbn' => $formData['isbn'],
                'size' => $formData['size'],
                'image' => $_FILES['image']['tmp_name'],
                'editor' => $idEditor,
                'book' => $idBook
            ]);
            $idEdition = $dbCo->lastInsertId();

            $query6 = $dbCo->prepare('INSERT INTO reading (Id_edition, Id_profile) VALUES (:edition, :profile);');
            $query6->execute([
                'edition' => $idEdition,
                'profile' => $_SESSION['id_profile']
            ]);

            $query7 = $dbCo->prepare('INSERT INTO list (list_name, Id_profile) VALUES (:status, :profile);');
            $query7->execute([
                'status' => array_search($formData['status'], $allowedStatus),
                'profile' => $_SESSION['id_profile']
            ]);
            $idList = $dbCo->lastInsertId();

            $query8 = $dbCo->prepare('INSERT INTO grouping_ (Id_edition, Id_list) VALUES (:edition, :list);');
            $query8->execute([
                'edition' => $idEdition,
                'list' => $idList
            ]);

            $dbCo->commit();

            header('content-type:application/json');
            throwAsyncMsg('Livre ajouté avec succès ! Redirection...');
        } catch (Exception $e) {
            $dbCo->rollBack();

            header('content-type:application/json');
            throwAsyncError('Une erreur s\'est produite lors du traitement du formulaire. ' . $e->getMessage());
        }
    }
}
