<?php
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $dbHost = $_ENV['DB_HOST'];
    $dbDatabase = $_ENV['DB_DATABASE'];
    $dbUser = $_ENV['DB_USER'];
    $dbPwd = $_ENV['DB_PWD'];

    $dsn = "mysql:host=$dbHost;dbname=$dbDatabase";
    $dbCo = new PDO($dsn, $dbUser, $dbPwd);
    $dbCo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die('Unable to connect to the database.' . $e->getMessage());
}