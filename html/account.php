<?php if (!isset($_SESSION))
    session_start();
var_dump($_SESSION);
include 'logic-php/connection.php'; ?>
<?php $username = $_SESSION['firstName'] . " " . $_SESSION['lastName'];
$firstLetterUpper = strtoupper(substr($_SESSION['firstName'], 0, 1));
$currentlyReadingQuery = "SELECT * FROM reading_progress;";

try {
    $stmt = $pdo->prepare($currentlyReadingQuery);
    $stmt->execute();
    $currentlyReading = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching currently reading books: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-black to-gray-900 text-gray-200 min-h-screen font-sans">

    <?php include 'parts/header.php'; ?>

    <div class="max-w-7xl mx-auto px-4 py-12">

        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-8 mb-8 border border-red-500/20 shadow-xl">
            <h1 class="text-4xl font-black tracking-widest mb-2">
                <span class="hero-gradient-text">WELCOME BACK,
                    <? echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?>!</span>
            </h1>
            <p class="text-gray-400 tracking-wide">Manage your account and reading activity</p>
        </div>

        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT COLUMN - Profile Card -->
            <div class="lg:col-span-1 space-y-8">

                <!-- Profile Info -->
                <div class="bg-gray-900/80 rounded-2xl p-6 border border-red-500/20 shadow-xl">
                    <h2 class="text-2xl font-bold mb-6 tracking-wide text-white">PROFILE</h2>

                    <!-- Avatar -->
                    <div class="flex justify-center mb-6">
                        <div
                            class="w-32 h-32 profile-badge rounded-full flex items-center justify-center border-4 border-red-500/50 shadow-lg">
                            <span class="text-white text-5xl font-black"><? echo $firstLetterUpper ?></span>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="space-y-4 text-gray-300">
                        <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <p class="text-xs text-gray-500 font-semibold tracking-wide mb-1">NAME</p>
                            <p class="text-lg text-white">
                                <? echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?>
                            </p>
                        </div>

                        <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <p class="text-xs text-gray-500 font-semibold tracking-wide mb-1">EMAIL</p>
                            <p class="text-lg text-white"><? echo $_SESSION['email'] ?></p>
                        </div>

                        <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <p class="text-xs text-gray-500 font-semibold tracking-wide mb-1">ADDRESS</p>
                            <p class="text-lg text-white"><? echo $_SESSION['address'] ?></p>
                        </div>

                        <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <p class="text-xs text-gray-500 font-semibold tracking-wide mb-1">MEMBER SINCE</p>
                            <p class="text-lg text-white"><? echo $_SESSION['createdAt'] ?></p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-3">
                        <button
                            class="w-full px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-all duration-300 font-semibold border border-gray-700 hover:border-red-500/50">
                            <a href="/logic-php/edit-profile.php">Edit Profile</a>
                        </button>
                        <button
                            class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300 font-semibold">
                            <a href="/logic-php/logoutfunc.php">Log Out</a>
                        </button>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-gray-900/80 rounded-2xl p-6 border border-red-500/20 shadow-xl">
                    <h2 class="text-2xl font-bold mb-6 tracking-wide text-white">STATISTICS</h2>
                    <div class="space-y-4">
                        <div
                            class="flex justify-between items-center bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <span class="text-gray-400">Books Read</span>
                            <span class="text-3xl font-bold text-green-500">42</span>
                        </div>
                        <div
                            class="flex justify-between items-center bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <span class="text-gray-400">Currently Reading</span>
                            <span class="text-3xl font-bold text-blue-500">5</span>
                        </div>
                        <div
                            class="flex justify-between items-center bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <span class="text-gray-400">Favorites</span>
                            <span class="text-3xl font-bold text-red-500">12</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN - Activity & Books -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Currently Reading -->
                <div class="bg-gray-900/80 rounded-2xl p-6 border border-red-500/20 shadow-xl">
                    <h2 class="text-2xl font-bold mb-6 tracking-wide text-white">CURRENTLY READING 📖</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Book 1 -->
                        <div
                            class="bg-gray-800/50 rounded-lg p-4 border border-gray-700 hover:border-red-500/50 transition-all duration-300">
                            <div class="flex gap-4">
                                <div
                                    class="w-20 h-28 bg-gradient-to-b from-red-600 to-red-800 rounded-lg border-2 border-red-500/50 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xs font-bold transform -rotate-90">BOOK</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-white mb-1">The Great Gatsby</h3>
                                    <p class="text-sm text-gray-400 mb-3">F. Scott Fitzgerald</p>
                                    <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                                        <div class="bg-red-500 h-2 rounded-full" style="width: 65%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500">65% complete</p>
                                </div>
                            </div>
                        </div>

                        <!-- Book 2 -->
                        <div
                            class="bg-gray-800/50 rounded-lg p-4 border border-gray-700 hover:border-red-500/50 transition-all duration-300">
                            <div class="flex gap-4">
                                <div
                                    class="w-20 h-28 bg-gradient-to-b from-blue-600 to-blue-800 rounded-lg border-2 border-blue-500/50 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xs font-bold transform -rotate-90">BOOK</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-white mb-1">1984</h3>
                                    <p class="text-sm text-gray-400 mb-3">George Orwell</p>
                                    <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: 32%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500">32% complete</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button
                        class="mt-6 w-full px-6 py-3 bg-gray-800/50 border-2 border-gray-700 text-white rounded-lg hover:bg-gray-700 hover:border-red-500/50 transition-all duration-300 font-semibold">
                        + Browse More Books
                    </button>
                </div>

                <!-- Borrowed Books -->
                <div class="bg-gray-900/80 rounded-2xl p-6 border border-red-500/20 shadow-xl">
                    <h2 class="text-2xl font-bold mb-6 tracking-wide text-white">BORROWED BOOKS 📚</h2>

                    <div class="space-y-4">
                        <!-- Borrowed Book 1 -->
                        <div
                            class="bg-gray-800/50 rounded-lg p-4 border border-gray-700 flex justify-between items-center hover:border-red-500/50 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-24 bg-gradient-to-b from-purple-600 to-purple-800 rounded-lg border-2 border-purple-500/50">
                                </div>
                                <div>
                                    <h3 class="font-bold text-white">To Kill a Mockingbird</h3>
                                    <p class="text-sm text-gray-400">Harper Lee</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 mb-1">DUE DATE</p>
                                <p class="font-bold text-orange-500">Jan 25, 2025</p>
                            </div>
                        </div>

                        <!-- Borrowed Book 2 -->
                        <div
                            class="bg-gray-800/50 rounded-lg p-4 border border-gray-700 flex justify-between items-center hover:border-red-500/50 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-24 bg-gradient-to-b from-green-600 to-green-800 rounded-lg border-2 border-green-500/50">
                                </div>
                                <div>
                                    <h3 class="font-bold text-white">Pride and Prejudice</h3>
                                    <p class="text-sm text-gray-400">Jane Austen</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 mb-1">DUE DATE</p>
                                <p class="font-bold text-green-500">Feb 5, 2025</p>
                            </div>
                        </div>

                        <!-- Borrowed Book 3 -->
                        <div
                            class="bg-gray-800/50 rounded-lg p-4 border border-gray-700 flex justify-between items-center hover:border-red-500/50 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-24 bg-gradient-to-b from-yellow-600 to-yellow-800 rounded-lg border-2 border-yellow-500/50">
                                </div>
                                <div>
                                    <h3 class="font-bold text-white">The Hobbit</h3>
                                    <p class="text-sm text-gray-400">J.R.R. Tolkien</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 mb-1">DUE DATE</p>
                                <p class="font-bold text-red-500">Jan 15, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-gray-900/80 rounded-2xl p-6 border border-red-500/20 shadow-xl">
                    <h2 class="text-2xl font-bold mb-6 tracking-wide text-white">RECENT ACTIVITY 🕐</h2>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4 bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <span class="text-3xl">✅</span>
                            <div>
                                <p class="text-white"><span class="font-bold">Finished</span> "Brave New World"</p>
                                <p class="text-sm text-gray-500">2 days ago</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <span class="text-3xl">📖</span>
                            <div>
                                <p class="text-white"><span class="font-bold">Started</span> "1984"</p>
                                <p class="text-sm text-gray-500">1 week ago</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <span class="text-3xl">⭐</span>
                            <div>
                                <p class="text-white"><span class="font-bold">Favorited</span> "The Great Gatsby"</p>
                                <p class="text-sm text-gray-500">2 weeks ago</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-gray-800/50 p-4 rounded-lg border border-gray-700">
                            <span class="text-3xl">📚</span>
                            <div>
                                <p class="text-white"><span class="font-bold">Borrowed</span> "To Kill a Mockingbird"
                                </p>
                                <p class="text-sm text-gray-500">3 weeks ago</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php include 'parts/footer.php'; ?>
</body>

</html>