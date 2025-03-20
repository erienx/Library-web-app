<?php
require_once 'config_session.inc.php';
function get_book_copy_id($book_id, $pdo)
{
    $query = "SELECT book_copy_id FROM book_copy WHERE book_copy.book_id = ? and book_copy.is_rented = 0 limit 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $book_id, PDO::PARAM_INT);
    $stmt->execute();
    $book_copy = $stmt->fetch(PDO::FETCH_ASSOC);
    return $book_copy['book_copy_id'] ?? NULL;
}
function add_to_cart($member_id, $book_id, $pdo) {
    try {
        $query = "SELECT cart_id FROM cart WHERE member_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $member_id, PDO::PARAM_INT);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            $cart_id = $cart['cart_id'];
        } else {
            $query = "INSERT INTO cart (member_id) VALUES (?)";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(1, $member_id, PDO::PARAM_INT);
            $stmt->execute();
            $cart_id = $pdo->lastInsertId();
        }
        $book_copy_id = get_book_copy_id($book_id, $pdo);

        if (!$book_copy_id) {
            $_SESSION["success_message"] = "Book not available";
        }
        else {

            $query = "SELECT 1 FROM cart_items WHERE cart_id = ? AND book_copy_id = ?";
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(1, $cart_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $book_copy_id, PDO::PARAM_INT);

            $stmt->execute();
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION["success_message"] = "Book is already in the cart.";
            } else {
                $query = "INSERT INTO cart_items (cart_id, book_copy_id) VALUES (?, ?)";
                $stmt = $pdo->prepare($query);

                $stmt->bindParam(1, $cart_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $book_copy_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $_SESSION["success_message"] = "Book added to cart";
                } else {
                    $_SESSION["success_message"] = "Failed to add copy.";
                }
            }
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function remove_from_cart($member_id, $book_id, $pdo) {
    try {
        $query = "DELETE ci
        FROM cart_items ci
        JOIN book_copy bc ON bc.book_copy_id = ci.book_copy_id
        JOIN books b ON b.book_id = bc.book_id
        JOIN cart c ON c.cart_id = ci.cart_id
        JOIN members m ON m.member_id = c.member_id
        WHERE m.member_id = ? AND b.book_id = ?;";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(1, $member_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $book_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION["success_message"] = "Book removed from cart.";
        } else {
            $_SESSION["success_message"] = "Failed to remove book.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function is_book_in_cart($member_id, $book_id_cmp, $pdo) {
    $books_id = get_books_in_cart($member_id,$pdo);
    foreach ($books_id as $book_id) {
        if ($book_id["book_id"] == $book_id_cmp) {
            return true;
        }
    }
    return false;
}
function get_books_in_cart($member_id, $pdo) {
    try {
        $query = "
                SELECT bc.book_id from members m
                JOIN cart c on c.member_id = m.member_id
                join cart_items ci on ci.cart_id = c.cart_id
                join book_copy bc on bc.book_copy_id = ci.book_copy_id
                where m.member_id = ?";
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
function get_cart_items($member_id, $pdo) {
    try {
        $query = "SELECT cart_id FROM cart WHERE member_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $member_id, PDO::PARAM_INT);
        $stmt->execute();
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            $cart_id = $cart['cart_id'];
        } else {
            return 0;
        }
        $query = "SELECT count(*) c FROM cart_items where cart_id = ?;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $cart_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $count['c'];
    }
    catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return NULL;
        }
}


