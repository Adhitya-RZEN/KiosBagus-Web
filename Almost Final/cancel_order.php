<?php
session_start();
include 'koneksi.php';

// 1. Pastikan pengguna sudah login
if (!isset($_SESSION['is_logged_in'])) {
    header('Location: masuk.php');
    exit;
}

// 2. Pastikan ID pesanan ada di URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: status_pesanan.php');
    exit;
}

$order_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// 3. Validasi Keamanan: Pastikan pesanan ini benar-benar milik pengguna yang sedang login
$stmt = $conn->prepare("SELECT status, user_id FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
    
    // Cek apakah user_id dari pesanan cocok dengan user_id dari session
    if ($order['user_id'] == $user_id) {
        
        // 4. Pastikan status pesanan masih "Diproses" sebelum dibatalkan
        if ($order['status'] === 'Diproses') {
            $update_stmt = $conn->prepare("UPDATE orders SET status = 'Dibatalkan' WHERE id = ?");
            $update_stmt->bind_param("i", $order_id);
            $update_stmt->execute();
            $update_stmt->close();
        }
    }
}
$stmt->close();
$conn->close();

// 5. Kembalikan pengguna ke halaman status pesanan
header('Location: status_pesanan.php');
exit;
?>