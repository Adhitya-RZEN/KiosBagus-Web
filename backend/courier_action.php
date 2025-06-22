<?php
session_start();
include 'koneksi.php';

// Keamanan: Pastikan hanya kurir yang bisa mengakses
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'kurir') {
    header('Location: masuk.php');
    exit;
}

// Pastikan ada parameter action dan id di URL
if (isset($_GET['action']) && isset($_GET['id'])) {
    
    $action = $_GET['action'];
    $order_id = intval($_GET['id']);

    $new_status = '';
    $current_status_check = '';

    if ($action === 'ship') {
        $new_status = 'Dikirim';
        $current_status_check = 'Diproses'; // Hanya bisa mengubah pesanan yang statusnya 'Diproses'
    } elseif ($action === 'complete') {
        $new_status = 'Selesai';
        $current_status_check = 'Dikirim'; // Hanya bisa mengubah pesanan yang statusnya 'Dikirim'
    }

    // Jika aksi valid, update database
    if ($new_status != '' && $order_id > 0) {
        // Menambahkan pengecekan status saat ini untuk mencegah perubahan ganda
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ? AND status = ?");
        $stmt->bind_param("sis", $new_status, $order_id, $current_status_check);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
// Kembalikan kurir ke halaman dashboard mereka
header('Location: kurir_dashboard.php');
exit;
?>