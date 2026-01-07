<!-- ========================================
     HEADER SECTION
     ========================================
     This is the top navigation bar that appears on every page
     It contains: logo, search bar, and navigation menu
-->
<header class="flex flex-col sticky top-0 z-50">
    
    <!-- Main header bar -->
    <section class="bg-[#1F1F1F] flex justify-evenly items-center border-2 border-color-[#D9D9D9]">
        
        <!-- Logo - clicking it takes you to the homepage -->
        <a href="index.php">
            <div class="bg-[#D9D9D9] py-1 px-10 rounded-[50px] m-1">
                <img src="/img/logo.png" alt="Tobrary logo" class="max-h-[70px] p-1">
            </div>
        </a>
        
        <!-- Decorative stripes (hidden on mobile, shown on medium screens and up) -->
        <img src="/img/header-stripes.png" alt="Decorative stripes" class="max-h-[100px] hidden md:block">
        
        <!-- Search form -->
        <form class="h-[60px] bg-[#D9D9D9] rounded-[50px] text-center flex items-center justify-end m-2 gap-4 font-['Indie_Flower',cursive] text-3xl w-[50vw]">
            
            <!-- Search input field container -->
            <div class="flex justify-center w-[80%] h-[100%] items-center">
                <input type="text" 
                       placeholder="For a mind that wanders.."
                       class="bg-[#D9D9D9] w-[50vw] h-[60%] text-center outline-none ml-3">
            </div>
            
            <!-- Search button -->
            <div class="flex h-[100%]">
                <!-- Black divider line -->
                <div class="bg-black h-[100%]"></div>
                <!-- Submit button with magnifying glass icon -->
                <button type="submit" class="mx-5">
                    <img src="/img/magnifying-glass-icon.png" alt="Search button" class="max-h-[100%]">
                </button>
            </div>
        </form>
        
        <!-- Decorative stripes (hidden on mobile, shown on medium screens and up) -->
        <img src="/img/header-stripes.png" alt="Decorative stripes" class="max-h-[100px] hidden md:block">
        
        <!-- Navigation menu toggle button (arrow) -->
        <button class="bg-[#D9D9D9] py-1 px-4 rounded-full mx-3 w-[10vw] flex justify-center" 
                aria-label="Toggle navigation menu">
            <img id="arrowButton" src="/img/arrow-button.png" alt="Toggle menu" class="max-h-[50px]">
        </button>
    </section>
    
    <!-- Navigation menu (hidden by default, opens when arrow button is clicked) -->
    <section id="navSection" class="flex flex-col overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
        
        <!-- Navigation container with background image -->
        <div class="bg-[url('/img/foldout-pages-background.png')] h-[100px] flex justify-evenly items-center border-3 border-color-black">
            
            <!-- Navigation links -->
            <nav class="flex font-['Indie_Flower',cursive] text-3xl text-white w-[100%] justify-evenly">
                <!-- Link to catalogue page -->
                <a href="index.php" class="hover:underline py-4 px-8 bg-black rounded-[40px] border-white border-2">
                    Catalogue
                </a>
                <!-- Link to discover page -->
                <a href="about.php" class="hover:underline py-4 px-8 bg-black rounded-[40px] border-white border-2">
                    Discover
                </a>
                <!-- Link to about us page -->
                <a href="blog.php" class="hover:underline py-4 px-8 bg-black rounded-[40px] border-white border-2">
                    About us
                </a>
                <!-- Link to account/login page -->
                <a href="loginpage.php" class="hover:underline py-4 px-8 bg-black rounded-[40px] border-white border-2">
                    Account
                </a>
            </nav>
        </div>
        
        <!-- Decorative black line at the bottom of the navigation menu -->
        <div class="w-full h-2 bg-black"></div>
    </section>
</header>