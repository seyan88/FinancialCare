

function addExpense() {
    const detailDiv = document.createElement('div');
    detailDiv.innerHTML = `
        <label>Kategori:</label>
        <input type="text" class="category" required>
        <label>Nominal:</label>
        <input type="number" step="0.01" class="amount" required>
    `;
    document.getElementById('expenseDetails').appendChild(detailDiv);
}

document.getElementById('dataForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const salary = document.getElementById('salary').value;
    const totalExpenses = document.getElementById('totalExpenses').value;
    const categories = Array.from(document.querySelectorAll('.category')).map(input => input.value);
    const amounts = Array.from(document.querySelectorAll('.amount')).map(input => parseFloat(input.value));

    fetch('save_data.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ salary, totalExpenses, categories, amounts })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Data berhasil disimpan!');
            loadChart();
        } else {
            alert('Gagal menyimpan data!');
        }
    });
});

function loadChart() {
    fetch('get_chart_data.php')
        .then(response => response.json())
        .then(data => {
            const options = {
                series: [{
                    name: 'Pengeluaran',
                    data: data.amounts
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                xaxis: {
                    categories: data.categories,
                }
            };

            const chart = new ApexCharts(document.querySelector("#chart1"), options);
            chart.render();
        });
}

loadChart();

function removeExpense(button) {
    const row = button.parentElement; // Mengambil elemen parent (div) dari tombol
    row.remove(); // Menghapus elemen row
}


// Fungsi untuk mendapatkan nama bulan secara real-time
function getMonthName() {
    const bulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    const tanggal = new Date();
    return bulan[tanggal.getMonth()];
}

// Tampilkan nama bulan pada elemen
document.getElementById("current-month").textContent = "Bulan: " + getMonthName();

// Fungsi untuk merender chart
function renderChart(data) {
    var options = {
        series: [{
            name: 'Pengeluaran',
            data: data
        }],
        chart: {
            height: 350,
            type: 'bar'
        },
        xaxis: {
            categories: ['Groceries', 'Fashion', 'Makanan', 'Transportasi', 'Hiburan']
        },
        title: {
            text: "Pengeluaran per Kategori",
            align: "center"
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
    return chart; // Return chart instance
}

// Data dummy untuk pengeluaran (replace dengan data dari database)
const dummyData = [200000, 300000, 150000, 100000, 50000];

// Render chart pertama kali
let currentChart = renderChart(dummyData);

// Fungsi untuk menghapus chart
document.getElementById("delete-chart-btn").addEventListener("click", function() {
    if (currentChart) {
        currentChart.destroy(); // Hapus chart
        document.querySelector("#chart").innerHTML = ""; // Bersihkan container
    }
});

// Ambil data dari server
async function fetchMonthlyData() {
    try {
        const response = await fetch("getMonthlyData.php");
        const result = await response.json();
        return result;
    } catch (error) {
        console.error("Gagal mengambil data:", error);
    }
}

// Render chart dengan data dari server
fetchMonthlyData().then(result => {
    if (result) {
        currentChart = renderChart(result.data);
    }
});

