// =========================
// Patient Homepage - Logout
// =========================
document.addEventListener("DOMContentLoaded", function () {
    const logoutLink = document.getElementById("logout-btn"); // link logout
    const popup = document.getElementById("logout-popup");
    const confirmBtn = document.getElementById("confirm-logout");
    const cancelBtn = document.getElementById("cancel-logout");

    if (logoutLink && popup) {
        // Khi bấm Logout -> hiện popup
        logoutLink.addEventListener("click", function (e) {
            e.preventDefault();
            popup.style.display = "flex";
        });

        // Xác nhận Logout
        if (confirmBtn) {
            confirmBtn.addEventListener("click", function () {
                // Laravel logout form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "/logout"; // route('logout') trong Laravel
                form.innerHTML = `@csrf`;
                document.body.appendChild(form);
                form.submit();
            });
        }

        // Hủy -> đóng popup
        if (cancelBtn) {
            cancelBtn.addEventListener("click", function () {
                popup.style.display = "none";
            });
        }
    }
});

// =========================
// Add Appointment
// =========================
document.addEventListener("DOMContentLoaded", function () {
    const radios = document.querySelectorAll('input[name="patient_status"]');
    radios.forEach(radio => {
        radio.addEventListener("change", function () {
            if (this.value === "no") {
                window.location.href = "/medical_record/update_profile";
            }
        });
    });
});

// =========================
// Payment Confirmation
// =========================
document.addEventListener("DOMContentLoaded", function () {
    const payBtn = document.querySelector(".btn-primary.p-center");
    const popup = document.getElementById("payment-popup");
    const closeBtn = document.getElementById("close-popup");

    if (payBtn && popup && closeBtn) {
        payBtn.addEventListener("click", function (e) {
            e.preventDefault(); // chặn submit form
            popup.style.display = "flex"; // hiện popup
        });

        closeBtn.addEventListener("click", function () {
            popup.style.display = "none";
            // Nếu muốn redirect sau khi thanh toán thành công:
            // window.location.href = "/appointments"; 
        });
    }
});
