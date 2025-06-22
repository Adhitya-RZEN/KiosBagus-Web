<?php
session_start();
include 'koneksi.php';

// TODO: Tambahkan pengecekan sesi khusus untuk admin

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Ambil semua data dari formulir
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    if ($action === 'add') {
        $image_url = 'Assets/download.jpeg'; // Default image

        $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, category, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiss", $name, $description, $price, $stock, $category, $image_url);
        
        $stmt->execute();
        $stmt->close();

    } elseif ($action === 'edit') {
        $product_id = $_POST['product_id'];

        // Pastikan product_id valid
        if (!empty($product_id)) {
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category = ? WHERE id = ?");
            $stmt->bind_param("ssiisi", $name, $description, $price, $stock, $category, $product_id);

            $stmt->execute();
            $stmt->close();
        }
    }
}

$conn->close();
// Arahkan kembali ke halaman manajemen produk
header('Location: admin_barang.php');
exit;