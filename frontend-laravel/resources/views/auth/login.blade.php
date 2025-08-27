{{-- Frontend/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Login - LifeCare' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="login-body">

<div class="login-container">
    <div class="logo-box">
        <img src="{{ asset('assets/images/smile-2_removebg.png') }}" alt="logo">
        <h1>LifeCare</h1>
    </div>

    {{-- Thông báo / lỗi --}}
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom:12px">
            <ul style="margin:0; padding-left:18px">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <label class="login-field" for="login-key">Login Key</label>
        <input class="input-field"
               type="text"
               id="login_key"
               name="login_key"
               value="{{ old('login_key') }}"
               placeholder="Please enter your phone number"
               required autofocus>

        <label class="login-field" for="password">Password</label>
        <input class="input-field"
               type="password"
               id="password"
               name="password"
               placeholder="Please enter your password"
               required>

        <div class="login-buttons">
            <a href="{{ url('register') }}" class="btn-outline">Register</a>
            <button type="submit" class="btn-primary">Login</button>
        </div>

        <div class="forgot-password">
            <a href="{{-- url('password.request') --}}">Forgot password</a>
        </div>
    </form>
</div>

</body>
</html>
