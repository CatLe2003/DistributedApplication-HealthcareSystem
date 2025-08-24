<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'LifeCare' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="nav-container">
            <div class="nav-left">
                <img src="/Frontend/assets/images/smile-2_removebg.png" alt="Smile.png" class="nav-header__logo">
                <h1 class="nav-header__name">LifeCare</h1>
            </div>
            <div class="nav-items">
                <a class="nav-item" href="homepage.html">Homepage</a>
                <a class="nav-item" href="list_departments.html">Services</a>
                <a class="nav-item" href="#">About</a>
            </div>
            <div class="nav-right">
                <!-- If is guest -->
                <!-- <a href="index.php?action=login" class="btn-header">Login</a> -->

                <!-- If login -->
                <a href="../appt/add_appt.html" class="btn-primary">Book an appointment</a>
                <div class="user-dropdown">
                    <div class="user-info">
                        <div class="avatar-circle"></div>
                        <span class="username">Username</span>
                    </div>
                    <div class="dropdown-user">
                        <a href="profile.html">
                            <i class="fa-solid fa-file-invoice nav-item__icon"></i>
                            Profile
                        </a>

                        <a href="../patient/medical_records.html">
                            <i class="fa-solid fa-notes-medical nav-item__icon"></i>
                            Medical Records
                        </a>

                        <a href="javascript:void(0)" id="logout-btn">
                            <i class="fa-solid fa-right-from-bracket nav-item__icon"></i>
                            Logout
                        </a>
                    </div>
                </div>
                <!-- Logout Confirmation Popup -->
                <div id="logout-popup" class="popup-overlay">
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
    </div>