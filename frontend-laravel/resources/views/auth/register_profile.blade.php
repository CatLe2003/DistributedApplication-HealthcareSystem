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

    <form class="login-form" method="POST" action="{{ route('profile.register') }}">
        @csrf
            <h3>Personal Information</h3>
            <label class="login-field" for="full_name">Full Name</label>
            <input class="input-field" type="text" id="full_name" name="full_name"
                   value="{{ old('full_name') }}" placeholder="Enter your full name" required>

            <label class="login-field" for="email">Email</label>
            <input class="input-field" type="email" id="email" name="email"
                   value="{{ old('email') }}" placeholder="Enter your email" required>

            <label class="login-field" for="phone">Phone</label>
            <input class="input-field" type="text" id="phone_number" name="phone_number"
                   value="{{ old('phone_number') }}" placeholder="Enter your phone number" required>

            <label class="login-field" for="gender">Gender</label>
            <select class="input-field" id="gender" name="gender" required>
                <option value="">Select gender</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>

            <label class="login-field" for="date_of_birth">Date of Birth</label>
            <input class="input-field" type="date" id="date_of_birth" name="date_of_birth"
                   value="{{ old('date_of_birth') }}" required>

            <label class="login-field" for="citizen_id">Citizen ID</label>
            <input class="input-field" type="text" id="citizen_id" name="citizen_id"
                   value="{{ old('citizen_id') }}" placeholder="Enter your citizen ID" required>

            <label class="login-field" for="address">Address</label>
            <input class="input-field" type="text" id="address" name="address"
                   value="{{ old('address') }}" placeholder="Enter your address" required>

            <label class="login-field" for="nationality">Nationality</label>
            <input class="input-field" type="text" id="nationality" name="nationality"
                   value="{{ old('nationality') }}" placeholder="Enter your nationality" required>

            <label class="login-field" for="ethnicity">Ethnicity</label>
            <input class="input-field" type="text" id="ethnicity" name="ethnicity"
                   value="{{ old('ethnicity') }}" placeholder="Enter your ethnicity" required>

            <label class="login-field" for="occupation">Occupation</label>
            <input class="input-field" type="text" id="occupation" name="occupation"
                   value="{{ old('occupation') }}" placeholder="Enter your occupation" required>

            <label class="login-field" for="allergy">Allergies</label>
            <input class="input-field" type="text" id="allergy" name="allergy"
                   value="{{ old('allergy') }}" placeholder="Enter your allergies (if any)">

        
        <div class="login-buttons">
            <a href="{{ url('login') }}" class="btn-outline">Back</a>
            <button type="submit" class="btn-primary">Register</button>
        </div>
    </form>
</div>

</body>
</html>
