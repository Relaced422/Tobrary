<?php
// ========================================
// ADMIN GENRE MANAGEMENT
// ========================================
// This page allows admins to view, add, edit, and delete genres

// Start session and connect to database
session_start();
require_once 'logic-php/connection.php';

// Check if user is an admin
if (empty($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    header("Location: index.php");
    exit();
}

// ========================================
// HANDLE ADD NEW GENRE
// ========================================
if (isset($_POST['add_genre'])) {
    $genreName = $_POST['genreName'];
    $description = $_POST['description'];
    
    // Check if genre name already exists
    $checkQuery = "SELECT COUNT(*) FROM genres WHERE genreName = ?";
    $stmt = $pdo->prepare($checkQuery);
    $stmt->execute([$genreName]);
    
    if ($stmt->fetchColumn() > 0) {
        $errorMessage = "This genre already exists!";
    } else {
        // Insert new genre into database
        $insertQuery = "INSERT INTO genres (genreName, description) VALUES (?, ?)";
        $stmt = $pdo->prepare($insertQuery);
        
        if ($stmt->execute([$genreName, $description])) {
            $successMessage = "Genre added successfully!";
        } else {
            $errorMessage = "Failed to add genre.";
        }
    }
}

// ========================================
// HANDLE EDIT GENRE
// ========================================
if (isset($_POST['edit_genre'])) {
    $genreId = $_POST['genreId'];
    $genreName = $_POST['genreName'];
    $description = $_POST['description'];
    
    // Check if genre name already exists (excluding current genre)
    $checkQuery = "SELECT COUNT(*) FROM genres WHERE genreName = ? AND genreId != ?";
    $stmt = $pdo->prepare($checkQuery);
    $stmt->execute([$genreName, $genreId]);
    
    if ($stmt->fetchColumn() > 0) {
        $errorMessage = "This genre name already exists!";
    } else {
        // Update genre information
        $updateQuery = "UPDATE genres SET genreName = ?, description = ? WHERE genreId = ?";
        $stmt = $pdo->prepare($updateQuery);
        
        if ($stmt->execute([$genreName, $description, $genreId])) {
            $successMessage = "Genre updated successfully!";
        } else {
            $errorMessage = "Failed to update genre.";
        }
    }
}

// ========================================
// HANDLE DELETE GENRE
// ========================================
if (isset($_POST['delete_genre'])) {
    $genreId = $_POST['genreId'];
    
    // Check if genre has any books
    $checkQuery = "SELECT COUNT(*) FROM books WHERE genreId = ?";
    $stmt = $pdo->prepare($checkQuery);
    $stmt->execute([$genreId]);
    $bookCount = $stmt->fetchColumn();
    
    if ($bookCount > 0) {
        $errorMessage = "Cannot delete genre. It has $bookCount book(s) assigned to it.";
    } else {
        // Delete genre from database
        $deleteQuery = "DELETE FROM genres WHERE genreId = ?";
        $stmt = $pdo->prepare($deleteQuery);
        
        if ($stmt->execute([$genreId])) {
            $successMessage = "Genre deleted successfully!";
        } else {
            $errorMessage = "Failed to delete genre.";
        }
    }
}

// ========================================
// FETCH ALL GENRES
// ========================================
// Get search query if it exists
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchQuery) {
    // Search genres by name
    $query = "SELECT g.*, COUNT(b.bookId) as bookCount 
              FROM genres g 
              LEFT JOIN books b ON g.genreId = b.genreId 
              WHERE g.genreName LIKE ?
              GROUP BY g.genreId
              ORDER BY g.genreName";
    $searchTerm = "%$searchQuery%";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$searchTerm]);
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Get all genres with book count
    $genres = $pdo->query("SELECT g.*, COUNT(b.bookId) as bookCount 
                           FROM genres g 
                           LEFT JOIN books b ON g.genreId = b.genreId 
                           GROUP BY g.genreId
                           ORDER BY g.genreName")->fetchAll(PDO::FETCH_ASSOC);
}

// Check if editing a genre
$editGenre = null;
if (isset($_GET['edit'])) {
    $editGenreId = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM genres WHERE genreId = ?");
    $stmt->execute([$editGenreId]);
    $editGenre = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Genres - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body class="font-['Manrope',sans-serif] bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F] min-h-screen">
    
    <!-- Header -->
    <header class="bg-[#D9D9D9] shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold font-['Lora',serif]">Manage Genres</h1>
                <p class="text-sm text-gray-600">Add, edit, or remove book genres</p>
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
                       placeholder="Search by genre name..." 
                       value="<?= htmlspecialchars($searchQuery) ?>"
                       class="flex-1 px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Search
                </button>
                <?php if ($searchQuery): ?>
                    <a href="admin-genres.php" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                        Clear
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Add/Edit Genre Form -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">
                    <?= $editGenre ? 'Edit Genre' : 'Add New Genre' ?>
                </h2>
                
                <form method="POST" class="flex flex-col gap-4">
                    <!-- Hidden field for genre ID when editing -->
                    <?php if ($editGenre): ?>
                        <input type="hidden" name="genreId" value="<?= $editGenre['genreId'] ?>">
                    <?php endif; ?>
                    
                    <!-- Genre Name -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Genre Name</label>
                        <input type="text" 
                               name="genreName" 
                               required 
                               value="<?= $editGenre ? htmlspecialchars($editGenre['genreName']) : '' ?>"
                               class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Description</label>
                        <textarea name="description" 
                                  rows="4"
                                  class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500"><?= $editGenre ? htmlspecialchars($editGenre['description']) : '' ?></textarea>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <button type="submit" 
                                name="<?= $editGenre ? 'edit_genre' : 'add_genre' ?>"
                                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
                            <?= $editGenre ? 'Update Genre' : 'Add Genre' ?>
                        </button>
                        
                        <?php if ($editGenre): ?>
                            <a href="admin-genres.php" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 font-semibold flex items-center">
                                Cancel
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Genres List -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">All Genres (<?= count($genres) ?>)</h2>
                
                <div class="space-y-3 max-h-[600px] overflow-y-auto">
                    <?php foreach ($genres as $genre): ?>
                        <div class="bg-white rounded-lg p-4 border-2 border-gray-300">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <!-- Genre Name -->
                                    <h3 class="text-lg font-bold font-['Lora',serif]">
                                        <?= htmlspecialchars($genre['genreName']) ?>
                                    </h3>
                                    
                                    <!-- Description -->
                                    <p class="text-sm text-gray-600 mt-1">
                                        <?= htmlspecialchars($genre['description']) ?>
                                    </p>
                                    
                                    <!-- Book Count Badge -->
                                    <div class="mt-2">
                                        <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                            <?= $genre['bookCount'] ?> book<?= $genre['bookCount'] != 1 ? 's' : '' ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2 ml-4">
                                    <!-- Edit Button -->
                                    <a href="?edit=<?= $genre['genreId'] ?>" class="bg-yellow-500 text-white text-xs px-3 py-1 rounded hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    
                                    <!-- Delete Button (disabled if genre has books) -->
                                    <?php if ($genre['bookCount'] == 0): ?>
                                        <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this genre?')">
                                            <input type="hidden" name="genreId" value="<?= $genre['genreId'] ?>">
                                            <button type="submit" name="delete_genre" class="bg-red-500 text-white text-xs px-3 py-1 rounded hover:bg-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button disabled class="bg-gray-400 text-white text-xs px-3 py-1 rounded cursor-not-allowed" title="Cannot delete genre with books">
                                            Delete
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </main>

</body>
</html>