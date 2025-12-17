<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if ($_SESSION != null) {
        echo "Persoon is ingelogd";
        echo "<br>";
        echo "vardump UserID: ";
        echo "<br>";
        var_dump($_SESSION);
    } else {
        echo "sessie gestart voor gast";
        echo "<br>";
        echo "vardump Session: ";
        var_dump($_SESSION);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include __DIR__ . '/parts/header.php'; ?>
    <script src="js/header.js"></script>
    <main class="bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F]">
        <?php if ($_SESSION == null) { ?>
            <div
                class="bg-[#D9D9D9] w-[70vw] mx-auto mt-20 rounded-lg shadow-lg items-center justify-center p-10 flex flex-col font-['Indie_Flower',cursive]">

                <h1 class="text-black text-[50px] pt-20">Tobrary - Your digital library realm.</h1>
                <h2 class="text-black text-2xl">Dive into knowledge. From the comfort of your couch.</h2>

                <div class="flex justify-evenly items-center">

                    <a href="" class="bg-[#6F6F6F] p-4 h-[20%] rounded-xl text-white flex items-center">
                        Browse Books
                    </a>

                    <img src="img/book-icon.png" alt="Book image" class="min-w-[200px]">

                    <a href="loginpage.php" class="bg-[#6F6F6F] p-4 rounded-xl text-white flex items-center">
                        Log in / Join
                    </a>

                </div>
            </div>

        <?php } else { ?>
            <h1 class="text-white text-4xl text-center pt-20">lorem</h1>
        <?php } ?>
    </main>
    <footer></footer>
</body>

</html>