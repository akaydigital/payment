<?php
require_once __DIR__ . '/functions.php';
if (isset($_GET['clear'])) { unset($_SESSION['cart']); header('Location: cart.php'); exit; }
page_header('Keranjang'); $items = cart_items(); ?>
<h1>Keranjang Belanja</h1>
<?php if (isset($_GET['added'])): ?><div class="success">Produk berhasil ditambahkan ke keranjang.</div><?php endif; ?>
<div class="checkout">
<?php if (!$items): ?>
    <p>Keranjang masih kosong.</p><a class="btn" href="index.php">Belanja Sekarang</a>
<?php else: ?>
    <?php foreach ($items as $item): ?>
        <div class="cart-line"><span><?= htmlspecialchars($item['name']) ?> × <?= $item['qty'] ?></span><strong><?= rupiah($item['subtotal']) ?></strong></div>
    <?php endforeach; ?>
    <div class="cart-line"><span>Total</span><strong><?= rupiah(cart_total()) ?></strong></div>
    <a class="btn" href="checkout.php">Proceed to Checkout</a>
    <a class="btn secondary" href="cart.php?clear=1">Kosongkan Keranjang</a>
<?php endif; ?>
</div>
<?php page_footer(); ?>
