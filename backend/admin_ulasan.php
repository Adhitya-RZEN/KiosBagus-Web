<?php
    session_start();
    include 'koneksi.php'; // Pastikan file ini berisi koneksi ke database Anda ($conn)
    // TODO: Tambahkan pengecekan sesi admin yang valid di sini
    // if (!isset($_SESSION['admin_logged_in'])) {
    //     header('Location: login.php');
    //     exit();
    // }

    // Ambil semua ulasan, gabungkan dengan nama produk
    $reviews_result = $conn->query("
        SELECT r.*, p.name AS product_name 
        FROM reviews r 
        JOIN products p ON r.product_id = p.id 
        ORDER BY r.review_date DESC
    ");

    // Helper untuk mengubah bulan ke Bahasa Indonesia
    function format_tanggal_indonesia($date_string) {
        $bulan = array (
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $timestamp = strtotime($date_string);
        // Format: 20 Juni 2025
        return date('d', $timestamp) . ' ' . $bulan[date('n', $timestamp)] . ' ' . date('Y', $timestamp);
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ulasan Pelanggan</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
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
      color: var(--text-color);
    }
    a {
        text-decoration: none;
        color: var(--accent-color-dark);
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
      color: var(--text-color);
      font-weight: 500;
      padding: 22px 15px;
      border-bottom: 3px solid transparent;
      transition: all 0.2s;
    }
    .admin-header nav a:hover { color: var(--accent-color-dark); }
    .admin-header nav a.active {
      color: var(--accent-color-dark);
      border-bottom: 3px solid var(--accent-color-dark);
    }
    .main-container {
        padding: 30px;
    }
    .content-header {
        margin-bottom: 20px;
    }
    .content-header h1 { margin: 0; }
    .review-filters {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    .tab-button {
      padding: 10px 20px;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      background-color: var(--card-bg-color);
      font-weight: 500;
      cursor: pointer;
      font-family: 'Montserrat', sans-serif;
      font-size: 14px;
    }
    .tab-button.active {
      background-color: var(--accent-color);
      border-color: var(--accent-color-dark);
    }
    .reviews-list {
        display: grid;
        gap: 20px;
    }
    .review-card {
        background-color: var(--card-bg-color);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid var(--border-color);
        transition: opacity 0.3s ease-in-out, height 0.3s ease-in-out;
        display: block; /* Default display */
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }
    .review-header .user-info { font-weight: 600; }
    .review-header .review-date { font-size: 14px; color: var(--secondary-text-color); }
    .review-body {
        padding: 15px 0;
    }
    .review-body .product-info {
        font-size: 14px;
        margin-bottom: 10px;
    }
    .review-body .product-info a {
        font-weight: 600;
    }
    .review-body .rating-stars {
        color: #f39c12;
        font-size: 18px;
        margin-bottom: 10px;
    }
    .review-body .review-text {
        line-height: 1.6;
        margin: 0;
    }
    .review-actions {
        display: flex;
        gap: 10px;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
    }
    .review-actions button, .review-actions a button {
        padding: 8px 15px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background-color: #f8f8f8;
        cursor: pointer;
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
        font-weight: 500;
    }
    .review-actions a { text-decoration: none; }
  </style>
</head>
<body>

  <header class="admin-header">
    <div class="logo">Admin Panel</div>
    <nav>
      <a href="admin_dashboard.php">Dashboard</a>
      <a href="admin_barang.php">Manajemen Produk</a>
      <a href="admin_pesanan.php">Manajemen Pesanan</a>
      <a href="admin_ulasan.php" class="active">Ulasan</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <main class="main-container">
    <div class="content-header">
      <h1>Ulasan Pelanggan</h1>
    </div>

    <div class="review-filters">
      <button class="tab-button active" data-filter="semua">Semua</button>
      <button class="tab-button" data-filter="1-3">Rating 1-3</button>
      <button class="tab-button" data-filter="4-5">Rating 4-5</button>
    </div>

    <div class="reviews-list">
      <?php if ($reviews_result && $reviews_result->num_rows > 0): ?>
        <?php while($review = $reviews_result->fetch_assoc()): ?>
          <div class="review-card" data-rating="<?php echo $review['rating']; ?>">
            <div class="review-header">
              <span class="user-info"><?php echo htmlspecialchars($review['username']); ?></span>
              <span class="review-date"><?php echo format_tanggal_indonesia($review['review_date']); ?></span>
            </div>
            <div class="review-body">
              <div class="product-info">Ulasan untuk: 
                <a href="detailproduk.php?id=<?php echo $review['product_id']; ?>" target="_blank">
                  <?php echo htmlspecialchars($review['product_name']); ?>
                </a>
              </div>
              <div class="rating-stars">
                <?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?>
              </div>
              <p class="review-text"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
            </div>
            <div class="review-actions">
              <button>Balas</button>
              <button>Sembunyikan</button>
              <a href="admin_review_action.php?action=delete&id=<?php echo $review['id']; ?>" onclick="return confirm('Yakin ingin menghapus ulasan ini?');">
                <button>Hapus</button>
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Belum ada ulasan yang masuk.</p>
      <?php endif; ?>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const filterButtons = document.querySelectorAll('.tab-button');
      const reviewCards = document.querySelectorAll('.review-card');

      filterButtons.forEach(button => {
        button.addEventListener('click', function() {
          // Menghapus kelas 'active' dari semua tombol
          filterButtons.forEach(btn => btn.classList.remove('active'));
          // Menambahkan kelas 'active' ke tombol yang diklik
          this.classList.add('active');

          const filterType = this.getAttribute('data-filter');

          reviewCards.forEach(card => {
            const rating = parseInt(card.getAttribute('data-rating'), 10);
            
            // Logika untuk menampilkan atau menyembunyikan kartu
            let shouldShow = false;
            if (filterType === 'semua') {
              shouldShow = true;
            } else if (filterType === '1-3') {
              if (rating >= 1 && rating <= 3) {
                shouldShow = true;
              }
            } else if (filterType === '4-5') {
              if (rating >= 4 && rating <= 5) {
                shouldShow = true;
              }
            }

            if (shouldShow) {
              card.style.display = 'block';
            } else {
              card.style.display = 'none';
            }
          });
        });
      });
    });
  </script>

</body>
</html>