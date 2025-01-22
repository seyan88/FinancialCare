<?php
include 'Database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    

    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    


    
<!-- --!fonts -->
<!-- KoHo -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=KoHo:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

<!-- /*Playfair Display*/ -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=KoHo:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

<!-- /*boxcoin -->
<link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

  <!-- /*remixicon -->
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>

<!-- /*SVG -->
<link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
        rel="stylesheet"
    />

</head>
<body>
<div class="container">
        <div class="login">
            <h2>Login</h2>
            <form action="Login.php" method="post"class="formlogin">
                <label for="username"class="username">Username:</label>
                <input type="text" name="username" id="username"  >
                <label for="password"class="password">Password:</label>
                <input type="password" name="password" id="password">
                <input type="submit" value="Login" name="login" >

               
            </form>
        </div>
    <div class="register">
       <p class="registerteks">Tidak punya akun? <a href="../Register/Register.php">Register</a></p>
       </div>
      
</div>
   <!-- Tambahkan elemen modal -->
   <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="errorMessage">maaf username atau password salah</p>
        </div>
    </div>



   
    <script src="script.js"></script>

</body>
</html>










    
