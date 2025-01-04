<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_bk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $id_pasien = $_POST['id_pasien']; // Assuming you have a way to get this
    $id_jadwal = $_POST['id_jadwal']; // Assuming you have a way to get this
    $keluhan = isset($_POST['keluhan']) ? $_POST['keluhan'] : '';

    // Validate data
    if (empty($id_pasien) || empty($id_jadwal) || empty($keluhan)) {
        $error = "Semua field harus diisi.";
    } else {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id_pasien, $id_jadwal, $keluhan); // "iis" means integer, integer, string

        // Execute the statement
        if ($stmt->execute()) {
            $success = "Pendaftaran berhasil! Berikut adalah detail pendaftaran Anda:";
        } else {
            $error = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Fetch the history of registrations
$history_sql = "SELECT * FROM daftar_poli ORDER BY id DESC"; // Adjust the query as needed
$history_result = $conn->query($history_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
        .details {
            margin-top: 20px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background -color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pendaftaran Pasien Baru</h1>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
            <div class="details">
                <h2>Detail Pendaftaran:</h2>
                <p><strong>ID Pasien:</strong> <?php echo htmlspecialchars($id_pasien); ?></p>
                <p><strong>ID Jadwal:</strong> <?php echo htmlspecialchars($id_jadwal); ?></p>
                <p><strong>Keluhan:</strong> <?php echo htmlspecialchars($keluhan); ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <h2>Data Pasien</h2>
            <label>ID Pasien:</label>
            <input type="text" name="id_pasien" required>

            <label>ID Jadwal:</label>
            <input type="text" name="id_jadwal" required>

            <label>Keluhan:</label>
            <textarea name="keluhan" required></textarea>

            <button type="submit">Daftar Sekarang</button>
        </form>

        <h2>Riwayat Pendaftaran</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Pasien</th>
                    <th>ID Jadwal</th>
                    <th>Keluhan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($history_result->num_rows > 0): ?>
                    <?php while ($row = $history_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_pasien']); ?></td>
                            <td><?php echo htmlspecialchars($row['id_jadwal']); ?></td>
                            <td><?php echo htmlspecialchars($row['keluhan']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Tidak ada riwayat pendaftaran.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>