<?php
session_start();
require_once __DIR__ . '/config.php';

function rupiah(int $amount): string {
    return 'Rp' . number_format($amount, 0, ',', '.');
}

function products(): array {
    return require __DIR__ . '/products.php';
}

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function require_login(): void {
    if (!current_user()) {
        header('Location: login.php');
        exit;
    }
}

function cart_items(): array {
    $items = [];
    $products = products();
    foreach ($_SESSION['cart'] ?? [] as $id => $qty) {
        if (isset($products[$id])) {
            $item = $products[$id];
            $item['qty'] = (int)$qty;
            $item['subtotal'] = $item['price'] * $item['qty'];
            $items[] = $item;
        }
    }
    return $items;
}

function cart_total(): int {
    return array_sum(array_column(cart_items(), 'subtotal'));
}

function create_snap_token(array $order): array {
    $auth = base64_encode(MIDTRANS_SERVER_KEY . ':');
    $payload = json_encode($order);

    $ch = curl_init(midtrans_snap_url());
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Basic ' . $auth,
        ],
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_TIMEOUT => 30,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($response === false || $httpCode >= 400) {
        throw new RuntimeException('Midtrans error: ' . ($error ?: $response));
    }

    return json_decode($response, true) ?: [];
}

function page_header(string $title): void { ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?> - <?= STORE_NAME ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="index.php"><?= STORE_NAME ?></a>
    <nav>
        <a href="index.php">Produk</a>
        <a href="cart.php">Keranjang (<?= count(cart_items()) ?>)</a>
        <?php if (current_user()): ?>
            <span><?= htmlspecialchars(current_user()['name']) ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
<?php }

function page_footer(): void { ?>
</main>
<footer class="footer">PT. AKAY DIGITAL NUSANTARA</footer>
</body>
</html>
<?php }
