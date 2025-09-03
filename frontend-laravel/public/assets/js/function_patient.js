// =========================
// Patient Homepage - Logout
// =========================
document.addEventListener("DOMContentLoaded", function () {
    const logoutLink = document.getElementById("logout-btn");
    const popup = document.getElementById("logout-popup");
    const confirmBtn = document.getElementById("confirm-logout");
    const cancelBtn = document.getElementById("cancel-logout");

    if (logoutLink && popup) {
        // Show popup when clicking Logout link
        logoutLink.addEventListener("click", function (e) {
            e.preventDefault();
            popup.style.display = "flex";
        });

        // Confirm Logout → submit hidden form
        if (confirmBtn) {
            confirmBtn.addEventListener("click", function () {
                document.getElementById('logout-form').submit();
            });
        }

        // Cancel → hide popup
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


// =========================    
// Get Doctor List by Department (Add Appointment)
// =========================
document.addEventListener('DOMContentLoaded', function() {
    const departmentSelect = document.getElementById('department');
    const doctorSelect = document.getElementById('doctor');

    departmentSelect.addEventListener('change', function() {
        const departmentId = this.value;

        fetch(`http://localhost:9000/employee/departments/${departmentId}/doctors`)
            .then(response => response.json())
            .then(data => {
                doctorSelect.innerHTML = '';
                console.log(data); 
                if (data.data && data.data.length > 0) {
                    data.data.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.EmployeeID;
                        option.textContent = doctor.FullName || '';
                        doctorSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.textContent = 'No doctors available';
                    doctorSelect.appendChild(option);
                }
            });
    });
});
// =========================

// Load Doctor Schedule when Doctor is selected
// =========================

document.addEventListener('DOMContentLoaded', function() {
    const doctorSelect = document.getElementById('doctor');
    const appointmentDateInput = document.getElementById('date');
    const timeSlotSelect = document.getElementById('time-slot');
    const weekdayIdInput = document.getElementById('weekday-id');
    
    let doctorSchedules = []; // lưu schedule của bác sĩ hiện tại

    // Map số weekday của JS sang tên
    const weekdayMap = {
        0: "Sunday",
        1: "Monday",
        2: "Tuesday",
        3: "Wednesday",
        4: "Thursday",
        5: "Friday",
        6: "Saturday"
    };

    // Fetch schedule khi đổi bác sĩ
    doctorSelect.addEventListener('change', function() {
        const doctorId = this.value;
        if (!doctorId) return;

        fetch(`http://localhost:9000/employee/doctors/${doctorId}/schedules`)
            .then(response => response.json())
            .then(data => {
                doctorSchedules = data.data || [];
                updateTimeSlots(); // cập nhật lại timeslot nếu đã chọn ngày
            })
            .catch(err => console.error("Error fetching schedule:", err));
    });

    // Khi chọn ngày, lọc timeslot theo lịch
    appointmentDateInput.addEventListener('change', function() {
        updateTimeSlots();
    });

    function updateTimeSlots() {
        const selectedDate = appointmentDateInput.value;
        if (!selectedDate || doctorSchedules.length === 0) {
            timeSlotSelect.innerHTML = '<option value="">-- Select a timeslot --</option>';
            return;
        }

        // Lấy weekday của ngày được chọn
        const dateObj = new Date(selectedDate);
        const weekdayName = weekdayMap[dateObj.getDay()];

        console.log("Selected date:", selectedDate, "Weekday:", weekdayName);
        // Cập nhật weekday_id ẩn
        const weekdayId = Object.keys(weekdayMap).find(key => weekdayMap[key] === weekdayName);
        weekdayIdInput.value = weekdayId || '';
        
        // Lọc schedule theo weekday
        const availableSlots = doctorSchedules.filter(sch => sch.weekday.WeekdayName === weekdayName);

        // Cập nhật dropdown timeslot
        timeSlotSelect.innerHTML = '';
        if (availableSlots.length > 0) {
            availableSlots.forEach(sch => {
                const start = sch.shift.StartTime.substring(0,5); // HH:MM
                const end = sch.shift.EndTime.substring(0,5);
                const option = document.createElement('option');
                option.value = sch.shift.ShiftID;
                option.textContent = `${start} - ${end}`;
                timeSlotSelect.appendChild(option);
            });
        } else {
            timeSlotSelect.innerHTML = '<option value="">No timeslot available</option>';
        }
    }
});
// =========================
