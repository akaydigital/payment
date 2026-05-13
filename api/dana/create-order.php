<?php

require_once __DIR__ . '/config.php';

use Dana\Configuration;
use Dana\Env;
use Dana\PaymentGateway\v1\Api\PaymentGatewayApi;
use Dana\PaymentGateway\v1\Model\CreateOrderRequest;

$orderId = $_POST['order_id'] ?? 'ORDER' . time();
$amount  = $_POST['amount'] ?? 10000;

$configuration = new Configuration();

$configuration->setApiKey('PRIVATE_KEY_PATH', DANA_PRIVATE_KEY_PATH);
$configuration->setApiKey('ORIGIN', DANA_ORIGIN);
$configuration->setApiKey('X_PARTNER_ID', DANA_CLIENT_ID);
$configuration->setApiKey('CLIENT_SECRET', DANA_CLIENT_SECRET);
$configuration->setApiKey('ENV', Env::SANDBOX);

$apiInstance = new PaymentGatewayApi(null, $configuration);

$request = new CreateOrderRequest([
    'partner_reference_no' => $orderId,
    'merchant_id' => DANA_MERCHANT_ID,
    'amount' => [
        'value' => number_format($amount, 2, '.', ''),
        'currency' => 'IDR'
    ],
    'url_params' => [
        [
            'url' => DANA_NOTIFY_URL,
            'type' => 'NOTIFICATION',
            'is_deeplink' => 'N'
        ],
        [
            'url' => DANA_RETURN_URL,
            'type' => 'PAY_RETURN',
            'is_deeplink' => 'N'
        ]
    ],
    'additional_info' => [
        'order' => [
            'order_title' => 'Testing Pembayaran DANA',
            'scenario' => 'API_TESTING'
        ]
    ]
]);

try {
    $response = $apiInstance->createOrder($request);

    echo '<pre>';
    print_r($response);
    echo '</pre>';

} catch (Exception $e) {
    echo '<h3>Error:</h3>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
}
