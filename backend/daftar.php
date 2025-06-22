<!DOCTYPE html>
<html lang="id">
<head>
  <title>Daftar - Kios Bagus</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <?php session_start(); ?>
  <header class="header">
    </header>

<main class="signup-container">
  <form class="signup-box" action="sign-in.php" method="POST">
    <h3>Daftar</h3>
    <p>Sudah punya akun? <a href="masuk.php">Masuk</a></p>

    <?php
        // Menampilkan pesan error atau sukses
        if (isset($_SESSION['register_message'])) {
            $color = isset($_SESSION['register_error']) ? 'red' : 'green';
            echo '<p style="color: ' . $color . ';">' . $_SESSION['register_message'] . '</p>';
            unset($_SESSION['register_message']);
            unset($_SESSION['register_error']);
        }
    ?>

    <label for="nomor">No. Handphone</label>
    <input type="text" id="nomor" name="no_hp" placeholder="No. Handphone" required />

    <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="Masukkan Username" required />

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="example@mail.com" required />

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Masukkan password" required />

    <label for="confirmPassword">Konfirmasi Password</label>
    <input type="password"id="confirmPassword" name="confirmPassword" placeholder="Ulangi password" required />

    <button type="submit">Daftar</button>
  </form>
</main>
  <footer class="footer">
    </footer>
</body>
</html>