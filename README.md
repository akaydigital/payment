# Website Demo Flow Transaksi Midtrans

Fitur:
- Homepage produk
- Login customer sederhana
- Detail produk
- Keranjang belanja
- Checkout dengan billing/shipping address
- Integrasi Midtrans Snap popup
- Halaman Thank You
- Endpoint notification callback

## Cara Pakai
1. Upload semua file ke hosting PHP.
2. Edit `config.php`:
   - `MIDTRANS_SERVER_KEY`
   - `MIDTRANS_CLIENT_KEY`
   - `BASE_URL`
3. Pastikan PHP cURL aktif.
4. Buka `index.php`.
5. Di Midtrans Dashboard, isi Payment Notification URL:
   `https://domain-anda.com/notification.php`

## Catatan
Ini demo flow untuk pengajuan/verifikasi. Untuk production, simpan order ke database MySQL dan jangan gunakan session saja.
