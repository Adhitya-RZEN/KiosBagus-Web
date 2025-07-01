<?php
    session_start();
    include 'koneksi.php'; // Sambungkan ke database

    // Tentukan kategori untuk halaman ini
    $category = 'Fresh Frozen';

    // Ambil semua produk dari kategori yang telah ditentukan
    // Menggunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY created_at DESC");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result_products = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Kategori: <?php echo htmlspecialchars($category); ?> - Kios Bagus</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
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

    <main class="page-container">
    
  <nav class="breadcrumb">
    <a href="index.php">Home</a> &nbsp;&gt;&nbsp; <span><?php echo htmlspecialchars($category); ?></span>
  </nav>

  <div class="category-header">
    <h2 class="category-title"><?php echo htmlspecialchars($category); ?></h2>
    <div class="sort-options">
      </div>
  </div>

  <div class="product-grid">
    <?php
      // Loop untuk menampilkan produk dari kategori ini
      if ($result_products->num_rows > 0) {
          while($product = $result_products->fetch_assoc()) {
              echo '<div class="produk-card">';
              echo '  <a href="detailproduk.php?id=' . $product['id'] . '">'; // Link ke halaman detail
              echo '    <img class="img-box" src="' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '"/>';
              echo '  </a>';
              echo '  <div class="produk-info">';
              echo '    <p class="nama-produk">' . htmlspecialchars($product['name']) . '</p>';
              echo '    <p class="harga-produk">Rp ' . number_format($product['price'], 0, ',', '.') . '</p>';
              echo '    <button class="add-to-cart-btn">Beli</button>';
              echo '  </div>';
              echo '</div>';
          }
      } else {
          echo "<p>Belum ada produk untuk kategori " . htmlspecialchars($category) . ".</p>";
      }
      $stmt->close();
      $conn->close();
    ?>
  </div>
</main>
  
    <footer class="footer">
      </footer>
    <script src="script.js"></script>
  </body>
  </html>