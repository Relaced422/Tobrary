<?php
// Include database connection
include 'connection.php';

// Check if form is submitted
if (isset($_POST['register_submit']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['address']) && isset($_POST['postalCode'])) {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];

    // Check if email already exists
    $checkSql = "SELECT * FROM users WHERE email = :email";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindParam(':email', $email);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        echo "<p class='text-red-600 font-semibold mt-2'>This email is already registered!</p>";
    } else {
        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO users (email, password, firstName, lastName, address, postalCode) 
                VALUES (:email, :password, :firstName, :lastName, :address, :postalCode)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // In production, use password_hash()!
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':postalCode', $postalCode);
        
        if ($stmt->execute()) {
            echo "<p class='text-green-600 font-semibold mt-2'>Account successfully created! Please log in.</p>";
            
            // Close the modal and refresh after 2 seconds
            echo "<script>
                setTimeout(function() {
                    closeRegisterModal();
                    window.location.href = window.location.href;
                }, 2000);
            </script>";
        } else {
            echo "<p class='text-red-600 font-semibold mt-2'>Registration failed. Please try again.</p>";
        }
    }
}
?>