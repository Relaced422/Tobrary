<?php
// ========================================
// ACCOUNT PAGE (LOGINPAGE.PHP)
// ========================================
// This page shows login/register forms for guests
// and the account dashboard for logged-in users

// Start the session if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>

<body class="font-['Manrope',sans-serif]">
    <!-- Fixed gradient background -->
    <div class="fixed inset-0 bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F] -z-10"></div>

    <!-- Include the header navigation -->
    <?php include __DIR__ . '/parts/header.php'; ?>
    <script src="js/header.js"></script>

    <main class="bg-gradient-to-b from-[#D9D9D9] to-[#3A3A3A] min-h-screen flex items-center justify-center p-4 md:p-8">
        
        <?php if (!isset($_SESSION['userId'])): ?>
            <!-- ========================================
                 NOT LOGGED IN - SHOW LOGIN FORM
                 ========================================
            -->
            
            <?php include 'parts/login-form.php'; ?>
            <?php include 'parts/register-modal.php'; ?>
            
        <?php else: 
            // User is logged in, get their statistics from the database
            include 'logic-php/get-user-stats.php';
        ?>
            <!-- ========================================
                 LOGGED IN - SHOW ACCOUNT DASHBOARD
                 ========================================
            -->
            
            <div class="max-w-6xl mx-auto w-full">

                <!-- Welcome banner at the top -->
                <div class="bg-gradient-to-r from-[#3A3A3A] to-[#2b2b2b] rounded-lg p-6 mb-6 border-2 border-black shadow-lg">
                    <h1 class="text-2xl md:text-4xl font-bold text-white mb-2 font-['Lora',serif]">
                        Welcome back, <?php echo htmlspecialchars($_SESSION['firstName']); ?>! 👋
                    </h1>
                    <p class="text-gray-300">Manage your account and view your reading activity</p>
                </div>

                <!-- Main dashboard grid (profile on left, activity on right) -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- ========================================
                         LEFT COLUMN - PROFILE & STATS
                         ========================================
                    -->
                    <div class="lg:col-span-1 space-y-6">
                        <?php include 'parts/profile-card.php'; ?>
                        <?php include 'parts/quick-stats.php'; ?>
                    </div>

                    <!-- ========================================
                         RIGHT COLUMN - READING ACTIVITY
                         ========================================
                    -->
                    <div class="lg:col-span-2 space-y-6">
                        <?php include 'parts/currently-reading.php'; ?>
                        <?php include 'parts/borrowed-books.php'; ?>
                        <?php include 'parts/recent-activity.php'; ?>
                    </div>
                    
                </div>
            </div>

            <!-- Edit profile modal (hidden by default) -->
            <?php include 'parts/edit-profile-modal.php'; ?>
            
            <?php
            // Handle logout when user clicks the logout button
            if (isset($_POST['logout'])) {
                include 'logic-php/logout.php';
            }
            ?>
            
        <?php endif; ?>
    </main>

    <!-- JavaScript for opening/closing modals -->
    <script src="js/registermodal.js"></script>
</body>

</html>