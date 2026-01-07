<!-- ========================================
     LOGIN FORM
     ========================================
     This is the login form shown to users who are not logged in
-->
<div class="flex flex-col items-center w-full max-w-md mx-auto">
    
    <!-- Login card container -->
    <div class="w-full bg-[#D9D9D9] rounded-2xl shadow-2xl p-8 border-2 border-[#2b2b2b] relative overflow-hidden">
        
        <!-- Decorative background circle (purely visual) -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full -mr-16 -mt-16 blur-2xl"></div>
        
        <!-- Main content (z-10 puts it above the decorative circle) -->
        <div class="relative z-10">
            
            <!-- Welcome heading (responsive text size: smaller on mobile, larger on desktop) -->
            <h1 class="text-3xl md:text-5xl font-bold mb-2 text-center text-[#2b2b2b] font-['Lora',serif]">
                Welcome Back!
            </h1>
            
            <!-- Subtitle -->
            <p class="text-center text-lg md:text-xl text-gray-600 mb-8">
                Log in to access your digital library
            </p>
            
            <!-- Login form - sends data to login.php when submitted -->
            <form action="" method="POST" class="flex flex-col gap-5">
                
                <!-- Email input field -->
                <div>
                    <label for="login-email" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                        Email Address
                    </label>
                    <input type="email" 
                           id="login-email" 
                           name="email" 
                           required 
                           placeholder="your.email@example.com" 
                           class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition bg-white">
                </div>

                <!-- Password input field -->
                <div>
                    <label for="login-password" class="block text-sm font-semibold text-[#2b2b2b] mb-2 font-['Lora',serif]">
                        Password
                    </label>
                    <input type="password" 
                           id="login-password" 
                           name="password" 
                           required 
                           placeholder="••••••••" 
                           class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition bg-white">
                </div>

                <!-- Submit button -->
                <button type="submit" 
                        name="login_submit" 
                        class="w-full px-4 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 font-bold text-lg border-2 border-blue-800 font-['Lora',serif]">
                    Log In →
                </button>
            </form>

            <!-- Include the PHP file that processes the login -->
            <?php include 'logic-php/login.php'; ?>

            <!-- Link to open registration modal -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Don't have an account? 
                    <!-- Button opens the registration modal (handled by JavaScript) -->
                    <button onclick="openRegisterModal()" class="text-blue-600 font-semibold hover:underline">
                        Register here
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>