<?php
session_start();
include 'koneksi.php';

$loginInput = $_POST['email'] ?? ''; 
$password = $_POST['password'] ?? '';

if (empty($loginInput) || empty($password)) {
    $_SESSION['login_error'] = "Email/No. HP dan Password tidak boleh kosong.";
    header("Location: masuk.php");
    exit;
}

// Ambil data user, termasuk kolom 'role' yang baru
$sql = "SELECT id, username, email, no_hp, password, role FROM users WHERE email = ? OR no_hp = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("ss", $loginInput, $loginInput);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Login berhasil, simpan data user di session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Simpan peran di session
        $_SESSION['is_logged_in'] = true;
        
        unset($_SESSION['login_error']);

        // --- PENGALIHAN BERBASIS PERAN ---
        switch ($user['role']) {
            case 'admin':
                header("Location: admin_dashboard.php");
                break;
            case 'kurir':
                header("Location: kurir_dashboard.php");
                break;
            default: // Untuk 'pelanggan' dan peran lainnya
                header("Location: index.php");
                break;
        }
        exit; // Pastikan script berhenti setelah redirect
    }
}

// Jika login gagal
$_SESSION['login_error'] = "Email/Password yang Anda masukkan salah.";
header("Location: masuk.php");

$stmt->close();
$conn->close();
?>