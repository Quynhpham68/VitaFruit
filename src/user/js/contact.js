// Chuyển đổi hiển thị popup và thay đổi icon trên nút
function togglePopup() {
    var popup = document.getElementById("contact-popup");
    var button = document.getElementById("contact-button");

    popup.classList.toggle("show");

    // Thay đổi icon của nút
    if (popup.classList.contains("show")) {
        button.innerHTML = '<i class="fas fa-times"></i>'; // Hiển thị dấu X khi popup mở
    } else {
        button.innerHTML = '<i class="fas fa-phone"></i>'; // Hiển thị icon điện thoại khi popup đóng
    }
}

document
    .getElementById("contact-button")
    .addEventListener("click", togglePopup);
