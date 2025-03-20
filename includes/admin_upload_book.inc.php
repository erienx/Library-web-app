<?php
require_once 'dbh.inc.php';
require_once 'config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_title = trim($_POST['book_title']);
    $book_author = trim($_POST['book_author']);
    $book_publisher = trim($_POST['book_publisher']);
    $book_category = trim($_POST['book_category']);
    $publication_date = trim($_POST['publication_date']);
    $pages = intval($_POST['pages']);
    $copies = intval($_POST['copies']);

    $cover_image = $_FILES['cover_image'];

    if ($cover_image['error'] == 0) {
        $upload_directory = __DIR__ . '/../covers/';
        $file_extension = pathinfo($cover_image['name'], PATHINFO_EXTENSION);
        $new_file_name = uniqid('book_cover_', true) . '.' . $file_extension;
        $target_file = $upload_directory . $new_file_name;
        $relative_file_path = '/covers/' . $new_file_name;

        if (move_uploaded_file($cover_image['tmp_name'], $target_file)) {
            try {
                $pdo->beginTransaction();

                $stmt = $pdo->prepare("SELECT publisher_id FROM publishers WHERE publisher_name = ?");
                $stmt->bindParam(1, $book_publisher, PDO::PARAM_STR);
                $stmt->execute();
                $publisher_id = $stmt->fetchColumn();
                if (!$publisher_id) {
                    $stmt = $pdo->prepare("INSERT INTO publishers (publisher_name) VALUES (?)");
                    $stmt->bindParam(1, $book_publisher, PDO::PARAM_STR);
                    $stmt->execute();
                    $publisher_id = $pdo->lastInsertId();
                }

                $stmt = $pdo->prepare("SELECT category_id FROM categories WHERE category_name = ?");
                $stmt->bindParam(1, $book_category, PDO::PARAM_STR);
                $stmt->execute();
                $category_id = $stmt->fetchColumn();
                if (!$category_id) {
                    $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
                    $stmt->bindParam(1, $book_category, PDO::PARAM_STR);
                    $stmt->execute();
                    $category_id = $pdo->lastInsertId();
                }

                $stmt = $pdo->prepare("INSERT INTO books (title, publisher_id, category_id, publication_date, pages, path_to_cover, rented_count) VALUES (?, ?, ?, ?, ?, ?, 0)");
                $stmt->bindParam(1, $book_title, PDO::PARAM_STR);
                $stmt->bindParam(2, $publisher_id, PDO::PARAM_INT);
                $stmt->bindParam(3, $category_id, PDO::PARAM_INT);
                $stmt->bindParam(4, $publication_date, PDO::PARAM_STR);
                $stmt->bindParam(5, $pages, PDO::PARAM_INT);
                $stmt->bindParam(6, $relative_file_path, PDO::PARAM_STR);
                $stmt->execute();
                $book_id = $pdo->lastInsertId();

                $stmt = $pdo->prepare("SELECT author_id FROM authors WHERE author_name = ?");
                $stmt->bindParam(1, $book_author, PDO::PARAM_STR);
                $stmt->execute();
                $author_id = $stmt->fetchColumn();
                if (!$author_id) {
                    $stmt = $pdo->prepare("INSERT INTO authors (author_name) VALUES (?)");
                    $stmt->bindParam(1, $book_author, PDO::PARAM_STR);
                    $stmt->execute();
                    $author_id = $pdo->lastInsertId();
                }

                $stmt = $pdo->prepare("INSERT INTO book_to_author (book_id, author_id) VALUES (?, ?)");
                $stmt->bindParam(1, $book_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $author_id, PDO::PARAM_INT);
                $stmt->execute();

                $stmt = $pdo->prepare("INSERT INTO book_copy (book_id, is_rented) VALUES (?, 0)");
                $stmt->bindParam(1, $book_id, PDO::PARAM_INT);
                for ($i = 0; $i < $copies; $i++) {
                    $stmt->execute();
                }

                $pdo->commit();
                $_SESSION['success_message'] = "Book added successfully";
                $referer = $_GET['redirect'] ?? '/library/';
                header("Location: " . $referer);
                die();
            } catch (Exception $e) {
                $pdo->rollBack();
                // echo $e->getMessage();
                $_SESSION['success_message'] = "Couldn't add book";
                $referer = $_GET['redirect'] ?? '/library/';
                header("Location: " . $referer);
                die();
            }
        } else {
            $_SESSION['success_message'] = "Couldn't upload cover";
            $referer = $_GET['redirect'] ?? '/library/';
            header("Location: " . $referer);
            die();
        }
    } else {
        $_SESSION['success_message'] = "Couldn't upload cover";
        $referer = $_GET['redirect'] ?? '/library/';
        header("Location: " . $referer);
        die();
    }
}
?>
