<?php
require_once './vendor/autoload.php';
require_once './includes/_functions.php';
include './includes/_db.php';

session_start();
if (!isset($_REQUEST['action'])) addErrorAndExit('Aucune action.', 'index.php');

checkCSRF('index.php');
checkXSS($_REQUEST);

// LOGOUT
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_REQUEST['action'] === 'logout') {
    unset($_SESSION['id_profile']);
    addMsg('Vous êtes déconnecté(e).');
    header('Location: index.php');
    exit;
}
