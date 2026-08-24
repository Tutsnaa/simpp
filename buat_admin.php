<?php
require_once "app/config/Database.php";

// 1. Inisialisasi koneksi menggunakan method connect()
$database = new Database();
$db = $database->connect();

// 2. Hash kata sandi
$password_hash = password_hash('12345', PASSWORD_DEFAULT);

// 3. Query insert
$sql = "INSERT INTO pengguna (nama, email, no_telepon, alamat, nama_pengguna, kata_sandi, role, status) 
        VALUES ('Administrator', 'admin@gmail.com', '081234567890', 'Jl. Admin', 'admin', :kata_sandi, 'Admin', 'Aktif')";

try {
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':kata_sandi', $password_hash);
    
    if ($stmt->execute()) {
        echo "<h3 style='color:green;'>Akun Admin Berhasil Dibuat!</h3>";
        echo "Username: <b>admin</b><br>";
        echo "Password: <b>12345</b>";
    }
} catch (PDOException $e) {
    echo "<h3 style='color:red;'>Gagal: " . $e->getMessage() . "</h3>";
}
?>