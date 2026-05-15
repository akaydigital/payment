<?php
// GANTI DENGAN KEY SANDBOX / PRODUCTION MIDTRANS ANDA
// Sandbox: https://dashboard.sandbox.midtrans.com/settings/access-keys
// Production: https://dashboard.midtrans.com/settings/access-keys

define('MIDTRANS_IS_PRODUCTION', false);
define('MIDTRANS_SERVER_KEY', 'Mid-server-qMKlQk7qIFs65YiK2BAEKNtX');
define('MIDTRANS_CLIENT_KEY', 'Mid-client-yPS959ObnOMPdLnY');

define('STORE_NAME', 'AKAY DIGITAL NUSANTARA');
define('BASE_URL', 'https://pay.akay.web.id'); // ganti setelah upload hosting

function midtrans_snap_url(): string {
    return MIDTRANS_IS_PRODUCTION
        ? 'https://app.midtrans.com/snap/v1/transactions'
        : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
}

function midtrans_snap_js(): string {
    return MIDTRANS_IS_PRODUCTION
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
}
