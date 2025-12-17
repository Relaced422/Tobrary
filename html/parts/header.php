

<!-- Header part -->
<header class="flex flex-col sticky top-0 z-50">
    <section class="bg-[#1F1F1F] flex justify-evenly items-center border-2 border-color-[#D9D9D9]">
        <!-- Tobrary logo button that redirects to index.php -->
        <a href="index.php">
            <div class="bg-[#D9D9D9] py-1 px-10 rounded-[50px] m-1">
                <img src="/img/logo.png" alt="Logo image" class="max-h-[70px] p-1">
            </div>
        </a>
        <!-- Decorative stripes -->
        <img src="img/header-stripes.png" alt="Stripes for decoration" class="max-h-[100px]">
        <!-- Search bar -->
        <form
            class="h-[60px] bg-[#D9D9D9] rounded-[50px] text-center flex items-center justify-end m-2 gap-4 font-['Indie_Flower',cursive] text-3xl w-[50vw]">
            <div class="flex justify-center w-[80%] h-[100%] items-center">
                <input type="text" placeholder="For a mind that wanders.."
                    class="bg-[#D9D9D9] w-[50vw] h-[60%] text-center outline-none ml-3">
            </div>
        <!-- Search confirm button -->
            <div class="flex h-[100%]">
                <div class="bg-black h-[100%]"> </div>
                <button type="submit" class="mx-5">
                    <img src="img/magnifying-glass-icon.png" alt="Search" class="max-h-[100%]">
                </button>
            </div>
        </form>
        <!-- Decorative stripes -->
        <img src="img/header-stripes.png" alt="Stripes for decoration" class="max-h-[100px]">
        <!-- Nav toggle foldout button -->
        <button class="bg-[#D9D9D9] py-1 px-4 rounded-full mx-3 w-[10vw] flex justify-center">
            <img id="arrowButton" src="img/arrow-button.png" alt="Arrow button" class="max-h-[50px]">
        </button>
    </section>
    <!-- Foldout section for nav -->
    <section id="navSection"
        class="flex flex-col overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
        <div
            class="bg-[url('/img/foldout-pages-background.png')] h-[100px] flex justify-evenly items-center border-3 border-color-black">
            <!-- Nav buttons -->
            <nav class="flex font-['Indie_Flower',cursive] text-3xl text-white w-[100%] justify-evenly">
                <a href="index.php"
                    class="hover:underline py-4 px-8 bg-black rounded-[40px] border-white border-2">Catalogue</a>
                <a href="about.php"
                    class="hover:underline py-4 px-8 bg-black rounded-[40px] border-white border-2">Discover</a>
                <a href="blog.php" class="hover:underline py-4 px-8 bg-black rounded-[40px] border-white border-2">About
                    us</a>
                <a href="loginpage.php"
                    class="hover:underline py-4 px-8 bg-black rounded-[40px] border-white border-2">Account</a>
            </nav>

        </div>
        <!-- Black line underneath the foldout -->
        <div class="w-full h-2 bg-black"></div>
    </section>
</header>