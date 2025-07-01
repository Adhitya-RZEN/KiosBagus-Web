<?php
session_start();
include 'koneksi.php';

// Validasi: Pastikan user login dan keranjang tidak kosong
if (!isset($_SESSION['is_logged_in']) || empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

// Ambil data dari form checkout
$user_id = $_SESSION['user_id'];
$customer_name = $_SESSION['username'];
$shipping_address = $_POST['shipping_address'];
$payment_method = $_POST['payment_method'];

// Ambil data produk dan hitung total belanja (validasi ulang di sisi server)
$product_ids = array_keys($_SESSION['cart']);
$placeholders = implode(',', array_fill(0, count($product_ids), '?'));
$stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
$stmt->execute();
$products_result = $stmt->get_result();

$products_data = [];
while ($row = $products_result->fetch_assoc()) {
    $products_data[$row['id']] = $row;
}

$total_amount = 0;
foreach ($_SESSION['cart'] as $id => $item) {
    $total_amount += $products_data[$id]['price'] * $item['quantity'];
}

// Mulai transaksi database
$conn->begin_transaction();

try {
    // 1. Simpan ke tabel 'orders'
    $stmt_order = $conn->prepare("INSERT INTO orders (user_id, customer_name, shipping_address, total_amount, payment_method) VALUES (?, ?, ?, ?, ?)");
    $stmt_order->bind_param("issis", $user_id, $customer_name, $shipping_address, $total_amount, $payment_method);
    $stmt_order->execute();
    
    // Ambil ID dari pesanan yang baru saja dibuat
    $order_id = $conn->insert_id;

    // 2. Simpan setiap item ke tabel 'order_items'
    $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $id => $item) {
        $product = $products_data[$id];
        $stmt_items->bind_param("iiis", $order_id, $id, $item['quantity'], $product['price']);
        $stmt_items->execute();
    }

    // Jika semua berhasil, commit transaksi
    $conn->commit();

    // 3. Kosongkan keranjang belanja
    unset($_SESSION['cart']);

    // Arahkan ke halaman sukses
    header('Location: order_success.php');
    exit();

} catch (Exception $e) {
    // Jika ada error, batalkan semua perubahan
    $conn->rollback();
    // Anda bisa membuat halaman error khusus atau redirect dengan pesan error
    echo "Terjadi kesalahan saat memproses pesanan. Silakan coba lagi. Error: " . $e->getMessage();
}
?>