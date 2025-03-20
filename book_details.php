<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/book_queries.inc.php';
require_once 'includes/config_session.inc.php';

$book_id = $_GET['id'] ?? null;
if (!$book_id || !is_numeric($book_id)) {
    die("Invalid book ID.");
}

$book = get_book_by_id($pdo, (int)$book_id);
if (!$book) {
    die("book not found.");
}
$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$current_url = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "php/header.php"; ?>
<div class="main-content">
    <div class="main-content-book">
        <div class="book-details-container">
            <div class="book-cover">
                <img src="<?php echo '/library' . htmlspecialchars($book['path_to_cover']); ?>" alt="Book Cover">
            </div>
            <div class="book-details-left">
                <h1><?php echo htmlspecialchars($book['title']); ?></h1>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author_name']); ?></p>
                <p><strong>Publisher:</strong> <?php echo htmlspecialchars($book['publisher_name']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($book['category_name']); ?></p>
                <p><strong>Publication Date:</strong> <?php echo htmlspecialchars($book['publication_date']); ?></p>
                <p><strong>Pages:</strong> <?php echo htmlspecialchars($book['pages']); ?></p>
                <p><strong>Rented Count:</strong> <?php echo htmlspecialchars($book['rented_count']); ?></p>
                <p><strong>Available Copies:</strong> <?php echo htmlspecialchars($book['available_copies']); ?>
                    / <?php echo htmlspecialchars($book['total_copies']); ?></p>
                <p class="description"><strong>Description:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing
                    elit.</p>
            </div>
            <div class="book-details-right">
                <div class="availability">
                    <?php if ($book['available_copies'] > 0) { ?>
                        <p class="available">Book is available</p>
                    <?php } else { ?>
                        <p class="unavailable">Book is unavailable</p>
                    <?php } ?>
                </div>
                <p class="price"><strong>Price:</strong> $9.99</p>
                <?php
                if (isset($_SESSION['user_id'])) {
                    require_once 'includes/cart.inc.php';
                    if (is_book_in_cart($_SESSION['user_id'], $book_id, $pdo)) {
                        ?>
                        <form action="includes/cart_management.inc.php?redirect=<?php echo urlencode($current_url); ?>"
                              method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="member_id"
                                   value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                            <input type="hidden" name="book_id"
                                   value="<?php echo htmlspecialchars($book['book_id']); ?>">
                            <button type="submit" class="add-to-cart">Remove from Cart</button>
                        </form>
                        <?php
                    } else {
                        ?>
                        <form action="includes/cart_management.inc.php?redirect=<?php echo urlencode($current_url); ?>"
                              method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="member_id"
                                   value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                            <input type="hidden" name="book_id"
                                   value="<?php echo htmlspecialchars($book['book_id']); ?>">
                            <button type="submit" class="add-to-cart">Add to Cart</button>
                        </form>
                        <?php
                    }
                } else {
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }
                    $is_book_in_cart = in_array($book_id, $_SESSION['cart']);
                    if ($is_book_in_cart) { ?>
                        <form action="includes/cart_management_session.inc.php?redirect=<?php echo urlencode($current_url); ?>"
                              method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="book_id"
                                   value="<?php echo htmlspecialchars($book['book_id']); ?>">
                            <button type="submit" class="add-to-cart">Remove from Cart</button>
                        </form>
                    <?php } else {
                        ?>
                        <form action="includes/cart_management_session.inc.php?redirect=<?php echo urlencode($current_url); ?>"
                              method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="book_id"
                                   value="<?php echo htmlspecialchars($book['book_id']); ?>">
                            <button type="submit" class="add-to-cart">Add to Cart</button>
                        </form>
                    <?php }
                }
                ?>

            </div>
        </div>
    </div>
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
