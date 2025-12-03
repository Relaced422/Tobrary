<?php
$host = "db";
$port = 3306;
$dbname = "tobrary";
$username = "root";
$password = "rootpassword";

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    // echo "Database connection established successfully.";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
