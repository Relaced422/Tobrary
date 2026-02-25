<?php
session_start();
include 'logic-php/connection.php';
include 'parts/header.php';

// Check if a search was submitted
// $_GET['q'] is the value typed in the search box (?q=something in the URL)
$search = $_GET['q'] ?? '';

// Pagination
$p = isset($_GET['p']) ? (int) $_GET['p'] : 1;
if ($p < 1)
    $p = 1;
$n = 12;

// -----------------------------------------------
// If there is a search term, search the database
// If not, just show all books like normal
// -----------------------------------------------
if ($search !== '') {

    // The % around the search term means "anything before or after this word"
    // So searching "harry" also finds "Harry Potter"
    $like = '%' . $search . '%';

    // Count how many books match the search (needed for pagination)
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM books WHERE title LIKE ? OR author LIKE ? OR genre LIKE ? OR isbn LIKE ?");
    $countStmt->execute([$like, $like, $like, $like]);
    $totalBooks = $countStmt->fetchColumn();

    $totalPages = max(1, ceil($totalBooks / $n));
    if ($p > $totalPages)
        $p = $totalPages;
    $offset = ($p - 1) * $n;

    // Fetch the actual matching books for this page
    $stmt = $pdo->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR genre LIKE ? OR isbn LIKE ? ORDER BY createdAt DESC LIMIT ? OFFSET ?");
    $stmt->execute([$like, $like, $like, $like, $n, $offset]);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {

    // No search — show all books (same as before)
    $totalBooks = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
    $totalPages = max(1, ceil($totalBooks / $n));
    if ($p > $totalPages)
        $p = $totalPages;
    $offset = ($p - 1) * $n;

    $stmt = $pdo->prepare("SELECT * FROM books ORDER BY createdAt DESC LIMIT ? OFFSET ?");
    $stmt->execute([$n, $offset]);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Books - Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"">
</head>

<body class=" bg-gradient-to-br from-black to-gray-900 text-gray-200 min-h-screen font-sans">

    <!-- Page Title -->
    <section class="bg-gray-950/50 py-12 px-8 border-b border-red-500/20 flex items-center justify-center">
        <div class="max-w-7xl mx-auto flex flex-col align-center justify-center gap-4">
            <h1 class="text-5xl font-bold text-white mb-4 tracking-wider">BROWSE BOOKS</h1>
            <p class="text-gray-400 text-lg">Explore our collection of books across all genres</p>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="max-w-7xl mx-auto px-8 py-8">
        <div class="bg-gray-900/60 rounded-xl p-6 border border-red-500/20">

            <!-- 
                Search form — uses GET so the search term appears in the URL as ?q=...
                This means you can share or bookmark a search result page.
                The value="..." keeps whatever the user typed in the box after searching.
            -->
            <form method="GET" action="books.php">
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-300 mb-2 uppercase tracking-wide">Search
                        Books</label>
                    <div class="flex gap-4">
                        <input type="text" name="q" value="<?= htmlspecialchars($search) ?>"
                            placeholder="Search by title, author, genre or ISBN..."
                            class="flex-1 px-4 py-3 bg-gray-800 text-white rounded border border-gray-700 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/50">
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded font-semibold transition-all duration-300 hover:from-red-500 hover:to-red-600 uppercase tracking-wide">
                            Search
                        </button>
                        <!-- Reset button — just links back to books.php with no search term -->
                        <?php if ($search !== ''): ?>
                            <a href="books.php"
                                class="px-8 py-3 bg-gray-700 text-white rounded font-semibold hover:bg-gray-600 transition uppercase tracking-wide">
                                Clear
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

        </div>
    </section>

    <!-- Results count -->
    <section class="max-w-7xl mx-auto px-8 py-4">
        <p class="text-gray-400">
            <?php if ($search !== ''): ?>
                <!-- Show different text depending on whether any results were found -->
                <?php if ($totalBooks > 0): ?>
                    Found <span class="text-white font-semibold"><?= $totalBooks ?></span> result(s) for "<span
                        class="text-red-400"><?= htmlspecialchars($search) ?></span>"
                <?php else: ?>
                    No results found for "<span class="text-red-400"><?= htmlspecialchars($search) ?></span>"
                <?php endif; ?>
            <?php else: ?>
                Showing page <?= $p ?> of <?= $totalPages ?> (<?= $totalBooks ?> total books)
            <?php endif; ?>
        </p>
    </section>

    <!-- Books Grid -->
    <section class="max-w-7xl mx-auto px-8 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php foreach ($books as $book): ?>
                <div
                    class="bg-gray-900/80 rounded-2xl overflow-hidden transition-all duration-300 border border-red-500/20 shadow-xl hover:-translate-y-3 hover:shadow-2xl hover:shadow-red-500/30 hover:border-red-500/50 group flex flex-col h-[650px]">

                    <div class="w-full h-72 flex items-center justify-center relative flex-shrink-0 bg-gray-800">
                        <img class="w-full h-full object-cover" src="img/books/<?= $book['coverImage'] ?>"
                            alt="<?= htmlspecialchars($book['title']) ?> cover">
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-lg font-semibold text-white mb-2"><?= htmlspecialchars($book['title']) ?></h3>
                        <p class="text-red-500 text-sm mb-2">by <?= htmlspecialchars($book['author']) ?></p>
                        <span
                            class="inline-block bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-xs mb-3 w-fit"><?= htmlspecialchars($book['genre']) ?></span>

                        <p class="text-gray-400 text-sm leading-relaxed line-clamp-3 mb-3">
                            <?= htmlspecialchars($book['description']) ?></p>

                        <div class="flex justify-between text-xs text-gray-600 mb-3">
                            <span>📖 <?= $book['totalPages'] ?> pages</span>
                            <span>📚 <?= $book['availableCopies'] ?>/<?= $book['totalCopies'] ?> available</span>
                        </div>

                        <?php if ($book['isAvailable'] > 0): ?>
                            <div
                                class="px-4 py-2 rounded font-semibold text-center text-sm mb-3 bg-green-500/10 text-green-400">
                                ✓ Available</div>
                        <?php else: ?>
                            <div class="px-4 py-2 rounded font-semibold text-center text-sm mb-3 bg-red-500/10 text-red-400">✗
                                Not Available</div>
                        <?php endif; ?>

                        <div class="flex-1"></div>

                        <a href="book-detail.php?id=<?= $book['bookId'] ?>"
                            class="block px-4 py-2 rounded bg-gradient-to-r from-red-600 to-red-700 text-white no-underline font-semibold text-center text-sm transition-all duration-300 hover:from-red-500 hover:to-red-600">
                            View Details
                        </a>

                        <a href="logic-php/cart-add.php?bookId=<?= $book['bookId'] ?>"
                            class="block mt-2 px-4 py-2 rounded border border-red-500/40 text-red-400 no-underline font-semibold text-center text-sm transition-all duration-300 hover:bg-red-500/10 hover:border-red-500">
                            <i class="fa fa-shopping-cart mr-2"></i> Add to Cart
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($books) === 0): ?>
            <div class="text-center py-16">
                <p class="text-gray-400 text-xl mb-2">No books found.</p>
                <a href="books.php" class="text-red-400 hover:underline">Clear search and browse all books</a>
            </div>
        <?php endif; ?>
    </section>

    <!-- Pagination -->
    <!-- We pass the search term along in pagination links with &q=... -->
    <!-- Otherwise clicking "Next" would lose the search and show all books again -->
    <?php if ($totalPages > 1): ?>
        <section class="max-w-7xl mx-auto px-8 pb-16">
            <div class="flex justify-center items-center gap-2 flex-wrap">

                <?php
                // Build the base URL for pagination links
                // If there's a search term, include it: ?q=harry&p=2
                // If not, just: ?p=2
                $baseUrl = $search !== '' ? '?q=' . urlencode($search) . '&p=' : '?p=';
                ?>

                <?php if ($p > 1): ?>
                    <a href="<?= $baseUrl . ($p - 1) ?>"
                        class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold">←
                        Previous</a>
                <?php else: ?>
                    <button class="px-4 py-2 bg-gray-800 text-gray-600 rounded cursor-not-allowed" disabled>← Previous</button>
                <?php endif; ?>

                <?php if ($p > 2): ?>
                    <a href="<?= $baseUrl . 1 ?>"
                        class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold">1</a>
                    <?php if ($p > 3): ?>
                        <span class="px-2 text-gray-500">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($p > 1): ?>
                    <a href="<?= $baseUrl . ($p - 1) ?>"
                        class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold"><?= $p - 1 ?></a>
                <?php endif; ?>

                <span class="px-4 py-2 bg-red-600 text-white rounded font-semibold"><?= $p ?></span>

                <?php if ($p < $totalPages): ?>
                    <a href="<?= $baseUrl . ($p + 1) ?>"
                        class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold"><?= $p + 1 ?></a>
                <?php endif; ?>

                <?php if ($p < $totalPages - 1): ?>
                    <?php if ($p < $totalPages - 2): ?>
                        <span class="px-2 text-gray-500">...</span>
                    <?php endif; ?>
                    <a href="<?= $baseUrl . $totalPages ?>"
                        class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold"><?= $totalPages ?></a>
                <?php endif; ?>

                <?php if ($p < $totalPages): ?>
                    <a href="<?= $baseUrl . ($p + 1) ?>"
                        class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition font-semibold">Next →</a>
                <?php else: ?>
                    <button class="px-4 py-2 bg-gray-800 text-gray-600 rounded cursor-not-allowed" disabled>Next →</button>
                <?php endif; ?>

            </div>
            <div class="text-center mt-4 text-gray-400 text-sm">
                Page <?= $p ?> of <?= $totalPages ?>
            </div>
        </section>
    <?php endif; ?>

    <?php include 'parts/footer.php'; ?>
    </body>

</html>