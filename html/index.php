<?php
// ========================================
// HOMEPAGE (INDEX.PHP)
// ========================================
// This is the main landing page of the Tobrary website

// Start the session to check if user is logged in
session_start();

// Check if the session has any data (meaning user is logged in)
$isLoggedIn = !empty($_SESSION);

// Connect to the database to get recent books
require_once 'logic-php/connection.php';

// Get the 10 most recently added books from the database
// This query joins three tables: books, authors, and genres
// CONCAT combines firstName and lastName into one "author" field
$recentBooksQuery = "
    SELECT 
        b.bookId, 
        b.title, 
        b.description, 
        b.coverImage, 
        CONCAT(a.firstName, ' ', a.lastName) as author, 
        g.genreName 
    FROM books b 
    JOIN authors a ON b.authorId = a.authorId 
    JOIN genres g ON b.genreId = g.genreId 
    ORDER BY b.createdAt DESC 
    LIMIT 10
";
$recentBooks = $pdo->query($recentBooksQuery)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tobrary - Your Digital Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <style>
        /* Hide scrollbar but keep scroll functionality */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="font-['Manrope',sans-serif]">
    <!-- Fixed gradient background -->
    <div class="fixed inset-0 bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F] -z-10"></div>
    
    <!-- Include the header navigation -->
    <?php include 'parts/header.php'; ?>
    
    <main>
        <!-- ========================================
             HERO SECTION
             ========================================
             Main welcome banner at the top of the page
        -->
        <div class="bg-[#D9D9D9] w-[70vw] mx-auto rounded-[20px] mt-10 shadow-lg p-5">
            
            <!-- Main heading -->
            <h1 class="text-black text-[50px] pt-20 font-['Lora',serif] font-bold text-center">
                Tobrary - Your digital library realm.
            </h1>
            
            <!-- Subheading -->
            <h2 class="text-black text-2xl text-center">
                Dive into knowledge from the comfort of your couch.
            </h2>
            
            <!-- Buttons section -->
            <div class="flex justify-evenly items-center mt-10">
                
                <?php if (!$isLoggedIn): ?>
                    <!-- Show these buttons if user is NOT logged in -->
                    
                    <!-- Browse Books button -->
                    <a href="#" class="bg-[#6F6F6F] p-4 rounded-xl text-white text-2xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Browse Books
                    </a>
                    
                    <!-- Decorative book icon -->
                    <img src="img/book-icon.png" alt="Book icon" class="min-w-[200px]">
                    
                    <!-- Login / Register button -->
                    <a href="loginpage.php" class="bg-[#6F6F6F] p-4 rounded-xl text-white text-2xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Log in / Join
                    </a>
                    
                <?php else: ?>
                    <!-- Show this if user IS logged in -->
                    
                    <div class="flex flex-col items-center">
                        <!-- Browse Books button (centered) -->
                        <a href="#" class="bg-[#6F6F6F] p-4 rounded-xl text-white text-2xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                            Browse Books
                        </a>
                        
                        <!-- Decorative book icon below button -->
                        <img src="img/book-icon.png" alt="Book icon" class="min-w-[200px] mt-4">
                    </div>
                    
                <?php endif; ?>
            </div>
        </div>

        <!-- ========================================
             NAVIGATION GRID (Logged in users only)
             ========================================
             Shows quick links to different sections
        -->
        <?php if ($isLoggedIn): ?>
        <div class="w-[70vw] mx-auto mt-16">
            <div class="bg-[#D9D9D9] rounded-[20px] p-8 shadow-lg">
                
                <!-- Grid with 4 navigation buttons -->
                <div class="grid grid-cols-2 gap-4 relative">
                    
                    <!-- Borrowed Books button -->
                    <a href="#" class="bg-[#6F6F6F] text-white rounded-full py-4 px-8 text-center text-xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Borrowed Books
                    </a>
                    
                    <!-- Search Catalog button -->
                    <a href="#" class="bg-[#6F6F6F] text-white rounded-full py-4 px-8 text-center text-xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Search Catalog
                    </a>
                    
                    <!-- Currently Reading button -->
                    <a href="#" class="bg-[#6F6F6F] text-white rounded-full py-4 px-8 text-center text-xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Currently Reading
                    </a>
                    
                    <!-- Favourites button -->
                    <a href="#" class="bg-[#6F6F6F] text-white rounded-full py-4 px-8 text-center text-xl font-['Lora',serif] font-semibold hover:bg-[#5F5F5F] transition">
                        Favourites
                    </a>
                    
                    <!-- Center logo icon (positioned in the middle of the 4 buttons) -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#3A3A3A] w-24 h-24 flex items-center justify-center rounded-lg border-4 border-black">
                        <span class="text-white text-6xl font-bold font-['Lora',serif]">T</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- ========================================
             RECENTLY ADDED BOOKS CAROUSEL
             ========================================
             Horizontal scrolling list of new books
        -->
        <div class="w-[70vw] mx-auto mt-16 pb-16">
            
            <!-- Section heading -->
            <h2 class="text-white text-4xl font-bold text-center mb-8 font-['Lora',serif]">
                Nieuw toegevoegd
            </h2>

            <div class="relative">
                
                <!-- Left scroll button -->
                <button onclick="scrollBooks('left')" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-12 bg-[#D9D9D9] hover:bg-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition z-10">
                    <span class="text-2xl font-bold">‹</span>
                </button>

                <!-- Books container (scrollable horizontally) -->
                <div id="booksContainer" class="flex gap-6 overflow-x-auto scroll-smooth scrollbar-hide">
                    
                    <?php 
                    // Loop through each book and display it
                    foreach ($recentBooks as $book): 
                    ?>
                    
                    <!-- Single book card -->
                    <div class="bg-[#D9D9D9] rounded-lg shadow-lg flex-shrink-0 w-[500px] p-4 flex gap-4">
                        
                        <!-- Book cover image -->
                        <div class="w-48 h-64 bg-white rounded-lg border-4 border-black overflow-hidden">
                            <img src="img/books/<?= htmlspecialchars($book['coverImage']) ?>" 
                                 alt="<?= htmlspecialchars($book['title']) ?>" 
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Book details section -->
                        <div class="flex-1 flex flex-col">
                            
                            <!-- Title and description box -->
                            <div class="bg-white rounded-lg p-4 border-2 border-black mb-2">
                                <!-- Book title -->
                                <h3 class="text-2xl font-bold font-['Lora',serif] mb-2">
                                    <?= htmlspecialchars($book['title']) ?>
                                </h3>
                                
                                <!-- Book description (scrollable if too long) -->
                                <div class="text-sm overflow-y-auto max-h-40">
                                    <p><?= htmlspecialchars($book['description']) ?></p>
                                </div>
                            </div>
                            
                            <!-- Author and Genre boxes -->
                            <div class="flex gap-2">
                                <!-- Author box -->
                                <div class="bg-white rounded-lg px-4 py-2 border-2 border-black flex-1">
                                    <p class="text-xs font-['Lora',serif] font-semibold">Author:</p>
                                    <p class="text-sm"><?= htmlspecialchars($book['author']) ?></p>
                                </div>
                                
                                <!-- Genre box -->
                                <div class="bg-white rounded-lg px-4 py-2 border-2 border-black">
                                    <p class="text-xs font-['Lora',serif] font-semibold">Genre:</p>
                                    <p class="text-sm"><?= htmlspecialchars($book['genreName']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php endforeach; ?>
                    
                </div>

                <!-- Right scroll button -->
                <button onclick="scrollBooks('right')" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-12 bg-[#D9D9D9] hover:bg-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition z-10">
                    <span class="text-2xl font-bold">›</span>
                </button>
            </div>
        </div>
    </main>

    <!-- Include JavaScript files -->
    <script src="js/header.js"></script>
    <script src="js/carousel.js"></script>
</body>
</html>