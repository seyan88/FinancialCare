<!DOCTYPE html>
<?php
session_start();

$conn = new mysqli("localhost", "root", "", "user_chart");
$conn1 = new mysqli("localhost","root","","database_web_financialcare");

$sql1="SELECT * FROM users Where username = '".$_SESSION['username']."'";
$result1=$conn1->query($sql1);

if(isset($_POST['logout']))
{
    session_unset();
    session_destroy();
    header("Location: ../../Login/Login.php");
    exit();
}




echo $_SESSION['username'];
if ($result1->num_rows > 0) {
    while($row1 = $result1->fetch_assoc()) {
        $id=$row1["id"];

        echo "      id nya: ",$id;

    }
} else {
    echo "0 hasil dari database pertama";
}







/*
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

*/




?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <button name="logout">Logout</button>
    </form>
</body>
</html>