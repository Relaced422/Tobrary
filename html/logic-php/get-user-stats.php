<?php
// ========================================
// GET USER STATISTICS
// ========================================
// This file gets all the user's reading data from the database
// Include this at the top of the logged-in section in loginpage.php

// Check if user is logged in
if (isset($_SESSION['userId'])) {
    
    // Connect to the database
    require_once 'connection.php';
    
    // Get the logged-in user's ID
    $userId = $_SESSION['userId'];
    
    
    // ========================================
    // QUICK STATS - Count books in different categories
    // ========================================
    
    // Count how many books the user has completed
    $query = "SELECT COUNT(*) as completed FROM reading_progress WHERE userId = ? AND status = 'completed'";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $booksCompleted = $result['completed'];
    
    // Count how many books the user is currently reading
    $query = "SELECT COUNT(*) as reading FROM reading_progress WHERE userId = ? AND status = 'reading'";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentlyReading = $result['reading'];
    
    // Count how many books the user has favorited
    $query = "SELECT COUNT(*) as favorites FROM favorites WHERE userId = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $favoritesCount = $result['favorites'];
    
    
    // ========================================
    // CURRENTLY READING BOOKS - Get details of books being read
    // ========================================
    
    // This query gets book information from 3 tables:
    // - reading_progress (stores what the user is reading and their progress)
    // - books (stores book titles and IDs)
    // - authors (stores author names)
    // CONCAT combines firstName and lastName into one "author" field
    // JOIN connects these tables together using their IDs
    $query = "SELECT 
                b.title, 
                CONCAT(a.firstName, ' ', a.lastName) as author,
                rp.percentageComplete as progress,
                b.bookId 
              FROM reading_progress rp 
              JOIN books b ON rp.bookId = b.bookId 
              JOIN authors a ON b.authorId = a.authorId
              WHERE rp.userId = ? AND rp.status = 'reading'
              ORDER BY rp.updatedAt DESC
              LIMIT 4";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    // fetchAll gets all matching rows as an array
    $readingBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
    // ========================================
    // BORROWED BOOKS - Get books with due dates
    // ========================================
    
    // Similar to above, but gets borrowed books from borrowing_logs table
    // ORDER BY dueDate ASC sorts by due date (soonest first)
    $query = "SELECT 
                b.title, 
                CONCAT(a.firstName, ' ', a.lastName) as author,
                bl.dueDate,
                b.bookId 
              FROM borrowing_logs bl 
              JOIN books b ON bl.bookId = b.bookId 
              JOIN authors a ON b.authorId = a.authorId
              WHERE bl.userId = ? AND bl.status = 'borrowed'
              ORDER BY bl.dueDate ASC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $borrowedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
    // ========================================
    // RECENT ACTIVITY - Combine different types of activity
    // ========================================
    
    // Create an empty array to store all activities
    $recentActivity = [];
    
    // Get recently completed books
    // 'finished' is added as action_type so we know what kind of activity this is
    $query = "SELECT 
                'finished' as action_type,
                b.title,
                rp.completedAt as action_date
              FROM reading_progress rp
              JOIN books b ON rp.bookId = b.bookId
              WHERE rp.userId = ? AND rp.status = 'completed' AND rp.completedAt IS NOT NULL
              ORDER BY rp.completedAt DESC
              LIMIT 3";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $completed = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get recently started books
    $query = "SELECT 
                'started' as action_type,
                b.title,
                rp.startedAt as action_date
              FROM reading_progress rp
              JOIN books b ON rp.bookId = b.bookId
              WHERE rp.userId = ? AND rp.status = 'reading' AND rp.startedAt IS NOT NULL
              ORDER BY rp.startedAt DESC
              LIMIT 2";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $started = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get recently favorited books
    $query = "SELECT 
                'favorited' as action_type,
                b.title,
                f.createdAt as action_date
              FROM favorites f
              JOIN books b ON f.bookId = b.bookId
              WHERE f.userId = ?
              ORDER BY f.createdAt DESC
              LIMIT 2";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $favorited = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // array_merge combines three separate arrays into one big array
    $recentActivity = array_merge($completed, $started, $favorited);
    
    // usort sorts the array using a custom comparison function
    // This function compares two items ($a and $b) by their action_date
    // strtotime converts date strings to timestamps (numbers) so we can compare them
    // Returns negative if $b is newer (puts $b first), positive if $a is newer
    usort($recentActivity, function($a, $b) {
        return strtotime($b['action_date']) - strtotime($a['action_date']);
    });
    
    // array_slice takes only the first 5 items from the sorted array
    // (0 = start at beginning, 5 = take 5 items)
    $recentActivity = array_slice($recentActivity, 0, 5);
}
?>