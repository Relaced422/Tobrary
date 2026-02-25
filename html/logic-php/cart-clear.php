<?php
session_start();
include 'connection.php';

$userId = $_SESSION['userId'] ?? null;

if (!$userId) {
    header("Location: ../login.php");
    exit();
}

$pdo->prepare("DELETE FROM cart WHERE userId = ?")->execute([$userId]);

header("Location: ../cart.php");
exit();