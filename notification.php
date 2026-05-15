<?php
// URL ini masukkan ke Midtrans Dashboard > Settings > Configuration > Payment Notification URL
// https://domain-anda.com/notification.php
require_once __DIR__ . '/config.php';
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
file_put_contents(__DIR__ . '/midtrans-notification.log', date('c') . ' ' . $raw . PHP_EOL, FILE_APPEND);

// Validasi signature key
if ($data && isset($data['order_id'], $data['status_code'], $data['gross_amount'], $data['signature_key'])) {
    $expected = hash('sha512', $data['order_id'] . $data['status_code'] . $data['gross_amount'] . MIDTRANS_SERVER_KEY);
    if (!hash_equals($expected, $data['signature_key'])) {
        http_response_code(403); echo 'Invalid signature'; exit;
    }
}

// TODO: update status order di database Anda sesuai transaction_status
// settlement/capture = paid, pending = unpaid, expire/cancel/deny = failed
http_response_code(200);
echo 'OK';
