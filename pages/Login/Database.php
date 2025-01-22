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

   

// Melakukan query untuk memeriksa username dan password
if(isset($_POST['login'])){
    $username = ($_POST['username']);
    $password = ($_POST['password']);
    $ambil= "SELECT * FROM users WHERE username = '$username'AND password = '$password'";
    $result=$db->query($ambil);

    $gagalusername = "SELECT * FROM users WHERE username = '$username'";
    $result1=$db->query($gagalusername);

    $gagalpassword = "SELECT * FROM users WHERE password = '$password'";
    $result2=$db->query($gagalpassword);


    if($result->num_rows > 0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        header("Location: ../Dashboard/Dashboard.php");
        exit();
    }else if($result1->num_rows == 0 && $result2->num_rows > 0){
        $_SESSION['error'] = "Maaf USERNAME yang anda masukkan tidak terdaftar";
        echo "<script>
        sessionStorage.setItem('errorusername', '$_SESSION[error]');
        window.location.href = 'login.php';
        </script>";
        exit();
    }else if($result2->num_rows == 0 && $result1->num_rows > 0){
        $_SESSION['error'] = "Maaf PASSWORD yang anda masukkan salah";
        echo "<script>
        sessionStorage.setItem('errorpassword', '$_SESSION[error]');
        window.location.href = 'login.php';
        </script>";
        exit();
    }else{
        $_SESSION['error'] = "USERNAME dan PASSWORD yang anda masukkan tidak terdaftar"; // Ditambahkan
        echo "<script>
                sessionStorage.setItem('errorMessage', '$_SESSION[error]'); // Ditambahkan
                window.location.href = 'login.php'; // Ditambahkan
              </script>"; // Ditambahkan
        exit();
    }
}

?>

<!-- if($result->num_rows > 0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        header("Location: ../Dashboard/Dashboard.php");
        exit();
    }else if($result1->num_rows == 0){
        $_SESSION['error'] = "Username salah";
        echo "<script>
        sessionStorage.setItem('errorusername', '$_SESSION[error]');
        window.location.href = 'login.php';
        </script>";
        exit();
    }else if($result2->num_rows == 0){
        $_SESSION['error'] = "PASSWORD salah";
        echo "<script>
        sessionStorage.setItem('errorpassword', '$_SESSION[error]');
        window.location.href = 'login.php';
        </script>";
        exit();
    }else{
        $_SESSION['error'] = "Username atau password salah"; // Ditambahkan
        echo "<script>
                sessionStorage.setItem('errorMessage', '$_SESSION[error]'); // Ditambahkan
                window.location.href = 'login.php'; // Ditambahkan
              </script>"; // Ditambahkan
        exit(); -->


