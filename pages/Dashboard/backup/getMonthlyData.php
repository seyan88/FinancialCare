<?php
header('Content-Type: application/json');

// Koneksi ke database
$conn = new mysqli("localhost", "username", "password", "nama_database");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$bulan = date('m'); // Bulan saat ini
$tahun = date('Y'); // Tahun saat ini

$query = "SELECT kategori, SUM(nominal) as total FROM pengeluaran WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' GROUP BY kategori";
$result = $conn->query($query);

$data = [];
$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['kategori'];
        $data[] = (int)$row['total'];
    }
}

echo json_encode(['categories' => $categories, 'data' => $data]);
$conn->close();
?>
