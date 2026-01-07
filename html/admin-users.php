<?php
// ========================================
// ADMIN USER MANAGEMENT
// ========================================
// This page allows admins to view, add, edit, and delete users

// Start session and connect to database
session_start();
require_once 'logic-php/connection.php';

// Check if user is an admin
if (empty($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    header("Location: index.php");
    exit();
}

// ========================================
// HANDLE ADD NEW USER
// ========================================
if (isset($_POST['add_user'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;
    
    // Insert new user into database
    $insertQuery = "INSERT INTO users (firstName, lastName, email, password, address, postalCode, isAdmin) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertQuery);
    
    if ($stmt->execute([$firstName, $lastName, $email, $password, $address, $postalCode, $isAdmin])) {
        $successMessage = "User added successfully!";
    } else {
        $errorMessage = "Failed to add user.";
    }
}

// ========================================
// HANDLE EDIT USER
// ========================================
if (isset($_POST['edit_user'])) {
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $postalCode = $_POST['postalCode'];
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;
    
    // Update user information
    $updateQuery = "UPDATE users SET firstName = ?, lastName = ?, email = ?, address = ?, postalCode = ?, isAdmin = ? 
                    WHERE userId = ?";
    $stmt = $pdo->prepare($updateQuery);
    
    if ($stmt->execute([$firstName, $lastName, $email, $address, $postalCode, $isAdmin, $userId])) {
        $successMessage = "User updated successfully!";
    } else {
        $errorMessage = "Failed to update user.";
    }
}

// ========================================
// HANDLE DELETE USER
// ========================================
if (isset($_POST['delete_user'])) {
    $userId = $_POST['userId'];
    
    // Delete user from database
    $deleteQuery = "DELETE FROM users WHERE userId = ?";
    $stmt = $pdo->prepare($deleteQuery);
    
    if ($stmt->execute([$userId])) {
        $successMessage = "User deleted successfully!";
    } else {
        $errorMessage = "Failed to delete user.";
    }
}

// ========================================
// HANDLE TOGGLE USER STATUS
// ========================================
if (isset($_POST['toggle_status'])) {
    $userId = $_POST['userId'];
    
    // Toggle the isActive status
    $toggleQuery = "UPDATE users SET isActive = NOT isActive WHERE userId = ?";
    $stmt = $pdo->prepare($toggleQuery);
    $stmt->execute([$userId]);
}

// ========================================
// FETCH ALL USERS
// ========================================
// Get search query if it exists
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchQuery) {
    // Search users by name or email
    $query = "SELECT * FROM users WHERE (firstName LIKE ? OR lastName LIKE ? OR email LIKE ?) ORDER BY createdAt DESC";
    $searchTerm = "%$searchQuery%";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Get all users
    $users = $pdo->query("SELECT * FROM users ORDER BY createdAt DESC")->fetchAll(PDO::FETCH_ASSOC);
}

// Check if editing a user
$editUser = null;
if (isset($_GET['edit'])) {
    $editUserId = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE userId = ?");
    $stmt->execute([$editUserId]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body class="font-['Manrope',sans-serif] bg-gradient-to-b from-[#D9D9D9] to-[#1F1F1F] min-h-screen">
    
    <!-- Header -->
    <header class="bg-[#D9D9D9] shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold font-['Lora',serif]">Manage Users</h1>
                <p class="text-sm text-gray-600">Add, edit, or remove users</p>
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
                       placeholder="Search by name or email..." 
                       value="<?= htmlspecialchars($searchQuery) ?>"
                       class="flex-1 px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Search
                </button>
                <?php if ($searchQuery): ?>
                    <a href="admin-users.php" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                        Clear
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Add/Edit User Form -->
        <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg mb-6">
            <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">
                <?= $editUser ? 'Edit User' : 'Add New User' ?>
            </h2>
            
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Hidden field for user ID when editing -->
                <?php if ($editUser): ?>
                    <input type="hidden" name="userId" value="<?= $editUser['userId'] ?>">
                <?php endif; ?>
                
                <!-- First Name -->
                <div>
                    <label class="block text-sm font-semibold mb-2">First Name</label>
                    <input type="text" 
                           name="firstName" 
                           required 
                           value="<?= $editUser ? htmlspecialchars($editUser['firstName']) : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Last Name</label>
                    <input type="text" 
                           name="lastName" 
                           required 
                           value="<?= $editUser ? htmlspecialchars($editUser['lastName']) : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           required 
                           value="<?= $editUser ? htmlspecialchars($editUser['email']) : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Password (only for new users) -->
                <?php if (!$editUser): ?>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Password</label>
                        <input type="password" 
                               name="password" 
                               required 
                               minlength="8"
                               class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                <?php endif; ?>
                
                <!-- Address -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Address</label>
                    <input type="text" 
                           name="address" 
                           required 
                           value="<?= $editUser ? htmlspecialchars($editUser['address']) : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Postal Code -->
                <div>
                    <label class="block text-sm font-semibold mb-2">Postal Code</label>
                    <input type="text" 
                           name="postalCode" 
                           required 
                           pattern="[0-9]{4}\s?[A-Za-z]{2}"
                           value="<?= $editUser ? htmlspecialchars($editUser['postalCode']) : '' ?>"
                           class="w-full px-4 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Admin Checkbox -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="isAdmin" 
                           id="isAdmin"
                           <?= ($editUser && $editUser['isAdmin']) ? 'checked' : '' ?>
                           class="w-4 h-4 mr-2">
                    <label for="isAdmin" class="text-sm font-semibold">Admin User</label>
                </div>
                
                <!-- Submit Button -->
                <div class="md:col-span-2 flex gap-4">
                    <button type="submit" 
                            name="<?= $editUser ? 'edit_user' : 'add_user' ?>"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold">
                        <?= $editUser ? 'Update User' : 'Add User' ?>
                    </button>
                    
                    <?php if ($editUser): ?>
                        <a href="admin-users.php" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 font-semibold">
                            Cancel
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-[#D9D9D9] rounded-lg p-6 shadow-lg">
            <h2 class="text-2xl font-bold font-['Lora',serif] mb-4">All Users (<?= count($users) ?>)</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-[#6F6F6F]">
                            <th class="text-left py-2 font-['Lora',serif]">ID</th>
                            <th class="text-left py-2 font-['Lora',serif]">Name</th>
                            <th class="text-left py-2 font-['Lora',serif]">Email</th>
                            <th class="text-left py-2 font-['Lora',serif]">Address</th>
                            <th class="text-left py-2 font-['Lora',serif]">Role</th>
                            <th class="text-left py-2 font-['Lora',serif]">Status</th>
                            <th class="text-left py-2 font-['Lora',serif]">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-b border-gray-300">
                                <!-- User ID -->
                                <td class="py-2"><?= $user['userId'] ?></td>
                                
                                <!-- Full Name -->
                                <td class="py-2 font-semibold">
                                    <?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) ?>
                                </td>
                                
                                <!-- Email -->
                                <td class="py-2 text-sm">
                                    <?= htmlspecialchars($user['email']) ?>
                                </td>
                                
                                <!-- Address -->
                                <td class="py-2 text-sm">
                                    <?= htmlspecialchars($user['address']) ?><br>
                                    <?= htmlspecialchars($user['postalCode']) ?>
                                </td>
                                
                                <!-- Role Badge -->
                                <td class="py-2">
                                    <span class="<?= $user['isAdmin'] ? 'bg-purple-500' : 'bg-blue-500' ?> text-white text-xs px-2 py-1 rounded">
                                        <?= $user['isAdmin'] ? 'Admin' : 'User' ?>
                                    </span>
                                </td>
                                
                                <!-- Active Status Badge -->
                                <td class="py-2">
                                    <span class="<?= $user['isActive'] ? 'bg-green-500' : 'bg-red-500' ?> text-white text-xs px-2 py-1 rounded">
                                        <?= $user['isActive'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                
                                <!-- Action Buttons -->
                                <td class="py-2">
                                    <div class="flex gap-2">
                                        <!-- Edit Button -->
                                        <a href="?edit=<?= $user['userId'] ?>" class="bg-yellow-500 text-white text-xs px-3 py-1 rounded hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        
                                        <!-- Toggle Status Button -->
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="userId" value="<?= $user['userId'] ?>">
                                            <button type="submit" name="toggle_status" class="bg-blue-500 text-white text-xs px-3 py-1 rounded hover:bg-blue-600">
                                                <?= $user['isActive'] ? 'Deactivate' : 'Activate' ?>
                                            </button>
                                        </form>
                                        
                                        <!-- Delete Button (can't delete yourself) -->
                                        <?php if ($user['userId'] != $_SESSION['userId']): ?>
                                            <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                <input type="hidden" name="userId" value="<?= $user['userId'] ?>">
                                                <button type="submit" name="delete_user" class="bg-red-500 text-white text-xs px-3 py-1 rounded hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
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