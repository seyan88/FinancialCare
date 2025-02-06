<?php
session_start();
$conn = new mysqli("localhost", "root", "", "user_chart");

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    echo json_encode([]);
    exit();
}

// Ambil user ID dari sesi
$conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");
$sql1 = "SELECT id FROM users WHERE username = '" . $_SESSION['username'] . "'";
$result1 = $conn1->query($sql1);
$userId = ($result1->num_rows > 0) ? $result1->fetch_assoc()["id"] : null;

// Ambil data pengeluaran dari database
$sql = "SELECT category, amount FROM expense_details WHERE user_data_id = '$userId'";
$result = $conn->query($sql);

$expenses = [];
$totalExpenses = 0;
while ($row = $result->fetch_assoc()) {
    $expenses[] = $row;
    $totalExpenses += floatval($row['amount']);
}


echo json_encode(["expenses" => $expenses, "total_expenses" => $totalExpenses]);
?>
