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
    <title>User's orders</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "php/header.php";
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 0) {
    header("Location: /library");
    die();
}
?>

<div class="main-content">
    <section class="search-section">
    <?php include "php/admin_search_bar.php"; ?>
    </section>
        <?php
        if (isset($_GET['search'])) {
            require_once "includes/validations.inc.php";
            $user_email = $_GET['search'];

            $user_id = get_user_id($pdo, $user_email);
            if (!$user_id){
                echo "<h2 id='orders'>Member not found</h2>";
            }
            else{

            require_once 'includes/orders.inc.php';
            require_once 'includes/book_queries.inc.php';

            $orders = get_user_orders($user_id, $pdo);
            echo "<h2 id ='orders''>" . (count($orders) > 0 ? "Orders" : "No orders so far") . "</h2>"; ?>
            <div class="order-container">
                <?php
                usort($orders, function ($a, $b) {
                    $status_order = ['ordered' => 1, 'rented' => 2, 'completed' => 3];
                    return $status_order[strtolower($a['status'])] <=> $status_order[strtolower($b['status'])];
                });

                $current_status = '';
                foreach ($orders as $order) {
                    $status = strtolower($order['status']);
                    if ($status !== $current_status) {
                        $current_status = $status;
                        echo "<h3 class='status-header'>" . ucfirst($status) . "</h3>";
                    }

                    $books = get_books_in_order($order['order_id'], $pdo);

                    ?>
                    <div class='order-block <?php echo $status ?>'>
                        <?php if ($status === 'ordered') { ?>
                            <form action="includes/remove_order.inc.php?redirect=<?php echo urlencode($current_url); ?>" method="POST" style="display:inline;">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                <button class='remove-btn material-symbols-outlined'>delete</button>
                            </form>
                            <form action="includes/admin_push_order.inc.php?redirect=<?php echo urlencode($current_url); ?>" method="POST" style="display:inline;">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                <input type="hidden" name="current_status" value="ordered">
                                <button class='remove-btn check-btn material-symbols-outlined'>check_box</button>
                            </form>
                        <?php }else if ($status === 'rented') {?>
                            <form action="includes/admin_push_order.inc.php?redirect=<?php echo urlencode($current_url); ?>" method="POST" style="display:inline;">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                <input type="hidden" name="current_status" value="rented">
                                <button class='remove-btn check-btn material-symbols-outlined'>check_box</button>
                            </form>
                        <?php
                        }
                        ?>
                        <div class='order-header'>
                            <h3>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h3>
                            <p>Status: <?php echo ucfirst($order['status']); ?></p>
                            <p>Ordered: <?php echo htmlspecialchars($order['created_at']); ?></p>

                            <?php if ($status === 'rented'): ?>
                                <p>Rented: <?php echo htmlspecialchars($order['rented_at']); ?></p>
                            <?php elseif ($status === 'completed'): ?>
                                <p>Completed: <?php echo htmlspecialchars($order['completed_at']); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class='order-books'>
                            <?php foreach ($books as $book_item) {
                                $book = get_book_by_id($pdo, $book_item['book_id']);
                                echo "
                                <div class='book-block'>
                                    <img src='/library/" . htmlspecialchars($book['path_to_cover']) . "' alt='Book Cover' class='book-image'>
                                    <div class='book-info'>
                                        <h4>" . htmlspecialchars($book['title']) . "</h4>
                                        <p>By: " . htmlspecialchars($book['author_name']) . "</p>
                                        <p>Category: " . htmlspecialchars($book['category_name']) . "</p>
                                    </div>
                                </div>";
                            } ?>
                        </div>
                    </div>
                    <?php
                }
            }
                ?>
            <?php
        } else {
            echo "<p>Please enter a search query to view orders.</p>";
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
<script src="js/admin_search.js"></script>
<script src="js/success_message_fade.js"></script>
</body>
</html>
