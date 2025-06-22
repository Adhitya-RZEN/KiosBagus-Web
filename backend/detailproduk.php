<?php
    session_start();
    include 'koneksi.php';

    // Periksa apakah ID produk ada di URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $product_id = intval($_GET['id']);

        // Ambil data produk dari database
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {
            $error_message = "Produk tidak ditemukan.";
        }
        $stmt->close();
    } else {
        $error_message = "Halaman tidak valid.";
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo isset($product) ? htmlspecialchars($product['name']) : 'Detail Produk'; ?> - Kios Bagus</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <style>
    .page-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
    .breadcrumb { font-size: 14px; margin-bottom: 20px; }
    .breadcrumb a { color: #c7a17a; text-decoration: none; }
    .breadcrumb span { color: #777; }
    .product-detail-container { display: flex; gap: 40px; background-color: #fff; padding: 30px; border-radius: 8px; border: 1px solid #e0e0e0; }
    .product-images { flex: 1; max-width: 450px; }
    .main-image img { width: 100%; border-radius: 8px; border: 1px solid #e0e0e0; }
    .product-info { flex: 1; }
    .product-info h1 { margin-top: 0; font-size: 28px; }
    .product-info .price { font-size: 24px; font-weight: 700; color: #c7a17a; margin-bottom: 20px; }
    .product-info .description { font-size: 15px; line-height: 1.6; color: #555; margin-bottom: 20px; }
    .quantity-selector { display: flex; align-items: center; margin-bottom: 25px; }
    .quantity-selector label { margin-right: 15px; font-weight: 500; }
    .quantity-selector button { width: 30px; height: 30px; border: 1px solid #e0e0e0; background-color: #f9f9f9; cursor: pointer; font-size: 18px; }
    .quantity-selector span.quantity { width: 40px; height: 30px; line-height: 30px; text-align: center; border-top: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0; }
    .action-buttons { display: flex; gap: 15px; }
    .action-button { padding: 12px 25px; border-radius: 5px; border: 1px solid #c7a17a; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
    .add-to-cart { background-color: #c7a17a; color: #fff; }
    .buy-now { background-color: #fff; color: #c7a17a; }
    .product-additional-info { margin-top: 40px; background-color: #fff; padding: 30px; border-radius: 8px; border: 1px solid #e0e0e0; }
    .tabs { display: flex; border-bottom: 1px solid #e0e0e0; margin-bottom: 20px; }
    .tab-button { padding: 10px 20px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 500; border-bottom: 3px solid transparent; margin-bottom: -1px; }
    .tab-button.active { border-bottom-color: #c7a17a; color: #c7a17a; }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
  </style>
</head>
<body>
  <header class="header"> </header>

  <main class="page-container">
    <?php if (isset($product)): ?>
    <nav class="breadcrumb">
      <a href="index.php">Home</a> &nbsp;&gt;&nbsp; 
      <a href="<?php echo htmlspecialchars(str_replace(' ', '', $product['category'])); ?>.php"><?php echo htmlspecialchars($product['category']); ?></a> &nbsp;&gt;&nbsp; 
      <span><?php echo htmlspecialchars($product['name']); ?></span>
    </nav>

    <section class="product-detail-container">
      <div class="product-images">
        <div class="main-image">
          <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Gambar Produk Utama">
        </div>
        </div>

      <div class="product-info">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
        <div class="description">
          <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        </div>
        
        <form action="cart_action.php?action=add" method="POST">
            <div class="quantity-selector">
              <label>Jumlah:</label>
              <button type="button" class="minus-btn" onclick="updateQuantity(-1)">-</button>
              <input type="text" name="quantity" class="quantity" value="1" readonly style="border: none; text-align: center; width: 30px; padding: 0;">
              <button type="button" class="plus-btn" onclick="updateQuantity(1)">+</button>
            </div>
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            
            <div class="action-buttons">
              <button type="submit" class="action-button add-to-cart">Tambah ke Keranjang</button>
              <button type="submit" formaction="checkout.php" class="action-button buy-now">Beli Sekarang</button>
            </div>
        </form>
      </div>
    </section>

    <section class="product-additional-info">
        <div class="tabs">
            <button class="tab-button active" onclick="showTab('detail')">Detail Produk</button>
            <button class="tab-button" onclick="showTab('ulasan')">Ulasan Pelanggan</button>
        </div>
        <div id="detail" class="tab-content active">
            <h4>Spesifikasi</h4>
            <ul>
                <li><strong>Kategori:</strong> <?php echo htmlspecialchars($product['category']); ?></li>
                <li><strong>Stok Tersedia:</strong> <?php echo htmlspecialchars($product['stock']); ?> item</li>
                </ul>
        </div>
        <div id="ulasan" class="tab-content">
        <h4>Tulis Ulasan Anda</h4>
        <?php if (isset($_SESSION['is_logged_in'])): ?>
            <form action="submit_review.php" method="POST" style="margin-bottom: 20px;">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <select name="rating" id="rating" required>
                        <option value="5">★★★★★ (Sempurna)</option>
                        <option value="4">★★★★☆ (Baik)</option>
                        <option value="3">★★★☆☆ (Cukup)</option>
                        <option value="2">★★☆☆☆ (Kurang)</option>
                        <option value="1">★☆☆☆☆ (Buruk)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Ulasan Anda:</label>
                    <textarea name="comment" id="comment" rows="1" required></textarea>
                </div>
                <button type="submit" class="action-button add-to-cart">Kirim Ulasan</button>
            </form>
        <?php else: ?>
            <p>Anda harus <a href="masuk.php">masuk</a> untuk menulis ulasan.</p>
        <?php endif; ?>

        <hr style="margin: 30px 0;">
        <h4>Ulasan yang Sudah Ada</h4>
        <?php
            // Ambil ulasan yang sudah ada untuk produk ini
            $review_stmt = $conn->prepare("SELECT * FROM reviews WHERE product_id = ? AND status = 'approved' ORDER BY review_date DESC");
            $review_stmt->bind_param("i", $product_id);
            $review_stmt->execute();
            $reviews = $review_stmt->get_result();

            if ($reviews->num_rows > 0) {
                while ($review = $reviews->fetch_assoc()) {
                    echo '<div class="review-card" style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">';
                    echo '<strong>' . htmlspecialchars($review['username']) . '</strong> - <span style="color: #f39c12;">' . str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) . '</span>';
                    echo '<p style="margin-top: 5px;">' . nl2br(htmlspecialchars($review['comment'])) . '</p>';
                    echo '</div>';
                }
            } else {
                echo "<p>Belum ada ulasan untuk produk ini.</p>";
            }
        ?>
    </div>
</section>

    <?php else: ?>
    <div style="text-align: center; padding: 50px;">
        <h2><?php echo $error_message ?? "Halaman tidak valid."; ?></h2>
        <p>Silakan kembali ke <a href="index.php">halaman utama</a>.</p>
    </div>
    <?php endif; ?>
    <?php if(isset($conn)) { $conn->close(); } ?>
  </main>

  <footer class="footer"> </footer>

  <script>
    function updateQuantity(amount) {
        const quantityInput = document.querySelector('.quantity');
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity + amount > 0) {
            quantityInput.value = currentQuantity + amount;
        }
    }

    function showTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        
        document.getElementById(tabId).classList.add('active');
        event.currentTarget.classList.add('active');
    }
  </script>
</body>
</html>