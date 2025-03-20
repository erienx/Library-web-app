<?php
require_once 'includes/config_session.inc.php';
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=admin_panel_settings,check_box,delete,orders,shopping_cart" />

<div class="top-section">
    <h1><a href="/library" class="logo" id="logo">Book a Book</a></h1>

    <div class="auth-links">
        <?php if (!isset($_SESSION['user_id'])) { ?>
            <a href="cart.php">
                <div class="cart-wrapper">
                    <button class="shopping-cart-btn material-symbols-outlined">shopping_cart</button>
                    <?php
                    $cart_items=0;
                    if (isset($_SESSION['cart'])) {
                        $cart_items = count($_SESSION['cart']);
                    }
                    if ($cart_items>9) {?>
                        <span class="cart-count">9+</span>
                    <?php }else{
                    ?>
                    <span class="cart-count"><?php echo $cart_items; ?></span>
                    <?php }?>
                </div>
            </a>
            <a href="/library/login.php" class="login-link">Log in</a>
            <a href="/library/register.php" class="register-link">Sign up</a>
        <?php } else {
            if ($_SESSION['is_admin'] == 1) { ?>
                <div class="admin-btn-container">
                    <button class="admin-btn material-symbols-outlined" id="admin-btn">admin_panel_settings</button>
                    <div class="dropdown-content" id="admin-dropdown">
                        <a href="/library/admin_orders.php">Manage orders</a>
                        <a href="/library/admin_upload_book.php">Add a book</a>
                    </div>
                </div>
            <script src="/library/js/dropdown.js"></script>
            <?php } ?>
            <a href="cart.php">
                <div class="cart-wrapper">
                    <button class="shopping-cart-btn material-symbols-outlined">shopping_cart</button>
                    <?php
                    require_once 'includes/cart.inc.php';
                    require_once 'includes/dbh.inc.php';
                    $cart_items=get_cart_items($_SESSION['user_id'], $pdo);
                    if ($cart_items>9) {?>
                        <span class="cart-count">9+</span>
                    <?php }else{
                        ?>
                        <span class="cart-count"><?php echo $cart_items; ?></span>
                    <?php }?>
                </div>
            </a>
            <a href="orders.php">
                <button class="shopping-cart-btn material-symbols-outlined">orders</button>
            </a>
            <a href="/library/includes/logout.inc.php" class="logout-link">Log out</a>
        <?php } ?>
    </div>
</div>

