<?php
require_once './vendor/autoload.php';
require_once './includes/_functions.php';
include './includes/_db.php';

session_start();
generateToken();

if (!isset($_SESSION['id_profile'])) addErrorAndExit('Veuillez vous identifier.', 'index.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/add.css">
    <title>Book Time - Ajouter un livre</title>
</head>

<body class="add flex column">
    <header>
        <h1 class="header-text">Ajouter un livre</h1>
    </header>
    <main class="flex column">
        <section>
            <?= displayNotif() ?>
        </section>
        <section class="">
            <form id="addForm" class="form-content flex column ai-center full-width" action="" method="post" enctype="multipart/form-data">
                <label id="imgContainer" class="file-input flex ai-center jc-center relat border">
                    <i id="imgIcon" class="image-icon fa-solid fa-image"></i>
                    <div class="camera-container flex absol">
                        <i class="camera-icon fa-solid fa-camera"></i>
                    </div>
                    <input id="fileInput" class="hidden" type="file" name="image" accept="image/png, image/jpeg">
                </label>
                <div class="inputs-container flex column full-width">
                    <label class="input-content flex column">
                        Titre
                        <input class="text-input" type="text" name="title" required>
                    </label>
                    <label class="input-content flex column">
                        Auteur
                        <input class="text-input" type="text" name="author">
                    </label>
                    <label class="input-content flex column">
                        Éditeur
                        <input class="text-input" type="text" name="editor">
                    </label>
                    <label class="input-content flex column">
                        ISBN
                        <input class="text-input" type="text" name="isbn" title="votre ISBN doit comporter soit 10 ou 13 chiffres" pattern="(?=.*\d).{13}|(?=.*\d).{10}">
                    </label>
                    <label class="input-content flex column">
                        Total de pages
                        <input class="text-input" type="number" name="size">
                    </label>
                    <label class="input-content flex column">
                        Résumé
                        <textarea class="text-input" name="summary" rows="6"></textarea>
                    </label>
                    <label class="input-content flex column">
                        Statut
                        <div>
                            <label class="">
                                En train de lire
                                <input class="hidden" type="radio" name="" value="reading">
                            </label>
                            <label class="">
                                À lire
                                <input class="hidden" type="radio" name="" value="to-read">
                            </label>
                            <label class="">
                                Liste de souhaits
                                <input class="hidden" type="radio" name="" value="wish">
                            </label>
                            <label class="">
                                Préféré
                                <input class="hidden" type="radio" name="" value="favorite">
                            </label>
                            <label class="">
                                En pause
                                <input class="hidden" type="radio" name="" value="on-pause">
                            </label>
                            <label class="">
                                Abandonné
                                <input class="hidden" type="radio" name="" value="abandoned">
                            </label>
                            <label class="">
                                Lu
                                <input class="hidden" type="radio" name="" value="read">
                            </label>
                        </div>
                    </label>
                    <input type="hidden" name="action" value="add">
                    <input id="token" type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                </div>
                <label class="fixed-button save flex ai-center">
                    <i class="icon fa-solid fa-check"></i>
                    <input class="fixed-content" type="submit" value="Sauvegarder">
                </label>
            </form>
            <a href="./books.php">
                <div class="fixed-button back flex ai-center">
                    <i class="icon fixed-content fa-solid fa-arrow-left"></i>
                </div>
            </a>
        </section>
    </main>

    <script type="module" src="assets/js/add.js"></script>
</body>

</html>