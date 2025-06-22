<?php
session_start();
include 'koneksi.php';

// TODO: Tambahkan pengecekan sesi khusus untuk admin di sini

// Pastikan ada parameter action dan id di URL
if (isset($_GET['action']) && isset($_GET['id'])) {
    
    $action = $_GET['action'];
    $order_id = intval($_GET['id']);

    // Tentukan status baru berdasarkan aksi
    $new_status = '';
    if ($action === 'cancel') {
        $new_status = 'Dibatalkan';
    } elseif ($action === 'ship') {
        $new_status = 'Dikirim';
    } elseif ($action === 'complete') {
        $new_status = 'Selesai';
    }

    // Jika status baru valid, update database
    if ($new_status != '' && $order_id > 0) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $order_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Setelah selesai, kembalikan admin ke halaman manajemen pesanan
header('Location: admin_pesanan.php');
exit;
?>