<!-- Edit Profile Modal - Hidden by default, shows when user clicks "Edit Profile" -->
<div id="editProfileModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    
    <!-- Modal container -->
    <div class="bg-[#D9D9D9] rounded-2xl shadow-2xl p-8 border-4 border-[#2b2b2b] relative max-w-md w-full max-h-[90vh] overflow-y-auto">
        
        <!-- Close button (X) in top right corner -->
        <button onclick="closeEditProfileModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 text-3xl font-bold">×</button>
        
        <!-- Modal title -->
        <h1 class="text-4xl font-bold mb-6 text-center text-[#2b2b2b] font-['Lora',serif]">Edit Profile</h1>
        
        <!-- Edit profile form -->
        <form action="" method="POST" class="flex flex-col gap-4">
            
            <!-- First and Last Name (side by side) -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">First Name</label>
                    <!-- Pre-fill with current first name from session -->
                    <!-- htmlspecialchars prevents XSS attacks by converting special characters -->
                    <input type="text" name="firstName" required value="<?php echo htmlspecialchars($_SESSION['firstName']); ?>" class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 bg-white">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Last Name</label>
                    <!-- Pre-fill with current last name from session -->
                    <input type="text" name="lastName" required value="<?php echo htmlspecialchars($_SESSION['lastName']); ?>" class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 bg-white">
                </div>
            </div>

            <!-- Email field -->
            <div>
                <label class="block text-sm font-semibold mb-2">Email</label>
                <!-- Pre-fill with current email from session -->
                <input type="email" name="email" required value="<?php echo htmlspecialchars($_SESSION['email']); ?>" class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 bg-white">
            </div>

            <!-- Address field -->
            <div>
                <label class="block text-sm font-semibold mb-2">Address</label>
                <!-- Pre-fill with current address from session -->
                <input type="text" name="address" required value="<?php echo htmlspecialchars($_SESSION['address']); ?>" class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 bg-white">
            </div>

            <!-- Postal Code field -->
            <div>
                <label class="block text-sm font-semibold mb-2">Postal Code</label>
                <!-- Pre-fill with current postal code from session -->
                <!-- pattern ensures format is: 4 numbers + optional space + 2 letters (e.g., 1234AB or 1234 AB) -->
                <input type="text" name="postalCode" required value="<?php echo htmlspecialchars($_SESSION['postalCode']); ?>" pattern="[0-9]{4}\s?[A-Za-z]{2}" class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-green-500 bg-white">
            </div>

            <!-- Submit button -->
            <button type="submit" name="update_profile" class="w-full px-4 py-4 bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-lg hover:from-green-700 hover:to-blue-700 shadow-lg font-bold text-lg border-2 border-green-800">
                Save Changes
            </button>
        </form>

        <!-- Include the PHP file that processes the form when submitted -->
        <?php include 'logic-php/edit-profile.php'; ?>
    </div>
</div>