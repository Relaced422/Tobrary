<?php
// ========================================
// ADMIN DASHBOARD
// ========================================
// This is the main control panel for administrators
// Only users with isAdmin = 1 can access this page

// Start the session to access user data
session_start();

// Connect to the database
require_once 'logic-php/connection.php';

// Check if user is logged in AND is an admin
if (empty($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    // If not an admin, redirect to homepage
    header("Location: index.php");
    exit();
}

// ========================================
// FETCH STATISTICS
// ========================================
// Get counts of different items in the database

// Count total users (excluding admins)
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users WHERE isAdmin = 0")->fetchColumn();

// Count total books in the library
$totalBooks = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();

// Count total authors
$totalAuthors = $pdo->query("SELECT COUNT(*) FROM authors")->fetchColumn();

// Count total genres
$totalGenres = $pdo->query("SELECT COUNT(*) FROM genres")->fetchColumn();

// Count currently borrowed books
$activeBorrowings = $pdo->query("SELECT COUNT(*) FROM borrowing_logs WHERE status = 'borrowed'")->fetchColumn();

// Count active reservations
$activeReservations = $pdo->query("SELECT COUNT(*) FROM reservations WHERE status = 'active'")->fetchColumn();


// ========================================
// FETCH RECENT DATA
// ========================================

// Get the 10 most recently registered users
$recentUsers = $pdo->query("
    SELECT userId, firstName, lastName, email, isActive, createdAt
    FROM users 
    WHERE isAdmin = 0 
    ORDER BY createdAt DESC 
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);

// Get the 10 most recently added books
$recentBooks = $pdo->query("
    SELECT 
        b.bookId,
        b.title, 
        CONCAT(a.firstName, ' ', a.lastName) as author, 
        g.genreName,
        b.availableCopies,
        b.totalCopies
    FROM books b 
    JOIN authors a ON b.authorId = a.authorId 
    JOIN genres g ON b.genreId = g.genreId 
    ORDER BY b.createdAt DESC 
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);


// ========================================
// HANDLE DELETE ACTIONS
// ========================================
// Process delete requests from admin

// Delete a user
if (isset($_POST['delete_user']) && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    
    // Delete the user from the database
    $deleteQuery = "DELETE FROM users WHERE userId = ? AND isAdmin = 0";
    $stmt = $pdo->prepare($deleteQuery);
    
    if ($stmt->execute([$userId])) {
        $successMessage = "User deleted successfully!";
    } else {
        $errorMessage = "Failed to delete user.";
    }
    
    // Refresh the page to show updated data
    header("Location: admin-dashboard.php");
    exit();
}

// Delete a book
if (isset($_POST['delete_book']) && isset($_POST['book_id'])) {
    $bookId = $_POST['book_id'];
    
    // Delete the book from the database
    $deleteQuery = "DELETE FROM books WHERE bookId = ?";
    $stmt = $pdo->prepare($deleteQuery);
    
    if ($stmt->execute([$bookId])) {
        $successMessage = "Book deleted successfully!";
    } else {
        $errorMessage = "Failed to delete book.";
    }
    
    // Refresh the page to show updated data
    header("Location: admin-dashboard.php");
    exit();
}

// Toggle user active status
if (isset($_POST['toggle_user_status']) && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    
    // Toggle the isActive status (0 becomes 1, 1 becomes 0)
    $toggleQuery = "UPDATE users SET isActive = NOT isActive WHERE userId = ?";
    $stmt = $pdo->prepare($toggleQuery);
    $stmt->execute([$userId]);
    
    // Refresh the page
    header("Location: admin-dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tobrary</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body class="font-['Manrope',sans-serif] bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F] min-h-screen">
    
    <!-- ========================================
         HEADER
         ========================================
    -->
    <header class="bg-[#D9D9D9] shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold font-['Lora',serif]">Admin Dashboard</h1>
                <p class="text-sm text-gray-600">Welcome back, <?= htmlspecialchars($_SESSION['firstName']) ?>!</p>
            </div>
            <div class="flex gap-4">
                <!-- Button to view the main website -->
                <a href="index.php" class="bg-[#6F6F6F] text-white px-6 py-2 rounded-lg hover:bg-[#5F5F5F] transition">
                    View Site
                </a>
                <!-- Button to view account page -->
                <a href="loginpage.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    My Account
                </a>
                <!-- Logout button -->
                <form action="logic-php/logout.php" method="POST" class="inline">
                    <button type="submit" name="logout" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-8">
        
        <!-- ========================================
             STATISTICS CARDS
             ========================================
             Shows quick overview of library statistics
        -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
            
            <!-- Total Users Card -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <div class="text-4xl font-bold text-[#6F6F6F] mb-2"><?= $totalUsers ?></div>
                <div class="text-sm font-semibold font-['Lora',serif]">Total Users</div>
            </div>
            
            <!-- Total Books Card -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <div class="text-4xl font-bold text-[#6F6F6F] mb-2"><?= $totalBooks ?></div>
                <div class="text-sm font-semibold font-['Lora',serif]">Total Books</div>
            </div>
            
            <!-- Authors Card -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <div class="text-4xl font-bold text-[#6F6F6F] mb-2"><?= $totalAuthors ?></div>
                <div class="text-sm font-semibold font-['Lora',serif]">Authors</div>
            </div>
            
            <!-- Genres Card -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <div class="text-4xl font-bold text-[#6F6F6F] mb-2"><?= $totalGenres ?></div>
                <div class="text-sm font-semibold font-['Lora',serif]">Genres</div>
            </div>
            
            <!-- Active Loans Card -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <div class="text-4xl font-bold text-[#6F6F6F] mb-2"><?= $activeBorrowings ?></div>
                <div class="text-sm font-semibold font-['Lora',serif]">Active Loans</div>
            </div>
            
            <!-- Reservations Card -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <div class="text-4xl font-bold text-[#6F6F6F] mb-2"><?= $activeReservations ?></div>
                <div class="text-sm font-semibold font-['Lora',serif]">Reservations</div>
            </div>
            
        </div>

        <!-- ========================================
             QUICK ACTIONS
             ========================================
             Buttons to manage different parts of the library
        -->
        <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg mb-8">
            <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                
                <!-- Button to manage users -->
                <a href="admin-users.php" class="bg-[#6F6F6F] text-white text-center py-4 rounded-lg hover:bg-[#5F5F5F] transition font-semibold">
                    Manage Users
                </a>
                
                <!-- Button to manage books -->
                <a href="admin-books.php" class="bg-[#6F6F6F] text-white text-center py-4 rounded-lg hover:bg-[#5F5F5F] transition font-semibold">
                    Manage Books
                </a>
                
                <!-- Button to manage authors -->
                <a href="admin-authors.php" class="bg-[#6F6F6F] text-white text-center py-4 rounded-lg hover:bg-[#5F5F5F] transition font-semibold">
                    Manage Authors
                </a>
                
                <!-- Button to manage genres -->
                <a href="admin-genres.php" class="bg-[#6F6F6F] text-white text-center py-4 rounded-lg hover:bg-[#5F5F5F] transition font-semibold">
                    Manage Genres
                </a>
                
            </div>
        </div>

        <!-- ========================================
             RECENT DATA TABLES
             ========================================
             Shows recently added users and books
        -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- ========================================
                 RECENT USERS TABLE
                 ========================================
            -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">Recent Users</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-[#6F6F6F]">
                                <th class="text-left py-2 font-['Lora',serif]">Name</th>
                                <th class="text-left py-2 font-['Lora',serif]">Email</th>
                                <th class="text-left py-2 font-['Lora',serif]">Status</th>
                                <th class="text-left py-2 font-['Lora',serif]">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentUsers as $user): ?>
                                <tr class="border-b border-gray-300">
                                    <!-- User's full name -->
                                    <td class="py-2">
                                        <?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) ?>
                                    </td>
                                    <!-- User's email -->
                                    <td class="py-2 text-sm">
                                        <?= htmlspecialchars($user['email']) ?>
                                    </td>
                                    <!-- Active/Inactive status badge -->
                                    <td class="py-2">
                                        <span class="<?= $user['isActive'] ? 'bg-green-500' : 'bg-red-500' ?> text-white text-xs px-2 py-1 rounded">
                                            <?= $user['isActive'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>
                                    <!-- Action buttons -->
                                    <td class="py-2">
                                        <div class="flex gap-2">
                                            <!-- Toggle active status button -->
                                            <form method="POST" class="inline">
                                                <input type="hidden" name="user_id" value="<?= $user['userId'] ?>">
                                                <button type="submit" name="toggle_user_status" class="bg-blue-500 text-white text-xs px-3 py-1 rounded hover:bg-blue-600">
                                                    <?= $user['isActive'] ? 'Deactivate' : 'Activate' ?>
                                                </button>
                                            </form>
                                            <!-- Delete user button -->
                                            <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                <input type="hidden" name="user_id" value="<?= $user['userId'] ?>">
                                                <button type="submit" name="delete_user" class="bg-red-500 text-white text-xs px-3 py-1 rounded hover:bg-red-600">
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
                <!-- Link to see all users -->
                <div class="mt-4">
                    <a href="admin-users.php" class="text-[#6F6F6F] hover:text-[#5F5F5F] font-semibold">
                        View All Users →
                    </a>
                </div>
            </div>

            <!-- ========================================
                 RECENT BOOKS TABLE
                 ========================================
            -->
            <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
                <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">Recently Added Books</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-[#6F6F6F]">
                                <th class="text-left py-2 font-['Lora',serif]">Title</th>
                                <th class="text-left py-2 font-['Lora',serif]">Author</th>
                                <th class="text-left py-2 font-['Lora',serif]">Copies</th>
                                <th class="text-left py-2 font-['Lora',serif]">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentBooks as $book): ?>
                                <tr class="border-b border-gray-300">
                                    <!-- Book title -->
                                    <td class="py-2 font-semibold">
                                        <?= htmlspecialchars($book['title']) ?>
                                    </td>
                                    <!-- Author name -->
                                    <td class="py-2 text-sm">
                                        <?= htmlspecialchars($book['author']) ?>
                                    </td>
                                    <!-- Available copies / Total copies -->
                                    <td class="py-2 text-sm">
                                        <?= $book['availableCopies'] ?> / <?= $book['totalCopies'] ?>
                                    </td>
                                    <!-- Action buttons -->
                                    <td class="py-2">
                                        <div class="flex gap-2">
                                            <!-- Edit book button -->
                                            <a href="admin-books.php?edit=<?= $book['bookId'] ?>" class="bg-yellow-500 text-white text-xs px-3 py-1 rounded hover:bg-yellow-600">
                                                Edit
                                            </a>
                                            <!-- Delete book button -->
                                            <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                                <input type="hidden" name="book_id" value="<?= $book['bookId'] ?>">
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
                <!-- Link to see all books -->
                <div class="mt-4">
                    <a href="admin-books.php" class="text-[#6F6F6F] hover:text-[#5F5F5F] font-semibold">
                        View All Books →
                    </a>
                </div>
            </div>

        </div>

    </main>

    <!-- ========================================
         FOOTER
         ========================================
    -->
    <footer class="bg-[#D9D9D9] mt-16 py-8">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-600">&copy; 2025 Tobrary. Admin Dashboard.</p>
        </div>
    </footer>

</body>
</html>