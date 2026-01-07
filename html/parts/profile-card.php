<!-- ========================================
     PROFILE CARD
     ========================================
     Shows the user's profile information and action buttons
-->
<div class="bg-[#D9D9D9] rounded-lg p-6 border-2 border-black shadow-lg">
    
    <!-- Card title -->
    <h2 class="text-2xl font-bold mb-4 text-[#2b2b2b] font-['Lora',serif]">Profile</h2>
    
    <!-- User avatar circle with first initial -->
    <div class="flex justify-center mb-4">
        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center border-4 border-black">
            <span class="text-white text-4xl font-bold font-['Lora',serif]">
                <?php 
                // Get the first letter of the user's first name and make it uppercase
                // substr() takes the first character (position 0, length 1)
                // strtoupper() converts it to uppercase
                echo strtoupper(substr($_SESSION['firstName'], 0, 1)); 
                ?>
            </span>
        </div>
    </div>

    <!-- User information section -->
    <div class="space-y-3 text-[#2b2b2b]">
        
        <!-- Full name -->
        <div>
            <p class="text-sm text-gray-600 font-semibold">Name</p>
            <p class="text-lg">
                <?php 
                // Combine first and last name with a space between them
                // htmlspecialchars() prevents security issues by escaping special characters
                echo htmlspecialchars($_SESSION['firstName'] . ' ' . $_SESSION['lastName']); 
                ?>
            </p>
        </div>
        
        <!-- Email address -->
        <div>
            <p class="text-sm text-gray-600 font-semibold">Email</p>
            <p class="text-lg"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
        </div>
        
        <!-- Address and postal code -->
        <div>
            <p class="text-sm text-gray-600 font-semibold">Address</p>
            <p class="text-lg"><?php echo htmlspecialchars($_SESSION['address']); ?></p>
            <p class="text-lg"><?php echo htmlspecialchars($_SESSION['postalCode']); ?></p>
        </div>
    </div>

    <!-- Action buttons section -->
    <div class="mt-6 space-y-3">
        
        <!-- Admin dashboard button (only shown if user is an admin) -->
        <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1): ?>
            <a href="admin-dashboard.php" class="block w-full px-4 py-3 bg-gradient-to-r from-red-600 to-gray-600 text-white text-center rounded-lg hover:from-purple-700 hover:to-blue-700 transition font-semibold border-2 border-purple-800 shadow-lg">
                🛡️ Admin Dashboard
            </a>
        <?php endif; ?>
        
        <!-- Edit profile button (opens modal via JavaScript) -->
        <button onclick="openEditProfileModal()" class="w-full px-4 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition font-semibold">
            Edit Profile
        </button>
        
        <!-- Logout button (submits form to logout.php) -->
        <form action="" method="post">
            <button name="logout" type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                Log Out
            </button>
        </form>
    </div>
</div>