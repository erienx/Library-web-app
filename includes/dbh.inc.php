<?php
$dsn = "mysql:host=localhost;dbname=librarydb";
$dbusername = "root";
$dbpassword = "";
$pdo = null;

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    die("Connection failed: " . $exception->getMessage());
}
