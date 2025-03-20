<?php
require_once 'dbh.inc.php';
require_once 'config_session.inc.php';

$current_status = trim($_POST['current_status']) ?? null;
$order_id = $_POST['order_id'];

try {
    $pdo->beginTransaction();
    if ($current_status === 'ordered') {
        $query = "update orders o
            set o.status = 'rented'
            where o.order_id = ?;";
    }
    else if ($current_status === 'rented') {
        $query = "update orders o
            set o.status = 'completed'
            where o.order_id = ?;";
    }
    else{
        $_SESSION["success_message"] = "Failed push order " . $order_id;
        $referer = $_GET['redirect'] ?? '/library/';
        header("Location: " . $referer);
        die();
    }

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(1, $order_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION["success_message"] = "Pushed order " . $order_id;
        if ($current_status === 'rented') { // completed in reality at this point
            $query = "
            UPDATE book_copy bc
            INNER JOIN order_items oi ON oi.book_copy_id = bc.book_copy_id
            INNER JOIN orders o ON o.order_id = oi.order_id
            INNER JOIN books b ON b.book_id = bc.book_id
            SET bc.is_rented = 0,
                b.rented_count = b.rented_count + 1
            WHERE oi.order_id = ? AND o.status = 'completed';
            ";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(1, $order_id, PDO::PARAM_INT);
            $stmt->execute();
        }
    } else {
        $_SESSION["success_message"] = "Failed push order " . $order_id;
    }
    $pdo->commit();
    $referer = $_GET['redirect'] ?? '/library/';
    header("Location: " . $referer);
    die();
} catch (PDOException $e) {
    $referer = $_GET['redirect'] ?? '/library/';
    header("Location: " . $referer);
    die();
}

