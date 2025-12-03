<?php
// Include database connection (zorg dat connection.php geen output geeft)
include __DIR__ . '/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple query (zoals je vroeg, geen security)
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $pdo->query($sql);

    if ($result && $result->rowCount() > 0) {
        $loginFeedback = "✔️ Succesvol ingelogd!";
        // header("Location: ../index.php");
    } else {
        $loginFeedback = "❌ Ongeldige inloggegevens";
    }
}
?>
