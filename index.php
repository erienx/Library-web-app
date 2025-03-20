<?php
require_once 'includes/config_session.inc.php';
$success_message = "";
if (isset($_SESSION['success_message'])) {
$success_message = $_SESSION['success_message'];
unset($_SESSION['success_message']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Library</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=arrow_forward" />
    <link rel="stylesheet" type = "text/css" href="css/style.css">
</head>
<body>
    <?php include "php/header.php"?>



    <div class = "main-content">
        <section class="search-section">
            <?php include"php/search_bar.php"?>
        </section>

        <section class="banner-section">
            <div class="banner-content">
                <div class="banner-text-wrapper">
                    <h2 class="banner-text">
                        <span class="ignite-text">Ignite Your</span>
                        <span class="imagination-text">Imagination</span>
                    </h2>
                    <div class="banner-books">
                        <img src="images/book.svg" alt="Book" class="book book-1">
                        <img src="images/book_opt1.svg" alt="Book" class="book book-2">
                        <img src="images/book_opt2.svg" alt="Book" class="book book-3">
                    </div>
                </div>
            </div>
            <div class="banner-image">
                <img src="images/img1.jpg" alt="Library Banner" class="banner-img">
                <img src="images/img2.jpg" alt="Library Banner" class="banner-img">
                <img src="images/img3.jpg" alt="Library Banner" class="banner-img">
            </div>
        </section>


        <?php include"php/slider_top.php"?>

        <?php include"php/slider_newest.php"?>

        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php include "php/footer.php" ?>

    <script src="js/main.js"></script>
    <script src="js/search.js"></script>
    <script src="js/slider.js"></script>
    <script src="js/success_message_fade.js"></script>
    <script src="js/rotate_img.js"></script>
</body>
</html>