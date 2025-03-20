<?php
require_once 'config_session.inc.php';
require_once 'dbh.inc.php';
$member_id = $_POST['member_id'];

$pdo->beginTransaction();
$query = "SELECT c.cart_id from cart c
inner join members m on m.member_id = c.member_id
where m.member_id = ?;";

$stmt = $pdo->prepare($query);

$stmt->bindParam(1, $member_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$result){
    $_SESSION['success_message'] = "Could not process the order";
    $referer = $_SESSION['previous_page'] ?? '/library/';
    unset($_SESSION['previous_page']);
    header("Location: " . $referer);
    die();
}
$cart_id = $result['cart_id'];

$query = "INSERT INTO orders (member_id) VALUES (?)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $member_id, PDO::PARAM_INT);
$stmt->execute();
$order_id = $pdo->lastInsertId();

if (!$order_id) {
    $_SESSION['success_message'] = "Could not process the order";
    $referer = $_SESSION['previous_page'] ?? '/library/';
    unset($_SESSION['previous_page']);
    header("Location: " . $referer);
    die();
}

$query = "
    INSERT INTO order_items (order_id, book_copy_id, added_at)
    SELECT ?, book_copy_id, added_at
    FROM cart_items
    WHERE cart_id = ?;
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $order_id, PDO::PARAM_INT);
$stmt->bindParam(2, $cart_id, PDO::PARAM_INT);
$stmt->execute();

$query = "select ci.book_copy_id from cart_items ci where ci.cart_id = ?;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $cart_id, PDO::PARAM_INT);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($cart_items as $cart_item) {
    $query = "update book_copy set is_rented = 1 where book_copy_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $cart_item['book_copy_id'], PDO::PARAM_INT);
    $stmt->execute();
}

$query = "DELETE FROM cart_items WHERE cart_id = ?";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $cart_id, PDO::PARAM_INT);
$stmt->execute();

$query = "DELETE FROM cart WHERE cart_id = ?";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $cart_id, PDO::PARAM_INT);
$stmt->execute();
$pdo->commit();

$_SESSION['success_message'] = "Your order has been placed.";
$referer = $_SESSION['previous_page'] ?? '/library/';
unset($_SESSION['previous_page']);
header("Location: " . $referer);
die();