<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="logo"><a href="index.html">Logo</a></div>
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
    <div class="auth">
      <a href="daftar.php">Daftar</a> <a href="masuk.php">Masuk</a>
    </div>
  </header>


<main class="signup-container" >
<form class="signup-box" action="sign-in.php" method="POST">
  <h3>Daftar</h3>
  <p>Sudah punya akun? <a href="masuk.php">Masuk</a></p>

  <label for="nomor">No. Handphone</label>
  <input type="text" id="nomor" name="no_hp" placeholder="No. Handphone" />

  <label for="username">Username</label>
  <input type="text" id="username" name="username" placeholder="Masukkan Username" required />

  <label for="email">Email</label>
  <input type="email" id="email" name="email" placeholder="example@mail.com" required />

  <label for="password">Password</label>
  <input type="password" id="password" name="password" placeholder="Masukkan password" required />

  <label for="confirmPassword">Konfirmasi Password</label>
  <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Ulangi password" required />

  <button type="submit">Lanjut</button>
</form>
</main>
  <!-- Footer -->
  <footer class="footer">
    <p>cus. service, media sosial,<br />informasi toko</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>