<?php require_once __DIR__ . '/functions.php'; page_header('Thank You'); $order = $_SESSION['last_order'] ?? null; ?>
<section class="checkout">
    <h1>Thank You</h1>
    <p>Order berhasil dibuat. Silakan selesaikan pembayaran jika status masih pending.</p>
    <?php if ($order): ?>
        <p><strong>Order ID:</strong> <?= htmlspecialchars($order['id']) ?></p>
        <?php foreach ($order['items'] as $item): ?><div class="cart-line"><span><?= htmlspecialchars($item['name']) ?> × <?= $item['qty'] ?></span><strong><?= rupiah($item['subtotal']) ?></strong></div><?php endforeach; ?>
        <div class="cart-line"><span>Ongkir</span><strong><?= rupiah($order['shipping']) ?></strong></div>
        <div class="cart-line"><span>Total</span><strong><?= rupiah($order['total']) ?></strong></div>
    <?php endif; ?>
    <a class="btn" href="index.php">Kembali ke Homepage</a>
</section>
<?php page_footer(); ?>
