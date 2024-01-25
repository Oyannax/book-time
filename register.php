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
    <title>Book Time - Inscription</title>
</head>

<body class="register basic-body">
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
            <form id="registerForm" class="form-content flex column" action="" method="post">
                <div class="inputs-container flex column">
                    <input class="text-input" type="text" name="username" placeholder="Nom d'utilisateur" required>
                    <input class="text-input" type="email" name="email" placeholder="Adresse mail" required>
                    <input class="text-input" type="password" name="password" placeholder="Mot de passe" title="au moins 8 caractères, dont un chiffre, une majuscule et une minuscule" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                    <input class="text-input" type="password" name="password-check" placeholder="Confirmez le mot de passe" required>
                    <input type="hidden" name="action" value="register">
                    <input id="token" type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                </div>
                <input class="submit-input" type="submit" value="S'inscrire">
            </form>
            <div class="link-container text-center">
                <p>Vous avez un compte ?<br><a href="./index.php">Connectez-vous</a></p>
            </div>
        </section>
    </main>

    <script type="module" src="assets/js/register.js"></script>
</body>

</html>