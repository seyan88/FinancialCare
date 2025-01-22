<?php
// save_data.php

header('Content-Type: application/json');

// Koneksi ke database
$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'user_chart'; // Ganti dengan nama database Anda
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mendekode data JSON dari permintaan POST
    $inputData = json_decode(file_get_contents('php://input'), true);

    // Validasi data yang diterima
    if (!isset($inputData['salary'], $inputData['totalExpenses'], $inputData['expenses'])) {
        echo json_encode(['error' => 'Invalid input data']);
        exit;
    }

    $salary = $inputData['salary'];
    $totalExpenses = $inputData['totalExpenses'];
    $expenses = $inputData['expenses']; // Array dari kategori dan nominal pengeluaran

    // Simpan data gaji dan total pengeluaran
    $stmt = $pdo->prepare("INSERT INTO summary (salary, total_expenses, created_at) VALUES (:salary, :total_expenses, NOW())");
    $stmt->bindParam(':salary', $salary, PDO::PARAM_STR);
    $stmt->bindParam(':total_expenses', $totalExpenses, PDO::PARAM_STR);
    $stmt->execute();

    // Ambil ID dari data yang baru saja disimpan
    $summaryId = $pdo->lastInsertId();

    // Simpan data detail pengeluaran
    $stmtDetail = $pdo->prepare("INSERT INTO expenses (summary_id, category, amount) VALUES (:summary_id, :category, :amount)");
    foreach ($expenses as $expense) {
        $stmtDetail->bindParam(':summary_id', $summaryId, PDO::PARAM_INT);
        $stmtDetail->bindParam(':category', $expense['category'], PDO::PARAM_STR);
        $stmtDetail->bindParam(':amount', $expense['amount'], PDO::PARAM_STR);
        $stmtDetail->execute();
    }

    // Berikan respon sukses
    echo json_encode(['success' => true, 'message' => 'Data saved successfully']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
