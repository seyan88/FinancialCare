<?php
session_start();
$conn = new mysqli("localhost", "root", "", "user_chart");

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    echo json_encode(["exists" => false, "message" => "User not logged in"]);
    exit();
}

// Ambil user ID dari sesi
$conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");
$sql1 = "SELECT id FROM users WHERE username = '" . $_SESSION['username'] . "'";
$result1 = $conn1->query($sql1);
$userId = ($result1->num_rows > 0) ? $result1->fetch_assoc()["id"] : null;

if (!$userId) {
    echo json_encode(["exists" => false, "message" => "User not found"]);
    exit();
}

// Ambil total pengeluaran pengguna dari database
$sql = "SELECT SUM(amount) as total_expenses FROM expense_details WHERE user_data_id = '$userId'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Periksa apakah ada data pengeluaran
if ($row && $row["total_expenses"] !== null) {
    echo json_encode(["exists" => true, "total_expenses" => floatval($row["total_expenses"])]);
} else {
    echo json_encode(["exists" => false, "total_expenses" => 0]);
}

$conn->close();
$conn1->close();
?>
