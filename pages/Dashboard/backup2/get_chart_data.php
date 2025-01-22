<?php
// get_chart_data.php

header('Content-Type: application/json');

// Sambungkan ke database
$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'user_chart'; // Ganti dengan nama database Anda
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk mendapatkan data pengeluaran per kategori
    $query = $pdo->prepare("SELECT kategori, SUM(nominal) as total_nominal FROM pengeluaran GROUP BY kategori");
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
