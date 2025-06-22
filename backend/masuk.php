<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk - Kios Bagus</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <?php session_start(); ?>
  <header class="header">
    <div class="logo"><a href="index.php">Logo</a></div>
    <div class="dropdown">
        <button class="dropdown-toggle"><img src="Assets/Grid.svg"/><p>Menu</p></button>
        <div class="dropdown-menu">
          <a href="beranda.html">Promo</a>
          <a href="produk.html">Brand</a>
          <div class="submenu-container">
            <a href="#">Produk</a>
            <div class="submenu">
              <a href="produk.html">Produk 1</a>
              <a href="produk.html">Produk 2</a>
              <a href="produk.html">Produk 3</a>
              <a href="produk.html">Produk 4</a>
            </div>
          </div>
        </div>
      </div>
    <input type="text" placeholder="Search" class="search" />
    <button class="search-btn"><img src="Assets/search.png"/></button>
    <div class="cart"><img src="Assets/Shopping cart.png"/></div>
    <div class="auth" id="loginFalse">
      <a href="daftar.php">Daftar</a> <a href="masuk.php">Masuk</a>
    </div>
  </header>

   <main class="login-container">
    <div class="login-box">
      <h3>Masuk</h3>
      <p>Belum punya akun?<a href="daftar.php">Daftar</a></p>

      <?php
        // Menampilkan pesan error jika ada
        if (isset($_SESSION['login_error'])) {
            echo '<p style="color: red;">' . $_SESSION['login_error'] . '</p>';
            unset($_SESSION['login_error']); // Hapus pesan setelah ditampilkan
        }
      ?>

      <form action="login.php" method="POST">
        <input type="text" name="email" placeholder="Email/No. Handphone" required />
        <input type="password" name="password" placeholder="Password" required />
        <label>
          <input type="checkbox" name="remember" /> Ingat saya
        </label>
        <button type="submit">Masuk</button>
      </form>
    </div>
  </main>

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