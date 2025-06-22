<?php
session_start();
include 'koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['is_logged_in'])) {
    header('Location: masuk.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Validasi sederhana
    if (!empty($product_id) && !empty($rating) && !empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, username, rating, comment) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisis", $product_id, $user_id, $username, $rating, $comment);
        $stmt->execute();
        $stmt->close();
    }
}

// Kembalikan pengguna ke halaman produk setelah mengirim ulasan
header('Location: detailproduk.php?id=' . $product_id);
exit;
?>