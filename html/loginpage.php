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
    <title>Account - Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Manrope:wght@200..800&display=swap"
        rel="stylesheet">
</head>

<body class="font-['Manrope',sans-serif]">
    <!-- Fixed Background -->
    <div class="fixed inset-0 bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F] -z-10"></div>

<?php include __DIR__ . '/parts/header.php'; ?>
    <script src="js/header.js"></script>
    
    <main class="bg-gradient-to-b from-[#D9D9D9] to-[#3A3A3A] min-h-screen flex items-center justify-center p-8">
        <?php if ($_SESSION == null) { ?>
            <!-- LOGIN FORM ONLY (Register is now a modal) -->
            <div class="flex flex-col items-center w-full max-w-md mx-auto">
                
                <!-- Login Form -->
                <div class="w-full bg-[#D9D9D9] rounded-2xl shadow-2xl p-8 border-2 border-[#2b2b2b] relative overflow-hidden">
                    <!-- Decorative background element -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <h1 class="text-5xl font-bold mb-2 text-center text-[#2b2b2b] font-['Lora',serif]">Welcome Back!</h1>
                        <p class="text-center text-xl text-gray-600 mb-8">Log in to access your digital library</p>
                        
                        <form action="" method="POST" class="flex flex-col gap-5">
                            <!-- Email Input -->
                            <div>
                                <label for="login-email" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                    Email Address
                                </label>
                                <input 
                                    type="email" 
                                    id="login-email"
                                    name="email" 
                                    required 
                                    placeholder="your.email@example.com"
                                    class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition bg-white"
                                >
                            </div>

                            <!-- Password Input -->
                            <div>
                                <label for="login-password" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                    Password
                                </label>
                                <input 
                                    type="password" 
                                    id="login-password"
                                    name="password" 
                                    required 
                                    placeholder="••••••••"
                                    class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition bg-white"
                                >
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between text-sm">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-400 text-blue-500 focus:ring-blue-500">
                                    <span class="text-gray-700">Remember me</span>
                                </label>
                                <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">
                                    Forgot password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                name="login_submit"
                                class="w-full px-4 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold text-lg border-2 border-blue-800 font-['Lora',serif]"
                            >
                                Log In →
                            </button>
                        </form>

                        <?php include 'logic-php/login.php'; ?>

                        <!-- Divider -->
                        <div class="mt-6 text-center">
                            <p class="text-gray-600 text-sm">
                                Don't have an account? 
                                <button onclick="openRegisterModal()" class="text-blue-600 font-semibold hover:underline">
                                    Register here
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REGISTER MODAL (Hidden by default) -->
            <div id="registerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-[#D9D9D9] rounded-2xl shadow-2xl p-8 border-4 border-[#2b2b2b] relative overflow-hidden max-w-md w-full max-h-[90vh] overflow-y-auto">
                    <!-- Close Button -->
                    <button onclick="closeRegisterModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 text-3xl font-bold">
                        ×
                    </button>

                    <!-- Decorative background element -->
                    <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full -ml-16 -mt-16 blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <h1 class="text-4xl font-bold mb-2 text-center text-[#2b2b2b] font-['Lora',serif]">Join Tobrary</h1>
                        <p class="text-center text-gray-600 mb-6">Create your account and start reading</p>
                        
                        <form action="" method="POST" class="flex flex-col gap-4">
                            <!-- Name Fields (Side by Side) -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="firstName" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                        First Name
                                    </label>
                                    <input 
                                        type="text" 
                                        id="firstName"
                                        name="firstName" 
                                        required 
                                        placeholder="John"
                                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white"
                                    >
                                </div>
                                <div>
                                    <label for="lastName" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                        Last Name
                                    </label>
                                    <input 
                                        type="text" 
                                        id="lastName"
                                        name="lastName" 
                                        required 
                                        placeholder="Doe"
                                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white"
                                    >
                                </div>
                            </div>

                            <!-- Address Input -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                    Address
                                </label>
                                <input 
                                    type="text" 
                                    id="address"
                                    name="address" 
                                    required 
                                    placeholder="123 Main Street"
                                    class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white"
                                >
                            </div>

                            <!-- Postal Code Input -->
                            <div>
                                <label for="postalCode" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                    Postal Code
                                </label>
                                <input 
                                    type="text" 
                                    id="postalCode"
                                    name="postalCode" 
                                    required 
                                    placeholder="1234 AB"
                                    pattern="[0-9]{4}\s?[A-Za-z]{2}" 
                                    title="Postal code must be in format: 1234 AB"
                                    class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white"
                                >
                                <p class="text-xs text-gray-600 mt-1">Format: 1234 AB</p>
                            </div>

                            <!-- Email Input -->
                            <div>
                                <label for="register-email" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                    Email Address
                                </label>
                                <input 
                                    type="email" 
                                    id="register-email"
                                    name="email" 
                                    required 
                                    placeholder="your.email@example.com"
                                    class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white"
                                >
                            </div>

                            <!-- Password Input -->
                            <div>
                                <label for="register-password" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                    Password
                                </label>
                                <input 
                                    type="password" 
                                    id="register-password"
                                    name="password" 
                                    required 
                                    placeholder="••••••••"
                                    minlength="8"
                                    class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white"
                                >
                                <p class="text-xs text-gray-600 mt-1">Minimum 8 characters</p>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="flex items-start gap-2">
                                <input 
                                    type="checkbox" 
                                    id="terms"
                                    required
                                    class="w-4 h-4 mt-1 rounded border-gray-400 text-purple-500 focus:ring-purple-500"
                                >
                                <label for="terms" class="text-sm text-gray-700">
                                    I agree to the <a href="#" class="text-purple-600 hover:underline font-semibold">Terms & Conditions</a> and <a href="#" class="text-purple-600 hover:underline font-semibold">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                name="register_submit"
                                class="w-full px-4 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold text-lg border-2 border-purple-800 mt-2 font-['Lora',serif]"
                            >
                                Create Account →
                            </button>
                        </form>

                        <?php include 'logic-php/register.php'; ?>
                    </div>
                </div>
            </div>

       <?php } else { ?>
            <!-- LOGGED IN VIEW - ACCOUNT DASHBOARD -->
            <div class="max-w-6xl mx-auto">
                
                <!-- Welcome Header -->
                <div class="bg-gradient-to-r from-[#3A3A3A] to-[#2b2b2b] rounded-lg p-6 mb-6 border-2 border-black shadow-lg">
                    <h1 class="text-4xl font-bold text-white mb-2 font-['Lora',serif]">
                        Welcome back, <?php echo $_SESSION['firstName']; ?>! 👋
                    </h1>
                    <p class="text-gray-300">Manage your account and view your reading activity</p>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- LEFT COLUMN - Profile Card -->
                    <div class="lg:col-span-1">
                        <div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg">
                            <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Profile</h2>
                            
                            <!-- User Avatar/Initial -->
                            <div class="flex justify-center mb-4">
                                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center border-4 border-black">
                                    <span class="text-white text-4xl font-bold font-['Lora',serif]">
                                        <?php echo strtoupper(substr($_SESSION['firstName'], 0, 1)); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- User Details -->
                            <div class="space-y-3 text-[#2b2b2b]">
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold font-['Lora',serif]">Name</p>
                                    <p class="text-lg"><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold font-['Lora',serif]">Email</p>
                                    <p class="text-lg"><?php echo $_SESSION['email']; ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold font-['Lora',serif]">Address</p>
                                    <p class="text-lg"><?php echo $_SESSION['address']; ?></p>
                                    <p class="text-lg"><?php echo $_SESSION['postalCode']; ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-semibold font-['Lora',serif]">Member Since</p>
                                    <p class="text-lg">
                                        <?php 
                                        echo isset($_SESSION['memberSince']) ? $_SESSION['memberSince'] : 'January 2024';
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 space-y-3">
                                <button onclick="openEditProfileModal()" class="w-full px-4 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition font-semibold font-['Lora',serif]">
                                    Edit Profile
                                </button>
                                <form action="" method="post">
                                    <button name="logout" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold font-['Lora',serif]" type="submit">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Quick Stats Card -->
                        <div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg mt-6">
                            <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Quick Stats</h2>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Books Read</span>
                                    <span class="text-2xl font-bold text-green-600 font-['Lora',serif]">12</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Currently Reading</span>
                                    <span class="text-2xl font-bold text-blue-600 font-['Lora',serif]">3</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Favorites</span>
                                    <span class="text-2xl font-bold text-purple-600 font-['Lora',serif]">5</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN - Activity & Books -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Currently Reading -->
                        <div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg">
                            <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Currently Reading 📖</h2>
                            
                            <!-- Book Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Example Book 1 -->
                                <div class="bg-white rounded-lg p-4 border-2 border-gray-300 hover:border-black transition">
                                    <div class="flex gap-4">
                                        <div class="w-16 h-24 bg-gradient-to-b from-red-500 to-red-700 rounded flex items-center justify-center border-2 border-black">
                                            <span class="text-white text-xs font-bold transform -rotate-90 whitespace-nowrap font-['Lora',serif]">Book</span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg font-['Lora',serif]">The Great Gatsby</h3>
                                            <p class="text-sm text-gray-600">F. Scott Fitzgerald</p>
                                            <div class="mt-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-green-500 h-2 rounded-full" style="width: 45%"></div>
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1">45% complete</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Example Book 2 -->
                                <div class="bg-white rounded-lg p-4 border-2 border-gray-300 hover:border-black transition">
                                    <div class="flex gap-4">
                                        <div class="w-16 h-24 bg-gradient-to-b from-blue-500 to-blue-700 rounded flex items-center justify-center border-2 border-black">
                                            <span class="text-white text-xs font-bold transform -rotate-90 whitespace-nowrap font-['Lora',serif]">Book</span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-lg font-['Lora',serif]">1984</h3>
                                            <p class="text-sm text-gray-600">George Orwell</p>
                                            <div class="mt-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-green-500 h-2 rounded-full" style="width: 78%"></div>
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1">78% complete</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="mt-4 w-full px-4 py-2 bg-gray-300 text-[#2b2b2b] rounded-lg hover:bg-gray-400 transition font-semibold border-2 border-gray-400 font-['Lora',serif]">
                                + Browse More Books
                            </button>
                        </div>

                        <!-- Borrowed Books -->
                        <div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg">
                            <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Borrowed Books 📚</h2>
                            
                            <div class="space-y-3">
                                <div class="bg-white rounded-lg p-4 border-2 border-gray-300 flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-16 bg-gradient-to-b from-purple-500 to-purple-700 rounded border-2 border-black"></div>
                                        <div>
                                            <h3 class="font-bold font-['Lora',serif]">To Kill a Mockingbird</h3>
                                            <p class="text-sm text-gray-600">Harper Lee</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 font-['Lora',serif]">Due Date</p>
                                        <p class="font-bold text-orange-600">Jan 25, 2024</p>
                                    </div>
                                </div>

                                <div class="bg-white rounded-lg p-4 border-2 border-gray-300 flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-16 bg-gradient-to-b from-green-500 to-green-700 rounded border-2 border-black"></div>
                                        <div>
                                            <h3 class="font-bold font-['Lora',serif]">Pride and Prejudice</h3>
                                            <p class="text-sm text-gray-600">Jane Austen</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 font-['Lora',serif]">Due Date</p>
                                        <p class="font-bold text-green-600">Feb 5, 2024</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reading History -->
                        <div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg">
                            <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Recent Activity 🕐</h2>
                            
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-2xl">✅</span>
                                    <p><span class="font-bold font-['Lora',serif]">Finished</span> "The Hobbit" - 3 days ago</p>
                                </div>
                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-2xl">📖</span>
                                    <p><span class="font-bold font-['Lora',serif]">Started</span> "1984" - 1 week ago</p>
                                </div>
                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-2xl">⭐</span>
                                    <p><span class="font-bold font-['Lora',serif]">Favorited</span> "The Great Gatsby" - 2 weeks ago</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- EDIT PROFILE MODAL -->
            <div id="editProfileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-[#D9D9D9] rounded-2xl shadow-2xl p-8 border-4 border-[#2b2b2b] relative overflow-hidden max-w-md w-full max-h-[90vh] overflow-y-auto">
                    <!-- Close Button -->
                    <button onclick="closeEditProfileModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 text-3xl font-bold">
                        ×
                    </button>

                    <!-- Decorative background element -->
                    <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-green-400/20 to-blue-400/20 rounded-full -ml-16 -mt-16 blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <h1 class="text-4xl font-bold mb-2 text-center text-[#2b2b2b] font-['Lora',serif]">Edit Profile</h1>
                        <p class="text-center text-gray-600 mb-6">Update your account information</p>
                        
                        <form action="" method="POST" class="flex flex-col gap-4">
                            <!-- Name Fields (Side by Side) -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="edit-firstName" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                        First Name
                                    </label>
                                    <input 
                                        type="text" 
                                        id="edit-firstName"
                                        name="firstName" 
                                        required 
                                        value="<?php echo $_SESSION['firstName']; ?>"
                                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition bg-white"
                                    >
                                </div>
                                <div>
                                    <label for="edit-lastName" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                        Last Name
                                    </label>
                                    <input 
                                        type="text" 
                                        id="edit-lastName"
                                        name="lastName" 
                                        required 
                                        value="<?php echo $_SESSION['lastName']; ?>"
                                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition bg-white"
                                    >
                                </div>
                            </div>

                            <!-- Email Input -->
                            <div>
                                <label for="edit-email" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                    Email Address
                                </label>
                                <input 
                                    type="email" 
                                    id="edit-email"
                                    name="email" 
                                    required 
                                    value="<?php echo $_SESSION['email']; ?>"
                                    class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition bg-white"
                                >
                            </div>

                            <!-- Address Input -->
                            <div>
                                <label for="edit-address" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                    Address
                                </label>
                                <input 
                                    type="text" 
                                    id="edit-address"
                                    name="address" 
                                    required 
                                    value="<?php echo $_SESSION['address']; ?>"
                                    class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition bg-white"
                                >
                            </div>

                            <!-- Postal Code Input -->
                            <div>
                                <label for="edit-postalCode" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                                    Postal Code
                                </label>
                                <input 
                                    type="text" 
                                    id="edit-postalCode"
                                    name="postalCode" 
                                    required 
                                    value="<?php echo $_SESSION['postalCode']; ?>"
                                    pattern="[0-9]{4}\s?[A-Za-z]{2}" 
                                    title="Postal code must be in format: 1234 AB"
                                    class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition bg-white"
                                >
                                <p class="text-xs text-gray-600 mt-1">Format: 1234 AB</p>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                name="update_profile"
                                class="w-full px-4 py-4 bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-lg hover:from-green-700 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold text-lg border-2 border-green-800 mt-2 font-['Lora',serif]"
                            >
                                Save Changes
                            </button>
                        </form>

                        <?php include 'logic-php/edit-profile.php'; ?>
                    </div>
                </div>
            </div>

            <?php
            // Handle logout
            if (isset($_POST['logout'])) {
                include 'logic-php/logout.php';
            }
            ?>

        <?php } ?>
    </main>

    <!-- JavaScript for Modals -->
    <script>
        // Register Modal Functions
        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Edit Profile Modal Functions
        function openEditProfileModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditProfileModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modals when clicking outside
        document.getElementById('registerModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRegisterModal();
            }
        });

        document.getElementById('editProfileModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditProfileModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRegisterModal();
                closeEditProfileModal();
            }
        });
    </script>
</body>

</html>