
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




        //fiture tambahan
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("dataForm").addEventListener("submit", function (event) {
                event.preventDefault();
                submitData();
            });
        });
        
        // Fungsi untuk menambah baris kategori dan nominal
        function addExpense() {
            const expenseDetails = document.getElementById("expenseDetails");
            const div = document.createElement("div");
            div.classList.add("expense-row");
            div.innerHTML = `
                <label>Kategori:</label>
                <input type="text" class="category" required>
                <label>Nominal:</label>
                <input type="number" step="0.01" class="amount" required>
                <button type="button" class="remove-btn" onclick="removeExpense(this)">Hapus</button>
            `;
            expenseDetails.appendChild(div);
        }
        
        // Fungsi untuk menghapus baris kategori
        function removeExpense(button) {
            button.parentElement.remove();
        }
        
        // // Fungsi untuk mengirim data ke PHP
        // function submitData() {
        //     let salary = document.getElementById("salary").value;
        //     let categories = document.querySelectorAll(".category");
        //     let amounts = document.querySelectorAll(".amount");
        
        //     let categoryArray = [];
        //     let amountArray = [];
        
        //     categories.forEach((category, index) => {
        //         categoryArray.push(category.value);
        //         amountArray.push(parseFloat(amounts[index].value));
        //     });
        
        //     let totalExpenses = amountArray.reduce((acc, curr) => acc + curr, 0);
        
        //     let data = {
        //         salary: salary,
        //         totalExpenses: totalExpenses,
        //         categories: categoryArray,
        //         amounts: amountArray
        //     };
        
        //     fetch("save_data.php", {
        //         method: "POST",
        //         headers: {
        //             "Content-Type": "application/json"
        //         },
        //         body: JSON.stringify(data)
        //     })
        //     .then(response => response.json())
        //     .then(result => {
        //         if (result.success) {
        //             alert("Data berhasil disimpan!");
        //             updateTotalExpenses(result.total_expenses);
        //         } else {
        //             alert("Gagal menyimpan data: " + result.message);
        //         }
        //     })
        //     .catch(error => console.error("Error:", error));
        // }

        function submitData() {
            let salary = document.getElementById("salary").value;
            let categories = document.querySelectorAll(".category");
            let amounts = document.querySelectorAll(".amount");
        
            let categoryArray = [];
            let amountArray = [];
        
            categories.forEach((category, index) => {
                categoryArray.push(category.value);
                amountArray.push(parseFloat(amounts[index].value) || 0); // Pastikan nilai valid
            });
        
            let newExpenses = amountArray.reduce((acc, curr) => acc + curr, 0);
        
            // Ambil total pengeluaran sebelumnya dari backend
            fetch("get_total_expenses.php")
                .then(response => response.json())
                .then(data => {
                    let totalExpenses;
        
                    if (data.exists) {
                        // Jika data sudah ada, tambahkan amount baru ke total sebelumnya
                        totalExpenses = data.total_expenses + newExpenses;
                    } else {
                        // Jika belum ada data, hanya gunakan amount yang baru
                        totalExpenses = newExpenses;
                    }
        
                    let sendData = {
                        salary: salary,
                        totalExpenses: totalExpenses,
                        categories: categoryArray,
                        amounts: amountArray
                    };
        
                    // Kirim data baru ke backend untuk disimpan
                    fetch("save_data.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(sendData)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            alert("Data berhasil disimpan!");
                            updateTotalExpenses(totalExpenses);
                        } else {
                            alert("Gagal menyimpan data: " + result.message);
                        }
                    })
                    .catch(error => console.error("Error saat menyimpan data:", error));
                })
                .catch(error => console.error("Error mengambil total expenses:", error));
        }
        




        
        // Fungsi untuk memperbarui total pengeluaran di halaman
        function updateTotalExpenses(newTotal) {
            document.getElementById("totalExpenses").value = newTotal;
        }
        
    


function removeExpense(button) {
    const row = button.parentElement; // Mengambil elemen parent (div) dari tombol
    row.remove(); // Menghapus elemen row
}


//Fiture V2 
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("dataForm").addEventListener("submit", function (event) {
        event.preventDefault();
        submitData();
    });

    loadExpenseList(); // Memuat daftar pengeluaran saat halaman dibuka
});

// Fungsi untuk menambah kategori baru
function addExpense() {
    const expenseDetails = document.getElementById("expenseDetails");
    const div = document.createElement("div");
    div.classList.add("expense-row");
    div.innerHTML = `
        <label>Kategori:</label>
        <input type="text" class="category" required>
        <label>Nominal:</label>
        <input type="number" step="0.01" class="amount" required>
        <button type="button" class="remove-btn" onclick="removeExpense(this)">Hapus</button>
    `;
    expenseDetails.appendChild(div);
}

// Fungsi untuk menghapus kategori pengeluaran
function removeExpense(button) {
    button.parentElement.remove();
}

// // Fungsi untuk mengirim data ke PHP
// function submitData() {
//     let salary = document.getElementById("salary").value;
//     let categories = document.querySelectorAll(".category");
//     let amounts = document.querySelectorAll(".amount");

//     let categoryArray = [];
//     let amountArray = [];

//     categories.forEach((category, index) => {
//         categoryArray.push(category.value);
//         amountArray.push(parseFloat(amounts[index].value));
//     });

//     let totalExpenses = amountArray.reduce((acc, curr) => acc + curr, 0);

//     let data = {
//         salary: salary,
//         totalExpenses: totalExpenses,
//         categories: categoryArray,
//         amounts: amountArray
//     };

//     fetch("proses_pengeluaran.php", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json"
//         },
//         body: JSON.stringify(data)
//     })
//     .then(response => response.json())
//     .then(result => {
//         if (result.success) {
//             alert("Data berhasil disimpan!");
//             updateTotalExpenses(result.total_expenses);
//             loadExpenseList(); // Memuat ulang daftar pengeluaran
//         } else {
//             alert("Gagal menyimpan data: " + result.message);
//         }
//     })
//     .catch(error => console.error("Error:", error));
// }





// // Fungsi untuk memperbarui indikator pengeluaran di halaman
// function updateExpenseIndicator(salary, totalExpenses) {
//     let warningMessage = document.getElementById("warningMessage");
//     let salaryNum = parseFloat(salary);
//     let totalNum = parseFloat(totalExpenses);

//     if (totalNum > salaryNum) {
//         warningMessage.textContent = "⚠️ Pengeluaran Anda melebihi gaji bulan ini!";
//         warningMessage.style.color = "red";
//     } else if (totalNum >= salaryNum * 0.8) {
//         warningMessage.textContent = "⚠️ Pengeluaran Anda bulan ini terlalu banyak!";
//         warningMessage.style.color = "orange";
//     } else {
//         warningMessage.textContent = "✅ Keuangan Anda dalam kondisi aman.";
//         warningMessage.style.color = "green";
//     }
    
// }







// Fungsi untuk memperbarui indikator pengeluaran di halaman
function updateExpenseIndicator() {
    fetch('get_user_data.php') // Ganti dengan path ke file PHP
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error("Error:", data.error);
        } else {
            updateExpenseIndicator(data.salary, data.total_expenses);
        }
    
   
    if (data.total_expenses >= data.salary) {
        warningMessage.textContent = "⚠️ Pengeluaran Anda melebihi gaji bulan ini!";
        warningMessage.style.color = "red";
    } else if (data.total_expenses >= data.salary * 0.5) {
        warningMessage.textContent = "⚠️ Pengeluaran Anda bulan ini terlalu banyak!";
        warningMessage.style.color = "orange";
    } else {
        warningMessage.textContent = "✅ Keuangan Anda dalam kondisi aman.";
        warningMessage.style.color = "green";
    }
    
})
}








// Fungsi untuk memuat daftar pengeluaran dari server
function loadExpenseList() {
    fetch("get_expenses.php")
    .then(response => response.json())
    .then(data => {
        const expenseList = document.getElementById("expenseList");
        expenseList.innerHTML = ""; // Kosongkan daftar sebelum diperbarui
        let totalExpenses = 0;

        data.expenses.forEach(expense => {
            const li = document.createElement("li");
            li.innerHTML = `<span>${expense.category}</span> <span>Rp ${expense.amount.toLocaleString()}</span>`;
            expenseList.appendChild(li);
            totalExpenses += parseFloat(expense.amount);
        });

        // Ambil salary untuk indikator
        let salary = document.getElementById("salary").value;
        updateExpenseIndicator(salary, totalExpenses);
    })
    .catch(error => console.error("Error loading expenses:", error));
}

