<?php
session_start();
include 'parts/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"">
</head>

<body class="bg-gradient-to-br from-black to-gray-900 text-gray-200 min-h-screen font-sans">

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-pattern text-center py-24 px-8 border-b border-red-500/20">
        <h1 class="text-5xl md:text-6xl font-black tracking-widest mb-4 hero-gradient-text">ABOUT US</h1>
        <p class="text-xl text-gray-400 tracking-widest max-w-2xl mx-auto">
            A modern library built for curious minds and lifelong learners
        </p>
    </section>

     <!-- ===== OUR STORY SECTION ===== -->
    <section class="max-w-7xl mx-auto px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <!-- Text block -->
            <div class="fade-in">
                <h2 class="section-title text-3xl font-bold text-white tracking-wider mb-8">Our Story</h2>
                <p class="text-gray-400 leading-relaxed mb-6">
                    Tobrary was founded with a simple belief: that access to knowledge should be effortless. 
                    What started as a small community reading room in the heart of the Innovation District 
                    has grown into a fully digital library platform serving thousands of readers every month.
                </p>
                <p class="text-gray-400 leading-relaxed mb-6">
                    We combine the warmth and trust of a traditional library with the convenience of 
                    modern technology — letting you browse, reserve, and manage your reading list entirely online.
                </p>
                <!-- Highlighted quote with red left border -->
                <div class="quote-bar my-8">
                    <p class="text-white text-lg italic leading-relaxed">
                        "We believe every great journey starts with a single page."
                    </p>
                </div>
                <p class="text-gray-400 leading-relaxed">
                    Today, our collection spans thousands of titles across dozens of genres — 
                    from timeless classics to the latest releases — all available to members of our community.
                </p>
            </div>

            <!-- Image block -->
            <!-- 
                This is a placeholder image box. Replace the <div> below with an <img> tag
                pointing to a real photo of your library once you have one.
                Example: <img src="img/about/library.jpg" alt="Tobrary interior" class="w-full h-96 object-cover rounded-2xl">
            -->
            <div class="fade-in">
                <div class="w-full h-96 bg-gray-900/80 rounded-2xl border border-red-500/20 flex items-center justify-center overflow-hidden relative">
                    <img src="img/store.png" alt="Tobrary storefront" class="w-full h-full object-cover">
                </div>
            </div>

        </div>
    </section>

    <!-- ===== STATS SECTION =====
         Four numbers that show the library at a glance.
    -->
    <section class="bg-gray-950/80 border-t border-b border-red-500/20 py-16 px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">

            <!-- Each stat card -->
            <div class="fade-in">
                <p class="text-5xl font-black hero-gradient-text mb-2">100+</p>
                <p class="text-gray-500 text-sm uppercase tracking-widest">Books in Collection</p>
            </div>
            <div class="fade-in">
                <p class="text-5xl font-black hero-gradient-text mb-2">1+</p>
                <p class="text-gray-500 text-sm uppercase tracking-widest">Active Members</p>
            </div>
            <div class="fade-in">
                <p class="text-5xl font-black hero-gradient-text mb-2">40+</p>
                <p class="text-gray-500 text-sm uppercase tracking-widest">Genres Available</p>
            </div>
            <div class="fade-in">
                <p class="text-5xl font-black hero-gradient-text mb-2">2026</p>
                <p class="text-gray-500 text-sm uppercase tracking-widest">Year Founded</p>
            </div>

        </div>
    </section>

    <!-- ===== MISSION & VALUES SECTION ===== -->
    <section class="max-w-7xl mx-auto px-8 py-20">

        <h2 class="section-title text-3xl font-bold text-white tracking-wider mb-12">Our Mission & Values</h2>

        <!-- Three value cards side by side (stacked on mobile) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Card 1 -->
            <!-- Same card style as book cards and contact info cards -->
            <div class="bg-gray-900/80 rounded-2xl p-8 border border-red-500/20 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                <div class="text-4xl mb-4">🌍</div>
                <h3 class="text-white font-bold text-xl mb-3">Open Access</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    We believe knowledge belongs to everyone. Our collection is accessible to all members 
                    of the community, regardless of background or experience.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-gray-900/80 rounded-2xl p-8 border border-red-500/20 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                <div class="text-4xl mb-4">💡</div>
                <h3 class="text-white font-bold text-xl mb-3">Inspire Curiosity</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    From children's books to advanced research texts, we curate our collection to 
                    spark curiosity and encourage a lifelong love of learning.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="bg-gray-900/80 rounded-2xl p-8 border border-red-500/20 hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                <div class="text-4xl mb-4">🤝</div>
                <h3 class="text-white font-bold text-xl mb-3">Community First</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Tobrary is more than a library — it's a gathering place for readers, thinkers, 
                    and creators. We host book clubs, lectures, and community events year-round.
                </p>
            </div>

        </div>
    </section>

    <!-- ===== TEAM SECTION ===== -->
    <section class="bg-gray-950/80 border-t border-red-500/20 py-20 px-8">
        <div class="max-w-7xl mx-auto">

            <h2 class="section-title text-3xl font-bold text-white tracking-wider mb-12">Meet the Team</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                <!-- Team member card -->
                <!-- 
                    The avatar circle uses initials as a placeholder.
                    Replace with <img> tags once you have real photos.
                -->
                <div class="bg-gray-900/80 rounded-2xl p-6 border border-red-500/20 text-center hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <!-- Avatar circle with initials -->
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-red-600 to-red-900 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        SJ
                    </div>
                    <h3 class="text-white font-bold text-lg mb-1">Sara Johnson</h3>
                    <p class="text-red-400 text-sm mb-3">Head Librarian</p>
                    <p class="text-gray-500 text-xs leading-relaxed">
                        15 years of experience curating collections and helping readers find their next favourite book.
                    </p>
                </div>

                <div class="bg-gray-900/80 rounded-2xl p-6 border border-red-500/20 text-center hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-red-600 to-red-900 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        TQ
                    </div>
                    <h3 class="text-white font-bold text-lg mb-1">Tobi Quenum</h3>
                    <p class="text-red-400 text-sm mb-3">Digital Systems Lead</p>
                    <p class="text-gray-500 text-xs leading-relaxed">
                        Built and maintains the Tobrary platform, keeping the catalogue fast, reliable and up to date.
                    </p>
                </div>

                <div class="bg-gray-900/80 rounded-2xl p-6 border border-red-500/20 text-center hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-red-600 to-red-900 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        LP
                    </div>
                    <h3 class="text-white font-bold text-lg mb-1">Lisa Park</h3>
                    <p class="text-red-400 text-sm mb-3">Community Manager</p>
                    <p class="text-gray-500 text-xs leading-relaxed">
                        Organises book clubs, author events, and reading programmes for all ages throughout the year.
                    </p>
                </div>

                <div class="bg-gray-900/80 rounded-2xl p-6 border border-red-500/20 text-center hover:border-red-500/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-red-600 to-red-900 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        TR
                    </div>
                    <h3 class="text-white font-bold text-lg mb-1">Tom Reyes</h3>
                    <p class="text-red-400 text-sm mb-3">Acquisitions Editor</p>
                    <p class="text-gray-500 text-xs leading-relaxed">
                        Responsible for selecting new titles and keeping the collection fresh with the latest releases.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== CALL TO ACTION =====
         Encourages visitors to sign up or browse books.
    -->
    <section class="hero-pattern py-20 px-8 border-t border-red-500/20 text-center">
        <h2 class="text-3xl font-bold text-white mb-4 tracking-wider">Ready to Start Reading?</h2>
        <p class="text-gray-400 mb-10 max-w-xl mx-auto">
            Join thousands of readers and get access to our full collection today. It's free to register.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="register.php"
                class="px-10 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded font-bold uppercase tracking-wide transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/40 no-underline">
                Create an Account
            </a>
            <a href="books.php"
                class="px-10 py-4 bg-transparent border border-red-500/40 text-red-400 rounded font-bold uppercase tracking-wide transition-all duration-300 hover:bg-red-500/10 hover:-translate-y-1 no-underline">
                Browse Books
            </a>
        </div>
    </section>

    <?php include 'parts/footer.php'; ?>

</body>
</html>