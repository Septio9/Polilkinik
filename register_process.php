<?php
include 'db.bk';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $role = $_POST['role'];

    // Menyimpan pengguna baru ke database
    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    
    if ($conn->query($query) === TRUE) {
        echo "Pengguna berhasil didaftarkan.";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>