<?php
require_once "includes/book_queries.inc.php";
require_once "includes/dbh.inc.php";
$books = get_top_books($pdo, 8);
?>
<div class="card-wrapper">
    <h2 class="slider-header">Most popular</h2>
    <button class="slider-button left">◀</button>
    <ul class="card-list">
        <?php foreach ($books as $book) {
            printf('<li class="card-item">
            <a href="book_details.php?id=%d" class="card-link">
                <img src="/library%s" alt="Card image" class="card-image">
                <p class="category">%s</p>
                <h2 class="card-title">%s</h2>
                <h3 class="card-author">%s</h3>
                <h4 class="card-rented_count">Rented %s times</h4>
                <button class="card-button material-symbols-rounded">arrow_forward</button>
            </a>
        </li>',
                htmlspecialchars($book["book_id"]),
                htmlspecialchars($book["path_to_cover"]),
                htmlspecialchars($book["category_name"]),
                htmlspecialchars($book["title"]),
                htmlspecialchars($book["author_name"]),
                htmlspecialchars($book["rented_count"])
            );
        } ?>
    </ul>
    <button class="slider-button right">▶</button>
</div>
