<?php
require_once __DIR__ . '/functions.php';
$products = products(); $id = $_GET['id'] ?? '';
if (!isset($products[$id])) { http_response_code(404); exit('Produk tidak ditemukan'); }
$product = $products[$id];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qty = max(1, (int)($_POST['qty'] ?? 1));
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
    header('Location: cart.php?added=1'); exit;
}
page_header($product['name']); ?>
<div class="row">
    <div class="card"><img style="height:420px" src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"></div>
    <form class="form" method="post">
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <p><?= htmlspecialchars($product['description']) ?></p>
        <p class="price"><?= rupiah($product['price']) ?></p>
        <label>Varian</label><select name="variant"><option>Default</option><option>Premium</option></select>
        <label>Jumlah</label><input type="number" name="qty" value="1" min="1">
        <button class="btn full" type="submit">Tambah ke Keranjang</button>
    </form>
</div>
<?php page_footer(); ?>
