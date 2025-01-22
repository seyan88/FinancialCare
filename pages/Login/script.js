// Ambil elemen modal
var modal = document.getElementById("errorModal"); // Ditambahkan
var usernameError = document.getElementById("errorusername"); // Ditambahkan
var passwordError = document.getElementById("errorpassword"); // Ditambahkan
var errormessage = document.getElementById("errorMessage"); // Ditambahkan
// Ambil elemen <span> yang menutup modal
var span = document.getElementsByClassName("close")[0]; // Ditambahkan

// Jika pesan error tersedia di session storage, tampilkan modal
if (sessionStorage.getItem("errorMessage")) { // Ditambahkan
    document.getElementById("errorMessage").textContent = sessionStorage.getItem("errorMessage"); // Ditambahkan
    modal.style.display = "block"; // Ditambahkan
    usernameError.style.display = "none"; // Ditambahkan
    passwordError.style.display = "none"; // Ditambahkan
    sessionStorage.removeItem("errorMessage"); // Hapus pesan error setelah ditampilkan // Ditambahkan

}
if (sessionStorage.getItem("errorusername")) { // Ditambahkan
    document.getElementById("errorusername").textContent = sessionStorage.getItem("errorusername"); // Ditambahkan
    modal.style.display = "block"; // Ditambahkan
    errormessage.style.display = "none"; // Ditambahkan
    passwordError.style.display = "none"; // Ditambahkan
    sessionStorage.removeItem("errorusername"); // Hapus pesan error setelah ditampilkan // Ditambahkan
}
if (sessionStorage.getItem("errorpassword")) { // Ditambahkan
    document.getElementById("errorpassword").textContent = sessionStorage.getItem("errorpassword"); // Ditambahkan
    modal.style.display = "block"; // Ditambahkan
    errormessage.style.display = "none"; // Ditambahkan
    usernameError.style.display = "none"; // Ditambahkan
    sessionStorage.removeItem("errorpassword"); // Hapus pesan error setelah ditampilkan // Ditambahkan
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
