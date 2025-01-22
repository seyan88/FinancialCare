<?php
// getMonthlyData.php

header('Content-Type: application/json');

// Koneksi database
$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'user_chart'; // Ganti dengan nama database Anda
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil bulan dari parameter GET
    $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Default ke bulan saat ini
    $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Default ke tahun saat ini

    // Query data pengeluaran bulanan
    $query = $pdo->prepare("
        SELECT kategori, SUM(nominal) AS total_nominal
        FROM pengeluaran
        WHERE MONTH(tanggal) = :bulan AND YEAR(tanggal) = :tahun
        GROUP BY kategori
    ");
    $query->bindParam(':bulan', $bulan, PDO::PARAM_INT);
    $query->bindParam(':tahun', $tahun, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Format data untuk grafik
    $chartData = [
        "categories" => [],
        "series" => []
    ];

    foreach ($result as $row) {
        $chartData["categories"][] = $row["kategori"];
        $chartData["series"][] = $row["total_nominal"];
    }

    // Kembalikan data dalam format JSON
    echo json_encode($chartData);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
