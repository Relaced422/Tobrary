<?php
session_start();
include 'connection.php';

$userId = $_SESSION['userId'] ?? null;
$index  = (int)$_GET['index'];

if (!$userId) {
    header("Location: ../login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT content FROM cart WHERE userId = ?");
$stmt->execute([$userId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $content = json_decode($row['content'], true) ?? [];
    array_splice($content, $index, 1);

    if (empty($content)) {
        $pdo->prepare("DELETE FROM cart WHERE userId = ?")->execute([$userId]);
    } else {
        $pdo->prepare("UPDATE cart SET content = ? WHERE userId = ?")->execute([json_encode($content), $userId]);
    }
}

header("Location: ../cart.php");
exit();