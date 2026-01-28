<?php
// ========================================
// DATABASE CONNECTION FILE
// ========================================
// This file connects our website to the MySQL database

// Database connection settings
$host = "db";                    // Server location
$port = 3306;                    // MySQL port number
$dbname = "tobrary";             // Database name
$username = "root";              // Database username
$password = "rootpassword";      // Database password

// Try to connect to the database
try {
    // Build the connection string with our settings
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    
    // Create the database connection and save it in $pdo
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,      // Show errors if something goes wrong
        PDO::ATTR_EMULATE_PREPARES => false,              // ✅ Use real prepared statements (fixes LIMIT/OFFSET)
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC  // ✅ Always fetch as associative arrays
    ]);
    
} catch (PDOException $e) {
    // If connection fails, stop the script and show the error
    die("Database connection failed: " . $e->getMessage());
}

// $pdo is now ready to use for database queries
?>