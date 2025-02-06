<?php
// session_start();
// $conn = new mysqli("localhost", "root", "", "user_chart");

// // Pastikan user sudah login
// if (!isset($_SESSION['username'])) {
//     echo json_encode(["error" => "User not logged in"]);
//     exit();
// }

// // Ambil user ID dari sesi
// $conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");
// $sql1 = "SELECT id FROM users WHERE username = '" . $_SESSION['username'] . "'";
// $stmt1 = $conn1->prepare($sql1);
// $stmt1->bind_param("s", $_SESSION['username']);
// $stmt1->execute();
// $result1 = $stmt1->get_result();
// $userId = ($result1->num_rows > 0) ? $result1->fetch_assoc()["id"] : null;

// // Jika user ID tidak ditemukan, hentikan eksekusi
// if (!$userId) {
//     echo json_encode(["error" => "User ID not found"]);
//     exit();
// }

// // Ambil salary dan total_expenses dari tabel user_data
// $sql = "SELECT salary, total_expenses FROM user_data WHERE id = '$userId'";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $userId);
// $stmt->execute();
// $result = $stmt->get_result();
// $userData = $result->fetch_assoc();

// // Jika data user tidak ditemukan
// if (!$userData) {
//     echo json_encode(["error" => "User data not found"]);
//     exit();
// }

// echo json_encode($userData);


// session_start();
// $conn = new mysqli("localhost", "root", "", "user_chart");

// // Pastikan user sudah login
// if (!isset($_SESSION['username'])) {
//     echo json_encode([]);
//     exit();
// }

// // Ambil user ID dari sesi
// $conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");
// $sql1 = "SELECT id FROM users WHERE username = '" . $_SESSION['username'] . "'";
// $result1 = $conn1->query($sql1);
// $userId = ($result1->num_rows > 0) ? $result1->fetch_assoc()["id"] : null;

// // Ambil data pengeluaran dari database
// $sql = "SELECT salary, total_expenses FROM user_data WHERE user_id = '$userId'";
// $result = $conn->query($sql);

// $expenses = [];
// $totalExpenses = 0;
// while ($row = $result->fetch_assoc()) {
//     $expenses[] = $row;
//     $totalExpenses += floatval($row['total_expenses']);
// }


// echo json_encode(["expenses" => $expenses, "total_expenses" => $totalExpenses]);



session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "user_chart");

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

// Ambil user ID dari sesi
$conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");
$sql1 = "SELECT id FROM users WHERE username = '" . $conn1->real_escape_string($_SESSION['username']) . "'";
$result1 = $conn1->query($sql1);
$userId = ($result1->num_rows > 0) ? $result1->fetch_assoc()["id"] : null;

if (!$userId) {
    echo json_encode(["error" => "User not found"]);
    exit();
}

// Ambil salary dan total_expenses dari database
$sql = "SELECT salary, total_expenses FROM user_data WHERE user_id = '$userId' LIMIT 1";
$result = $conn->query($sql);

$data = ($result->num_rows > 0) ? $result->fetch_assoc() : ["salary" => 0, "total_expenses" => 0];

echo json_encode(["salary" => floatval($data['salary']), "total_expenses" => floatval($data['total_expenses'])]);






?>




