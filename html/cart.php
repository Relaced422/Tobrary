<?php
session_start();
include 'parts/header.php';
include 'logic-php/connection.php';

$userId = $_SESSION['userId'] ?? null;
$cart = [];

if ($userId) {
    $stmt = $pdo->prepare("SELECT content FROM cart WHERE userId = ?");
    $stmt->execute([$userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && !empty($row['content'])) {
        $bookIds = json_decode($row['content'], true);

        if (!empty($bookIds)) {
            $placeholders = implode(',', array_fill(0, count($bookIds), '?'));
            $stmt = $pdo->prepare("SELECT bookId, title, author, genre, coverImage, price FROM books WHERE bookId IN ($placeholders)");
            $stmt->execute($bookIds);
            $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tobrary - My Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"">
</head>
<body class="bg-gradient-to-br from-black to-gray-900 text-gray-200 min-h-screen">

    <!-- PAGE HEADER -->
    <section class="border-b border-red-500/20 py-12 px-8 text-center">
        <p class="text-red-500 text-xs tracking-[0.4em] uppercase mb-2">Your Selection</p>
        <h1 class="text-6xl text-white tracking-widest">MY CART</h1>
    </section>

    <main class="max-w-6xl mx-auto px-4 py-12">

        <?php if (empty($cart)): ?>
        <!-- EMPTY STATE -->
        <div class="empty-state flex flex-col items-center justify-center py-32 text-center">
            <div class="w-28 h-28 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center mb-8">
                <i class="fa fa-shopping-basket text-5xl text-red-500/50"></i>
            </div>
            <h2 class="text-3xl text-white mb-3 tracking-wide">Your cart is empty</h2>
            <p class="text-gray-500 mb-10 max-w-sm">You haven't reserved any books yet. Browse our collection and find something you'll love.</p>
            <a href="books.php"
               class="px-10 py-4 rounded bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold uppercase tracking-widest transition-all duration-300 hover:from-red-500 hover:to-red-600 hover:-translate-y-1 shadow-lg hover:shadow-red-500/40">
                Browse Books
            </a>
        </div>

        <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-10">

            <!-- CART ITEMS -->
            <div class="flex-1">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl text-white font-semibold tracking-wide">
                        Reserved Books <span class="text-red-500">(<?= count($cart) ?>)</span>
                    </h2>
                    <a href="logic-php/cart-clear.php"
                       class="text-xs text-gray-600 hover:text-red-500 uppercase tracking-widest transition-colors duration-200">
                        <i class="fa fa-trash mr-1"></i> Clear All
                    </a>
                </div>

                <div class="bg-gray-900/60 rounded-2xl border border-red-500/15 overflow-hidden">
                    <?php foreach ($cart as $index => $item): ?>
                    <div class="cart-row flex items-center gap-5 p-5 <?= $index < count($cart) - 1 ? 'border-b border-red-500/10' : '' ?>"
                         style="animation-delay: <?= $index * 0.07 ?>s">

                        <!-- Cover -->
                        <a href="book-detail.php?id=<?= htmlspecialchars($item['bookId']) ?>">
                            <img src="img/books/<?= htmlspecialchars($item['coverImage']) ?>"
                                 alt="<?= htmlspecialchars($item['title']) ?>"
                                 class="w-16 h-20 object-cover rounded-lg shadow-md border border-red-500/20 hover:border-red-500/60 transition-all duration-300">
                        </a>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold text-base truncate">
                                <?= htmlspecialchars($item['title']) ?>
                            </h3>
                            <p class="text-red-400 text-sm"><?= htmlspecialchars($item['author']) ?></p>
                            <?php if (!empty($item['genre'])): ?>
                            <span class="inline-block mt-1 bg-red-500/10 text-red-400 px-2 py-0.5 rounded-full text-xs">
                                <?= htmlspecialchars($item['genre']) ?>
                            </span>
                            <?php endif; ?>
                        </div>

                        <!-- Quanity -->
                        <div class="flex items-center gap-2 bg-gray-800/80 rounded-lg px-3 py-2 border border-gray-700/50">
                            <span class="text-white font-bold w-6 text-center text-sm"><?= (int)($item['qty'] ?? 1) ?></span>
                        </div>

                        <!-- Remove -->
                        <a href="logic-php/cart-remove.php?index=<?= $index ?>"
                           class="remove-btn text-gray-600 ml-2"
                           title="Remove">
                            <i class="fa fa-times text-lg"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Continue Shopping -->
                <div class="mt-6">
                    <a href="books.php"
                       class="inline-flex items-center gap-2 text-gray-500 hover:text-red-400 text-sm uppercase tracking-widest transition-colors duration-200">
                        <i class="fa fa-arrow-left text-xs"></i> Continue Browsing
                    </a>
                </div>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="lg:w-80 xl:w-96">
                <div class="summary-card bg-gray-900/80 rounded-2xl border border-red-500/20 p-7 sticky top-24">
                    <h2 class="text-xl text-white font-semibold tracking-wide mb-6">Order Summary</h2>

                    <!-- Line Items -->
                    <div class="space-y-3 mb-6">
                        <?php
                        $subtotal = 0;
                        foreach ($cart as $item):
                            $qty = (int)($item['qty'] ?? 1);
                            $price = (float)($item['price'] ?? 0);
                            $lineTotal = $qty * $price;
                            $subtotal += $lineTotal;
                        ?>
                        <div class="flex justify-between text-sm text-gray-400">
                            <span class="truncate max-w-[180px]"><?= htmlspecialchars($item['title']) ?> × <?= $qty ?></span>
                            <span class="text-white ml-4">
                                <?= $price > 0 ? '$' . number_format($lineTotal, 2) : 'Free' ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <hr class="divider mb-6">

                    <!-- Totals -->
                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotal</span>
                            <span class="text-white"><?= $subtotal > 0 ? '$' . number_format($subtotal, 2) : 'Free' ?></span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Reservation Fee</span>
                            <span class="text-green-400">Waived</span>
                        </div>
                    </div>

                    <hr class="divider mb-6">

                    <div class="flex justify-between items-center mb-8">
                        <span class="text-white font-bold text-lg">Total</span>
                        <span class="text-2xl font-bold text-red-400">
                            <?= $subtotal > 0 ? '$' . number_format($subtotal, 2) : 'Free' ?>
                        </span>
                    </div>

                    <!-- Checkout Button -->
                    <a href="checkout.php"
                       class="checkout-btn block w-full text-center py-4 rounded-xl text-white font-bold uppercase tracking-widest text-sm mb-3">
                        <span><i class="fa fa-lock mr-2"></i>Proceed to Checkout</span>
                    </a>

                    <!-- PayPal / Alternative -->
                    <a href="checkout.php?method=paypal"
                       class="block w-full text-center py-3 rounded-xl border border-gray-700 text-gray-400 hover:border-gray-500 hover:text-white font-semibold uppercase tracking-widest text-xs transition-all duration-300 hover:bg-gray-800/50">
                        <i class="fa fa-paypal mr-2 text-blue-400"></i></i>Pay with PayPal
                    </a>

                    <!-- Security note -->
                    <p class="text-center text-gray-600 text-xs mt-5 flex items-center justify-center gap-2">
                        <i class="fa fa-shield-alt text-green-500/50"></i>
                        Secure & encrypted checkout
                    </p>
                </div>
            </div>

        </div>
        <?php endif; ?>

    </main>

    <!-- FOOTER -->
    <?php include 'parts/footer.php'; ?>

</body>
</html>