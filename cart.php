<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/config_session.inc.php';


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
    <title>Search Results</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "php/header.php"; ?>


<div class="main-content">

    <div class="main-content-search">
        <?php
        require_once "includes/cart.inc.php";
        require_once 'includes/dbh.inc.php';
        require_once 'includes/book_queries.inc.php';

        if (!isset($_SESSION['user_id'])) {
            $books_id = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        }
        else {
            $books_id = get_books_in_cart($_SESSION['user_id'], $pdo);
        }
        if ($books_id) {
        $resultCount = count($books_id);

        echo "<h2 id ='orders'>".($resultCount === 1 ? "Book" : "Books") . " in your cart ("."$resultCount".")". "</h2>";

            if (isset($_SESSION['user_id'])){?>
            <form action="includes/commit_order.inc.php" method="POST" style="display:inline;">
                <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                <button type="submit" class="commit-order"">Commit order</button>
            </form>

        <?php
            }
        foreach ($books_id as $book_id) {


        if (isset($_SESSION['user_id'])) {
            $book = get_book_by_id($pdo, $book_id["book_id"]);
            $form_action = 'includes/cart_management.inc.php?redirect=' . urlencode($current_url);
        } else {
            $book = get_book_by_id($pdo, $book_id);
            $form_action = 'includes/cart_management_session.inc.php?redirect=' . urlencode($current_url);
        }
        ?>

        <div class="book-wrapper">
            <a href="book_details.php?id=<?php echo htmlspecialchars($book['book_id']); ?>" class="search-link">
                <div class="book-block">
                    <img src="/library/<?php echo htmlspecialchars($book['path_to_cover']); ?>" alt="Book Cover" class="book-image">
                    <div class="book-info">
                        <h2><?php echo htmlspecialchars($book['title']); ?></h2>
                        <h3><?php echo htmlspecialchars($book['author_name']); ?></h3>
                        <p><?php echo htmlspecialchars($book['description'] ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."); ?></p>
                    </div>
                        <form action="<?php echo $form_action; ?>" method="POST" class="cart-form">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($_SESSION['user_id'] ?? ''); ?>">
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>">
                            <button class="remove-btn material-symbols-outlined">delete</button>
                        </form>
                </div>
            </a>
        </div>
        <?php }
        } else {
            echo "<h2 id ='orders'>No books in cart</h2>";
        }

        ?>
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
