
<?php
    include './Database.php';



    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
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
    rel="stylesheet">
</head>
<body>

<div class="back">
        <a href="../Login/Login.php"><i class="ri-arrow-left-circle-fill"></i></a>
        </div>
        
    <div class="container">

       

        <div class="Register">
            <h2>Register</h2>
            <form action="Database.php" method="post" class="formregister">
                <label for="name">Name:</label>
                <input type="text" name="nama" id="name">
                <label for="email">Email:</label>
                <input type="email" name="gmail" id="email">

                <label for="country">Country:</label>
                <select name="country" id="country">
                    <option value="Indonesia">Indonesia</option>
                    <option value="US">US</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Singapura">Singapura</option>
                </select>

                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
                
                <label for="password">Password:</label> 
                <input type="password" id="password" name="password"> 
                <span id="passwordError" class="error"></span> 
                <br> 
                <input type="submit" class="kirim"value="Submit" name="submit" href="../Login/Login.php">
                
            </form>

        </div>
    </div>


    <script src="script.js"></script>
</body>
</html>

