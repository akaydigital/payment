<?php
require_once __DIR__ . '/functions.php';
require_login();
$items = cart_items();
if (!$items) { header('Location: cart.php'); exit; }
$user = current_user();
$shipping = 10000;
$total = cart_total() + $shipping;
$orderId = 'ORDER-' . date('YmdHis') . '-' . random_int(100, 999);
$itemDetails = [];
foreach ($items as $item) {
    $itemDetails[] = ['id'=>$item['id'], 'price'=>$item['price'], 'quantity'=>$item['qty'], 'name'=>$item['name']];
}
$itemDetails[] = ['id'=>'SHIPPING', 'price'=>$shipping, 'quantity'=>1, 'name'=>'Ongkos Kirim'];

$snapToken = null; $error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $transaction = [
            'transaction_details' => ['order_id' => $orderId, 'gross_amount' => $total],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'billing_address' => ['first_name'=>$user['name'], 'address'=>$user['address'], 'city'=>'Surabaya', 'country_code'=>'IDN'],
                'shipping_address' => ['first_name'=>$user['name'], 'address'=>$user['address'], 'city'=>'Surabaya', 'country_code'=>'IDN'],
            ],
            'enabled_payments' => ['bank_transfer','gopay','shopeepay','qris','credit_card'],
            'callbacks' => ['finish' => BASE_URL . '/thankyou.php?order_id=' . urlencode($orderId)]
        ];
        $response = create_snap_token($transaction);
        $snapToken = $response['token'] ?? null;
        $_SESSION['last_order'] = ['id'=>$orderId, 'items'=>$items, 'shipping'=>$shipping, 'total'=>$total, 'user'=>$user];
    } catch (Throwable $e) { $error = $e->getMessage(); }
}
page_header('Checkout'); ?>
<script src="<?= midtrans_snap_js() ?>" data-client-key="<?= MIDTRANS_CLIENT_KEY ?>"></script>
<h1>Checkout</h1>
<?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="row">
    <section class="checkout">
        <h2>Billing & Shipping Address</h2>
        <p><strong><?= htmlspecialchars($user['name']) ?></strong><br><?= htmlspecialchars($user['email']) ?><br><?= htmlspecialchars($user['phone']) ?><br><?= nl2br(htmlspecialchars($user['address'])) ?></p>
        <h2>Metode Pembayaran</h2>
        <p>Midtrans Snap: Virtual Account, GoPay, ShopeePay, QRIS, Kartu Kredit.</p>
        <form method="post"><button class="btn full" type="submit">Submit Order / Bayar Sekarang</button></form>
    </section>
    <aside class="summary">
        <h2>Ringkasan Pesanan</h2>
        <?php foreach ($items as $item): ?><div class="cart-line"><span><?= htmlspecialchars($item['name']) ?> × <?= $item['qty'] ?></span><strong><?= rupiah($item['subtotal']) ?></strong></div><?php endforeach; ?>
        <div class="cart-line"><span>Ongkir</span><strong><?= rupiah($shipping) ?></strong></div>
        <div class="cart-line"><span>Grand Total</span><strong><?= rupiah($total) ?></strong></div>
    </aside>
</div>
<?php if ($snapToken): ?>
<script>
window.snap.pay('<?= htmlspecialchars($snapToken, ENT_QUOTES) ?>', {
    onSuccess: function(result){ window.location.href = 'thankyou.php?order_id=<?= urlencode($orderId) ?>&status=success'; },
    onPending: function(result){ window.location.href = 'thankyou.php?order_id=<?= urlencode($orderId) ?>&status=pending'; },
    onError: function(result){ alert('Pembayaran gagal. Silakan coba lagi.'); },
    onClose: function(){ alert('Popup pembayaran ditutup sebelum selesai.'); }
});
</script>
<?php endif; ?>
<?php page_footer(); ?>
