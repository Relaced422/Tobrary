<!-- ========================================
     REGISTRATION MODAL
     ========================================
     This popup form allows new users to create an account
     Hidden by default, opens when user clicks "Register here" button
-->
<div id="registerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    
    <!-- Modal container -->
    <div class="bg-[#D9D9D9] rounded-2xl shadow-2xl p-8 border-4 border-[#2b2b2b] relative overflow-hidden max-w-md w-full max-h-[90vh] overflow-y-auto">
        
        <!-- Close button (X) in top right corner -->
        <button onclick="closeRegisterModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 text-3xl font-bold">×</button>
        
        <!-- Decorative background circle (purely visual) -->
        <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full -ml-16 -mt-16 blur-2xl"></div>
        
        <!-- Main content (z-10 puts it above the decorative circle) -->
        <div class="relative z-10">
            
            <!-- Modal title -->
            <h1 class="text-4xl font-bold mb-2 text-center text-[#2b2b2b] font-['Lora',serif]">Join Tobrary</h1>
            <p class="text-center text-gray-600 mb-6">Create your account and start reading</p>
            
            <!-- Registration form - sends data to register.php when submitted -->
            <form action="" method="POST" class="flex flex-col gap-4">
                
                <!-- First and Last name (side by side in 2 columns) -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">First Name</label>
                        <input type="text" 
                               name="firstName" 
                               required 
                               placeholder="John" 
                               class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">Last Name</label>
                        <input type="text" 
                               name="lastName" 
                               required 
                               placeholder="Doe" 
                               class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white">
                    </div>
                </div>

                <!-- Address field -->
                <div>
                    <label class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">Address</label>
                    <input type="text" 
                           name="address" 
                           required 
                           placeholder="123 Main Street" 
                           class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white">
                </div>

                <!-- Postal code field -->
                <div>
                    <label class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">Postal Code</label>
                    <!-- pattern attribute ensures format is: 4 numbers + optional space + 2 letters -->
                    <input type="text" 
                           name="postalCode" 
                           required 
                           placeholder="1234 AB" 
                           pattern="[0-9]{4}\s?[A-Za-z]{2}" 
                           class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white">
                </div>

                <!-- Email field -->
                <div>
                    <label class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">Email</label>
                    <input type="email" 
                           name="email" 
                           required 
                           placeholder="your.email@example.com" 
                           class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white">
                </div>

                <!-- Password field -->
                <div>
                    <label class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">Password</label>
                    <!-- minlength="8" requires at least 8 characters -->
                    <input type="password" 
                           name="password" 
                           required 
                           placeholder="••••••••" 
                           minlength="8" 
                           class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition bg-white">
                </div>

                <!-- Submit button -->
                <button type="submit" 
                        name="register_submit" 
                        class="w-full px-4 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold text-lg border-2 border-purple-800 mt-2 font-['Lora',serif]">
                    Create Account →
                </button>
            </form>

            <!-- Include the PHP file that processes the registration -->
            <?php include 'logic-php/register.php'; ?>
        </div>
    </div>
</div>