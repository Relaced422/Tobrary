<!-- <iframe src="https://tryhackme.com/api/v2/badges/public-profile?userPublicId=1812018" style='border:none;'></iframe> -->
<?php
require_once __DIR__ . '/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <main class="bg-[url('img/blackrecycled.jpg')] h-[80vh] bg-cover bg-center">
        <?php include __DIR__ . '/parts/header.php'; ?>
        
    </main>
    <footer></footer>
</body>

</html>