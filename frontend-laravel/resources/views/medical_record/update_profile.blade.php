<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Update Profile - LifeCare')</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">
</head>
<script src="{{ asset('assets/js/function_patient.js') }}"></script>

<body>
    <div class="container">
        @include('components.header_patient')
    </div>

    <!-- Main -->
    <div class="main-container">
        <section class="paper-list-container">
            <h2 class="paper-list-title">Edit Profile</h2>
            <hr class="breakline">
            
            @if(session('success'))
                <div class="alert alert-success" id="profile-alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" id="profile-alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="search-form">
                @csrf
                <div class="profile-header">
                    <img src="" alt="" class="profile-avatar" id="avatar-preview">
                    <!-- <input type="file" id="upload-photo" accept="image/*" hidden>
                    <button type="button" class="btn-primary"
                        onclick="document.getElementById('upload-photo').click()">New photo</button> -->
                </div>

                <div class="search-row">
                    <label class="form-label" for="fullname">Fullname</label>
                    <input type="text" id="fullname" class="input-field" name="full_name" value="John Smith">
                </div>

                <div class="search-row">
                    <label class="form-label" for="gender">Gender</label>
                    <select id="gender" name="gender" class="input-field">
                        <option value="Male" selected>Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="search-row">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone_number" class="input-field" value="094543545">
                </div>

                <div class="search-row">
                    <label class="form-label" for="citizen">Citizen ID</label>
                    <input type="text" id="citizen" name="citizen_id" class="input-field" value="830534546785">
                </div>

                <div class="search-row">
                    <label class="form-label" for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="date_of_birth" class="input-field" value="2025-08-20">
                </div>

                <div class="search-row">
                    <label class="form-label" for="address">Address</label>
                    <input type="text" id="address" name="address" class="input-field" value="12 ABC Street">
                </div>

                <div class="search-row">
                    <label class="form-label" for="nationality">Nationality</label>
                    <input type="text" id="nationality" name="nationality" class="input-field" value="Vietnam">
                </div>

                <div class="search-row">
                    <label class="form-label" for="occupation">Occupation</label>
                    <input type="text" id="occupation" name="occupation" class="input-field" value="Neet">
                </div>

                <div class="search-row">
                    <label class="form-label" for="ethnicity">Ethnicity</label>
                    <input type="text" id="ethnicity" name="ethnicity" class="input-field" value="">
                </div>

                <div class="search-row">
                    <label class="form-label" for="allergy">Allergy</label>
                    <input type="text" id="allergy" name="allergy" class="input-field" value="">
                </div>

                <div class="search-row">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="input-field" value="john.smith@example.com">
                </div>

                <div class="login-buttons">
                    <button type="submit" class="btn-primary">Update</button>
                    <a href="{{ url('medical_record/profile') }}" type="button" class="btn-outline">Cancel</a>
                </div>
            </form>
        </section>
    </div>

    @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient')

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>

</html>