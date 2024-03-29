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
    <link rel="stylesheet" href="./assets/css/tabs.css">
    <title>Book Time - Liste de lecture</title>
</head>

<body class="basic-body">
    <header>
        <div class="header-container flex column full-height">
            <div class="header-content flex jc-center fit-height">
                <img class="header-logo" src="./assets/img/light-bt-logo.png" alt="Book Time logo">
                <h1 class="header-title flex ai-center">Book<br>Time</h1>
            </div>
            <?php
            $query = $dbCo->prepare('SELECT username FROM profile WHERE id_profile = :id');
            $query->execute([
                'id' => $_SESSION['id_profile']
            ]);
            $username = $query->fetchColumn();
            ?>
            <h2 class="header-text">Bienvenue <?= $username ?> !</h2>
        </div>
        <div class="logout-icon absol fit-width">
            <a href="./action.php?action=logout&token=<?= $_SESSION['token'] ?>"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </div>
    </header>
    <main class="books-main flex column">
        <section>
            <?= displayNotif() ?>
        </section>
        <section class="reading-books flex column">
            <div class="carousel-container flex column device-width">
                <div class="carousel-content over-hidden">
                    <div class="slide-container flex fit-width padding">
                        <a href="./add.php?status=reading">
                            <div class="slide add-slide flex ai-end jc-between column">
                                <div class="add-descr flex column full-width">
                                    <h3 class="add-title">Ajouter un livre</h3>
                                    <p class="add-text">Quel livre avez-vous lu aujourd'hui ?</p>
                                </div>
                                <i class="add-icon text-center fa-solid fa-plus"></i>
                            </div>
                        </a>
                        <div class="slide book-slide">
                            <div class="bar-container relat over-hidden">
                                <div class="progress-bar inactive"></div>
                                <div class="active-bar-container flex relat">
                                    <div class="progress-bar active"></div>
                                    <i class="bookmark-icon relat fa-solid fa-bookmark"></i>
                                </div>
                            </div>
                            <div class="book-descr flex column">
                                <h3 class="book-title over-hidden">The Hunger Games</h3>
                                <div class="info-container flex">
                                    <img class="book-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover">
                                    <p class="book-author">Suzanne Collins</p>
                                </div>
                            </div>
                        </div>
                        <div class="slide book-slide">
                            <div class="bar-container relat over-hidden">
                                <div class="progress-bar inactive"></div>
                                <div class="active-bar-container flex relat">
                                    <div class="progress-bar active"></div>
                                    <i class="bookmark-icon relat fa-solid fa-bookmark"></i>
                                </div>
                            </div>
                            <div class="book-descr flex column">
                                <h3 class="book-title over-hidden">The Hunger Games</h3>
                                <div class="info-container flex">
                                    <img class="book-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover">
                                    <p class="book-author">Suzanne Collins</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="controls-container flex jc-around">
                    <button id="prev" class="arrow prev" type="button" disabled>
                        <i class="fa-solid fa-angle-left"></i>
                    </button>
                    <ul class="dot-container flex">
                        <li class="dot"></li>
                        <li class="dot"></li>
                        <li class="dot"></li>
                    </ul>
                    <button id="next" class="arrow next" type="button">
                        <i class="fa-solid fa-angle-right"></i>
                    </button>
                </div>
            </div>
            <div class="reading-container padding">
                <div class="reading-content flex ai-center jc-between border">
                    <div class="reading-descr">
                        <h4 class="reading-title">Vous lisez <span>2</span> livres.</h4>
                        <p>Plus</p>
                    </div>
                    <ul class="book-covers flex">
                        <li class="first"><img class="small-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                        <li class="next"><img class="small-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="books-section flex column">
            <div class="section-header flex ai-center jc-between padding">
                <div class="section-title">
                    <h4>À lire</h4>
                    <div class="highlight"></div>
                </div>
                <p>Plus</p>
            </div>
            <div class="to-read-container flex column ai-center device-width">
                <div class="to-read-content flex device-width over-hidden">
                    <ul class="to-read-covers flex">
                        <a href="./add.php?status=to-read">
                            <li class="add-cover flex ai-center jc-center">
                                <i class="add-icon text-center fa-solid fa-plus"></i>
                            </li>
                        </a>
                        <li><img class="medium-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                        <li><img class="medium-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                        <li><img class="medium-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                        <li><img class="medium-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                        <li><img class="medium-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                    </ul>
                </div>
                <div class="highlight"></div>
            </div>
        </section>
        <section class="books-section flex column">
            <div class="section-header flex ai-center jc-between padding">
                <div class="section-title">
                    <h4>Listes</h4>
                    <div class="highlight"></div>
                </div>
                <p>Plus</p>
            </div>
            <div class="list-container device-width over-hidden">
                <div class="lists flex fit-width padding">
                    <div class="list-content flex column jc-between border">
                        <ul class="book-covers flex">
                            <li class="first"><img class="small-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                        </ul>
                        <div>
                            <h4 class="list-title">Liste de souhaits</h4>
                            <p><span>1</span> livre</p>
                        </div>
                    </div>
                    <div class="list-content flex column jc-between border">
                        <ul class="book-covers flex">
                            <li class="first"><img class="small-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                            <li class="next"><img class="small-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                            <li class="next"><img class="small-cover" src="./assets/img/the-hunger-games.jpg" alt="The Hunger Games book cover"></li>
                        </ul>
                        <div>
                            <h4 class="list-title">Préférés</h4>
                            <p><span>4</span> livres</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="stop-section flex column">
            <div class="padding">
                <div class="stop-content flex ai-center jc-between border">
                    <div class="stop-descr">
                        <h4 class="stop-title">Livres en pause</h4>
                        <p><span>3</span> livres</p>
                    </div>
                    <i class="stop-icon fa-solid fa-pause"></i>
                </div>
            </div>
            <div class="padding">
                <div class="stop-content flex ai-center jc-between border">
                    <div class="stop-descr">
                        <h4 class="stop-title">Livres abandonnés</h4>
                        <p><span>0</span> livre</p>
                    </div>
                    <i class="stop-icon fa-regular fa-flag"></i>
                </div>
            </div>
        </section>
    </main>
    <script src="./assets/js/books.js"></script>
</body>

</html>