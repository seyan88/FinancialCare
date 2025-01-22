// script1.js

// Menambah baris input kategori dan nominal pengeluaran
function addExpense() {
    const expenseDetails = document.getElementById("expenseDetails");
    const expenseRow = document.createElement("div");
    expenseRow.className = "expense-row";

    expenseRow.innerHTML = `
        <label>Kategori:</label>
        <input type="text" class="category" required>
        <label>Nominal:</label>
        <input type="number" step="0.01" class="amount" required>
        <button type="button" class="remove-btn" onclick="removeExpense(this)">Hapus</button>
    `;

    expenseDetails.appendChild(expenseRow);
}

// Menghapus baris input kategori dan nominal pengeluaran
function removeExpense(button) {
    const expenseRow = button.parentNode;
    expenseRow.parentNode.removeChild(expenseRow);
}

// Fungsi untuk mengirim data ke server
async function saveData(data) {
    try {
        const response = await fetch("save_data.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        if (result.success) {
            alert(result.message);
        } else {
            alert(`Error: ${result.error}`);
        }
    } catch (error) {
        console.error("Error saving data:", error);
        alert("Terjadi kesalahan saat menyimpan data.");
    }
}

// Event listener untuk formulir
document.getElementById("dataForm").addEventListener("submit", async function (event) {
    event.preventDefault();

    const salary = parseFloat(document.getElementById("salary").value);
    const totalExpenses = parseFloat(document.getElementById("totalExpenses").value);
    const expenseRows = document.querySelectorAll(".expense-row");

    const expenses = Array.from(expenseRows).map(row => ({
        category: row.querySelector(".category").value,
        amount: parseFloat(row.querySelector(".amount").value),
    }));

    const data = {
        salary: salary,
        totalExpenses: totalExpenses,
        expenses: expenses,
    };

    await saveData(data);
    updateChart(expenses); // Perbarui chart setelah data disimpan
});

// Fungsi untuk memperbarui grafik menggunakan ApexCharts
function updateChart(expenses) {
    const categories = expenses.map(expense => expense.category);
    const amounts = expenses.map(expense => expense.amount);

    const options = {
        chart: {
            type: "pie",
        },
        series: amounts,
        labels: categories,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 300,
                },
                legend: {
                    position: "bottom",
                },
            },
        }],
    };

    const chart = new ApexCharts(document.getElementById("chart"), options);
    chart.render();
}

// Menghapus grafik yang ada
document.getElementById("delete-chart-btn").addEventListener("click", function () {
    const chartContainer = document.getElementById("chart");
    chartContainer.innerHTML = ""; // Menghapus grafik
    alert("Chart berhasil dihapus.");
});
