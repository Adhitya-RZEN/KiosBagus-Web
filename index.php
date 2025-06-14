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
    <div class="logo">logo</div>
    <div class="dropdown">
      <button class="dropdown-toggle"><img src="Assets/Grid.svg"/><p>Menu</p></button>
      <div class="dropdown-menu">
        <a href="beranda.html">Promo</a>
        <a href="produk.html">Brand</a>

        </div>
      </div>
    </div>
    <input type="text" placeholder="Search" class="search" />
    <button class="search-btn"><img src="Assets/search.png"/></button>
    <div class="cart"><img src="Assets/Shopping cart.png"/></div>
    <div class="auth" id="loginFalse">
      <a href="daftar.html">Daftar</a> <a href="masuk.html">Masuk</a>
    </div>
    <div class="auth" display="none" id="loginTrue">
    <img src="#" alt="Profile" class="profile-pic" id="profilePic" />
    
    <div class="dropdown" id="userDropdown">
      <div class="header">Nama User</div>
      <hr />
      <div class="content">
        <div class="left">Point User</div>
        <div class="right">
          <div>HIstory</div>
          <div>Akun</div>
        </div>
      </div>
      <button class="logout-btn">LogOut</button>
    </div>
  </div>
  </header>

  <!-- Carousel -->
<div class="carousel">
  <button class="carousel-btn prev">&#10094;</button> <!-- panah kiri -->

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

  <button class="carousel-btn next">&#10095;</button> <!-- panah kanan -->

  <!-- Carousel Dots -->
  <div class="carousel-dots">
    <span class="dot"></span>
    <span class="dot active"></span>
    <span class="dot"></span>
  </div>
</div>


  <!-- Kategori -->
<div class="categories-wrapper">
    <div class="categories">
      <button>Kebutuhan Rumah</button>
      <button>Makanan</button>
      <button>Minuman</button>
      <button>Produk Fresh dan Frozen</button>
      <button>Kesehatan</button>
      <button>Personal Care</button>
      <button>Kebutuhan Ibu & Anak</button>
      <button>Lifestyle</button>
      <button>Kebutuhan Dapur</button>
    </div>
</div>

  <!-- Banner Promo -->
  <div class="promo-banner">
    <h2>PROMO JUMAT</h2>
  </div>

  <!-- Rekomendasi -->
  <section class="produk-section">
    <h3>Rekomendasi</h3>
    <div class="produk-list">
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
    </div>
    <div class="produk-list">
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
    </div>
  </section>

  <!-- Terbaru -->
  <section class="produk-section">
    <h3>Terbaru</h3>
    <div class="produk-list">
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
    </div>
    <div class="produk-list">
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
      <div class="produk-card"><img class="img-box" src="Assets/download.jpeg" alt="Gambar Protein"/><div class="item-box"></div><p>Nama Produk</p><p>Harga P</p></div>
    </div>
    <div class="load-more">Selengkapnya ⌄</div>
  </section>

  <!-- Section: Tata Cara -->
  <section class="tata-cara">
    <p>tata cara berbelanja</p>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>cus. service, media sosial,<br />informasi toko</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>
