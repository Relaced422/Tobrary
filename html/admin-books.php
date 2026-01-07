<?php
// ========================================
// ADMIN BOOK MANAGEMENT
// ========================================
// This page allows admins to view, add, edit, and delete books

// Start session and connect to database
session_start();
require_once 'logic-php/connection.php';

// Check if user is an admin
if (empty($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    header("Location: index.php");
    exit();
}

// ========================================
// HANDLE ADD NEW BOOK
// ========================================
if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $authorId = $_POST['authorId'];
    $genreId = $_POST['genreId'];
    $isbn = $_POST['isbn'];
    $publicationYear = $_POST['publicationYear'];
    $description = $_POST['description'];
    $totalPages = $_POST['totalPages'];
    $totalCopies = $_POST['totalCopies'];
    $availableCopies = $_POST['availableCopies'];
    
    // Insert new book into database
    $insertQuery = "INSERT INTO books (title, authorId, genreId, isbn, publicationYear, description, totalPages, totalCopies, availableCopies) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    if ($stmt->execute([$title, $authorId, $genreId, $isbn, $publicationYear, $description, $totalPages, $totalCopies, $availableCopies])) {
        $successMessage = "Book added successfully!";
    } else {
        $errorMessage = "Failed to add book.";
    }
}

// ========================================
// HANDLE EDIT BOOK
// ========================================
if (isset($_POST['edit_book'])) {
    $bookId = $_POST['bookId'];
    $title = $_POST['title'];
    $authorId = $_POST['authorId'];
    $genreId = $_POST['genreId'];
    $isbn = $_POST['isbn'];
    $publicationYear = $_POST['publicationYear'];
    $description = $_POST['description'];
    $totalPages = $_POST['totalPages'];
    $totalCopies = $_POST['totalCopies'];
    $availableCopies = $_POST['availableCopies'];
    
    // Update book information
    $updateQuery = "UPDATE books SET title = ?, authorId = ?, genreId = ?, isbn = ?, publicationYear = ?, 
                    description = ?, totalPages = ?, totalCopies = ?, availableCopies = ? 
                    WHERE bookId = ?";
    $stmt = $pdo->prepare($updateQuery);
    
    if ($stmt->execute([$title, $authorId, $genreId, $isbn, $publicationYear, $description, $totalPages, $totalCopies, $availableCopies, $bookId])) {
        $successMessage = "Book updated successfully!";
    } else {
        $errorMessage = "Failed to update book.";
    }
}

// ========================================
// HANDLE DELETE BOOK
// ========================================
if (isset($_POST['delete_book'])) {
    $bookId = $_POST['bookId'];
    
    // Delete book from database
    $deleteQuery = "DELETE FROM books WHERE bookId = ?";
    $stmt = $pdo->prepare($deleteQuery);
    
    if ($stmt->execute([$bookId])) {
        $successMessage = "Book deleted successfully!";
    } else {
        $errorMessage = "Failed to delete book.";
    }
}

// ========================================
// FETCH ALL AUTHORS AND GENRES (for dropdown)
// ========================================
$authors = $pdo->query("SELECT authorId, CONCAT(firstName, ' ', lastName) as name FROM authors ORDER BY firstName")->fetchAll(PDO::FETCH_ASSOC);
$genres = $pdo->query("SELECT genreId, genreName FROM genres ORDER BY genreName")->fetchAll(PDO::FETCH_ASSOC);

// ========================================
// FETCH ALL BOOKS
// ========================================
// Get search query if it exists
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchQuery) {
    // Search books by title, author, or ISBN
    $query = "SELECT b.*, CONCAT(a.firstName, ' ', a.lastName) as authorName, g.genreName
              FROM books b
              JOIN authors a ON b.authorId = a.authorId
              JOIN genres g ON b.genreId = g.genreId
              WHERE b.title LIKE ? OR b.isbn LIKE ? OR CONCAT(a.firstName, ' ', a.lastName) LIKE ?
              ORDER BY b.createdAt DESC";
    $searchTerm = "%$searchQuery%";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Get all books
    $books = $pdo->query("SELECT b.*, CONCAT(a.firstName, ' ', a.lastName) as authorName, g.genreName
                          FROM books b
                          JOIN authors a ON b.authorId = a.authorId
                          JOIN genres g ON b.genreId = g.genreId
                          ORDER BY b.createdAt DESC")->fetchAll(PDO::FETCH_ASSOC);
}

// Check if editing a book
$editBook = null;
if (isset($_GET['edit'])) {
    $editBookId = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM books WHERE bookId = ?");
    $stmt->execute([$editBookId]);
    $editBook = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body class="font-['Manrope',sans-serif] bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F] min-h-screen">
    
    <!-- Header -->
    <header class="bg-[#D9D9D9] shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold font-['Lora',serif]">Manage Books</h1>
                <p class="text-sm text-gray-600">Add, edit, or remove books from the library</p>
            </div>
            <div class="flex gap-4">
                <a href="admin-dashboard.php" class="bg-[#6F6F6F] text-white px-6 py-2 rounded-lg hover:bg-[#5F5F5F] transition">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-8">
        
        <!-- Success/Error Messages -->
        <?php if (isset($successMessage)): ?>
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                <?= $successMessage ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($errorMessage)): ?>
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>

        <!-- Search Bar -->
        <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg mb-6">
            <form method="GET" class="flex gap-4">
                <input type="text" 
                       name="search" 
                       placeholder="Search by title, author, or ISBN..." 
                       value="<?= htmlspecialchars($searchQuery) ?>"
                       class="flex-1 px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Search
                </button>
                <?php if ($searchQuery): ?>
                    <a href="admin-books.php" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                        Clear
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Add/Edit Book Form -->
        <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg mb-6">
            <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">
                <?= $editBook ? 'Edit Book' : 'Add New Book' ?>
            </h2>
            
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Hidden field for book ID when editing -->
                <?php if ($editBook): ?>
                    <input type="hidden" name="bookId" value="<?= $editBook['bookId'] ?>">
                <?php endif; ?>
                
                <!-- Title -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2">Book Title</label>
                    <input type="text" 
                           name="title" 
                           required 
                           value="<?= $editBook ? htmlspecialchars($editBook['title']) : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Author Dropdown -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Author</label>
                    <select name="authorId" 
                            required 
                            class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Select Author</option>
                        <?php foreach ($authors as $author): ?>
                            <option value="<?= $author['authorId'] ?>" 
                                    <?= ($editBook && $editBook['authorId'] == $author['authorId']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($author['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Genre Dropdown -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Genre</label>
                    <select name="genreId" 
                            required 
                            class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Select Genre</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= $genre['genreId'] ?>" 
                                    <?= ($editBook && $editBook['genreId'] == $genre['genreId']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($genre['genreName']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- ISBN -->
                <div>
                    <label class="block text-sm font-semibold mb-2">ISBN</label>
                    <input type="text" 
                           name="isbn" 
                           value="<?= $editBook ? htmlspecialchars($editBook['isbn']) : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Publication Year -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Publication Year</label>
                    <input type="number" 
                           name="publicationYear" 
                           min="1000" 
                           max="2100"
                           value="<?= $editBook ? $editBook['publicationYear'] : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Total Pages -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Total Pages</label>
                    <input type="number" 
                           name="totalPages" 
                           required 
                           min="1"
                           value="<?= $editBook ? $editBook['totalPages'] : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Total Copies -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Total Copies</label>
                    <input type="number" 
                           name="totalCopies" 
                           required 
                           min="1"
                           value="<?= $editBook ? $editBook['totalCopies'] : '1' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Available Copies -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Available Copies</label>
                    <input type="number" 
                           name="availableCopies" 
                           required 
                           min="0"
                           value="<?= $editBook ? $editBook['availableCopies'] : '1' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2">Description</label>
                    <textarea name="description" 
                              rows="4"
                              class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500"><?= $editBook ? htmlspecialchars($editBook['description']) : '' ?></textarea>
                </div>
                
                <!-- Submit Button -->
                <div class="md:col-span-2 flex gap-4">
                    <button type="submit" 
                            name="<?= $editBook ? 'edit_book' : 'add_book' ?>"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
                        <?= $editBook ? 'Update Book' : 'Add Book' ?>
                    </button>
                    
                    <?php if ($editBook): ?>
                        <a href="admin-books.php" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 font-semibold">
                            Cancel
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Books Table -->
        <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
            <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">All Books (<?= count($books) ?>)</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-[#6F6F6F]">
                            <th class="text-left py-2 font-['Lora',serif]">ID</th>
                            <th class="text-left py-2 font-['Lora',serif]">Title</th>
                            <th class="text-left py-2 font-['Lora',serif]">Author</th>
                            <th class="text-left py-2 font-['Lora',serif]">Genre</th>
                            <th class="text-left py-2 font-['Lora',serif]">ISBN</th>
                            <th class="text-left py-2 font-['Lora',serif]">Copies</th>
                            <th class="text-left py-2 font-['Lora',serif]">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr class="border-b border-gray-300">
                                <!-- Book ID -->
                                <td class="py-2"><?= $book['bookId'] ?></td>
                                
                                <!-- Title -->
                                <td class="py-2 font-semibold">
                                    <?= htmlspecialchars($book['title']) ?>
                                </td>
                                
                                <!-- Author Name -->
                                <td class="py-2 text-sm">
                                    <?= htmlspecialchars($book['authorName']) ?>
                                </td>
                                
                                <!-- Genre -->
                                <td class="py-2 text-sm">
                                    <?= htmlspecialchars($book['genreName']) ?>
                                </td>
                                
                                <!-- ISBN -->
                                <td class="py-2 text-sm">
                                    <?= htmlspecialchars($book['isbn']) ?>
                                </td>
                                
                                <!-- Available / Total Copies -->
                                <td class="py-2 text-sm">
                                    <span class="<?= $book['availableCopies'] > 0 ? 'text-green-600' : 'text-red-600' ?> font-semibold">
                                        <?= $book['availableCopies'] ?>
                                    </span> / <?= $book['totalCopies'] ?>
                                </td>
                                
                                <!-- Action Buttons -->
                                <td class="py-2">
                                    <div class="flex gap-2">
                                        <!-- Edit Button -->
                                        <a href="?edit=<?= $book['bookId'] ?>" class="bg-yellow-500 text-white text-xs px-3 py-1 rounded hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                            <input type="hidden" name="bookId" value="<?= $book['bookId'] ?>">
                                            <button type="submit" name="delete_book" class="bg-red-500 text-white text-xs px-3 py-1 rounded hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>