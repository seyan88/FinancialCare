<?php
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
// $sql = "SELECT category, amount FROM expense_details WHERE user_data_id = '$userId'";
// $result = $conn->query($sql);

// $expenses = [];
// $totalExpenses = 0;
// while ($row = $result->fetch_assoc()) {
//     $expenses[] = $row;
//     $totalExpenses += floatval($row['amount']);
// }


// echo json_encode(["expenses" => $expenses, "total_expenses" => $totalExpenses]);


//code baru

header('Content-Type: application/json');
session_start();
$conn = new mysqli("localhost", "root", "", "user_chart");
$conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");

if ($conn->connect_error || $conn1->connect_error) {
    die(json_encode(["success" => false, "message" => "Koneksi database gagal"]));
}

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    echo json_encode(["expenses" => [], "total_expenses" => 0]);
    exit();
}

// Ambil user ID dari database_web_financialcare
$sql1 = "SELECT id FROM users WHERE username = ?";
$stmt1 = $conn1->prepare($sql1);
$stmt1->bind_param("s", $_SESSION['username']);
$stmt1->execute();
$result1 = $stmt1->get_result();

if ($result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $userId = $row1["id"];
} else {
    echo json_encode(["success" => false, "message" => "User tidak ditemukan"]);
    exit();
}

// Ambil bulan dan tahun saat ini
$monthYear = date('Y-m');

// Ambil data pengeluaran dari database berdasarkan bulan dan tahun saat ini
$sql = "
    SELECT expense_details.category, SUM(expense_details.amount) AS total_amount 
    FROM expense_details 
    JOIN user_data ON user_data.id = expense_details.user_data_id 
    WHERE user_data.month_year = ? AND user_data.user_id = ?
    GROUP BY expense_details.category
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $monthYear, $userId);
$stmt->execute();
$result = $stmt->get_result();

$expenses = [];
$totalExpenses = 0;

while ($row = $result->fetch_assoc()) {
    $expenses[] = [
        "category" => $row["category"],
        "amount" => floatval($row["total_amount"])
    ];
    $totalExpenses += floatval($row['total_amount']);
}

echo json_encode(["expenses" => $expenses, "total_expenses" => $totalExpenses]);


?>
