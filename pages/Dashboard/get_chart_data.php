<?php
$conn = new mysqli("localhost", "root", "", "user_chart");
$monthYear = date('Y-m');

$result = $conn->query("
    SELECT category, SUM(amount) as total_amount 
    FROM expense_details 
    JOIN user_data ON user_data.id = expense_details.user_data_id 
    WHERE user_data.month_year = '$monthYear'
    GROUP BY category
");

$categories = [];
$amounts = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
    $amounts[] = $row['total_amount'];
}

echo json_encode(["categories" => $categories, "amounts" => $amounts]);
?>
