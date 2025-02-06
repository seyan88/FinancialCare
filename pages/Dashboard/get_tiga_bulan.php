<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "user_chart");
$conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");

if ($conn->connect_error || $conn1->connect_error) {
    echo json_encode(["success" => false, "message" => "Koneksi database gagal"]);
    exit();
}

if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "message" => "User tidak login"]);
    exit();
}

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

$monthYear = isset($_GET['month_year']) ? $_GET['month_year'] : date('Y-m');

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

$categories = [];
$amounts = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
    $amounts[] = $row['total_amount'];
}

$stmt->close();
$conn->close();
$conn1->close();

echo json_encode([
    "success" => true,
    "month_year" => $monthYear,
    "categories" => $categories,
    "amounts" => $amounts
]);
?>
