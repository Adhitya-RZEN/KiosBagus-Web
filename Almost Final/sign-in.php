<?php
session_start();
include 'koneksi.php'; // Menggunakan file koneksi

// Mengambil data dari form
$nomor = $_POST['no_hp'] ?? ''; 
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// Validasi sederhana
if (empty($nomor) || empty($username) || empty($email) || empty($password)) {
    $_SESSION['register_message'] = "Semua kolom wajib diisi.";
    $_SESSION['register_error'] = true;
    header("Location: daftar.php");
    exit;
}

if ($password !== $confirmPassword) {
    $_SESSION['register_message'] = "Password dan Konfirmasi Password tidak cocok.";
    $_SESSION['register_error'] = true;
    header("Location: daftar.php");
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Siapkan statement untuk insert
$sql = "INSERT INTO users (username, email, no_hp, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $nomor, $hashedPassword);

if ($stmt->execute()) {
    $_SESSION['register_message'] = "Registrasi berhasil! Silakan masuk.";
    header("Location: masuk.php");
} else {
    // Cek jika error karena duplikat email atau username
    if ($conn->errno == 1062) {
         $_SESSION['register_message'] = "Email atau Username sudah terdaftar.";
    } else {
         $_SESSION['register_message'] = "Registrasi gagal, silakan coba lagi.";
    }
    $_SESSION['register_error'] = true;
    header("Location: daftar.php");
}

$stmt->close();
$conn->close();
exit;
?>