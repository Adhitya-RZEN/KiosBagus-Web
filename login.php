<?php
session_start();

$conn = new mysqli("localhost", "root", "", "db_kios");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$loginInput = $_POST['email'] ?? ''; 
$password = $_POST['password'] ?? '';

if (empty($loginInput) || empty($password)) {
    echo "Data tidak lengkap. <a href='masuk.php'>Kembali</a>";
    exit;
}

$sql = "SELECT * FROM users WHERE email = ? OR no_hp = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $loginInput, $loginInput);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    }
}

echo "Login gagal. <a href='masuk.php'>Coba lagi</a>";

$stmt->close();
$conn->close();
?>
