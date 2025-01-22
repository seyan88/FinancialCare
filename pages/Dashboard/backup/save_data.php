<?php
$conn = new mysqli("localhost", "root", "", "user_chart");

$data = json_decode(file_get_contents("php://input"), true);
$salary = $data['salary'];
$totalExpenses = $data['totalExpenses'];
$categories = $data['categories'];
$amounts = $data['amounts'];
$monthYear = date('Y-m');

$conn->query("INSERT INTO user_data (user_id, salary, total_expenses, month_year) VALUES (1, '$salary', '$totalExpenses', '$monthYear')");
$userDataId = $conn->insert_id;

foreach ($categories as $index => $category) {
    $amount = $amounts[$index];
    $conn->query("INSERT INTO expense_details (user_data_id, category, amount) VALUES ('$userDataId', '$category', '$amount')");
}

echo json_encode(["success" => true]);
?>
