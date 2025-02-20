
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinancialCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Style1.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    
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

<!-- Navbar -->

<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">FinancialCare</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">FinancialCare</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Setting</a>
          </li>
        </ul>
        <form class="d-flex mt-3" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button style="background-color: #a30dff; border: none; border-radius: 5px; " class="search-btn" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>

<!-- tester -->
<div class="container">
    <div class="form-container">
        <h1>FinancialCare</h1>
        <form id="dataForm">
            <label>Gaji:</label>
            <input type="number" step="0.01" id="salary" required>
            <label>Total Pengeluaran:</label>
            <input type="number" step="0.01" id="totalExpenses" required>
            <h3>Detail Pengeluaran:</h3>
            <div id="expenseDetails">
                <div class="expense-row">
                    <label>Kategori:</label>
                    <input type="text" class="category" required>
                    <label>Nominal:</label>
                    <input type="number" step="0.01" class="amount" required>
                    <button type="button" class="remove-btn" onclick="removeExpense(this)">Hapus</button>
                </div>
            </div>
            <button type="button" onclick="addExpense()">Tambah Kategori</button>
            <br><br>
            <button type="submit">Simpan Data</button>
        </form>
    </div>
    <div class="chart-container1">
        <div id="chart1"><h2 class="chart1" id="current-month1">Bulan: Januari</h2></div>
    </div>
</div>

<div id="chart-container">
    <div id="chart-title">
        <h2 id="current-month">Bulan: Januari</h2>
    </div>
    <div id="chart"></div>
    <button id="delete-chart-btn" class="remove-btn">Hapus Chart</button>
</div>


<script src="script1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>