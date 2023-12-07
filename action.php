<?php
require_once './vendor/autoload.php';
require_once './includes/_functions.php';
include './includes/_db.php';

session_start();
if (!isset($_REQUEST['action'])) addErrorAndExit('Aucune action.', 'index.php');

checkCSRF('index.php');
checkXSS($_REQUEST);