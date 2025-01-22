<?php
// Koneksi ke database
$db = new mysqli("localhost", "root", "", "Database_Web_Financialcare");

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

// Mendapatkan data dari form
if(isset($_POST['submit'])){
    $name = ($_POST['nama']);
    $email = ($_POST['gmail']);
    $country = ($_POST['country']);
    $username = ($_POST['username']);
    $password = ($_POST['password']);
    $check = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $result=$db->query($check);

if($result->num_rows > 0){
    echo "Username atau email sudah terdaftar";
    echo"<br>"; 
    echo"<a href='.../../Register.php'>Kembali</a>";
}else{  
    $sql = "INSERT INTO users (name, email, country, username, password) VALUES ('$name', '$email', '$country', '$username', '$password')";
    echo"Akun berhasil terdaftar" ;
    if ($db->query($sql) === TRUE) {
        header("location: ../Login/Login.php");
        }else{
        echo "Error: " .$db->error;
        }
    }
}
if(isset($_POST['login'])){
    $username = ($_POST['username']);
    $password = ($_POST['password']);
    $ambil= "SELECT * FROM users WHERE username = '$username'";
    $result=$db->query($ambil);
    if($result->num_rows > 0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        header("Location: ../../../Login/Login.php");
        exit();
    }else{
        
        echo"Username atau password salah";

    }
}
?>



