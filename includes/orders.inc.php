<?php
require_once 'config_session.inc.php';
function get_user_orders($member_id, $pdo){
    try {
        $query = "
                select o.order_id, o.status, o.created_at, o.rented_at, o.completed_at from orders o
                inner join members m on m.member_id = o.member_id
                where m.member_id = ?;";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(1, $member_id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results ?? NULL;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return NULL;
    }
}
function get_books_in_order($order_id, $pdo) {
    try {
        $query = "
                select bc.book_id from orders o 
                inner join order_items oi on oi.order_id = o.order_id
                inner join book_copy bc on bc.book_copy_id = oi.book_copy_id
                where o.order_id = ?";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(1, $order_id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results ?? NULL;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return NULL;
    }
}

function remove_order($order_id, $pdo){
    try {
        $pdo->beginTransaction();
        $query = "
            UPDATE book_copy bc
            INNER JOIN order_items oi ON oi.book_copy_id = bc.book_copy_id
            INNER JOIN orders o ON o.order_id = oi.order_id
            SET bc.is_rented = 0
            WHERE oi.order_id = ? AND o.status = 'ordered';
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $order_id, PDO::PARAM_INT);
        $stmt->execute();

        $query = "DELETE oi
            FROM order_items oi
            INNER JOIN orders o ON o.order_id = oi.order_id
            WHERE oi.order_id = ? AND o.status = 'ordered';";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(1, $order_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION["success_message"] = "Order has been removed";
        } else {
            $_SESSION["success_message"] = "Failed to remove order";
        }

        $query = "DELETE FROM orders
        WHERE order_id = ? AND status = 'ordered';";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(1, $order_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION["success_message"] = "Order has been removed";
        } else {
            $_SESSION["success_message"] = "Failed to remove order";
        }
        $pdo->commit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
