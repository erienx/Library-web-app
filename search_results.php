<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "php/header.php"; ?>

<div class="main-content">
    <?php include "php/search_bar.php"; ?>
    <div class="main-content-search">
        <?php
        $searchValue = $_GET['search'];
        if (isset($searchValue)) {
            require_once "includes/book_queries.inc.php";
            require_once 'includes/dbh.inc.php';
            $books = get_books($pdo, $searchValue);
            if ($books) {
                $searchValue = htmlspecialchars($searchValue);
                $resultCount = count($books);

                echo "<h2>Found " . $resultCount . " " . ($resultCount === 1 ? "result" : "results") . "</h2>";

                foreach ($books as $book) {
                    printf("
                        <div class='book-wrapper'>
                            <a href='book_details.php?id=%d' class='search-link'>
                            <div class='book-block'>
                                <img src='/library/%s' alt='Book Cover' class='book-image'>
                                <div class='book-info'>
                                    <h2>%s</h2>
                                    <h3>%s</h3>
                                    <p>%s</p>
                                </div>
                            </div>
                            </a>
                        </div>",
                        htmlspecialchars($book["book_id"]),
                        htmlspecialchars($book["path_to_cover"]),
                        htmlspecialchars($book["title"]),
                        htmlspecialchars($book["author_name"]),
                        htmlspecialchars($book["description"] ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.")
                    );
                }
            } else {
                echo "<h2>Found 0 results</h2>";
            }
        } else {
            echo "<h1>No search term provided.</h1>";
        }
        ?>
    </div>
</div>

<?php include "php/footer.php"; ?>

<script src="js/main.js"></script>
<script src="js/search.js"></script>
</body>
</html>
