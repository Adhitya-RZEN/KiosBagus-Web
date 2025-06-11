<?php
$conn = new mysqli("localhost", "root", "", "db_kios");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$nomor = $_POST['no_hp']; 
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if ($password !== $confirmPassword) {
    echo "Password tidak cocok. <a href='daftar.php'>Coba lagi</a>";
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (no_hp, username, email, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nomor, $username, $email, $hashedPassword);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Registrasi berhasil. <a href='masuk.php'>Login di sini</a>";
} else {
    echo "Registrasi gagal. <a href='daftar.php'>Coba lagi</a>";
}

$stmt->close();
$conn->close();
?>
