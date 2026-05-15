<?php
require_once __DIR__ . '/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user'] = [
        'name' => trim($_POST['name'] ?: 'Customer Demo'),
        'email' => trim($_POST['email'] ?: 'customer@example.com'),
        'phone' => trim($_POST['phone'] ?: '081234567890'),
        'address' => trim($_POST['address'] ?: 'Surabaya, Jawa Timur'),
    ];
    header('Location: index.php'); exit;
}
page_header('Login'); ?>
<form class="form" method="post">
    <h1>Login Customer</h1>
    <label>Nama</label><input name="name" value="Customer Demo" required>
    <label>Email</label><input name="email" type="email" value="customer@example.com" required>
    <label>No. HP</label><input name="phone" value="081234567890" required>
    <label>Alamat</label><textarea name="address" required>Surabaya, Jawa Timur</textarea>
    <button class="btn" type="submit">Login</button>
</form>
<?php page_footer(); ?>
