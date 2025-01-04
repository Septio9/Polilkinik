<?php
session_start();
include('koneksi.php'); // Koneksi ke database

// Proses registrasi
if (isset($_POST['register_user'])) {
    $nama = $_POST['nama'];          // Nama pengguna
    $email = $_POST['email'];        // Email pengguna
    $password = $_POST['password'];  // Password pengguna
    $role = $_POST['role'];          // Role (Pasien, Dokter, atau Admin)

    // Cek jika email sudah ada di database
    $sql_check_email = "SELECT * FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check_email);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error_message_register = "Email sudah terdaftar, silakan gunakan email lain.";
    } else {
        // Melakukan password hashing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Query untuk menyimpan data pengguna ke database
        $sql = "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            $success_message = "Registrasi berhasil! Silakan login.";
        } else {
            $error_message_register = "Terjadi kesalahan: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <form method="POST" action="register.php">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Registrasi Pengguna</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success_message)) { echo "<div class='alert alert-success'>$success_message</div>"; } ?>
                        <?php if (isset($error_message_register)) { echo "<div class='alert alert-danger'>$error_message_register</div>"; } ?>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Mendaftar sebagai</label>
                            <select name="role" class="form-select" required>
                                <option value="pasien">Pasien</option>
                                <option value="dokter_klinik">Dokter Klinik</option>
                            </select>
                        </div>
                        <button type="submit" name="register_user" class="btn btn-primary w-100">Registrasi</button>
                    </div>
                </div>
            </form>
            <div class="mt-3 text-center">
                <a href="login.php">Sudah punya akun? Login di sini</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>