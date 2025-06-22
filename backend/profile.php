<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengaturan Akun</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />

  <style>
    /* Menggunakan gaya yang sama dari checkout.html untuk konsistensi */
    .customer-account-container {
      display: flex;
      justify-content: center;
      padding: 40px 20px;
      background-color: #f4f4f4;
      font-family: 'Montserrat', sans-serif;
      gap: 20px;
      align-items: flex-start;
    }

    .account-sidebar {
      background-color: #fff;
      padding: 24px;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      width: 280px;
      flex-shrink: 0;
    }

    .account-sidebar h3 {
      font-size: 18px;
      margin-top: 0;
      margin-bottom: 20px;
    }

    .account-sidebar .sidebar-section {
      margin-bottom: 24px;
    }
    
    .account-sidebar .sidebar-section h4 {
        font-size: 16px;
        margin-bottom: 12px;
        color: #333;
    }

    .account-sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .account-sidebar .sidebar-section a {
        display: block;
        text-decoration: none;
        color: #555;
        font-size: 14px;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.2s;
    }

     .account-sidebar .sidebar-section a:hover {
        background-color: #f1f1f1;
        color: #000;
     }
     
     .account-sidebar .sidebar-section a.active {
        background-color: #c7a17a;
        color: #fff;
        font-weight: 500;
     }

    .account-content {
      background-color: #fff;
      padding: 24px;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      flex-grow: 1;
      max-width: 800px;
    }
    
    /* GAYA BARU UNTUK HALAMAN PROFIL */
    .account-content h1 {
        margin-top: 0;
        font-size: 24px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .profile-header img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #eee;
    }
    
    .profile-header .user-info h2 {
        margin: 0;
        font-size: 20px;
    }
    
    .profile-header .user-info p {
        margin: 5px 0 0 0;
        color: #777;
    }

    .form-section {
        margin-bottom: 40px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    
    .form-group input:focus {
        border-color: #c7a17a;
        outline: none;
    }
    
    .submit-btn {
        background-color: #c7a17a;
        color: #fff;
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.2s;
    }
    
    .submit-btn:hover {
        background-color: #b38f6b;
    }

  </style>
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

  <main class="customer-account-container">
    
    <aside class="account-sidebar">
      <h3>Kios Bagus</h3>
      <div class="sidebar-section">
        <h4>Transaksi</h4>
        <a href="checkout.php">Status Pesanan</a>
      </div>
      <div class="sidebar-section">
        <h4>Akun Saya</h4>
        <a href="profile.php" class="active">Pengaturan Akun</a>
      </div>
       <div class="sidebar-section">
        <a href="logout.php">Logout</a>
      </div>
    </aside>

    <section class="account-content">
      <h1>Pengaturan Akun</h1>
      
      <div class="profile-header">
        <img src="https://tr.rbxcdn.com/180DAY-80fe87c42012957cd6e2c9dd75de797d/420/420/Face/Webp/noFilter" alt="Foto Profil">
        <div class="user-info">
          <h2>Adhitya Nugraha</h2>
          <p>aditya.nugraha@example.com</p>
        </div>
      </div>
      
      <form>
        <div class="form-section">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" value="aditya.nugraha" readonly>
          </div>
          <div class="form-group">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" id="fullname" value="Adhitya Nugraha">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" value="aditya.nugraha@example.com">
          </div>
          <div class="form-group">
            <label for="phone">No. Handphone</label>
            <input type="text" id="phone" value="087771906230">
          </div>
          <button type="submit" class="submit-btn">Simpan Perubahan</button>
        </div>
      </form>

      <div class="form-section">
          <h2>Ubah Password</h2>
          <form>
             <div class="form-group">
                <label for="old_password">Password Lama</label>
                <input type="password" id="old_password">
             </div>
             <div class="form-group">
                <label for="new_password">Password Baru</label>
                <input type="password" id="new_password">
             </div>
             <div class="form-group">
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <input type="password" id="confirm_password">
             </div>
             <button type="submit" class="submit-btn">Ubah Password</button>
          </form>
      </div>

    </section>

  </main>

  <script src="script.js"></script>
</body>
</html>