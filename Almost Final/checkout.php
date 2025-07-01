<?php
    session_start();
    include 'koneksi.php';

    // 1. Pastikan pengguna sudah login
    if (!isset($_SESSION['is_logged_in'])) {
        header('Location: masuk.php');
        exit;
    }

    // 2. Pastikan keranjang tidak kosong
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        header('Location: Keranjang.php');
        exit;
    }

    // 3. Ambil data user
    $user_id = $_SESSION['user_id'];
    $user_stmt = $conn->prepare("SELECT username, no_hp FROM users WHERE id = ?");
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user = $user_stmt->get_result()->fetch_assoc();

    // 4. Ambil data produk & siapkan variabel
    $product_ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
    $stmt->execute();
    $products_result = $stmt->get_result();
    
    $products_data = [];
    while ($row = $products_result->fetch_assoc()) {
        $products_data[$row['id']] = $row;
    }

    $total_belanja = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <title>Pesanan - Kios Bagus</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<header class="header">
    <div class="logo"><a href="index.php">Logo</a></div>
    <div class="dropdown">
      <button class="dropdown-toggle"><img src="Assets/Grid.svg"/><p>Menu</p></button>
      <div class="dropdown-menu">
        <a href="beranda.html">Promo</a>
        <a href="produk.html">Brand</a>
      </div>
    </div>
    <input type="text" placeholder="Search" class="search" />
    <button class="search-btn"><img src="Assets/search.png"/></button>
    
    <a href="Keranjang.php" class="cart cart-link">
        <img src="Assets/Shopping cart.png" alt="Keranjang Belanja"/>
    </a>
    
    <?php if (isset($_SESSION['is_logged_in'])): ?>
        <div class="auth" id="loginTrue">
            <img src="https://via.placeholder.com/40" alt="Profile" class="profile-pic" />
            <div class="dropdown" id="userDropdown">
              <div class="header"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
              <hr />
              <a href="profile.php">Akun Saya</a>
              <a href="logout.php" class="logout-btn">LogOut</a>
            </div>
        </div>
    <?php else: ?>
        <div class="auth" id="loginFalse">
          <a href="daftar.php">Daftar</a> <a href="masuk.php">Masuk</a>
        </div>
    <?php endif; ?>
</header>
  
  <main class="checkout-page-container">
    <form action="place_order.php" method="POST" style="display: contents;">
      
      <section class="order-details">
        <h1>Pesanan</h1>

        <div class="checkout-box">
          <h2>Detail Penerima</h2>
          <p>
            <b>Rumah</b><br> <?php echo htmlspecialchars($user['username']); ?> - <?php echo htmlspecialchars($user['no_hp']); ?><br>
            <textarea name="shipping_address" required placeholder="[Catatan: Jl.TGH Lopan] Rembiga, Kec. Selaparang, Kota Mataram, Nusa Tenggara Barat, Indonesia" style="width: 100%; height: 80px; margin-top: 10px;"></textarea>
          </p>
        </div>

        <div class="checkout-box">
          <div style="display: flex; justify-content: space-between; align-items: start;">
              <h2>Pengiriman</h2>
              <p class="id-info">ID Pesanan: <b><?php echo strtoupper(uniqid('WEKS-')); ?></b></p>
          </div>
          <div class="detail-item">
              <span class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-event" viewBox="0 0 16 16"><path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>
              </span>
              <p>Rabu, 11 Juni 2025</p>
          </div>
          <div class="detail-item">
              <span class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/></svg>
              </span>
              <p>Estimasi pengiriman setelah pembayaran paling telat 1 jam</p>
          </div>
        </div>

        <div class="checkout-box">
          <div style="display: flex; justify-content: space-between; align-items: start;">
            <h2>Produk</h2>
            <p class="id-info">ID Pengiriman: <b><?php echo strtoupper(uniqid('AWD-')); ?></b></p>
          </div>
          <?php foreach($_SESSION['cart'] as $id => $item): 
              $product = $products_data[$id];
              $item_total = $product['price'] * $item['quantity'];
              $total_belanja += $item_total;
          ?>
            <div class="product-item" style="margin-bottom: 15px;">
              <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="product-image-placeholder" style="object-fit: cover;">
              <div class="product-info">
                <p class="product-name"><?php echo htmlspecialchars($product['name']); ?></p>
                <p class="product-quantity">Jumlah Beli: <?php echo $item['quantity']; ?></p>
              </div>
              <p class="product-price">Rp <?php echo number_format($item_total, 0,',','.'); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <aside class="order-summary">
        <div class="checkout-box">
          <h2>Ringkasan Pesanan</h2>
          <div class="summary-row">
            <span class="label">Sub-total</span>
            <span class="value">Rp. <?php echo number_format($total_belanja, 0, ',', '.'); ?></span>
          </div>
          <div class="summary-row">
            <span class="label">Diskon</span>
            <span class="value">Rp. 0</span>
          </div>
          <div class="summary-row">
            <span class="label">Ongkos Kirim</span>
            <span class="value">Rp. 0</span>
          </div>
          <hr>
          <div class="summary-total">
            <span>Total Belanja</span>
            <span>Rp. <?php echo number_format($total_belanja, 0, ',', '.'); ?></span>
          </div>
          
          <div style="margin-top: 20px;">
              <label for="payment_method" style="font-weight: 500; font-size: 14px; display: block; margin-bottom: 8px;">Metode Pembayaran</label>
              <select name="payment_method" id="payment_method" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                  <option value="COD">COD (Cash on Delivery)</option>
                  <option value="Transfer Bank">Transfer Bank</option>
                  <option value="E-Wallet">E-Wallet</option>
              </select>
          </div>
          <button type="submit" class="payment-btn" style="margin-top: 20px;">Beli</button>
        </div>
      </aside>

    </form>
  </main>

    </form>
  </main>
  
  <section class="tata-cara">
    <h2>Cara Mudah Berbelanja</h2>
    <div class="langkah-pembelian">
        <div class="langkah">
            <div class="nomor">1</div>
            <h3>Cari Produk</h3>
            <p>Jelajahi kategori atau gunakan fitur pencarian untuk menemukan produk yang Anda inginkan.</p>
        </div>
        <div class="langkah">
            <div class="nomor">2</div>
            <h3>Tambah ke Keranjang</h3>
            <p>Klik tombol "Beli" atau "Tambah ke Keranjang" pada produk yang ingin Anda beli.</p>
        </div>
        <div class="langkah">
            <div class="nomor">3</div>
            <h3>Checkout</h3>
            <p>Pergi ke halaman keranjang, periksa kembali pesanan Anda, lalu lanjutkan ke proses checkout.</p>
        </div>
        <div class="langkah">
            <div class="nomor">4</div>
            <h3>Pembayaran</h3>
            <p>Isi detail pengiriman dan pilih metode pembayaran yang paling nyaman untuk Anda.</p>
        </div>
    </div>
  </section>

  <footer class="footer">
    <div class="footer-container">
        <div class="footer-column">
            <h4>Layanan Pelanggan</h4>
            <ul>
                <li><a href="#">Pusat Bantuan</a></li>
                <li><a href="#">Cara Berbelanja</a></li>
                <li><a href="#">Pengembalian Barang</a></li>
                <li><a href="#">Hubungi Kami</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Informasi Toko</h4>
            <ul>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Lokasi Toko</a></li>
                <li><a href="#">Karir</a></li>
                <li><a href="#">Syarat & Ketentuan</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Media Sosial</h4>
            <div class="social-media">
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram"></a>
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook"></a>
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Logo_of_Twitter.svg" alt="Twitter"></a>
            </div>
        </div>
    </div>
    <div class="copyright">
        &copy; 2025 Kios Bagus. Semua Hak Dilindungi.
    </div>
  </footer>
  <script src="script.js"></script>
</body>
</html>