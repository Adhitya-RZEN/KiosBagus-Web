<?php
session_start();
include 'koneksi.php'; // Sertakan koneksi untuk cek stok

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$action = $_GET['action'] ?? 'add';

// Logika untuk menambahkan item (dari POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $product_id = $_POST['product_id'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;

    if ($product_id > 0 && $quantity > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = ['quantity' => $quantity];
        }
    }
}

// Logika untuk menghapus item
if ($action === 'remove') {
    $product_id = $_GET['id'] ?? 0;
    if ($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// === LOGIKA BARU UNTUK UPDATE KUANTITAS ===
if ($action === 'update') {
    $product_id = $_GET['id'] ?? 0;
    $quantity = $_GET['quantity'] ?? 1;

    // Pastikan kuantitas tidak kurang dari 1
    if ($product_id > 0 && $quantity < 1) {
        // Jika kuantitas menjadi 0 atau kurang, hapus item
        unset($_SESSION['cart'][$product_id]);
    } elseif ($product_id > 0) {
        // Cek stok di database sebelum menambah kuantitas
        $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        
        if ($product && $quantity <= $product['stock']) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        }
    }
}
// ==========================================

// Arahkan kembali ke halaman keranjang
header('Location: Keranjang.php');
exit();
?>