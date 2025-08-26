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

    <form class="login-form" method="POST" action="{{-- route('register') --}}">

        <label class="login-field" for="fullname">Fullname</label>
        <input class="input-field" type="text" id="fullname" name="fullname"
               value="{{ old('fullname') }}" placeholder="Please enter your fullname" required>

        <label class="login-field" for="phone_number">Phone Number</label>
        <input class="input-field" type="text" id="phone_number" name="phone_number"
               value="{{ old('phone_number') }}" placeholder="Please enter your number phone" required>

        <label class="login-field" for="email">Email</label>
        <input class="input-field" type="email" id="email" name="email"
               value="{{ old('email') }}" placeholder="Please enter your email" required>

        <label class="login-field" for="dob">Day of Birth</label>
        <input type="date" id="dob" name="dob" class="input-field" value="{{ old('dob') }}">

        <label class="login-field" for="gender">Gender</label>
        <select id="gender" name="gender" class="input-field">
            <option value="male"   @selected(old('gender')==='male')>Male</option>
            <option value="female" @selected(old('gender')==='female')>Female</option>
        </select>

        <div class="login-buttons">
            <a href="{{ url('login') }}" class="btn-outline">Back</a>
            <button type="submit" class="btn-primary">Register</button>
        </div>
    </form>
</div>

</body>
</html>
