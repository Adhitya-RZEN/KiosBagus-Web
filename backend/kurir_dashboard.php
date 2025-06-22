<?php
    session_start();
    include 'koneksi.php';

    // Keamanan: Pastikan hanya kurir yang bisa mengakses halaman ini
    if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'kurir') {
        // Jika bukan kurir, arahkan ke halaman login atau halaman utama
        header('Location: masuk.php');
        exit;
    }

    // Ambil pesanan untuk setiap tab
    $tugas_baru = $conn->query("SELECT * FROM orders WHERE status = 'Diproses' ORDER BY order_date ASC");
    $sedang_diantar = $conn->query("SELECT * FROM orders WHERE status = 'Dikirim' ORDER BY order_date ASC");
    $riwayat = $conn->query("SELECT * FROM orders WHERE status IN ('Selesai', 'Dibatalkan') ORDER BY order_date DESC LIMIT 20");

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Kurir</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --bg-color: #f4f5f7; --card-bg-color: #ffffff; --text-color: #333333; --secondary-text-color: #777; --accent-color: #efb1b1; --accent-color-dark: #e89a9a; --border-color: #e0e0e0; --success-color: #27ae60; --success-color-light: #e8f8f5; }
    body { font-family: 'Montserrat', sans-serif; background-color: var(--bg-color); margin: 0; color: var(--text-color); }
    .courier-header { background-color: var(--card-bg-color); color: var(--text-color); padding: 0 30px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; height: 65px; }
    .courier-header h1 { margin: 0; font-size: 20px; }
    .courier-header a { color: var(--text-color); text-decoration: none; font-weight: 500; }
    .main-container { padding: 20px; }
    .task-filters { display: flex; gap: 10px; margin-bottom: 20px; }
    .filter-tab { flex: 1; padding: 12px; text-align: center; border: 1px solid var(--border-color); background-color: var(--card-bg-color); border-radius: 8px; cursor: pointer; font-weight: 600; }
    .filter-tab.active { background-color: var(--accent-color); border-color: var(--accent-color-dark); }
    .order-list { display: none; }
    .order-list.active { display: block; }
    .order-card { background-color: var(--card-bg-color); border-radius: 12px; margin-bottom: 15px; border: 1px solid var(--border-color); overflow: hidden; }
    .order-card-header { padding: 15px; display: flex; justify-content: space-between; align-items: center; background-color: #fdfdfd; border-bottom: 1px solid var(--border-color); }
    .order-card-header .order-id { font-weight: 700; }
    .order-card-header .order-status { font-weight: 600; color: var(--secondary-text-color); }
    .order-card-body { padding: 15px; font-size: 14px; }
    .order-card-body p { margin: 0 0 10px 0; }
    .order-card-body .address { line-height: 1.5; }
    .order-card-actions { padding: 15px; background-color: #f9f9f9; border-top: 1px solid var(--border-color); }
    .action-button { width: 100%; padding: 12px; font-size: 16px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; background-color: var(--accent-color); color: var(--text-color); text-align: center; display: block; text-decoration: none; }
    .action-button.completed { background-color: var(--success-color-light); color: var(--success-color); cursor: default; }
  </style>
</head>
<body>

  <header class="courier-header">
    <h1>Tugas Saya - <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <a href="logout.php">Logout</a>
  </header>

  <main class="main-container">
    <div class="task-filters">
      <button class="filter-tab active" data-filter="baru">Tugas Baru</button>
      <button class="filter-tab" data-filter="diantar">Sedang Diantar</button>
      <button class="filter-tab" data-filter="riwayat">Riwayat</button>
    </div>

    <div id="baru" class="order-list active">
      <?php while($order = $tugas_baru->fetch_assoc()): ?>
        <div class="order-card">
          <div class="order-card-header"><span class="order-id">ID: ORD-<?php echo $order['id']; ?></span><span class="order-status"><?php echo $order['status']; ?></span></div>
          <div class="order-card-body">
            <p><strong>Pelanggan:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
            <p class="address"><strong>Alamat:</strong> <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
          </div>
          <div class="order-card-actions">
            <a href="courier_action.php?action=ship&id=<?php echo $order['id']; ?>" class="action-button">Ambil Pesanan</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <div id="diantar" class="order-list">
        <?php while($order = $sedang_diantar->fetch_assoc()): ?>
        <div class="order-card">
          <div class="order-card-header"><span class="order-id">ID: ORD-<?php echo $order['id']; ?></span><span class="order-status"><?php echo $order['status']; ?></span></div>
          <div class="order-card-body">
            <p><strong>Pelanggan:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
            <p class="address"><strong>Alamat:</strong> <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
          </div>
          <div class="order-card-actions">
            <a href="courier_action.php?action=complete&id=<?php echo $order['id']; ?>" class="action-button">Selesaikan Pengiriman</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <div id="riwayat" class="order-list">
        <?php while($order = $riwayat->fetch_assoc()): ?>
        <div class="order-card">
          <div class="order-card-header"><span class="order-id">ID: ORD-<?php echo $order['id']; ?></span><span class="order-status" style="color: <?php echo $order['status'] === 'Selesai' ? 'green' : 'red'; ?>;"><?php echo $order['status']; ?></span></div>
          <div class="order-card-body">
            <p><strong>Pelanggan:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const filterTabs = document.querySelectorAll('.filter-tab');
      const orderLists = document.querySelectorAll('.order-list');
      
      filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
          // Hapus kelas active dari semua tab dan list
          filterTabs.forEach(t => t.classList.remove('active'));
          orderLists.forEach(l => l.classList.remove('active'));
          
          // Tambahkan kelas active ke tab yang diklik dan list yang sesuai
          this.classList.add('active');
          const filter = this.getAttribute('data-filter');
          document.getElementById(filter).classList.add('active');
        });
      });
    });
  </script>
</body>
</html>