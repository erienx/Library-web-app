<?php
function get_top_books(PDO $pdo, int $limit) {
    try {
        $query = "
            SELECT books.*, categories.category_name, authors.author_name
            FROM books
            INNER JOIN categories ON books.category_id = categories.category_id
            INNER JOIN book_to_author ON books.book_id = book_to_author.book_id
            INNER JOIN authors ON book_to_author.author_id = authors.author_id
            ORDER BY rented_count DESC LIMIT :limit
        ";

        $statement = $pdo->prepare($query);
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
function get_newest_books(PDO $pdo, int $limit){
    global $pdo;
    try{
        $query = "select books.*, categories.category_name, authors.author_name
from books 
inner join categories on books.category_id = categories.category_id
INNER JOIN book_to_author ON books.book_id = book_to_author.book_id
    INNER JOIN authors ON book_to_author.author_id = authors.author_id
order by added_date desc limit :limit;";

        $statement = $pdo->prepare($query);
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_DEFAULT);
        $statement = null;

        return $result ?: null;
    }catch(PDOException $exception){
        die("Query failed: " . $exception->getMessage());
    }
}
function get_books(PDO $pdo, string $search_term){
    global $pdo;
    try{
        $search_term_wildcards = "%" . $search_term . "%";
        $query = "
    SELECT books.*, categories.category_name, authors.author_name
    FROM books
    INNER JOIN categories ON books.category_id = categories.category_id
    INNER JOIN book_to_author ON books.book_id = book_to_author.book_id
    INNER JOIN authors ON book_to_author.author_id = authors.author_id
    WHERE books.title LIKE :search_term or authors.author_name LIKE :search_term
    ORDER BY rented_count DESC;
";



        $statement = $pdo->prepare($query);
        $statement->bindValue(':search_term', $search_term_wildcards, PDO::PARAM_STR);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_DEFAULT);
        $statement = null;

        return $result ?: null;
    }catch(PDOException $exception){
        die("Query failed: " . $exception->getMessage());
    }
}
function get_book_by_id(PDO $pdo, int $id) {
    try {
        $query = "
            SELECT 
                books.*, 
                categories.category_name, 
                authors.author_name, 
                publishers.publisher_name,
                COUNT(book_copy.book_copy_id) AS total_copies,
                COUNT(CASE WHEN book_copy.is_rented = 0 THEN 1 END) AS available_copies
            FROM books
            INNER JOIN categories ON books.category_id = categories.category_id
            INNER JOIN book_to_author ON books.book_id = book_to_author.book_id
            INNER JOIN authors ON book_to_author.author_id = authors.author_id
            INNER JOIN publishers ON books.publisher_id = publishers.publisher_id
            LEFT JOIN book_copy ON books.book_id = book_copy.book_id
            WHERE books.book_id = :id
            GROUP BY books.book_id
        ";

        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}