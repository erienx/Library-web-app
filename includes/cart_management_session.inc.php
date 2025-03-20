<?php
require_once "config_session.inc.php";
$action = $_POST['action'] ?? null;

if ($action === 'add') {
    $book_id = $_POST['book_id'];
    array_push($_SESSION['cart'], $book_id);

    $referer = $_GET['redirect'] ?? '/library/';
    header("Location: " . $referer);
    die();
} elseif ($action === 'remove') {
    $book_id = $_POST['book_id'];

    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value == $book_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    $referer = $_GET['redirect'] ?? '/library/';
    header("Location: " . $referer);
    die();
}
