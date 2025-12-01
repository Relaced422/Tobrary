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
</head>
<body>
<header class="bg-[#1F1F1F] flex justify-around items-center p-4 border-2 border-white">
    <div class="flex flex-col gap-6">
        <button class="bg-[#7B7B7B] rounded-lg text-center p-4 w-[10vw] border border-white text-white">Cataloog</button>
        <button class="bg-[#7B7B7B] rounded-lg text-center p-4 w-[10vw] border border-white text-white">Aanbieding</button>
    </div>
    <div>
        <img src="/img/logo.png" alt="Tobrary Logo" class="h-[20vh]">
    </div>
    <div class="flex flex-col gap-6">
        <button class="bg-[#7B7B7B] rounded-lg text-center p-4 w-[10vw] border border-white text-white">Account</button>
        <button class="bg-[#7B7B7B] rounded-lg text-center p-4 w-[10vw] border border-white text-white">Bestellingen</button>
    </div>
</header>
<main class="bg-[url('img/blackrecycled.jpg')] h-[80vh] bg-cover bg-center">

</main>
<footer></footer>
</body>
</html>