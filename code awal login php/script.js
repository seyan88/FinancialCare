// Ambil elemen modal
var modal = document.getElementById("errorModal"); // Ditambahkan

// Ambil elemen <span> yang menutup modal
var span = document.getElementsByClassName("close")[0]; // Ditambahkan

// Jika pesan error tersedia di session storage, tampilkan modal
if (sessionStorage.getItem("errorMessage")) { // Ditambahkan
    document.getElementById("errorMessage").textContent = sessionStorage.getItem("errorMessage"); // Ditambahkan
    modal.style.display = "block"; // Ditambahkan
    sessionStorage.removeItem("errorMessage"); // Hapus pesan error setelah ditampilkan // Ditambahkan
}

// Ketika pengguna mengklik <span> (x), tutup modal
span.onclick = function() { // Ditambahkan
    modal.style.display = "none"; // Ditambahkan
}

// Ketika pengguna mengklik di luar modal, tutup modal
window.onclick = function(event) { // Ditambahkan
    if (event.target == modal) { // Ditambahkan
        modal.style.display = "none"; // Ditambahkan
    }
}
