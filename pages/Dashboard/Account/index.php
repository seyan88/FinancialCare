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

// Mengambil email user berdasarkan username
$sql1 = "SELECT email FROM users WHERE username = '".$_SESSION['username']."'";


if ($result1->num_rows > 0) {
    $email = $result1->fetch_assoc()["email"];
   
} else {
    echo json_encode(["success" => false, "message" => "Email tidak ditemukan"]);
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <style>
        body {
            background-color: #1a1a2e;
            color: #e0e0e0;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-top: 50px;
        }
        .box {
            background-color: #16213e;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        button, .back-button {
            background-color: #663399;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover, .back-button:hover {
            background-color: #1a5276;
        }
        .back-button {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("get_data.php")
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("username").textContent = "Username: " + "<?php echo $_SESSION['username']; ?>";
                        document.getElementById("email").textContent = "Email: "+ "<?php echo $email ?>"; // Gantilah dengan email dari database
                        document.getElementById("total_expenses").textContent = "Total Pengeluaran: Rp " + data.total_expenses;
                        document.getElementById("salary").textContent = "Gaji: Rp " + data.salary;
                        let sisa = data.salary - data.total_expenses;
                        document.getElementById("sisa").textContent = "Sisa: Rp " + sisa;
                    } else {
                        document.getElementById("total_expenses").textContent = data.message;
                    }
                })
                .catch(error => console.error("Error fetching data:", error));
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="box">
            <h3>Informasi Akun</h3>
            <p id="username">Username: Loading...</p>
            <p id="email">Email: Loading...</p>
        </div>
        <div class="box">
            <form action="" method="post">
                <button name="logout">Logout</button>
            </form>
        </div>
        <div class="box">
            <h3>Keuangan</h3>
            <p id="total_expenses">Total Pengeluaran: Loading...</p>
            <p id="salary">Gaji: Loading...</p>
            <p id="sisa">Sisa: Loading...</p>
        </div>
        <a href="../../Dashboard/Dashboard.php" class="back-button">Kembali ke Menu Utama</a>
    </div>
</body>
</html>
