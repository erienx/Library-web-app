<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/config_session.inc.php';

$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 0) {
    header("Location: /library");
    die();
}

$current_url = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Book</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "php/header.php"; ?>

<div class="main-content">
    <div class="add-book-container">
        <div class="book-form">
            <h2>Add a book</h2>

    <form action="includes/admin_upload_book.inc.php?redirect=<?php echo urlencode($current_url); ?>" method="POST" enctype="multipart/form-data">
        <div class="input-container">
            <input type="text" id="book_title" name="book_title" required>
            <label for="book_title">Book Title</label>
        </div>

        <div class="input-container">
            <input type="text" id="book_author" name="book_author" required>
            <label for="book_author">Book Author</label>
        </div>

        <div class="input-container">
            <input type="text" id="book_publisher" name="book_publisher" required>
            <label for="book_publisher">Publisher</label>
        </div>

        <div class="input-container">
            <input type="text" id="book_category" name="book_category" required>
            <label for="book_category">Category</label>
        </div>


        <div class="input-container">
            <input type="number" id="pages" name="pages" min="1" required>
            <label for="pages">Number of Pages</label>
        </div>


        <div class="input-container">
            <input type="number" id="copies" name="copies" min="1" required>
            <label for="copies">Number of Copies</label>
        </div>

        <div class="date-container">
            <label for="publication_date">Publication Date</label>
            <input type="date" id="publication_date" name="publication_date" required>
        </div>

        <div class="file-container">
            <label for="cover_image">Book Cover</label>
            <input type="file" id="cover_image" name="cover_image" required>
        </div>

        <button type="submit" class="btn">Add Book</button>
    </form>
        </div></div>

    <?php if (!empty($success_message)): ?>
        <div class="success-message">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>
</div>

<?php include "php/footer.php"; ?>

<script src="js/main.js"></script>
<script src="js/success_message_fade.js"></script>
</body>
</html>
