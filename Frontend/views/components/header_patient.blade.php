<header class="nav-container">
    <div class="nav-left">
        <img src="{{ asset('Frontend/views/assets/images/smile-2_removebg.png') }}" alt="Smile.png" class="nav-header__logo">
        <h1 class="nav-header__name">LifeCare</h1>
    </div>

    <div class="nav-items">
        <a class="nav-item" href="{{ url('homepage') }}">Homepage</a>
        <a class="nav-item" href="{{ url('list_departments') }}">Services</a>
        <a class="nav-item" href="#">About</a>
    </div>
    
    <!-- If is guest -->
    <!-- <a href="index.php?action=login" class="btn-header">Login</a> -->
    
    <div class="nav-right">
        <a href="{{ url('appointment/add_appt') }}" class="btn-primary">Book an appointment</a>

        <div class="user-dropdown">
            <div class="user-info">
                <div class="avatar-circle"></div>
                <span class="username">{{ Auth::user()->name ?? 'Username' }}</span>
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
    </div>
</header>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const logoutLink = document.getElementById("logout-btn");
    const popup = document.getElementById("logout-popup");
    const confirmBtn = document.getElementById("confirm-logout");
    const cancelBtn = document.getElementById("cancel-logout");

    if (logoutLink) {
        logoutLink.addEventListener("click", function (e) {
            e.preventDefault();
            popup.style.display = "flex";
        });
    }
    if (confirmBtn) {
        confirmBtn.addEventListener("click", function () {
            // đổi sang route logout của bạn (POST) nếu dùng Laravel Auth
            window.location.href = "{{ url('login') }}";
        });
    }
    if (cancelBtn) {
        cancelBtn.addEventListener("click", function () {
            popup.style.display = "none";
        });
    }
});
</script>
@endpush
