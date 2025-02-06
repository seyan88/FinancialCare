<?php
// session_start();
// $conn = new mysqli("localhost", "root", "", "user_chart");
// $conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");

// // Mengecek koneksi database
// if ($conn->connect_error || $conn1->connect_error) {
//     die(json_encode(["success" => false, "message" => "Koneksi database gagal"]));
// }

// // Mengambil id user yang sedang login dari database_web_financialcare
// $sql1 = "SELECT id FROM users WHERE username = '" . $_SESSION['username'] . "'";
// $result1 = $conn1->query($sql1);

// if ($result1->num_rows > 0) {
//     $row1 = $result1->fetch_assoc();
//     $id = $row1["id"];
// } else {
//     echo json_encode(["success" => false, "message" => "User tidak ditemukan di database"]);
//     exit();
// }

// // Mengambil data JSON yang dikirimkan
// $data = json_decode(file_get_contents("php://input"), true);
// $salary = $data['salary'];
// $newCategories = $data['categories']; // Kategori baru yang ditambahkan
// $newAmounts = $data['amounts']; // Amount baru yang ditambahkan
// $monthYear = date('Y-m');

// // Mengecek apakah user sudah memiliki data untuk bulan ini di user_data
// $sqlCheck = "SELECT id, total_expenses FROM user_data WHERE user_id = '$id' AND month_year = '$monthYear'";
// $resultCheck = $conn->query($sqlCheck);

// $totalNewExpense = array_sum($newAmounts); // Akumulasi amount baru yang ditambahkan

// if ($resultCheck->num_rows > 0) {
//     // Jika data sudah ada, update salary dan total_expenses dengan penambahan amount baru
//     $rowCheck = $resultCheck->fetch_assoc();
//     $userDataId = $rowCheck['id'];
//     $updatedTotalExpenses = $rowCheck['total_expenses'] + $totalNewExpense; // Akumulasi total pengeluaran

//     $sqlUpdate = "UPDATE user_data SET salary = '$salary', total_expenses = '$updatedTotalExpenses' WHERE id = '$userDataId'";
//     $conn->query($sqlUpdate);
//     exit;
// } else {
//     // Jika data belum ada, insert data baru ke user_data
//     $updatedTotalExpenses = $totalNewExpense;
//     $sqlInsert = "INSERT INTO user_data (id,user_id, salary, total_expenses, month_year) VALUES ('$id','$id', '$salary', '$updatedTotalExpenses', '$monthYear')";
//     $conn->query($sqlInsert);
//     $userDataId = $conn->insert_id;
//     exit;
// }

// // Menyimpan pengeluaran baru ke expense_details
// foreach ($newCategories as $index => $category) {
//     $amount = $newAmounts[$index];
//     $sqlExpense = "INSERT INTO expense_details (user_data_id, category, amount) VALUES ('$userDataId', '$category', '$amount')";
//     $conn->query($sqlExpense);
// }

// echo json_encode(["success" => true, "message" => "Data berhasil diperbarui", "total_expenses" => $updatedTotalExpenses]);



// session_start();
// $conn = new mysqli("localhost", "root", "", "user_chart");
// $conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");

// // Mengecek koneksi database
// if ($conn->connect_error || $conn1->connect_error) {
//     die(json_encode(["success" => false, "message" => "Koneksi database gagal"]));
// }

// // Mengambil id user yang sedang login dari database_web_financialcare
// $sql1 = "SELECT id FROM users WHERE username = ?";
// $stmt1 = $conn1->prepare($sql1);
// $stmt1->bind_param("s", $_SESSION['username']);
// $stmt1->execute();
// $result1 = $stmt1->get_result();

// if ($result1->num_rows > 0) {
//     $row1 = $result1->fetch_assoc();
//     $id = $row1["id"]; // Menggunakan id user sebagai id untuk user_data
// } else {
//     echo json_encode(["success" => false, "message" => "User tidak ditemukan di database"]);
//     exit();
// }

// // Mengambil data JSON yang dikirimkan dari JavaScript
// $data = json_decode(file_get_contents("php://input"), true);
// $salary = $data['salary'];
// $newCategories = $data['categories']; // Kategori pengeluaran baru
// $newAmounts = $data['amounts']; // Jumlah pengeluaran baru
// $monthYear = date('Y-m');

// // Mengecek apakah user sudah memiliki data untuk bulan ini di user_data
// $sqlCheck = "SELECT id, total_expenses FROM user_data WHERE user_id = ? AND month_year = ?";
// $stmtCheck = $conn->prepare($sqlCheck);
// $stmtCheck->bind_param("is", $id, $monthYear);
// $stmtCheck->execute();
// $resultCheck = $stmtCheck->get_result();

// $totalNewExpense = array_sum($newAmounts); // Akumulasi total pengeluaran baru

// if ($resultCheck->num_rows > 0) {
//     // Jika data sudah ada, update salary dan total_expenses
//     $rowCheck = $resultCheck->fetch_assoc();
//     $updatedTotalExpenses = $rowCheck['total_expenses'] + $totalNewExpense; // Akumulasi total pengeluaran

//     $sqlUpdate = "UPDATE user_data SET salary = ?, total_expenses = ? WHERE user_id = ? AND month_year = ?";
//     $stmtUpdate = $conn->prepare($sqlUpdate);
//     $stmtUpdate->bind_param("diis", $salary, $updatedTotalExpenses, $id, $monthYear);
//     $stmtUpdate->execute();
// } else {
//     // Jika data belum ada, insert data baru ke user_data
//     $updatedTotalExpenses = $totalNewExpense;
//     $sqlInsert = "INSERT INTO user_data (id, user_id, salary, total_expenses, month_year) VALUES (?, ?, ?, ?, ?)";
//     $stmtInsert = $conn->prepare($sqlInsert);
//     $stmtInsert->bind_param("iiids", $id, $id, $salary, $updatedTotalExpenses, $monthYear);
//     $stmtInsert->execute();
// }

// // Menyimpan pengeluaran baru ke expense_details
// foreach ($newCategories as $index => $category) {
//     $amount = $newAmounts[$index];
//     $sqlExpense = "INSERT INTO expense_details (user_data_id, category, amount) VALUES (?, ?, ?)";
//     $stmtExpense = $conn->prepare($sqlExpense);
//     $stmtExpense->bind_param("isi", $id, $category, $amount);
//     $stmtExpense->execute();
// }

// echo json_encode(["success" => true, "message" => "Data berhasil diperbarui", "total_expenses" => $updatedTotalExpenses]);


// kode pembaruan terakhir
session_start();
$conn = new mysqli("localhost", "root", "", "user_chart");
$conn1 = new mysqli("localhost", "root", "", "database_web_financialcare");

// Mengecek koneksi database
if ($conn->connect_error || $conn1->connect_error) {
    die(json_encode(["success" => false, "message" => "Koneksi database gagal"]));
}

// Mengambil id user yang sedang login dari database_web_financialcare
$sql1 = "SELECT id FROM users WHERE username = ?";
$stmt1 = $conn1->prepare($sql1);
$stmt1->bind_param("s", $_SESSION['username']);
$stmt1->execute();
$result1 = $stmt1->get_result();

if ($result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $id = $row1["id"]; // ID user dari database_web_financialcare
} else {
    echo json_encode(["success" => false, "message" => "User tidak ditemukan di database"]);
    exit();
}

// Mengambil data JSON yang dikirimkan dari JavaScript
$data = json_decode(file_get_contents("php://input"), true);
$salary = $data['salary'];
$newCategories = $data['categories']; // Kategori pengeluaran baru
$newAmounts = $data['amounts']; // Jumlah pengeluaran baru
$monthYear = date('Y-m');

// Mengecek apakah user sudah memiliki data untuk bulan ini di user_data
$sqlCheck = "SELECT id, total_expenses FROM user_data WHERE user_id = ? AND month_year = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("is", $id, $monthYear);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

$totalNewExpense = array_sum($newAmounts); // Akumulasi total pengeluaran baru

if ($resultCheck->num_rows > 0) {
    // Jika data sudah ada, update salary dan total_expenses
    $rowCheck = $resultCheck->fetch_assoc();
    $userDataId = $rowCheck['id'];
    $updatedTotalExpenses = $rowCheck['total_expenses'] + $totalNewExpense; // Update total pengeluaran

    $sqlUpdate = "UPDATE user_data SET salary = ?, total_expenses = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("dii", $salary, $updatedTotalExpenses, $userDataId);
    $stmtUpdate->execute();
} else {
    // Jika data belum ada, insert data baru ke user_data
    $updatedTotalExpenses = $totalNewExpense;
    $sqlInsert = "INSERT INTO user_data (user_id, salary, total_expenses, month_year) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("idis", $id, $salary, $updatedTotalExpenses, $monthYear);
    $stmtInsert->execute();
    $userDataId = $stmtInsert->insert_id; // Ambil ID yang baru dibuat
}

// Menyimpan pengeluaran baru ke expense_details
foreach ($newCategories as $index => $category) {
    $amount = $newAmounts[$index];
    $sqlExpense = "INSERT INTO expense_details (user_data_id, category, amount) VALUES (?, ?, ?)";
    $stmtExpense = $conn->prepare($sqlExpense);
    $stmtExpense->bind_param("isi", $userDataId, $category, $amount);
    $stmtExpense->execute();
}

echo json_encode(["success" => true, "message" => "Data berhasil diperbarui", "total_expenses" => $updatedTotalExpenses]);





?>
