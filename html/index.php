<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tobrary - Where Knowledge Meets Innovation</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style src="css/style.css"></style>
</head>

<?php include 'parts/header.php'; ?>

<body class="bg-gradient-to-br from-black to-gray-900 text-gray-200 min-h-screen font-sans">
    
    <!-- HERO SECTION -->
    <section class="hero-pattern text-center py-24 px-8 border-b border-red-500/20">
        <h1 class="text-6xl mb-4 hero-gradient-text font-black tracking-widest">TOBRARY</h1>
        <p class="text-xl text-gray-400 mb-12 tracking-widest">Where Knowledge Meets Innovation</p>
        
        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto">
            <form action="search.php" method="GET" class="flex flex-col sm:flex-row gap-4 shadow-2xl rounded-full overflow-hidden border-2 border-red-500/30">
                <input 
                    type="text" 
                    name="q" 
                    class="flex-1 px-8 py-5 border-0 bg-gray-900/90 text-white text-base outline-none placeholder-gray-600" 
                    placeholder="Search for books, authors, or genres..."
                    required
                >
                <button type="submit" class="px-10 py-5 bg-gradient-to-r from-red-600 to-red-700 text-white border-0 cursor-pointer font-bold transition-all duration-300 hover:from-red-500 hover:to-red-600 uppercase tracking-wide">
                    Search
                </button>
            </form>
        </div>
    </section>
    
    <!-- FEATURED BOOKS SECTION -->
    <section class="py-16 px-8 max-w-7xl mx-auto">
        <h2 class="section-title text-center text-4xl mb-12 text-white tracking-wider">Featured Books</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Book Card 1 -->
            <div class="bg-gray-900/80 rounded-2xl overflow-hidden transition-all duration-300 border border-red-500/20 shadow-xl hover:-translate-y-3 hover:shadow-2xl hover:shadow-red-500/30 hover:border-red-500/50 group">
                <div class="book-cover-pattern w-full h-80 flex items-center justify-center relative overflow-hidden"></div>
                <div class="p-6">
                    <h3 class="text-xl mb-2 text-white font-semibold">Sample Book Title</h3>
                    <p class="text-red-500 text-base mb-2">by Sample Author</p>
                    <span class="inline-block bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs mb-4">Fiction</span>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4 line-clamp-3">
                        This is a sample book description that will be displayed here.
                    </p>
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span>📖 350 pages</span>
                        <span>📚 3/5 available</span>
                    </div>
                    <div class="px-4 py-2 rounded font-semibold text-center mb-4 bg-green-500/10 text-green-400">
                        ✓ Available
                    </div>
                    <a href="book-detail.php?id=1" class="block mt-4 px-6 py-3 rounded bg-gradient-to-r from-red-600 to-red-700 text-white no-underline font-semibold text-center transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/50">
                        View Details
                    </a>
                </div>
            </div>
            
            <!-- Book Card 2 -->
            <div class="bg-gray-900/80 rounded-2xl overflow-hidden transition-all duration-300 border border-red-500/20 shadow-xl hover:-translate-y-3 hover:shadow-2xl hover:shadow-red-500/30 hover:border-red-500/50 group">
                <div class="book-cover-pattern w-full h-80 flex items-center justify-center relative overflow-hidden"></div>
                <div class="p-6">
                    <h3 class="text-xl mb-2 text-white font-semibold">Another Great Book</h3>
                    <p class="text-red-500 text-base mb-2">by Another Author</p>
                    <span class="inline-block bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs mb-4">Mystery</span>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4 line-clamp-3">
                        Another engaging description for this wonderful book.
                    </p>
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span>📖 420 pages</span>
                        <span>📚 0/3 available</span>
                    </div>
                    <div class="px-4 py-2 rounded font-semibold text-center mb-4 bg-red-500/10 text-red-400">
                        ✗ Unavailable
                    </div>
                    <a href="book-detail.php?id=2" class="block mt-4 px-6 py-3 rounded bg-gradient-to-r from-red-600 to-red-700 text-white no-underline font-semibold text-center transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/50">
                        View Details
                    </a>
                </div>
            </div>
            
            <!-- Book Card 3 -->
            <div class="bg-gray-900/80 rounded-2xl overflow-hidden transition-all duration-300 border border-red-500/20 shadow-xl hover:-translate-y-3 hover:shadow-2xl hover:shadow-red-500/30 hover:border-red-500/50 group">
                <div class="book-cover-pattern w-full h-80 flex items-center justify-center relative overflow-hidden"></div>
                <div class="p-6">
                    <h3 class="text-xl mb-2 text-white font-semibold">The Last Book</h3>
                    <p class="text-red-500 text-base mb-2">by Famous Writer</p>
                    <span class="inline-block bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs mb-4">Science Fiction</span>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4 line-clamp-3">
                        A thrilling science fiction adventure awaits you.
                    </p>
                    <div class="flex justify-between text-sm text-gray-600 mb-4">
                        <span>📖 280 pages</span>
                        <span>📚 5/5 available</span>
                    </div>
                    <div class="px-4 py-2 rounded font-semibold text-center mb-4 bg-green-500/10 text-green-400">
                        ✓ Available
                    </div>
                    <a href="book-detail.php?id=3" class="block mt-4 px-6 py-3 rounded bg-gradient-to-r from-red-600 to-red-700 text-white no-underline font-semibold text-center transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/50">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        
        <!-- View All Books Button -->
        <div class="text-center mt-12">
            <a href="books.php" class="inline-block px-12 py-4 text-lg rounded bg-gradient-to-r from-red-600 to-red-700 text-white no-underline font-semibold transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/50">
                View All Books →
            </a>
        </div>
    </section>
    
    <!-- QUICK LINKS SECTION -->
    <section class="bg-gray-950/80 py-16 px-8 mt-12 border-t border-red-500/20">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <a href="genres.php" class="bg-gray-900/60 p-8 rounded-xl text-center border border-red-500/20 transition-all duration-300 no-underline hover:bg-gray-800/80 hover:border-red-500/50 hover:-translate-y-2">
                <div class="text-5xl mb-4">🎭</div>
                <h3 class="text-white mb-2 text-xl">Browse Genres</h3>
                <p class="text-gray-500 text-sm">Explore books by category</p>
            </a>
            
            <a href="authors.php" class="bg-gray-900/60 p-8 rounded-xl text-center border border-red-500/20 transition-all duration-300 no-underline hover:bg-gray-800/80 hover:border-red-500/50 hover:-translate-y-2">
                <div class="text-5xl mb-4">✍️</div>
                <h3 class="text-white mb-2 text-xl">Meet Authors</h3>
                <p class="text-gray-500 text-sm">Discover talented writers</p>
            </a>
            
            <a href="account.php" class="bg-gray-900/60 p-8 rounded-xl text-center border border-red-500/20 transition-all duration-300 no-underline hover:bg-gray-800/80 hover:border-red-500/50 hover:-translate-y-2">
                <div class="text-5xl mb-4">👤</div>
                <h3 class="text-white mb-2 text-xl">My Account</h3>
                <p class="text-gray-500 text-sm">Manage your reservations</p>
            </a>
            
            <a href="contact.php" class="bg-gray-900/60 p-8 rounded-xl text-center border border-red-500/20 transition-all duration-300 no-underline hover:bg-gray-800/80 hover:border-red-500/50 hover:-translate-y-2">
                <div class="text-5xl mb-4">📧</div>
                <h3 class="text-white mb-2 text-xl">Contact Us</h3>
                <p class="text-gray-500 text-sm">Get in touch with us</p>
            </a>
        </div>
    </section>
    
    <!-- FOOTER -->
    <?php include 'parts/footer.php'; ?>
</body>
</html>