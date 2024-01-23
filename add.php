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
        </section>
        <section class="">
            <form id="addForm" class="form-content flex column ai-center full-width" action="" method="post">
                <label class="file-input flex ai-center jc-center relat border">
                    <i class="image-icon fa-solid fa-image"></i>
                    <div class="camera-container flex absol">
                        <i class="camera-icon fa-solid fa-camera"></i>
                    </div>
                    <input class="hidden" type="file" name="">
                </label>
                <div class="inputs-container flex column full-width">
                    <label class="input-content flex column">
                        Titre
                        <input class="text-input" type="text" name="">
                    </label>
                    <label class="input-content flex column">
                        Auteur
                        <input class="text-input" type="text" name="">
                    </label>
                    <label class="input-content flex column">
                        Éditeur
                        <input class="text-input" type="text" name="">
                    </label>
                    <label class="input-content flex column">
                        ISBN
                        <input class="text-input" type="text" name="">
                    </label>
                    <label class="input-content flex column">
                        Total de pages
                        <input class="text-input" type="text" name="">
                    </label>
                    <label class="input-content flex column">
                        Résumé
                        <textarea class="text-input" type="text" name="" rows="6"></textarea>
                    </label>
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
</body>

</html>