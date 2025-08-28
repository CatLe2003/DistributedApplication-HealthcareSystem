{{-- resources/views/components/sidebar_employee.blade.php --}}
<aside class="navbar navbar-vertical navbar-expand-md">
    <div class="container">
        <a href="{{ url('dashboard_doctor') }}" class="navbar__header">
            <img src="{{ asset('assets/images/smile-2_removebg.png') }}" alt="Smile.png" class="navbar-header__logo">
            <h1>LifeCare</h1>
        </a>

        <hr class="navbar__divider">
        
        <!-- Navigation -->
        <div class="navbar__collapse">
            <ul class="navbar-nav">
                <li class="navbar-nav__item">
                    <a href="{{ url('dashboard_doctor') }}" class="nav-item__link text-primary">
                        <i class="fa-solid fa-tv nav-item__icon"></i>
                        <p class="nav-item__text">Dashboard</p>
                    </a>
                </li>
                <!-- Dentist Only -->
                <li class="navbar-nav__item">
                    <a href="{{ url('patient_management') }}" class="nav-item__link text-primary">
                        <i class="fa-solid fa-bed-pulse nav-item__icon"></i>
                        <p class="nav-item__text">Patients</p>
                    </a>
                </li>
                <li class="navbar-nav__item">
                    <a href="{{ url('schedule_management') }}" class="nav-item__link text-primary">
                        <i class="fa-solid fa-calendar-check nav-item__icon"></i>
                        <p class="nav-item__text">Schedule Management</p>
                    </a>
                </li>
                <!-- Staff Only -->
                <li class="navbar-nav__item">
                    <a href="{{ url('prescriptions') }}" class="nav-item__link text-primary">
                        <i class="fa-solid fa-pills nav-item__icon"></i>
                        <p class="nav-item__text">Prescriptions</p>
                    </a>
                </li>
                <li class="navbar-nav__item">
                    <a href="{{ url('appointment_management') }}" class="nav-item__link text-primary">
                        <i class="fa-solid fa-calendar-check nav-item__icon"></i>
                        <p class="nav-item__text">Appointments</p>
                    </a>
                </li>
                <!-- Admin Only -->
                <li class="navbar-nav__item">
                    <a href="{{ url('medicine_management') }}" class="nav-item__link text-primary">
                        <i class="fa-solid fa-pills nav-item__icon"></i>
                        <p class="nav-item__text">Medicines</p>
                    </a>
                </li>
                <li class="navbar-nav__item">
                    <a href="{{ url('statistical_report') }}" class="nav-item__link text-primary">
                        <i class="fa-solid fa-file-invoice nav-item__icon"></i>
                        <p class="nav-item__text">Statistical Report</p>
                    </a>
                </li>
            </ul>

            <hr class="navbar__divider">

            <ul class="navbar-nav mb-md-3">
                <li class="navbar-nav__item">
                    <a href="{{ url('login') }}" class="nav-item__link text-danger">
                        <i class="fa-solid fa-right-from-bracket nav-item__icon"></i>
                        <p class="nav-item__text">Log Out</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
