<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="flex flex-col">
        <h1>Inloggen</h1>
        <form action="login.php" method="POST">
            <input type="email" name="email" required placeholder="email">
            <input type="password" name="password" required placeholder="password">
            <input type="submit">
        </form>
    </div>
</body>

</html>

<?php
// var_dump($_POST['email']. " " .$_POST['password']);
if (isset($_POST['email']) && isset($_POST['password']))
    if (($_POST['email'] == "optquenum@gmail.com") && ($_POST['password'] == "admin")) {
        echo "<h1> Succesvol ingelogd<h1>";
    } else {
        echo "<h1> Ongeldige inloggegevens<h1>";
    }
// header("Location: index.php");
?>