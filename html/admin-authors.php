<?php
// ========================================
// ADMIN AUTHOR MANAGEMENT
// ========================================
// This page allows admins to view, add, edit, and delete authors

// Start session and connect to database
session_start();
require_once 'logic-php/connection.php';

// Check if user is an admin
if (empty($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    header("Location: index.php");
    exit();
}

// ========================================
// HANDLE ADD NEW AUTHOR
// ========================================
if (isset($_POST['add_author'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $bio = $_POST['bio'];
    
    // Insert new author into database
    $insertQuery = "INSERT INTO authors (firstName, lastName, bio) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    if ($stmt->execute([$firstName, $lastName, $bio])) {
        $successMessage = "Author added successfully!";
    } else {
        $errorMessage = "Failed to add author.";
    }
}

// ========================================
// HANDLE EDIT AUTHOR
// ========================================
if (isset($_POST['edit_author'])) {
    $authorId = $_POST['authorId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $bio = $_POST['bio'];
    
    // Update author information
    $updateQuery = "UPDATE authors SET firstName = ?, lastName = ?, bio = ? WHERE authorId = ?";
    $stmt = $pdo->prepare($updateQuery);
    
    if ($stmt->execute([$firstName, $lastName, $bio, $authorId])) {
        $successMessage = "Author updated successfully!";
    } else {
        $errorMessage = "Failed to update author.";
    }
}

// ========================================
// HANDLE DELETE AUTHOR
// ========================================
if (isset($_POST['delete_author'])) {
    $authorId = $_POST['authorId'];
    
    // Check if author has any books
    $checkQuery = "SELECT COUNT(*) FROM books WHERE authorId = ?";
    $stmt = $pdo->prepare($checkQuery);
    $stmt->execute([$authorId]);
    $bookCount = $stmt->fetchColumn();
    
    if ($bookCount > 0) {
        $errorMessage = "Cannot delete author. They have $bookCount book(s) in the library.";
    } else {
        // Delete author from database
        $deleteQuery = "DELETE FROM authors WHERE authorId = ?";
        $stmt = $pdo->prepare($deleteQuery);
        
        if ($stmt->execute([$authorId])) {
            $successMessage = "Author deleted successfully!";
        } else {
            $errorMessage = "Failed to delete author.";
        }
    }
}

// ========================================
// FETCH ALL AUTHORS
// ========================================
// Get search query if it exists
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchQuery) {
    // Search authors by name
    $query = "SELECT a.*, COUNT(b.bookId) as bookCount 
              FROM authors a 
              LEFT JOIN books b ON a.authorId = b.authorId 
              WHERE a.firstName LIKE ? OR a.lastName LIKE ?
              GROUP BY a.authorId
              ORDER BY a.firstName, a.lastName";
    $searchTerm = "%$searchQuery%";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$searchTerm, $searchTerm]);
    $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Get all authors with book count
    $authors = $pdo->query("SELECT a.*, COUNT(b.bookId) as bookCount 
                            FROM authors a 
                            LEFT JOIN books b ON a.authorId = b.authorId 
                            GROUP BY a.authorId
                            ORDER BY a.firstName, a.lastName")->fetchAll(PDO::FETCH_ASSOC);
}

// Check if editing an author
$editAuthor = null;
if (isset($_GET['edit'])) {
    $editAuthorId = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM authors WHERE authorId = ?");
    $stmt->execute([$editAuthorId]);
    $editAuthor = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Authors - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body class="font-['Manrope',sans-serif] bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F] min-h-screen">
    
    <!-- Header -->
    <header class="bg-[#D9D9D9] shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold font-['Lora',serif]">Manage Authors</h1>
                <p class="text-sm text-gray-600">Add, edit, or remove authors</p>
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
                       placeholder="Search by author name..." 
                       value="<?= htmlspecialchars($searchQuery) ?>"
                       class="flex-1 px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Search
                </button>
                <?php if ($searchQuery): ?>
                    <a href="admin-authors.php" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                        Clear
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Add/Edit Author Form -->
        <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg mb-6">
            <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">
                <?= $editAuthor ? 'Edit Author' : 'Add New Author' ?>
            </h2>
            
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Hidden field for author ID when editing -->
                <?php if ($editAuthor): ?>
                    <input type="hidden" name="authorId" value="<?= $editAuthor['authorId'] ?>">
                <?php endif; ?>
                
                <!-- First Name -->
                <div>
                    <label class="block text-sm font-semibold mb-2">First Name</label>
                    <input type="text" 
                           name="firstName" 
                           required 
                           value="<?= $editAuthor ? htmlspecialchars($editAuthor['firstName']) : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Last Name</label>
                    <input type="text" 
                           name="lastName" 
                           required 
                           value="<?= $editAuthor ? htmlspecialchars($editAuthor['lastName']) : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Biography -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2">Biography</label>
                    <textarea name="bio" 
                              rows="4"
                              class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500"><?= $editAuthor ? htmlspecialchars($editAuthor['bio']) : '' ?></textarea>
                </div>
                
                <!-- Submit Button -->
                <div class="md:col-span-2 flex gap-4">
                    <button type="submit" 
                            name="<?= $editAuthor ? 'edit_author' : 'add_author' ?>"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
                        <?= $editAuthor ? 'Update Author' : 'Add Author' ?>
                    </button>
                    
                    <?php if ($editAuthor): ?>
                        <a href="admin-authors.php" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 font-semibold">
                            Cancel
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Authors Table -->
        <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
            <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">All Authors (<?= count($authors) ?>)</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-[#6F6F6F]">
                            <th class="text-left py-2 font-['Lora',serif]">ID</th>
                            <th class="text-left py-2 font-['Lora',serif]">Name</th>
                            <th class="text-left py-2 font-['Lora',serif]">Biography</th>
                            <th class="text-left py-2 font-['Lora',serif]">Books</th>
                            <th class="text-left py-2 font-['Lora',serif]">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($authors as $author): ?>
                            <tr class="border-b border-gray-300">
                                <!-- Author ID -->
                                <td class="py-2"><?= $author['authorId'] ?></td>
                                
                                <!-- Full Name -->
                                <td class="py-2 font-semibold">
                                    <?= htmlspecialchars($author['firstName'] . ' ' . $author['lastName']) ?>
                                </td>
                                
                                <!-- Biography (truncated) -->
                                <td class="py-2 text-sm max-w-md">
                                    <?php 
                                    // Show first 100 characters of bio
                                    $bio = htmlspecialchars($author['bio']);
                                    echo strlen($bio) > 100 ? substr($bio, 0, 100) . '...' : $bio;
                                    ?>
                                </td>
                                
                                <!-- Book Count -->
                                <td class="py-2">
                                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                        <?= $author['bookCount'] ?> book<?= $author['bookCount'] != 1 ? 's' : '' ?>
                                    </span>
                                </td>
                                
                                <!-- Action Buttons -->
                                <td class="py-2">
                                    <div class="flex gap-2">
                                        <!-- Edit Button -->
                                        <a href="?edit=<?= $author['authorId'] ?>" class="bg-yellow-500 text-white text-xs px-3 py-1 rounded hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        
                                        <!-- Delete Button (disabled if author has books) -->
                                        <?php if ($author['bookCount'] == 0): ?>
                                            <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this author?')">
                                                <input type="hidden" name="authorId" value="<?= $author['authorId'] ?>">
                                                <button type="submit" name="delete_author" class="bg-red-500 text-white text-xs px-3 py-1 rounded hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button disabled class="bg-gray-400 text-white text-xs px-3 py-1 rounded cursor-not-allowed" title="Cannot delete author with books">
                                                Delete
                                            </button>
                                        <?php endif; ?>
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