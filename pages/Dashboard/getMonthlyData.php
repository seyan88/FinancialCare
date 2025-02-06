<?php
// // Koneksi ke database
// $conn = new mysqli("localhost", "root", "", "user_chart");

// // Cek koneksi
// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// }

// // Ambil parameter bulan dari URL, atau gunakan bulan saat ini
// $monthYear = isset($_GET['month_year']) ? $_GET['month_year'] : date('Y-m-d');

// // Query untuk mengambil data pengeluaran berdasarkan kategori
// $result = $conn->query("
//     SELECT category, SUM(amount) as total_amount 
//     FROM expense_details 
//     JOIN user_data ON user_data.id = expense_details.user_data_id 
//     WHERE user_data.month_year = '$monthYear'
//     GROUP BY category
// ");

// // Inisialisasi array untuk kategori dan jumlah
// $categories = [];
// $amounts = [];

// // Proses hasil query
// while ($row = $result->fetch_assoc()) {
//     $categories[] = $row['category'];
//     $amounts[] = $row['total_amount'];
// }

// // Mengirimkan hasil dalam format JSON
// header('Content-Type: application/json');
// echo json_encode(["categories" => $categories, "amounts" => $amounts]);
?>


<?php
// URL endpoint untuk data JSON
// $url = "http://localhost/pages/Dashboard/getMonthlyData.php?month_year=2025-01";

// // Mengambil data JSON dari URL
// $jsonData = file_get_contents($url);

// // Mengurai data JSON menjadi array asosiatif
// $data = json_decode($jsonData, true);

// // Memproses data
// if (!empty($data)) {
//     echo "Kategori dan Total Pengeluaran:\n";
//     foreach ($data['categories'] as $index => $category) {
//         echo "- " . $category . ": " . $data['amounts'][$index] . "\n";
//     }
// } else {
//     echo "Tidak ada data untuk bulan ini.";
// }


session_start();
header('Content-Type: application/json');

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "user_chart");
$conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");

// Cek koneksi database
if ($conn->connect_error || $conn1->connect_error) {
    echo json_encode(["success" => false, "message" => "Koneksi database gagal"]);
    exit();
}

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "message" => "User tidak login"]);
    exit();
}

// Mengambil ID user dari database_web_financialcare
$sql1 = "SELECT id FROM users WHERE username = ?";
$stmt1 = $conn1->prepare($sql1);
$stmt1->bind_param("s", $_SESSION['username']);
$stmt1->execute();
$result1 = $stmt1->get_result();

if ($result1->num_rows > 0) {
    $userId = $result1->fetch_assoc()["id"];
} else {
    echo json_encode(["success" => false, "message" => "User tidak ditemukan"]);
    exit();
}
$stmt1->close();

// Ambil bulan dan tahun dari parameter GET atau default ke bulan ini
$monthYear = isset($_GET['month_year']) ? $_GET['month_year'] : date('Y-m');

// Query untuk mengambil data pengeluaran berdasarkan kategori
$sql = "
    SELECT category, SUM(amount) as total_amount 
    FROM expense_details 
    JOIN user_data ON user_data.id = expense_details.user_data_id 
    WHERE user_data.month_year = ? AND user_data.user_id = ?
    GROUP BY category
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $monthYear, $userId);
$stmt->execute();
$result = $stmt->get_result();

// Inisialisasi array untuk kategori dan jumlah
$categories = [];
$amounts = [];

// Proses hasil query
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
    $amounts[] = $row['total_amount'];
}

// Menutup koneksi
$stmt->close();
$conn->close();
$conn1->close();

// Mengirimkan hasil dalam format JSON
echo json_encode([
    "success" => true,
    "month_year" => $monthYear,
    "categories" => $categories,
    "amounts" => $amounts
]);






?>
