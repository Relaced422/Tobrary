    <!-- ===== HEADER WITH NAVIGATION ===== -->
    <!-- sticky = stays at top when scrolling, top-0 = positioned at top -->
    <!-- z-50 = high z-index so it stays above other content -->
    <header class="bg-black/95 shadow-lg sticky top-0 z-50 border-b-2 border-red-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-wrap justify-between items-center gap-4">
                
                <!-- Logo/Brand -->
                <!-- text-3xl = large text, font-bold = bold, tracking-wider = letter spacing -->
                <a href="index.php" class="text-3xl font-bold tracking-widest gradient-text no-underline">
                    TOBRARY
                </a>
                
                <!-- Main Navigation Menu -->
                <!-- flex = flexbox, gap-6 = spacing between items -->
                <nav class="flex flex-wrap gap-6 items-center">
                    <!-- hover:text-red-500 = red text on hover -->
                    <!-- transition = smooth animation, rounded = rounded corners -->
                    <a href="books.php" class="text-gray-200 no-underline transition-all duration-300 px-4 py-2 rounded hover:text-red-500 hover:bg-red-500/10 uppercase text-sm tracking-wide">Books</a>
                    <a href="genres.php" class="text-gray-200 no-underline transition-all duration-300 px-4 py-2 rounded hover:text-red-500 hover:bg-red-500/10 uppercase text-sm tracking-wide">Genres</a>
                    <a href="authors.php" class="text-gray-200 no-underline transition-all duration-300 px-4 py-2 rounded hover:text-red-500 hover:bg-red-500/10 uppercase text-sm tracking-wide">Authors</a>
                    <a href="about.php" class="text-gray-200 no-underline transition-all duration-300 px-4 py-2 rounded hover:text-red-500 hover:bg-red-500/10 uppercase text-sm tracking-wide">About Us</a>
                    <a href="contact.php" class="text-gray-200 no-underline transition-all duration-300 px-4 py-2 rounded hover:text-red-500 hover:bg-red-500/10 uppercase text-sm tracking-wide">Contact</a>
                </nav>
                
                <!-- User Account Buttons -->
                <div class="flex gap-4 items-center">
                    <?php if(isset($_SESSION['userId'])): ?>
                        <!-- If user is logged in, show account and logout -->
                        <!-- bg-transparent = no background, border-2 = 2px border -->
                        <a href="account.php" class="px-6 py-3 rounded border-2 border-gray-600 text-gray-200 no-underline font-semibold transition-all duration-300 hover:bg-gray-800 hover:border-gray-500 uppercase text-sm tracking-wide">My Account</a>
                        
                        <!-- bg-gradient-to-r = gradient from left to right -->
                        <!-- shadow-lg = large shadow, hover:-translate-y-1 = lift up on hover -->
                        <a href="logout.php" class="px-6 py-3 rounded bg-gradient-to-r from-red-600 to-red-700 text-white no-underline font-semibold transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/50 uppercase text-sm tracking-wide">Logout</a>
                    <?php else: ?>
                        <!-- If user is not logged in, show login and register -->
                        <a href="login.php" class="px-6 py-3 rounded border-2 border-gray-600 text-gray-200 no-underline font-semibold transition-all duration-300 hover:bg-gray-800 hover:border-gray-500 uppercase text-sm tracking-wide">Login</a>
                        <a href="register.php" class="px-6 py-3 rounded bg-gradient-to-r from-red-600 to-red-700 text-white no-underline font-semibold transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/50 uppercase text-sm tracking-wide">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>