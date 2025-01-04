<?php
session_start();
include('koneksi.php'); // Koneksi ke database

// Proses login untuk semua pengguna
if (isset($_POST['login_user'])) {
    $email = $_POST['email_user'];        // Email yang dimasukkan
    $password = $_POST['password_user'];  // Password yang dimasukkan
    $role = $_POST['role_user'];          // Role yang dipilih

    if (empty($email) || empty($password) || empty($role)) {
        $error_message_login = "Semua field harus diisi!";
    } else {
        $sql = "SELECT * FROM users WHERE email = ? AND role = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nama'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect user based on role
                if ($user['role'] === 'pasien') {
                    header('Location: user.php'); // Redirect to user dashboard
                } else if ($user['role'] === 'dokter_klinik' || $user['role'] === 'admin') {
                    header('Location: index.php'); // Redirect to admin/dashboard
                }
                exit();  
            } else {
                $error_message_login = "Password salah!";
            }
        } else {
            $error_message_login = "Pengguna tidak ditemukan!";
        }
    }
}

// The rest of your code for doctor/admin login can remain unchanged
if (isset($_POST['login_dokter_admin'])) {
    $email = $_POST['email_dokter_admin'];  // Email yang dimasukkan dokter/admin
    $password = $_POST['password_dokter_admin'];  // Password yang dimasukkan dokter/admin
    $role = $_POST['role_dokter_admin'];  // Role yang dipilih (dokter/admin)

    if (empty($email) || empty($password) || empty($role)) {
        $error_message_dokter_admin = "Semua field harus diisi!";
    } else {
        $sql = "SELECT * FROM users WHERE email = ? AND role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nama'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect user to index.php after login
                header('Location: index.php');
                exit();  
            } else {
                $error_message_dokter_admin = "Password salah!";
            }
        } else {
            $error_message_dokter_admin = "Pengguna tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <form method="POST" action="login.php">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message_login)) { echo "<div class='alert alert-danger'>$error_message_login</div>"; } ?>
                        <div class="mb-3">
                            <label for="email_user" class="form-label">Email</label>
                            <input type="email" name="email_user" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_user" class="form-label">Password</label>
                            <input type="password" name="password_user" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_user" class="form-label">Login sebagai</label>
                            <select name="role_user" class="form-select" required>
                                <option value="pasien">Pasien</option>
                                <option value="dokter_klinik">Dokter Klinik</option>
                            </select> 
                        </div>
                        <button type="submit" name="login_user" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </form>
            <div class="mt-3 text-center">
                <a href="register.php">Registrasi disini</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>