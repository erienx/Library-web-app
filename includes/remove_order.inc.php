<?php
require_once 'dbh.inc.php';
require_once 'orders.inc.php';


$order_id = $_POST['order_id'];
remove_order($order_id, $pdo);

$referer = $_GET['redirect'] ?? '/library/';
header("Location: " . $referer);
exit();

