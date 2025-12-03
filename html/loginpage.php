<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>


<body>
    <?php include __DIR__ . '/parts/header.php'; ?>
    <script src="js/header.js"></script>
    <main class="bg-gradient-to-b from-[#D9D9D9] to-[#3A3A3A] min-h-screen flex items-center justify-center p-4">

        <div class="flex gap-8 w-full max-w-4xl">
            <!-- Login Form -->
            <div
                class="flex flex-col bg-gradient-to-b from-[#3A3A3A] to-[#D9D9D9] rounded-lg shadow-lg p-8 border-2 border-black w-[30vw]">
                <h1 class="text-3xl font-bold mb-6 text-center text-white">Log in</h1>
                <form action="" method="POST" class="flex flex-col gap-4">
                    <input type="email" name="email" required placeholder="Email"
                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    <input type="password" name="password" required placeholder="Password"
                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    <input type="submit" value="Log In"
                        class="px-4 py-3 bg-black text-white rounded-lg hover:bg-gray-800 cursor-pointer font-semibold transition">
                    <input type="hidden" name="form_type" value="login">
                </form>
                <?php if (!empty($loginFeedback)): ?>
                    <p class="text-center text-white mt-4"><?= $loginFeedback ?></p>
                <?php endif; ?>
            </div>

            <!-- Register Form -->
            <div
                class="flex flex-col bg-gradient-to-b from-[#3A3A3A] to-[#D9D9D9] rounded-lg shadow-lg p-8 border-2 border-black w-[30vw]">
                <h1 class="text-3xl font-bold mb-6 text-white text-center">Register</h1>
                <form action="" method="POST" class="flex flex-col gap-4">
                    <input type="text" name="firstName" required placeholder="First Name"
                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    <input type="text" name="lastName" required placeholder="Last Name"
                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    <input type="text" name="address" required placeholder="Address"
                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    <input type="text" name="postalCode" required placeholder="Postal Code (1234 AB)"
                        pattern="[0-9]{4}\s?[A-Za-z]{2}" title="Postal code must be in format: 1234 AB"
                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    <input type="email" name="email" required placeholder="Email"
                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    <input type="password" name="password" required placeholder="Password"
                        class="px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    <input type="submit" value="Register"
                        class="px-4 py-3 bg-black text-white rounded-lg hover:bg-gray-800 cursor-pointer font-semibold transition">
                    <input type="hidden" name="form_type" value="register">
                    <?php if (!empty($registerFeedback)): ?>
                        <p class="text-center text-white mt-4"><?= $registerFeedback ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </main>
</body>

</html>