<?php
    session_start();
    include 'koneksi.php';

    // 1. Pastikan pengguna sudah login, jika tidak, arahkan ke halaman masuk
    if (!isset($_SESSION['is_logged_in'])) {
        header('Location: masuk.php');
        exit;
    }

    // 2. Ambil ID pengguna dari session
    $user_id = $_SESSION['user_id'];

    // 3. Ambil semua pesanan milik pengguna tersebut dari database, urutkan dari yang terbaru
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $orders_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan Saya</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .page-container { max-width: 900px; margin: 30px auto; padding: 20px; }
        .order-card { background-color: #fff; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 20px; overflow: hidden; }
        .order-header { background-color: #f8f9fa; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0; }
        .order-header .order-id { font-weight: 700; }
        .order-header .order-date { font-size: 14px; color: #777; }
        .order-body { padding: 20px; }
        .order-body p { margin: 0 0 10px 0; }
        .order-status { padding: 5px 12px; border-radius: 15px; font-size: 12px; font-weight: 500; color: #fff; text-transform: capitalize; }
        .status-diproses { background-color: #2980b9; }
        .status-dikirim { background-color: #f39c12; }
        .status-selesai { background-color: #27ae60; }
        .status-dibatalkan { background-color: #c0392b; }
        .order-actions { margin-top: 20px; padding-top: 15px; border-top: 1px solid #e0e0e0; }
        .cancel-btn { background-color: #e74c3c; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; text-decoration: none; }
    </style>
</head>
<body>
    <header class="header"> </header>
    
    <main class="page-container">
        <h1>Status Pesanan Saya</h1>

        <?php if ($orders_result->num_rows > 0): ?>
            <?php while($order = $orders_result->fetch_assoc()): ?>
                <div class="order-card">
                    <div class="order-header">
                        <span class="order-id">ID Pesanan: ORD-<?php echo $order['id']; ?></span>
                        <span class="order-date"><?php echo date('d M Y, H:i', strtotime($order['order_date'])); ?></span>
                    </div>
                    <div class="order-body">
                        <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?></p>
                        <p><strong>Alamat Pengiriman:</strong> <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                        <p><strong>Status:</strong> 
                            <span class="order-status status-<?php echo strtolower($order['status']); ?>">
                                <?php echo htmlspecialchars($order['status']); ?>
                            </span>
                        </p>
                        <div class="order-actions">
                            <?php
                                // Tombol "Batalkan Pesanan" hanya muncul jika statusnya "Diproses"
                                if ($order['status'] === 'Diproses'):
                            ?>
                                <a href="cancel_order.php?id=<?php echo $order['id']; ?>" class="cancel-btn" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                    Batalkan Pesanan
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Anda belum memiliki riwayat pesanan. <a href="index.php">Mulai belanja sekarang!</a></p>
        <?php endif; ?>
    </main>
    
    <footer class="footer"> </footer>
</body>
</html>