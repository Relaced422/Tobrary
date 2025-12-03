<?php
$loginFeedback = "";
$registerFeedback = "";
include __DIR__ . '/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'register') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $address = $_POST['address'] ?? '';
    $postalCode = $_POST['postalCode'] ?? '';

    // Simple query (zoals jij wilde)
    $sql = "INSERT INTO users (email, password, firstName, lastName, address, postalCode) VALUES ('$email', '$password', '$firstName', '$lastName', '$address', '$postalCode')";
    $result = $pdo->query($sql);

    // Voor INSERT geeft query() vaak true/false; check $result
    if ($result) {
        // als je wilt: echo succesbericht of redirect
        $registerFeedback = "✔️ Succesvol ingelogd!";
        // header("Location: ../index.php");
    } else {
        $registerFeedback = "❌ Ongeldige inloggegevens";
    }
}
?>
