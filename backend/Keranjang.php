<?php
    session_start();
    include 'koneksi.php';

    $cart_items = array();
    $subtotal = 0;
    
    // Cek jika keranjang ada dan tidak kosong
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Ambil semua product ID dari keranjang
        $product_ids = array_keys($_SESSION['cart']);
        
        // Buat placeholder untuk query IN (...)
        $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
        
        // Ambil detail produk dari database untuk semua item di keranjang
        $stmt = $conn->prepare("SELECT id, name, price, image_url FROM products WHERE id IN ($placeholders)");
        // Bind product IDs ke statement
        $stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);
        $stmt->execute();
        $result = $stmt->get_result();

        $products_data = array();
        while ($row = $result->fetch_assoc()) {
            $products_data[$row['id']] = $row;
        }

        // Siapkan data untuk ditampilkan dan hitung subtotal
        foreach ($_SESSION['cart'] as $id => $item) {
            if (isset($products_data[$id])) {
                $product = $products_data[$id];
                $quantity = $item['quantity'];
                $item_total = $product['price'] * $quantity;
                $subtotal += $item_total;

                $cart_items[] = [
                    'id' => $id,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image_url' => $product['image_url'],
                    'quantity' => $quantity,
                    'total' => $item_total
                ];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Keranjang Belanja - Kios Bagus</title>
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

<main class="keranjang-container">
    <div class="keranjang-items">
      <h2>Keranjang</h2>

      <?php
        if (isset($_SESSION['cart_error'])) {
            echo '<p class="cart-error">' . htmlspecialchars($_SESSION['cart_error']) . '</p>';
            unset($_SESSION['cart_error']); // Hapus pesan setelah ditampilkan
        }
      ?>
      
      <?php if (!empty($cart_items)): ?>
        <?php foreach ($cart_items as $item): ?>
        <div class="cart-item">
          <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 80px; height: 80px; margin-right: 20px; border-radius: 5px;">
          <div class="item-details">
            <p class="nama-produk"><?php echo htmlspecialchars($item['name']); ?></p>
            <p>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></p>
            <a href="cart_action.php?action=remove&id=<?php echo $item['id']; ?>" style="color: red; font-size: 12px;">Hapus</a>
          </div>
          
          <div class="quantity-selector">
            <a href="cart_action.php?action=update&id=<?php echo $item['id']; ?>&quantity=<?php echo $item['quantity'] - 1; ?>" class="quantity-btn">-</a>
            <span class="quantity" style="padding: 0 10px;"><?php echo $item['quantity']; ?></span>
            
            <a href="cart_action.php?action=update&id=<?php echo $item['id']; ?>&quantity=<?php echo $item['quantity'] + 1; ?>" class="quantity-btn">+</a>
          </div>

          <p class="total-beli">Rp <?php echo number_format($item['total'], 0, ',', '.'); ?></p>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Keranjang belanja Anda kosong. <a href="index.php">Mulai belanja</a>.</p>
      <?php endif; ?>
    </div>

    <aside class="ringkasan-pesanan">
      <h3>Ringkasan Pesanan</h3>
      <div class="summary-item">
        <span class="label">Subtotal</span>
        <span class="value">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
      </div>
      <div class="summary-item">
        <span class="label">Ongkos Kirim</span>
        <span class="value">Rp 0</span> </div>
      <div class="summary-total">
        <span>Total Belanja</span>
        <span>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
      </div>
      <?php if (!empty($cart_items)): ?>
        <button class="checkout-btn" onclick="window.location.href='checkout.php'">Checkout</button>
      <?php else: ?>
        <button class="checkout-btn" disabled>Checkout</button>
      <?php endif; ?>
    </aside>
  </main>

  <footer class="footer">
    </footer>
  <script src="script.js"></script>
</body>
</html>