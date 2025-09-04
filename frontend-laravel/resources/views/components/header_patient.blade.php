<header class="nav-container">
    <div class="nav-left">
        <img src="{{ asset('assets/images/smile-2_removebg.png') }}" alt="Smile.png" class="nav-header__logo">
        <h1 class="nav-header__name">LifeCare</h1>
    </div>

    <div class="nav-items">
        <a class="nav-item" href="{{ url('/home') }}">Homepage</a>
        <a class="nav-item" href="{{ url('department/list_departments') }}">Services</a>
        <a class="nav-item" href="#">About</a>
    </div>
    <!-- If is guest -->
    <!-- <a href="{{ url('/login') }}" class="btn-header">Login</a> -->

    <!-- If login -->
    <div class="nav-right">
        <a href="{{ url('appointment/add_appt') }}" class="btn-primary">Book an appointment</a>

        <!-- Appointment Notifications -->
        <div class="notification-dropdown">
            <button id="notif-btn" class="btn-header">
                <i class="fa-solid fa-bell"></i>
                <span id="notif-count" class="notif-badge">3</span> <!-- ví dụ có 3 thông báo -->
            </button>

            <div id="notif-box" class="dropdown-notif" style="display:none">
                <h4>Appointment Notifications</h4>
                <ul>
                    <li>📅 2025-09-05: Appointment with Dr. Smith at 10:00</li>
                    <li>📅 2025-09-07: Appointment with Dr. Tanaka at 14:00</li>
                    <li>📅 2025-09-10: Appointment with Dr. Nguyen at 09:30</li>
                </ul>
                <a href="{{ url('appointment/list_appts') }}" class="view-all">View All &gt;&gt;</a>
            </div>
        </div>

        <div class="user-dropdown">
            <div class="user-info">
                <div class="avatar-circle"></div>
                <span class="username">{{ session('login_key') ?? 'Guest' }} (ID: {{ session('user_id') }})</span>
            </div>
            <div class="dropdown-user">
                <a href="{{ url('medical_record/profile') }}">
                    <i class="fa-solid fa-file-invoice nav-item__icon"></i> Profile
                </a>
                <a href="{{ url('medical_record/medical_records') }}">
                    <i class="fa-solid fa-notes-medical nav-item__icon"></i> Medical Records
                </a>
                <a href="javascript:void(0)" id="logout-btn">
                    <i class="fa-solid fa-right-from-bracket nav-item__icon"></i> Logout
                </a>
            </div>
        </div>

        {{-- Popup Confirm Logout --}}
        <div id="logout-popup" class="popup-overlay" style="display:none">
            <div class="popup-box">
                <h3 class="paper-list-title">Confirm Logout</h3>
                <p class="paper-detail-description">Are you sure you want to logout?</p>
                <div style="margin-top: 15px;">
                    <button id="confirm-logout" class="btn-primary">Yes, Logout</button>
                    <button id="cancel-logout" class="btn-outline">Cancel</button>
                </div>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

    </div>
</header>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // ===== Logout popup =====
        const logoutLink = document.getElementById("logout-btn");
        const popup = document.getElementById("logout-popup");
        const confirmBtn = document.getElementById("confirm-logout");
        const cancelBtn = document.getElementById("cancel-logout");
        const logoutForm = document.getElementById("logout-form");

        if (logoutLink) {
            logoutLink.addEventListener("click", function (e) {
                e.preventDefault();
                popup.style.display = "flex";
            });
        }
        if (confirmBtn && logoutForm) {
            confirmBtn.addEventListener("click", function () {
                // GỌI ĐÚNG POST /logout
                logoutForm.submit();
            });
        }
        if (cancelBtn) {
            cancelBtn.addEventListener("click", function () {
                popup.style.display = "none";
            });
        }

        // ===== Notifications dropdown =====
        const notifBtn = document.getElementById("notif-btn");
        const notifBox = document.getElementById("notif-box");

        if (notifBtn && notifBox) {
            notifBtn.addEventListener("click", function (e) {
                e.preventDefault();
                const isOpen = notifBox.style.display === "block";
                notifBox.style.display = isOpen ? "none" : "block";
                notifBtn.setAttribute("aria-expanded", (!isOpen).toString());
            });

            // click bên ngoài sẽ đóng dropdown
            document.addEventListener("click", function(e) {
                if (!notifBox.contains(e.target) && !notifBtn.contains(e.target)) {
                    notifBox.style.display = "none";
                    notifBtn.setAttribute("aria-expanded", "false");
                }
            });

            // ESC để đóng
            document.addEventListener("keydown", function(e) {
                if (e.key === "Escape") {
                    notifBox.style.display = "none";
                    notifBtn.setAttribute("aria-expanded", "false");
                }
            });
        }

        // Debug nhanh nếu vẫn không chạy:
        // console.log('notifBtn:', !!notifBtn, 'notifBox:', !!notifBox);
    });
</script>
@endpush

