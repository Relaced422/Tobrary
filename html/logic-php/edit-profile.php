<?php
// edit-profile.php
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    header("Location: loginpage.php");
    exit();
}

// Handle form submission
if (isset($_POST['update_profile'])) {
    $userId = $_SESSION['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    
    // Check if email is already taken by another user
    $emailCheckSql = "SELECT * FROM users WHERE email = '$email' AND userId != '$userId'";
    $emailCheckResult = $pdo->query($emailCheckSql);
    
    if ($emailCheckResult->rowCount() > 0) {
        echo "<p class='text-red-600 font-semibold'>Dit emailadres is al in gebruik!</p>";
    } else {
        // Update user information
        $sql = "UPDATE users SET 
                firstName = '$firstName', 
                lastName = '$lastName', 
                email = '$email', 
                address = '$address', 
                postalCode = '$postalCode' 
                WHERE userId = '$userId'";
        
        $result = $pdo->query($sql);
        
        if ($result) {
            // Update session variables
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['email'] = $email;
            $_SESSION['address'] = $address;
            $_SESSION['postalCode'] = $postalCode;
            
            echo "<p class='text-green-600 font-semibold'>Profiel succesvol bijgewerkt!</p>";
            
            // Refresh page after 1 second
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'loginpage.php';
                }, 50);
            </script>";
        } else {
            echo "<p class='text-red-600 font-semibold'>Er ging iets fout bij het bijwerken.</p>";
        }
    }
}
?>