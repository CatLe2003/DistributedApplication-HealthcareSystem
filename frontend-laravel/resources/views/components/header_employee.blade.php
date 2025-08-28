{{-- resources/views/components/header_employee.blade.php --}}
<nav class="navbar navbar-top navbar-expand-md">
    <div class="container container-header">
        <a href="{{-- url('layouts/...') --}}" class="h4 container__dashboard-name">SYSTEM EMPLOYEE DASHBOARD</a>

        <li class="navbar-user">
            <img src="http://localhost/RestaurantPOS/Restro/admin/assets/img/theme/user-a-min.png" alt=""
                class="navbar-user-img">
            <span class="navbar-user-name">{{ session('login_key') ?? 'Guest' }} (ID: {{ session('user_id') }})</span>

            <ul class="navbar-user-menu">
                <li class="navbar-nav__item">
                    <a href="{{ url('profile_employee') }}" class="nav-item__link text-primary">
                        <i class="fa-solid fa-user nav-item__icon"></i>
                        <p class="nav-item__text">My profile</p>
                    </a>
                </li>

                <hr class="">

                <li class="navbar-nav__item">
                    <a href="{{ url('/login') }}" class="nav-item__link text-primary">
                        <i class="fa-solid fa-person-running nav-item__icon"></i>
                        <p class="nav-item__text">Logout</p>
                    </a>
                </li>
            </ul>
        </li>
    </div>
</nav>
