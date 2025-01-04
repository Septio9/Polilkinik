<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_bk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $id_dokter = $_POST['id_dokter'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    // Validate data
    if (empty($id_dokter) || empty($hari) || empty($jam_mulai) || empty($jam_selesai)) {
        $error = "Semua field harus diisi.";
    } else {
        // Check if the doctor ID exists in the dokter table
        $check_doctor_sql = "SELECT * FROM dokter WHERE id = ?";
        $check_stmt = $conn->prepare($check_doctor_sql);
        $check_stmt->bind_param("i", $id_dokter);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            $error = "ID Dokter tidak ditemukan.";
        } else {
            // Prepare the SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) VALUES (?, ?, ?, ?)");
            
            // Check if the statement was prepared successfully
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param("isss", $id_dokter, $hari, $jam_mulai, $jam_selesai);

            // Execute the statement
            if ($stmt->execute()) {
                $success = "Jadwal berhasil ditambahkan!";
            } else {
                $error = "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
        $check_stmt->close();
    }
}

// Fetch the history of schedules
$history_sql = "SELECT * FROM jadwal_periksa ORDER BY id DESC";
$history_result = $conn->query($history_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pemeriksaan Dokter</title>
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
        input[type="time"],
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
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Jadwal Dokter</h1>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>ID Dokter:</label>
            <input type="text" name="id_dokter" required>

            <label>Hari:</label>
            <select name="hari" required>
                <option value="">Pilih Hari</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
            </select>

            <label>Jam Mulai:</label>
            <input type="time" name="jam_mulai" required>

            <label>Jam Selesai:</label>
            <input type="time" name="jam_selesai" required>

            <button type="submit">Tambah Jadwal</button>
        </form>

        <h2>Riwayat Jadwal Dokter</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Dokter</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($history_result->num_rows > 0): ?>
                    <?php while ($row = $history_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_dokter']); ?></td>
                            <td><?php echo htmlspecialchars($row['hari']); ?></td>
                            <td><?php echo htmlspecialchars($row['jam_mulai']); ?></td>
                            <td><?php echo htmlspecialchars($row['jam_selesai']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Tidak ada jadwal dokter.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>