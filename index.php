<?php
require_once './vendor/autoload.php';
require_once './includes/_functions.php';
include './includes/_db.php';

session_start();
generateToken();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/id.css">
    <title>Book Time - Connexion</title>
</head>

<body class="login basic-body">
    <header>
        <div class="header-container flex ai-center jc-center full-height">
            <div class="header-content flex ai-center">
                <img class="header-logo" src="./assets/img/light-bt-logo.png" alt="Book Time logo">
                <h1 class="header-title">Book<br>Time</h1>
            </div>
        </div>
    </header>
    <main>
        <section>
            <?= displayNotif() ?>
        </section>
        <section class="form-container flex column ai-center">
            <form id="loginForm" class="form-content flex column" method="post">
                <div class="inputs-container flex column">
                    <input class="text-input" type="email" name="email" placeholder="Adresse mail" required>
                    <input class="text-input" type="password" name="password" placeholder="Mot de passe" required>
                    <input type="hidden" name="action" value="login">
                    <input id="token" type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                </div>
                <input class="submit-input" type="submit" value="Se connecter">
            </form>
            <div class="link-container text-center">
                <p>Vous n'avez pas de compte ?<br><a href="./register.php">Inscrivez-vous</a></p>
            </div>
        </section>
    </main>

    <script type="module" src="assets/js/index.js"></script>
</body>

</html>