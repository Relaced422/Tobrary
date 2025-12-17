<?php
include 'connection.php';

if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $pdo->query($sql);

    if ($result->rowCount() > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $_SESSION['userId'] = $row['userId'];
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['address'] = $row['address'];
        $_SESSION['postalCode'] = $row['postalCode'];

        echo "Ingelogd!";
        echo "<script>
        // After successful login, waits 1 second then refreshes
        setTimeout(function() {
            window.location.href = window.location.href;
        }, 1000);
        </script>";
    } else {
        echo "Foutieve gegevens!";
    }
}
?>
