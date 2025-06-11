<?php
session_start();
$conn = new mysqli("localhost", "root", "", "burger_resto");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$inputs = array_values($_POST);
if (count($inputs) < 2) {
    echo "Data tidak lengkap. <a href='masuk.html'>Kembali</a>";
    exit;
}

$loginInput = $inputs[0]; 
$password = $inputs[1];

$sql = "SELECT * FROM users WHERE email=? OR no_hp=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $loginInput, $loginInput);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: home.php");
        exit;
    }
}

echo "Login gagal. <a href='masuk.html'>Coba lagi</a>";
?>
