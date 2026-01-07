<?php
// ========================================
// REGISTER FILE
// ========================================
// This file creates a new user account when someone signs up

// Connect to the database
include 'connection.php';

// Check if the registration form was submitted
if (isset($_POST['register_submit'])) {
    
    // Get all the form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];

    // Check if this email is already registered
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$email]);

    // If email already exists, show error message
    if ($checkStmt->rowCount() > 0) {
        echo "<p class='text-red-600 font-semibold mt-2'>This email is already registered!</p>";
        
    } else {
        // Email is available, so we can create the account
        
        // Insert the new user into the database
        $insertQuery = "INSERT INTO users (email, password, firstName, lastName, address, postalCode) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        
        $insertStmt = $pdo->prepare($insertQuery);
        $success = $insertStmt->execute([$email, $password, $firstName, $lastName, $address, $postalCode]);
        
        // Check if the account was created successfully
        if ($success) {
            echo "<p class='text-green-600 font-semibold mt-2'>Account successfully created! Please log in.</p>";
            
            // Close the registration modal and refresh the page after 2 seconds
            echo "<script>
                setTimeout(function() {
                    closeRegisterModal();
                    window.location.href = window.location.href;
                }, 2000);
            </script>";
            
        } else {
            // Something went wrong with creating the account
            echo "<p class='text-red-600 font-semibold mt-2'>Registration failed. Please try again.</p>";
        }
    }
}
?>