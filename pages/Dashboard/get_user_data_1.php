<?php
// session_start();
// header('Content-Type: application/json');

// // Koneksi ke database user_chart
// $conn = new mysqli("localhost", "root", "", "user_chart");
// $conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");

// // Periksa koneksi database
// if ($conn->connect_error || $conn1->connect_error) {
//     echo json_encode(["success" => false, "message" => "Koneksi database gagal"]);
//     exit();
// }

// // Pastikan user sudah login
// if (!isset($_SESSION['username'])) {
//     echo json_encode(["success" => false, "message" => "User tidak login"]);
//     exit();
// }

// // Mengambil ID user dari database_web_financialcare
// $sql1 = "SELECT id FROM users WHERE username = ?";
// $stmt1 = $conn1->prepare($sql1);
// $stmt1->bind_param("s", $_SESSION['username']);
// $stmt1->execute();
// $result1 = $stmt1->get_result();

// if ($result1->num_rows > 0) {
//     $userId = $result1->fetch_assoc()["id"];
// } else {
//     echo json_encode(["success" => false, "message" => "User tidak ditemukan"]);
//     exit();
// }
// $stmt1->close();

// // Mengambil salary dan total_expenses dari database user_chart
// $sql2 = "SELECT salary, total_expenses FROM user_data WHERE user_id = ? LIMIT 1";
// $stmt2 = $conn->prepare($sql2);
// $stmt2->bind_param("i", $userId);
// $stmt2->execute();
// $result2 = $stmt2->get_result();

// if ($result2->num_rows > 0) {
//     $data = $result2->fetch_assoc();
//     $response = [
//         "success" => true,
//         "salary" => floatval($data["salary"]),
//         "total_expenses" => floatval($data["total_expenses"])
//     ];
// } else {
//     $response = [
//         "success" => false,
//         "message" => "Data tidak ditemukan",
//         "salary" => 0,
//         "total_expenses" => 0
//     ];
// }

// $stmt2->close();
// $conn->close();
// $conn1->close();

// echo json_encode($response);


//code baru
session_start();
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

// Koneksi ke database user_chart
$conn = new mysqli("localhost", "root", "", "user_chart");
$conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");

// Periksa koneksi database
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

// Mendapatkan bulan dan tahun saat ini
$currentMonthYear = date("Y-m");

// Mengambil salary dan total_expenses dari database user_chart berdasarkan bulan saat ini
$sql2 = "SELECT salary, total_expenses FROM user_data WHERE user_id = ? AND month_year = ? LIMIT 1";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("is", $userId, $currentMonthYear);
$stmt2->execute();
$result2 = $stmt2->get_result();

$data = $result2->fetch_assoc() ?: ["salary" => 0, "total_expenses" => 0];

$response = [
    "success" => true,
    "salary" => number_format(floatval($data["salary"]), 2, '.', ''),
    "total_expenses" => number_format(floatval($data["total_expenses"]), 2, '.', ''),
    "message" => $data["salary"] > 0 ? "Data ditemukan" : "Data tidak ditemukan untuk bulan ini"
];

$stmt2->close();
$conn->close();
$conn1->close();

echo json_encode($response);



// 
?>
