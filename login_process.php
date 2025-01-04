<?php
session_start();
include 'db.bk';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengambil data pengguna dari database
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Memverifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role']; // role: admin, dokter, pasien

            // Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: admin.html");
            } elseif ($user['role'] == 'dokter') {
                header("Location: dokter.html");
            } elseif ($user['role'] == 'pasien') {
                header("Location: pasien.html");
            }
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Username tidak ditemukan.";
    }
}
?>