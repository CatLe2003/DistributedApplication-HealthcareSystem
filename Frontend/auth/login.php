<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - LifeCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/assets/css/style.css">
</head>
<body class="login-body">

    <div class="login-container">
        <div class="logo-box">
            <img src="/Frontend/assets/images/smile-2_removebg.png" alt="logo">
            <h1>LifeCare</h1>
        </div>

        <form class="login-form">
            <label class="login-field" for="phone_number">Username</label>
            <input class="input-field" type="text" id="phone_number" placeholder="Please enter your number phone" required>

            <label class="login-field" for="password">Password</label>
            <input class="input-field" type="password" id="password" placeholder="Please enter your password" required>

            <div class="login-buttons">
              <button type="button" class="btn-outline">Register</button>
              <button type="submit" class="btn-primary">Login</button>
            </div>

            <div class="forgot-password">
              <a href="#">Forgot password</a>
            </div>
          </form>
    </div>

</body>
</html>
