<?php
require_once './vendor/autoload.php';
require_once './includes/_functions.php';
include './includes/_db.php';

header('content-type:application/json');
$data = json_decode(file_get_contents('php://input'), true);

session_start();
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
        throwAsyncError('Une erreur s\'est produite lors de la création du compte.' . $e->getMessage());
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
        throwAsyncError('Une erreur s\'est produite lors de la connexion au compte.' . $e->getMessage());
    }
}


// ADD
else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data['action'] === 'add' && isset($data['title'])) {
    // All fields completed?
    if (strlen($data['title']) <= 0) throwAsyncError('Veuillez saisir le titre du livre.');

    // Valid image upload?
    // if (strlen($data['cover']) > 0) {
    //     if (!isset($_FILES['image'])) throwAsyncError('Aucun fichier trouvé.');

    //     $filePath = $_FILES['image']['tmp_name'];
    //     $fileSize = filesize($filePath);
    //     $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    //     $fileType = finfo_file($fileInfo, $filePath);
    // };

    // Valid ISBN?
    if (strlen($data['isbn']) > 0) {
        if (!preg_match('@(?=.*\d).{13}|(?=.*\d).{10}@', $data['isbn'])) throwAsyncError('Votre ISBN doit comporter soit 10 ou 13 chiffres.');
    };
}
