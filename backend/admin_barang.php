<?php
    session_start();
    include 'koneksi.php';

    // TODO: Tambahkan pengecekan sesi khusus untuk admin

    // Ambil semua produk dari database
    $products_result = $conn->query("SELECT * FROM products ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Produk</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-color: #f4f5f7;
      --card-bg-color: #ffffff;
      --text-color: #333333;
      --accent-color: #efb1b1;
      --accent-color-dark: #e89a9a;
      --border-color: #e0e0e0;
    }
    body { font-family: 'Montserrat', sans-serif; background-color: var(--bg-color); margin: 0; }
    .admin-header { background-color: var(--card-bg-color); padding: 0 30px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; height: 65px; }
    .admin-header .logo { font-size: 20px; font-weight: 700; }
    .admin-header nav a { text-decoration: none; color: var(--text-color); font-weight: 500; padding: 22px 15px; }
    .main-container { padding: 30px; }
    .content-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .content-header h1 { margin: 0; }
    .btn-add { padding: 10px 20px; border: none; border-radius: 8px; background-color: var(--accent-color); color: var(--text-color); font-weight: 600; cursor: pointer; }
    .product-table-container { background-color: #fff; padding: 25px; border-radius: 16px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
    .product-cell { display: flex; align-items: center; gap: 15px; }
    .product-cell img { width: 40px; height: 40px; border-radius: 5px; object-fit: cover; }
    .btn-edit { padding: 8px 15px; border: 1px solid var(--border-color); background: none; border-radius: 8px; cursor: pointer; }
    .modal-overlay { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
    .modal-content { background-color: #fff; padding: 30px; border-radius: 16px; width: 100%; max-width: 500px; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; }
    .modal-header h2 { margin: 0; }
    .close-button { font-size: 24px; cursor: pointer; border: none; background: none; }
    .form-group { margin: 15px 0; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
    .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid var(--border-color); box-sizing: border-box; }
    .form-group textarea { height: 100px; resize: vertical; }
  </style>
</head>
<body>

<header class="admin-header">
    <div class="logo">Admin Panel</div>
    <nav>
      <a href="admin_dashboard.php">Dashboard</a>
      <a href="admin_barang.php" class="active">Manajemen Produk</a>
      <a href="admin_pesanan.php">Manajemen Pesanan</a>
      <a href="admin_ulasan.html">Ulasan</a>
      <a href="#">Logout</a>
    </nav>
  </header>

  <main class="main-container">
    <div class="content-header">
      <h1>Manajemen Produk</h1>
      <button class="btn-add" onclick="openAddModal()">Tambah Produk Baru</button>
    </div>
    <div class="product-table-container">
      <table>
        <thead>
          <tr><th>Produk</th><th>Stok</th><th>Harga</th><th>Kategori</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php if ($products_result->num_rows > 0): ?>
            <?php while($product = $products_result->fetch_assoc()): ?>
              <tr>
<td>
    <button class="btn-edit"
        onclick="openEditModal(this)"
        data-id="<?php echo $product['id']; ?>"
        data-name="<?php echo htmlspecialchars($product['name']); ?>"
        data-description="<?php echo htmlspecialchars($product['description']); ?>"
        data-price="<?php echo $product['price']; ?>"
        data-stock="<?php echo $product['stock']; ?>"
        data-category="<?php echo htmlspecialchars($product['category']); ?>">
        Edit
    </button>
</td>
                <td>
                  <div class="product-cell">
                    <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <span><?php echo htmlspecialchars($product['name']); ?></span>
                  </div>
                </td>
                <td><?php echo $product['stock']; ?></td>
                <td>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($product['category']); ?></td>
                <td><button class="btn-edit">Edit</button></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5" style="text-align: center;">Belum ada produk.</td></tr>
          <?php endif; $conn->close(); ?>
        </tbody>
      </table>
    </div>
  </main>
  
  <div id="productModal" class="modal-overlay">
    <div class="modal-content">
      <form id="productForm" action="admin_product_action.php" method="POST">
        <div class="modal-header">
          <h2 id="modalTitle">Tambah Produk Baru</h2>
          <span class="close-button" onclick="closeModal()">&times;</span>
        </div>
        <input type="hidden" name="action" id="formAction" value="add">
        <input type="hidden" name="product_id" id="productId" value="">
        
        <div class="form-group"><label for="productName">Nama Produk</label><input type="text" name="name" id="productName" required></div>
        <div class="form-group"><label for="productStock">Stok</label><input type="number" name="stock" id="productStock" required></div>
        <div class="form-group"><label for="productPrice">Harga</label><input type="number" name="price" id="productPrice" required></div>
        <div class="form-group"><label for="productCategory">Kategori</label>
            <select name="category" id="productCategory" required>
                <option value="Minuman">Minuman</option>
                <option value="Kebutuhan Dapur">Kebutuhan Dapur</option>
                <option value="Personal Care">Personal Care</option>
                <option value="Kebutuhan Rumah">Kebutuhan Rumah</option>
                <option value="Kebutuhan Ibu & Anak">Kebutuhan Ibu & Anak</option>
            </select>
        </div>
        <div class="form-group"><label for="productDescription">Deskripsi</label><textarea name="description" id="productDescription"></textarea></div>
        <button type="submit" class="btn-add" id="modalSubmitButton">Simpan Produk</button>
      </form>
    </div>
  </div>

  <script>
    const modal = document.getElementById('productModal');
    const modalTitle = document.getElementById('modalTitle');
    const productForm = document.getElementById('productForm');
    const formAction = document.getElementById('formAction');
    const productId = document.getElementById('productId');
    const modalSubmitButton = document.getElementById('modalSubmitButton');

    function closeModal() {
        modal.style.display = 'none';
    }

    // Fungsi untuk membuka modal dalam mode 'Tambah'
    function openAddModal() {
        productForm.reset();
        modalTitle.textContent = 'Tambah Produk Baru';
        modalSubmitButton.textContent = 'Simpan Produk';
        formAction.value = 'add';
        productId.value = '';
        modal.style.display = 'flex';
    }

    // Fungsi BARU untuk membuka modal dalam mode 'Edit'
    function openEditModal(button) {
        // Ambil data dari atribut data-* tombol yang diklik
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const description = button.getAttribute('data-description');
        const price = button.getAttribute('data-price');
        const stock = button.getAttribute('data-stock');
        const category = button.getAttribute('data-category');

        // Isi formulir modal dengan data tersebut
        document.getElementById('productName').value = name;
        document.getElementById('productDescription').value = description;
        document.getElementById('productPrice').value = price;
        document.getElementById('productStock').value = stock;
        document.getElementById('productCategory').value = category;
        
        // Atur modal untuk mode 'Edit'
        modalTitle.textContent = 'Edit Produk';
        modalSubmitButton.textContent = 'Simpan Perubahan';
        formAction.value = 'edit';
        productId.value = id;
        modal.style.display = 'flex';
    }
</script>
</body>
</html>