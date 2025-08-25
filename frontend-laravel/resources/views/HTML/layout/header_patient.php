<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Paper - LifeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                <a class="nav-item" href="#">Homepage</a>
                <a class="nav-item" href="#">Departments</a>
                <a class="nav-item" href="#">About</a>
            </div>
            <div class="nav-right">
                <!-- <a href="index.php?action=login" class="btn-header">Login</a> -->

                <!-- If login -->
                <a href="index.php?action=add-paper" class="btn-primary">Book an appointment</a>
                <div class="user-dropdown">
                    <div class="user-info">
                        <div class="avatar-circle"></div>
                        <span class="username">Username</span>
                    </div>
                    <div class="dropdown-user">
                        <a href="index.php?action=profile">Profile</a>
                        <a href="index.php?action=logout">Logout</a>
                    </div>
                </div>
            </div>

        </header>
    </div>
