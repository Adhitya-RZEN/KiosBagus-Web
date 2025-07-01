<?php
    session_start();
    include 'koneksi.php'; // Sambungkan ke database

    // Ambil 5 produk terbaru untuk bagian "Rekomendasi"
    $result_rekomendasi = $conn->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 8");
    $result_semua_produk = $conn->query("SELECT * FROM products ORDER BY created_at");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda - Kios Bagus</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<header class="header">
<div class="logo"><a href="index.php">Logo</a></div>
    <div class="dropdown">
      <button class="dropdown-toggle"><img src="Assets/Grid.svg"/><p>Menu</p></button>
      <div class="dropdown-menu">
        <a href="detailpesanan.html">Pesanan</a>
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

<div class="carousel">
  <button class="carousel-btn prev">&#10094;</button>
  <div class="carousel-wrapper">
    <div class="carousel-duo">
      <div class="carousel-item">PROMO 1</div>
      <div class="carousel-item">PROMO 2</div>
      <div class="carousel-item">PROMO 3</div>
      <div class="carousel-item">PROMO 4</div>
      <div class="carousel-item">PROMO 5</div>
      <div class="carousel-item">PROMO 6</div>
    </div>
  </div>
  <button class="carousel-btn next">&#10095;</button>
  <div class="carousel-dots">
    <span class="dot"></span>
    <span class="dot active"></span>
    <span class="dot"></span>
  </div>
</div>


  <div class="categories-wrapper">
    <div class="categories">
      <button onclick="window.location.href='kebutuhanrumah.php'">Kebutuhan Rumah</button>
      <button onclick="window.location.href='Makanan.php'">Makanan</button>
      <button onclick="window.location.href='Minuman.php'">Minuman</button>
      <button onclick="window.location.href='FreshFrozen.php'">Produk Fresh dan Frozen</button>
      <button onclick="window.location.href='Kesehatan.php'">Kesehatan</button>
      <button onclick="window.location.href='PersonalCaare.php'">Personal Care</button>
      <button onclick="window.location.href='IbuAnak.php'">Kebutuhan Ibu & Anak</button>
      <button onclick="window.location.href='Lifestyle.php'">Lifestyle</button>
      <button onclick="window.location.href='Dapur.php'">Kebutuhan Dapur</button>
    </div>
</div>

  <div class="promo-banner">
    <h2>PROMO JUMAT</h2>
  </div>

  <section class="produk-section">
    <h3>Rekomendasi</h3>
    <div class="produk-list">
      <?php
        if ($result_rekomendasi->num_rows > 0) {
            while($product = $result_rekomendasi->fetch_assoc()) {
                echo '<a href="detailproduk.php?id=' . $product['id'] . '" class="produk-card-link">'; 
                echo '  <div class="produk-card">';
                echo '    <img class="img-box" src="' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '"/>';
                echo '    <div class="produk-info">';
                echo '      <p class="nama-produk">' . htmlspecialchars($product['name']) . '</p>';
                echo '      <p class="harga-produk">Rp ' . number_format($product['price'], 0, ',', '.') . '</p>';
                echo '      <button class="add-to-cart-btn">Beli</button>';
                echo '    </div>';
                echo '  </div>';
                echo '</a>';
            }
        } else {
            echo "<p>Belum ada produk untuk ditampilkan.</p>";
        }
      ?>
    </div>
</section>

<section class="produk-section" style="margin-top: 50px; border-top: 2px solid #f0f0f0; padding-top: 20px;">
    <h3>Semua Produk</h3>
    <div class="produk-list">
      <?php
        // Loop untuk menampilkan SEMUA produk
        if ($result_semua_produk->num_rows > 0) {
            while($product = $result_semua_produk->fetch_assoc()) {
                // Menggunakan format yang sama persis dengan kartu produk rekomendasi
                echo '<a href="detailproduk.php?id=' . $product['id'] . '" class="produk-card-link">'; 
                echo '  <div class="produk-card">';
                echo '    <img class="img-box" src="' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '"/>';
                echo '    <div class="produk-info">';
                echo '      <p class="nama-produk">' . htmlspecialchars($product['name']) . '</p>';
                echo '      <p class="harga-produk">Rp ' . number_format($product['price'], 0, ',', '.') . '</p>';
                echo '      <button class="add-to-cart-btn">Beli</button>';
                echo '    </div>';
                echo '  </div>';
                echo '</a>';
            }
        } else {
            echo "<p>Belum ada produk untuk ditampilkan.</p>";
        }
      ?>
    </div>
</section>

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