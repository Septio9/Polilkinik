<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .hero {
            padding: 100px 0;
            text-align: center;
            position: relative;
        }
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .hero p {
            font-size: 1.5rem;
        }
        .service-icon {
            font-size: 50px;
            color: #007bff;
        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-primary"> <!-- Changed bg-light to bg-primary -->
    <div class="container">
        <a class="navbar-brand text-white" href="#">Poliklinik Sehat</a> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="jadwal.php">Jadwal Periksa</a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="login.php">Logout</a> 
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Selamat Datang di Poliklinik Sehat</h1>
        <p>Kesehatan Anda adalah Prioritas Kami</p>
    </div>
</div>

<!-- Services Section -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Layanan Kami</h2>
    <div class="row justify-content-center"> <!-- Added row and justify-content-center -->
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="service-icon text-center"> <!-- Center the icon -->
                        <i class="fas fa-user-md fa-2x"></i> <!-- Added size for better visibility -->
                    </div>
                    <h5 class="card-title text-center">Memeriksa Pasien</h5> <!-- Center the title -->
                    <p class="card-text text-center">Proses pemeriksaan pasien dengan cepat dan efisien.</p> <!-- Center the text -->
                    <div class="text-center"> <!-- Center the button -->
                        <a href="daftar.php" class="btn btn-primary">Mulai Pemeriksaan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center py-4">
    <div class="container">
        <p>&copy; 2024 Poliklinik Sehat. Semua hak dilindungi.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>