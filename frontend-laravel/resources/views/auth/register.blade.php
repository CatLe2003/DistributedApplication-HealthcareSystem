{{-- Frontend/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Register - LifeCare' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="login-body">

<div class="login-container">
    <div class="logo-box">
        <h1>Welcome to LifeCare</h1>
    </div>

    {{-- Hiển thị lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom:12px">
            <ul style="margin:0; padding-left:18px">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="login-form" method="POST" action="{{ route('register') }}">
        @csrf
        <label class="login-field" for="login_key">Login Key</label>
        <input class="input-field" type="text" id="login_key" name="login_key"
               value="{{ old('login_key') }}" placeholder="Please enter your phone number" required>

        <label class="login-field" for="password">Password</label>
        <input class="input-field" type="password" id="password" name="password"
               placeholder="Please enter your password" value="{{ old('password') }}" required>

        <input type="hidden" name="role" value="PATIENT">
        <div class="login-buttons">
            <a href="{{ url('login') }}" class="btn-outline">Back</a>
            <button type="submit" class="btn-primary">Register</button>
        </div>
    </form>
</div>

</body>
</html>
