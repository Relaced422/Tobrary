<?php
// ========================================
// EDIT PROFILE FILE
// ========================================
// This file updates user information when they edit their profile

// Connect to the database
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // If not logged in, send them to the login page
    header("Location: loginpage.php");
    exit();
}

// Check if the form was submitted
if (isset($_POST['update_profile'])) {
    
    // Get the user ID from the session
    $userId = $_SESSION['userId'];
    
    // Get all the form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    
    // Check if this email is already used by another user
    $emailCheckQuery = "SELECT * FROM users WHERE email = ? AND userId != ?";
    $emailCheckStmt = $pdo->prepare($emailCheckQuery);
    $emailCheckStmt->execute([$email, $userId]);
    
    // If the email is already taken, show an error
    if ($emailCheckStmt->rowCount() > 0) {
        echo "<p class='text-red-600 font-semibold'>This email address is already in use!</p>";
        
    } else {
        // Email is available, so update the user's information
        $updateQuery = "UPDATE users SET 
                        firstName = ?, 
                        lastName = ?, 
                        email = ?, 
                        address = ?, 
                        postalCode = ? 
                        WHERE userId = ?";
        
        $updateStmt = $pdo->prepare($updateQuery);
        $updateSuccess = $updateStmt->execute([$firstName, $lastName, $email, $address, $postalCode, $userId]);
        
        // Check if the update worked
        if ($updateSuccess) {
            // Update the session with the new information
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['email'] = $email;
            $_SESSION['address'] = $address;
            $_SESSION['postalCode'] = $postalCode;
            
            echo "<p class='text-green-600 font-semibold'>Account succesfully edited!</p>";
            
            // Redirect back to the profile page after a short delay
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'loginpage.php';
                }, 50);
            </script>";
            
        } else {
            // Something went wrong with the update
            echo "<p class='text-red-600 font-semibold'>Something went wrong while updating your account.</p>";
        }
    }
}
?>