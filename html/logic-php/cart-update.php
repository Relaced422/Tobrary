<?php
session_start();

$action = $_GET['action'] ?? null;
$index  = (int)($_GET['index'] ?? 0);

if ($action === 'increase') {
    $_SESSION['cart'][$index]['qty'] = ($_SESSION['cart'][$index]['qty'] ?? 1) + 1;
} elseif ($action === 'decrease') {
    $_SESSION['cart'][$index]['qty'] = ($_SESSION['cart'][$index]['qty'] ?? 1) - 1;
    if ($_SESSION['cart'][$index]['qty'] <= 0) {
        array_splice($_SESSION['cart'], $index, 1);
    }
}

header("Location: ../cart.php");
exit();