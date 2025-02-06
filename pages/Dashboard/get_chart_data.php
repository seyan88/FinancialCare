<?php
// session_start();
// $conn = new mysqli("localhost", "root", "", "user_chart");
// $monthYear = date('Y-m');

// $conn1 = new mysqli("localhost","root","","database_web_financialcare");
// //mengambil nilai sesuai dengan user yang login dari database_web_financialcare
// $sql1="SELECT * FROM users Where username = '".$_SESSION['username']."'";
// $result1=$conn1->query($sql1);


// //mengambil nilai id dari database_web_financialcare
// if ($result1->num_rows > 0) {
//     while($row1 = $result1->fetch_assoc()) {
//        $id=$row1["id"];
//     }
// } else {
//     echo "0 hasil dari database pertama";
// }


// $result = $conn->query("
//     SELECT category, SUM(amount) as total_amount 
//     FROM expense_details 
//     JOIN user_data ON user_data.id = expense_details.user_data_id 
//     WHERE user_data.month_year = '$monthYear' AND user_data_id='$id'
//     GROUP BY category
// ");

// $categories = [];
// $amounts = [];

// while ($row = $result->fetch_assoc()) {
//     $categories[] = $row['category'];
//     $amounts[] = $row['total_amount'];
// }

// echo json_encode(["categories" => $categories, "amounts" => $amounts]);



// code baru
session_start();
$conn = new mysqli("localhost", "root", "", "user_chart");
$conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");

if ($conn->connect_error || $conn1->connect_error) {
    die(json_encode(["success" => false, "message" => "Koneksi database gagal"]));
}

// Mendapatkan bulan dan tahun saat ini
$monthYear = date('Y-m');

// Mengambil ID user dari database_web_financialcare
$sql1 = "SELECT id FROM users WHERE username = ?";
$stmt1 = $conn1->prepare($sql1);
$stmt1->bind_param("s", $_SESSION['username']);
$stmt1->execute();
$result1 = $stmt1->get_result();

if ($result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $id = $row1["id"];
} else {
    echo json_encode(["success" => false, "message" => "User tidak ditemukan"]);
    exit();
}

// Mengambil data pengeluaran berdasarkan kategori untuk bulan ini
$sql = "
    SELECT expense_details.category, SUM(expense_details.amount) AS total_amount 
    FROM expense_details 
    JOIN user_data ON user_data.id = expense_details.user_data_id 
    WHERE user_data.month_year = ? AND user_data.user_id = ?
    GROUP BY expense_details.category
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $monthYear, $id);
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
$amounts = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
    $amounts[] = $row['total_amount'];
}

echo json_encode(["categories" => $categories, "amounts" => $amounts]);






?>
