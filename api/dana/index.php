<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Testing DANA Sandbox</title>
</head>
<body>
    <h2>Testing Pembayaran DANA Sandbox</h2>

    <form action="create-order.php" method="post">
        <label>Order ID</label><br>
        <input type="text" name="order_id" value="ORDER<?= time(); ?>"><br><br>

        <label>Nominal</label><br>
        <input type="number" name="amount" value="10000"><br><br>

        <button type="submit">Buat Pembayaran Test</button>
    </form>
</body>
</html>
