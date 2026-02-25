<?php
session_start();
include 'logic-php/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-gradient-to-br from-black to-gray-900 text-gray-200 min-h-screen font-sans">

    <?php include 'parts/header.php'; ?>
    <main>
        <div class="min-h-screen flex items-center justify-center px-4 py-12">
            <div class="max-w-md w-full">

                <!-- Login Card -->
                <div class="bg-gray-900/80 rounded-2xl shadow-2xl border border-red-500/20 overflow-hidden glow-effect">

                    <!-- Header -->
                    <div class="bg-gradient-to-r from-red-600 to-red-700 p-8 text-center">
                        <h1 class="text-4xl font-black tracking-widest text-white mb-2">TOBRARY</h1>
                        <p class="text-red-100">Sign in to your account</p>
                    </div>

                    <!-- Login Form -->
                    <div class="p-8">

                        <?php if (isset($error)): ?>
                            <div
                                class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg mb-6 text-center">
                                <span class="font-semibold">⚠️ <?= $error ?></span>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="logic-php/loginfunc.php" class="space-y-6">

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-300 mb-2 tracking-wide">
                                    EMAIL ADDRESS
                                </label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-3 bg-gray-800/50 border-2 border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition-all duration-300"
                                    placeholder="your.email@example.com">
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password"
                                    class="block text-sm font-semibold text-gray-300 mb-2 tracking-wide">
                                    PASSWORD
                                </label>
                                <input type="password" id="password" name="password" required
                                    class="w-full px-4 py-3 bg-gray-800/50 border-2 border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition-all duration-300"
                                    placeholder="••••••••">
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between text-sm">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox"
                                        class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-red-500 focus:ring-red-500 focus:ring-offset-gray-900">
                                    <span class="ml-2 text-gray-400 group-hover:text-gray-300 transition">Remember
                                        me</span>
                                </label>
                                <a href="#" class="text-red-500 hover:text-red-400 transition font-semibold">
                                    Forgot password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full px-6 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white font-bold text-lg rounded-lg transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/50 tracking-wide uppercase">
                                Sign In →
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="relative my-8">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-700"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-gray-900/80 text-gray-500">OR</span>
                            </div>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="text-gray-400 mb-4">
                                Don't have an account?
                            </p>
                            <a href="register.php"
                                class="inline-block px-8 py-3 bg-gray-800/50 border-2 border-red-500/50 text-red-500 font-semibold rounded-lg transition-all duration-300 hover:bg-red-500/10 hover:border-red-500 hover:-translate-y-1">
                                Create Account
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-8">
                    <a href="index.php" class="text-gray-500 hover:text-red-500 transition text-sm">
                        ← Back to Home
                    </a>
                </div>
            </div>
        </div>
    </main>
    <?php include 'parts/footer.php'; ?>
</body>

</html>