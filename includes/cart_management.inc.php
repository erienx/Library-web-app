<?php
require_once 'cart.inc.php';
require_once 'dbh.inc.php';


$action = $_POST['action'] ?? null;

if ($action === 'add') {
    $member_id = $_POST['member_id'];
    $book_id = $_POST['book_id'];
    add_to_cart($member_id, $book_id, $pdo);

    $referer = $_GET['redirect'] ?? '/library/';
    header("Location: " . $referer);
    die();
} elseif ($action === 'remove') {
    $member_id = $_POST['member_id'];
    $book_id = $_POST['book_id'];
    remove_from_cart($member_id, $book_id, $pdo);

    $referer = $_GET['redirect'] ?? '/library/';
    header("Location: " . $referer);
    die();
}
