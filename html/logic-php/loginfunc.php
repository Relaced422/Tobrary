<?php
// ========================================
// LOGIN FILE
// ========================================
// This file checks if the user's email and password are correct

// Connect to the database
session_start();
include 'connection.php';

// Check if the login form was submitted
if (isset($_POST['email']) && isset($_POST['password'])) {

    // Get the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Search for a user with this email in the database
    // The ? is a placeholder that will be replaced with $email (safe from SQL injection)
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);

    // Check if we found a user with this email
    if ($stmt->rowCount() > 0) {
        
        // Get the user's data from the database
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if the password matches (direct comparison)
        if ($password === $user['password']) {
            
            // Password is correct! Save user information in the session
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['address'] = $user['address'];
            $_SESSION['postalCode'] = $user['postalCode'];
            $_SESSION['isAdmin'] = $user['isAdmin'];
            $_SESSION['createdAt'] = $user['createdAt'];

            header ("Location: ../index.php");
            exit();
        } else {
            // Password is wrong
            echo "Incorrect credentials!";
        }
        
    } else {
        // No user found with this email
        echo "Incorrect credentials!";
    }
}
?>