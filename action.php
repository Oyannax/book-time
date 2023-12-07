<?php
require_once './vendor/autoload.php';
require_once './includes/_functions.php';
include './includes/_db.php';

session_start();
if (!isset($_REQUEST['action'])) addErrorAndExit('Aucune action.', 'index.php');

checkCSRF('index.php');
checkXSS($_REQUEST);

// REGISTER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_REQUEST['action'] === 'register' && isset($_REQUEST['username']) && isset($_REQUEST['email']) && isset($_REQUEST['password']) && isset($_REQUEST['password-check'])) {
    // All fields completed?
    if (strlen($_REQUEST['username']) === 0) addErrorAndExit('Veuillez saisir un nom d\'utilisateur.', 'register.php');
    if (strlen($_REQUEST['email']) === 0) addErrorAndExit('Veuillez saisir une adresse mail.', 'register.php');
    if (strlen($_REQUEST['password']) === 0) addErrorAndExit('Veuillez saisir un mot de passe.', 'register.php');
    if (strlen($_REQUEST['password-check']) === 0 || $_REQUEST['password'] !== $_REQUEST['password-check']) addErrorAndExit('Veuillez confirmer le mot de passe.', 'register.php');

    // Valid email?
    $email = filter_var($_REQUEST['email'], FILTER_SANITIZE_EMAIL);
    $atPos = mb_strpos($email, '@');
    $domain = mb_substr($email, $atPos + 1);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !checkdnsrr($domain . '.', 'MX')) addErrorAndExit('Veuillez saisir une adresse mail valide.', 'register.php');

    // Valid password?
    if (!checkPwdFormat($_REQUEST['password'])) addErrorAndExit('Veuillez saisir un mot de passe valide.', 'register.php');

    try {
        $query = $dbCo->prepare('SELECT user_email FROM profile;');
        $query->execute();
        $result = $query->fetchAll();
        foreach ($result as $i) {
            if ($i['user_email'] === $email) addErrorAndExit('Cette adresse mail existe déjà.', 'register.php');
        }

        $register = $dbCo->prepare('INSERT INTO profile (username, user_email, user_password) VALUES (:username, :email, :password);');
        $isRegisterOk = $register->execute([
            'username' => $_REQUEST['username'],
            'email' => $email,
            'password' => password_hash($_REQUEST['password'], PASSWORD_DEFAULT)
        ]);

        if ($isRegisterOk) {
            addMsg('Votre compte a été créé avec succès !');
            $_SESSION['id_profile'] = $dbCo->lastInsertId();
        }
    } catch (Exception $e) {
        addErrorAndExit('Une erreur s\'est produite lors de la création du compte' . $e->getMessage(), 'register.php');
    }
}

header('Location: books.php');
