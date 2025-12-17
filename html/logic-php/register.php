<?php
// Include database connection
include 'logic-php/connection.php';

// Check if form is submitted
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['address']) && isset($_POST['postalCode'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $password = $_POST['password'];

    // Simple query
    $sql = "INSERT INTO users (email, password, firstName, lastName, address, postalCode) VALUES ('$email', '$password', '$firstName', '$lastName', '$address', '$postalCode')";
    $result = $pdo->query($sql);

    if ($result->rowCount() > 0) {
        echo "<h1 class=\"text-green\">Succesvol account aangemaakt</h1>";
        // header("Location: ../index.php");
    } else {
        echo "<h1 class=\"text-red\">Ongeldige gegevens</h1>";
    }
}
?>