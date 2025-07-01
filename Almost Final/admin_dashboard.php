<?php
    session_start();
    include 'koneksi.php';

    // TODO: Tambahkan pengecekan sesi khusus untuk admin

    // --- Query untuk Kartu Ringkasan ---
    
    // 1. Menghitung Pendapatan Hari Ini
    $revenue_query = "SELECT SUM(total_amount) as daily_revenue FROM orders WHERE DATE(order_date) = CURDATE()";
    $revenue_result = $conn->query($revenue_query);
    $daily_revenue = $revenue_result->fetch_assoc()['daily_revenue'] ?? 0;

    // 2. Menghitung Jumlah Pesanan Hari Ini
    $orders_query = "SELECT COUNT(id) as daily_orders FROM orders WHERE DATE(order_date) = CURDATE()";
    $orders_result = $conn->query($orders_query);
    $daily_orders = $orders_result->fetch_assoc()['daily_orders'] ?? 0;

    // 3. Menghitung Item Terjual Hari Ini
    $items_query = "SELECT SUM(oi.quantity) as items_sold FROM order_items oi JOIN orders o ON oi.order_id = o.id WHERE DATE(o.order_date) = CURDATE()";
    $items_result = $conn->query($items_query);
    $items_sold = $items_result->fetch_assoc()['items_sold'] ?? 0;
    
    $conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-color: #f4f5f7;
      --card-bg-color: #ffffff;
      --text-color: #333333;
      --accent-color: #efb1b1;
      --accent-color-dark: #e89a9a;
      --border-color: #e0e0e0;
    }
    body { font-family: 'Montserrat', sans-serif; background-color: var(--bg-color); margin: 0; color: var(--text-color); }
    .admin-header { background-color: var(--card-bg-color); padding: 0 30px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; height: 65px; }
    .admin-header .logo { font-size: 20px; font-weight: 700; }
    .admin-header nav a { text-decoration: none; color: var(--text-color); font-weight: 500; padding: 22px 15px; border-bottom: 3px solid transparent; transition: all 0.2s; }
    .admin-header nav a.active { color: var(--accent-color-dark); border-bottom: 3px solid var(--accent-color-dark); }
    .dashboard-container { padding: 30px; }
    .card { background-color: var(--card-bg-color); border-radius: 16px; padding: 25px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); text-decoration: none; color: var(--text-color); display: block; }
    .card h2 { margin-top: 0; font-size: 18px; font-weight: 600; color: var(--secondary-text-color); }
    .card .value { font-size: 28px; font-weight: 700; margin: 10px 0 0 0; }
    .summary-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 30px; }
    .graph-placeholder { display: flex; align-items: center; justify-content: center; height: 300px; margin-top: 20px; border-radius: 10px; background-color: #f8f8f8; border: 1px dashed var(--border-color); }
  </style>
</head>
<body>

  <header class="admin-header">
    <div class="logo">Admin Panel</div>
    <nav>
      <a href="admin_dashboard.php" class="active">Dashboard</a>
      <a href="admin_barang.php">Manajemen Produk</a>
      <a href="admin_pesanan.php">Manajemen Pesanan</a>
      <a href="admin_ulasan.php">Ulasan</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <main class="dashboard-container">
    <h1>Dashboard Hari Ini (21 Juni 2025)</h1>
    <section class="summary-cards">
      
      <div class="card">
        <h2>Pendapatan Hari Ini</h2>
        <p class="value">Rp <?php echo number_format($daily_revenue, 0, ',', '.'); ?></p>
      </div>
      
      <a href="admin_pesanan.php" class="card">
        <h2>Pesanan Baru Hari Ini</h2>
        <p class="value"><?php echo $daily_orders; ?></p>
      </a>

      <div class="card">
        <h2>Produk Terjual Hari Ini</h2>
        <p class="value"><?php echo $items_sold; ?> item</p>
      </div>

    </section>

    <div class="card">
      <h2>Grafik Penjualan Mingguan</h2>
      <div class="graph-placeholder">
        Tempat untuk Grafik
      </div>
    </div>
  </main>
</body>
</html>