<?php
$conn = new mysqli("localhost", "root", "", "burger_resto");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if ($password !== $confirmPassword) {
    echo "Password tidak cocok. <a href='daftar.html'>Coba lagi</a>";
    exit;
}
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $hashedPassword);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Registrasi sucessful. <a href='masuk.html'>Login di sini</a>";
} else {
    echo "Registrasi fail. <a href='daftar.html'>Coba lagi</a>";
}

$stmt->close();
$conn->close();
?>
