<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username_db = "root"; // ganti dengan username database Anda
$password_db = ""; // ganti dengan password database Anda
$dbname = "database_web_financialcare"; // ganti dengan nama database Anda

$db = new mysqli($servername, $username_db, $password_db, $dbname);

// Periksa koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
if(isset($_POST['login'])){
    $username = ($_POST['username']);
    $password = ($_POST['password']);
    $check = "SELECT * FROM user WHERE email = '$username' OR username = '$password'";
    $result=$db->query($check);

// Melakukan query untuk memeriksa username dan password
if(isset($_POST['login'])){
    $username = ($_POST['username']);
    $password = ($_POST['password']);
    $ambil= "SELECT * FROM user WHERE username = '$username'AND password = '$password'";
    $result=$db->query($ambil);
    if($result->num_rows > 0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        header("Location: ../Dashboard/Dashboard.php");
        
    }else{
        $_SESSION['error'] = "Username atau password salah"; // Ditambahkan
        echo "<script>
                sessionStorage.setItem('errorMessage', '$_SESSION[error]'); // Ditambahkan
                window.location.href = 'login.php'; // Ditambahkan
              </script>"; // Ditambahkan
    }
}
}
?>




