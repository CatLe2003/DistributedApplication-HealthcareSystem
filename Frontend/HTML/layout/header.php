<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBB - Paper System</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="nav-container">
        <div class="nav-left">
            <img src="/assets/images/smile-2_removebg.png" alt="Smile.png" class="nav-header__logo">
            <h1 class="nav-header__name">BBB</h1>
        </div>
        <div class="nav-items">
            <a class="nav-item" href="#">Homepage</a>
            <a class="nav-item" href="#">Papers</a>
            <a class="nav-item" href="#">Search</a>
        </div>
        <div class="nav-right">
            <a href="#" class="btn-primary">Login</a>
        </div>
        <!-- If login -->
        <div class="nav-right">
            <a href="#" class="btn-primary">Add new paper</a>
        <div class="user-dropdown">
            <div class="user-info">
                <div class="avatar-circle"></div>
                <span class="username">Username</span>
            </div>
            <div class="dropdown-user" id="dropdownMenu">
                <a href="index.php?action=profile">Profile</a>
                <a href="index.php?action=logout">Logout</a>
            </div>
        </div>        
    </header>
</body>
</html>