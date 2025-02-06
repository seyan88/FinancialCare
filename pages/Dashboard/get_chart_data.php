<?php
session_start();
$conn = new mysqli("localhost", "root", "", "user_chart");
$monthYear = date('Y-m');

$conn1 = new mysqli("localhost","root","","database_web_financialcare");
//mengambil nilai sesuai dengan user yang login dari database_web_financialcare
$sql1="SELECT * FROM users Where username = '".$_SESSION['username']."'";
$result1=$conn1->query($sql1);


//mengambil nilai id dari database_web_financialcare
if ($result1->num_rows > 0) {
    while($row1 = $result1->fetch_assoc()) {
       $id=$row1["id"];
    }
} else {
    echo "0 hasil dari database pertama";
}


$result = $conn->query("
    SELECT category, SUM(amount) as total_amount 
    FROM expense_details 
    JOIN user_data ON user_data.id = expense_details.user_data_id 
    WHERE user_data.month_year = '$monthYear' AND user_data_id='$id'
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
