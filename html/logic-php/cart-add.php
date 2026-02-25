<?php
session_start();
include 'connection.php';

$userId = $_SESSION['userId'] ?? null;
$bookId = (int)$_GET['bookId'];

if (!$userId) {
    header("Location: ../login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT cartId, content FROM cart WHERE userId = ?");
$stmt->execute([$userId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $content = json_decode($row['content'], true) ?? [];
    $content[] = $bookId; // just always add it, no duplicate check for now
    $stmt = $pdo->prepare("UPDATE cart SET content = ? WHERE userId = ?");
    $stmt->execute([json_encode($content), $userId]);
} else {
    $stmt = $pdo->prepare("INSERT INTO cart (userId, content) VALUES (?, ?)");
    $stmt->execute([$userId, json_encode([$bookId])]);
}

header("Location: ../index.php");
exit();