<?php
    session_start();
    include 'koneksi.php';

    // TODO: Tambahkan pengecekan sesi khusus untuk admin di sini
    // if (!isset($_SESSION['is_admin_logged_in'])) {
    //     header('Location: admin_login_page.php'); // Ganti dengan halaman login admin Anda
    //     exit;
    // }

    // Ambil semua data pesanan, diurutkan dari yang paling baru
    $orders_result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Pesanan</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="path/to/your/admin_style.css"> <style>
    :root {
      --bg-color: #f4f5f7;
      --card-bg-color: #ffffff;
      --text-color: #333333;
      --secondary-text-color: #777;
      --accent-color: #efb1b1;
      --accent-color-dark: #e89a9a;
      --border-color: #e0e0e0;
    }
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: var(--bg-color);
      margin: 0;
    }
    .admin-header {
      background-color: var(--card-bg-color);
      padding: 0 30px;
      border-bottom: 1px solid var(--border-color);
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 65px;
    }
    .admin-header .logo { font-size: 20px; font-weight: 700; }
    .admin-header nav a {
      text-decoration: none;
      color: var(--text-color);
      font-weight: 500;
      padding: 22px 15px;
      border-bottom: 3px solid transparent;
      transition: all 0.2s;
    }
    .main-container { padding: 30px; }
    .content-header { margin-bottom: 20px; }
    .content-header h1 { margin: 0; }
    .order-table-container {
      background-color: #fff;
      padding: 25px;
      border-radius: 16px;
    }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
    .status {
      padding: 5px 12px;
      border-radius: 15px;
      font-size: 12px;
      font-weight: 500;
      display: inline-block;
      text-transform: capitalize;
    }
    .status.diproses { background-color: #eaf2fa; color: #2980b9; }
    .status.dikirim { background-color: #fef5e7; color: #f39c12; }
    .status.selesai { background-color: #e8f8f5; color: #27ae60; }
    .status.dibatalkan { background-color: #fbeeeeee; color: #c0392b; }
    .action-buttons { display: flex; gap: 10px; }
    .action-buttons button { padding: 8px 15px; border-radius: 8px; cursor: pointer; border: 1px solid var(--border-color); }
    .btn-detail { background-color: #f8f8f8; }
    .btn-cancel { background-color: #fff; color: #c0392b; border-color: #c0392b; }
    .detail-container { position: relative; }
    .detail-popup {
        display: none;
        position: absolute;
        bottom: 100%;
        left: 0;
        transform: translateY(-10px);
        background-color: var(--card-bg-color);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        padding: 15px;
        width: 300px;
        z-index: 10;
    }
    .detail-container:hover .detail-popup { display: block; }
    .detail-popup h4 { margin-top: 0; margin-bottom: 10px; font-size: 14px; border-bottom: 1px solid #eee; padding-bottom: 8px; }
    .detail-popup p, .detail-popup ul { font-size: 13px; margin: 0; color: var(--secondary-text-color); line-height: 1.5; }
    .detail-popup ul { padding-left: 20px; margin-top: 5px; }
  </style>
</head>
<body>

<header class="admin-header">
    <div class="logo">Admin Panel</div>
    <nav>
      <a href="admin_dashboard.php">Dashboard</a>
      <a href="admin_barang.php">Manajemen Produk</a>
      <a href="admin_pesanan.php" class="active">Manajemen Pesanan</a>
      <a href="admin_ulasan.php">Ulasan</a>
      <a href="#">Logout</a>
    </nav>
  </header>

  <main class="main-container">
    <div class="content-header"><h1>Manajemen Pesanan</h1></div>
    <div class="order-table-container">
      <table>
        <thead>
          <tr>
            <th>ID Pesanan</th>
            <th>Pelanggan</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="order-table-body">
          <?php if ($orders_result->num_rows > 0): ?>
            <?php while($order = $orders_result->fetch_assoc()): ?>
            <tr>
              <td>ORD-<?php echo $order['id']; ?></td>
              <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
              <td><?php echo date('d M Y, H:i', strtotime($order['order_date'])); ?></td>
              <td>Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?></td>
              <td>
                  <span class="status <?php echo strtolower($order['status']); ?>">
                      <?php echo htmlspecialchars($order['status']); ?>
                  </span>
              </td>
              <td class="action-buttons">
                  <div class="detail-container">
                    <button class="btn-detail">Detail</button>
                    <div class="detail-popup">
                        </div>
                 </div

                <a href="admin_order_action.php?action=cancel&id=<?php echo $order['id']; ?>" 
                   onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ORD-<?php echo $order['id']; ?>?');">
                  <button class="btn-cancel">Batalkan</button>
                </a>
                          <h4>Rincian Pesanan</h4>
                          <p><strong>Alamat:</strong> <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                          <strong>Barang:</strong>
                          <ul>
                            <?php
                              // Ambil item untuk pesanan ini
                              $item_stmt = $conn->prepare("SELECT oi.quantity, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
                              $item_stmt->bind_param("i", $order['id']);
                              $item_stmt->execute();
                              $items_result = $item_stmt->get_result();
                              while($item = $items_result->fetch_assoc()) {
                                  echo '<li>' . htmlspecialchars($item['name']) . ' x ' . $item['quantity'] . '</li>';
                              }
                              $item_stmt->close();
                            ?>
                          </ul>
                      </div>
                  </div>
                  <button class="btn-cancel">Batalkan</button>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6" style="text-align: center;">Belum ada pesanan.</td></tr>
          <?php endif; ?>
          <?php $conn->close(); ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>