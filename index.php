<?php require_once __DIR__ . '/functions.php'; page_header('Homepage'); $products = products(); ?>
<section class="hero">
    <h1>Selamat Datang Di AKAY DIGITAL</h1>

</section>

</section>
<div class="grid">
<?php foreach ($products as $product): ?>
    <article class="card">
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <div class="card-body">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <p class="price"><?= rupiah($product['price']) ?></p>
            <a class="btn" href="product.php?id=<?= urlencode($product['id']) ?>">Detail Produk</a>
        </div>
    </article>
<?php endforeach; ?>
</div>
<?php page_footer(); ?>
