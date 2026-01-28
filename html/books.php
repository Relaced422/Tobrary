<?php
session_start();
include 'logic-php/connection.php';
include 'parts/header.php';

// Paginatation reset
$p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if($p < 1) $p = 1;
$n = 12;

// Get total number of books
$totalBooks = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
$totalPages = ceil($totalBooks / $n);

// Ensure current page is within bounds
if($p > $totalPages) $p = $totalPages;

$offset = ($p - 1) * $n;

// Get books for this page
$booksQuery = "SELECT * FROM books ORDER BY createdAt DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($booksQuery);
$stmt->bindValue(':limit', $n, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Books - Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-gradient-to-br from-black to-gray-900 text-gray-200 min-h-screen font-sans">

    <!-- Page Title -->
    <section class="bg-gray-950/50 py-12 px-8 border-b border-red-500/20">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-5xl font-bold text-white mb-4 tracking-wider">Browse Books</h1>
            <p class="text-gray-400 text-lg">Explore our collection of books across all genres</p>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="max-w-7xl mx-auto px-8 py-8">
        <div class="bg-gray-900/60 rounded-xl p-6 border border-red-500/20">
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2 uppercase tracking-wide">Search Books</label>
                <div class="flex gap-4">
                    <input type="text" placeholder="Search by title, author, or ISBN..."
                        class="flex-1 px-4 py-3 bg-gray-800 text-white rounded border border-gray-700 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/50">
                    <button class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded font-semibold transition-all duration-300 hover:from-red-500 hover:to-red-600 uppercase tracking-wide">
                        Search
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2 uppercase tracking-wide">Genre</label>
                    <select class="w-full px-4 py-3 bg-gray-800 text-white rounded border border-gray-700 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/50">
                        <option>All Genres</option>
                        <option>Fiction</option>
                        <option>Non-Fiction</option>
                        <option>Mystery</option>
                        <option>Science Fiction</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2 uppercase tracking-wide">Author</label>
                    <select class="w-full px-4 py-3 bg-gray-800 text-white rounded border border-gray-700 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/50">
                        <option>All Authors</option>
                        <option>Harper Lee</option>
                        <option>George Orwell</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2 uppercase tracking-wide">Availability</label>
                    <select class="w-full px-4 py-3 bg-gray-800 text-white rounded border border-gray-700 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/50">
                        <option>All Books</option>
                        <option>Available Only</option>
                        <option>Unavailable</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mt-6">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-300 mb-2 uppercase tracking-wide">Sort By</label>
                    <select class="w-full px-4 py-3 bg-gray-800 text-white rounded border border-gray-700 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/50">
                        <option>Title (A-Z)</option>
                        <option>Title (Z-A)</option>
                        <option>Newest First</option>
                        <option>Oldest First</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button class="px-8 py-3 bg-gray-700 text-white rounded font-semibold transition-all duration-300 hover:bg-gray-600 uppercase tracking-wide">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Results count -->
    <section class="max-w-7xl mx-auto px-8 py-4">
        <p class="text-gray-400">
            Showing page <?php echo $p; ?> of <?php echo $totalPages; ?> (<?php echo $totalBooks; ?> total books)
        </p>
    </section>

    <!-- Books Grid -->
    <section class="max-w-7xl mx-auto px-8 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php 
            foreach ($books as $book) {
            ?>
                <div class="bg-gray-900/80 rounded-2xl overflow-hidden transition-all duration-300 border border-red-500/20 shadow-xl hover:-translate-y-3 hover:shadow-2xl hover:shadow-red-500/30 hover:border-red-500/50 group flex flex-col h-[650px]">

                    <div class="w-full h-72 flex items-center justify-center relative flex-shrink-0 bg-gray-800">
                        <img class="w-full h-full object-cover" src="img/books/<?php echo $book['coverImage']; ?>"
                            alt="<?php echo $book['title']; ?> cover">
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-lg font-semibold text-white mb-2">
                            <?php echo htmlspecialchars($book['title']); ?>
                        </h3>

                        <p class="text-red-500 text-sm mb-2">
                            by <?php echo htmlspecialchars($book['author']); ?>
                        </p>

                        <span class="inline-block bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs mb-3 w-fit">
                            <?php echo htmlspecialchars($book['genre']); ?>
                        </span>

                        <div class="mb-3">
                            <p class="text-gray-400 text-sm leading-relaxed line-clamp-3">
                                <?php echo htmlspecialchars($book['description']); ?>
                            </p>
                            <?php if (strlen($book['description']) > 100) { ?>
                                <span class="text-red-400 text-xs font-semibold">Read more...</span>
                            <?php } ?>
                        </div>

                        <div class="flex justify-between text-xs text-gray-600 mb-3">
                            <span>📖 <?php echo $book['totalPages']; ?> pages</span>
                            <span>📚 <?php echo $book['availableCopies']; ?>/<?php echo $book['totalCopies']; ?> available</span>
                        </div>

                        <?php if($book['isAvailable'] > 0) { ?>
                            <div class="px-4 py-2 rounded font-semibold text-center text-sm mb-3 bg-green-500/10 text-green-400">
                                ✓ Available
                            </div>
                        <?php } else { ?>
                            <div class="px-4 py-2 rounded font-semibold text-center text-sm mb-3 bg-red-500/10 text-red-400">
                                ✗ Not Available
                            </div>
                        <?php } ?>

                        <div class="flex-1"></div>

                        <div class="flex gap-2">
                            <a href="book-detail.php?id=<?php echo $book['bookId']; ?>"
                                class="flex-1 px-4 py-2 rounded bg-gradient-to-r from-red-600 to-red-700 text-white no-underline font-semibold text-center text-sm transition-all duration-300 hover:from-red-500 hover:to-red-600">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php if (count($books) == 0) { ?>
            <div class="text-center py-16">
                <p class="text-gray-400 text-xl">No books found.</p>
            </div>
        <?php } ?>
    </section>

    <!-- Pagination -->
    <section class="max-w-7xl mx-auto px-8 pb-16">
        <div class="flex justify-center items-center gap-2 flex-wrap">
            
            <?php if ($p > 1) { ?>
                <a href="?p=<?php echo $p - 1; ?>" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold">
                    ← Previous
                </a>
            <?php } else { ?>
                <button class="px-4 py-2 bg-gray-800 text-gray-600 rounded cursor-not-allowed" disabled>
                    ← Previous
                </button>
            <?php } ?>

            <?php 
            if ($p > 2) { ?>
                <a href="?p=1" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold">1</a>
                <?php if ($p > 3) { ?>
                    <span class="px-2 text-gray-500">...</span>
                <?php } ?>
            <?php } ?>

            <?php if ($p > 1) { ?>
                <a href="?p=<?php echo $p - 1; ?>" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold">
                    <?php echo $p - 1; ?>
                </a>
            <?php } ?>

            <a href="?p=<?php echo $p; ?>" class="px-4 py-2 bg-red-600 text-white rounded font-semibold">
                <?php echo $p; ?>
            </a>

            <?php if ($p < $totalPages) { ?>
                <a href="?p=<?php echo $p + 1; ?>" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold">
                    <?php echo $p + 1; ?>
                </a>
            <?php } ?>

            <?php if ($p < $totalPages - 1) { 
                if ($p < $totalPages - 2) { ?>
                    <span class="px-2 text-gray-500">...</span>
                <?php } ?>
                <a href="?p=<?php echo $totalPages; ?>" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold">
                    <?php echo $totalPages; ?>
                </a>
            <?php } ?>

            <?php if ($p < $totalPages) { ?>
                <a href="?p=<?php echo $p + 1; ?>" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold">
                    Next →
                </a>
            <?php } else { ?>
                <button class="px-4 py-2 bg-gray-800 text-gray-600 rounded cursor-not-allowed" disabled>
                    Next →
                </button>
            <?php } ?>
        </div>

        <div class="text-center mt-4 text-gray-400 text-sm">
            Page <?php echo $p; ?> of <?php echo $totalPages; ?> (<?php echo $totalBooks; ?> total books)
        </div>
    </section>

    <?php include 'parts/footer.php'; ?>
</body>
</html>