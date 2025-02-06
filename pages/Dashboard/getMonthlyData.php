<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "user_chart");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil parameter bulan dari URL, atau gunakan bulan saat ini
$monthYear = isset($_GET['month_year']) ? $_GET['month_year'] : date('Y-m-d');

// Query untuk mengambil data pengeluaran berdasarkan kategori
$result = $conn->query("
    SELECT category, SUM(amount) as total_amount 
    FROM expense_details 
    JOIN user_data ON user_data.id = expense_details.user_data_id 
    WHERE user_data.month_year = '$monthYear'
    GROUP BY category
");

// Inisialisasi array untuk kategori dan jumlah
$categories = [];
$amounts = [];

// Proses hasil query
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
    $amounts[] = $row['total_amount'];
}

// Mengirimkan hasil dalam format JSON
header('Content-Type: application/json');
echo json_encode(["categories" => $categories, "amounts" => $amounts]);
?>


<?php
// URL endpoint untuk data JSON
$url = "http://localhost/pages/Dashboard/getMonthlyData.php?month_year=2025-01";

// Mengambil data JSON dari URL
$jsonData = file_get_contents($url);

// Mengurai data JSON menjadi array asosiatif
$data = json_decode($jsonData, true);

// Memproses data
if (!empty($data)) {
    echo "Kategori dan Total Pengeluaran:\n";
    foreach ($data['categories'] as $index => $category) {
        echo "- " . $category . ": " . $data['amounts'][$index] . "\n";
    }
} else {
    echo "Tidak ada data untuk bulan ini.";
}
?>
