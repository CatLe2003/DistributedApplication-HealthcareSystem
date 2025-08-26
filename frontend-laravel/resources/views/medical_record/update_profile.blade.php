<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Update Profile - LifeCare')</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('Frontend/assets/css/style.css') }}"> --}}
    <link rel="stylesheet" href="Frontend/views/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<script src="{{ asset('Frontend/assets/js/function_patient.js') }}"></script>
<body>
    <div class="container">
       {{--  @include('components.header_patient') --}}
    </div>

    <!-- Main -->
    <div class="main-container">
        <section class="paper-list-container">
            <h2 class="paper-list-title">Edit Profile</h2>
            <hr class="breakline">

            <form class="search-form">
                <div class="profile-header">
                    <img src="" alt="" class="profile-avatar" id="avatar-preview">
                    <!-- <input type="file" id="upload-photo" accept="image/*" hidden>
                    <button type="button" class="btn-primary"
                        onclick="document.getElementById('upload-photo').click()">New photo</button> -->
                </div>

                <div class="search-row">
                    <label class="form-label" for="fullname">Fullname</label>
                    <input type="text" id="fullname" class="input-field" value="John Smith">
                </div>

                <div class="search-row">
                    <label class="form-label" for="gender">Gender</label>
                    <select id="gender" class="input-field">
                        <option value="Male" selected>Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="search-row">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="text" id="phone" class="input-field" value="094543545">
                </div>

                <div class="search-row">
                    <label class="form-label" for="citizen">Citizen ID</label>
                    <input type="text" id="citizen" class="input-field" value="830534546785">
                </div>

                <div class="search-row">
                    <label class="form-label" for="dob">Date of Birth</label>
                    <input type="date" id="dob" class="input-field" value="2025-08-20">
                </div>

                <div class="search-row">
                    <label class="form-label" for="address">Address</label>
                    <input type="text" id="address" class="input-field" value="12 ABC Street">
                </div>

                <div class="search-row">
                    <label class="form-label" for="nationality">Nationality</label>
                    <input type="text" id="nationality" class="input-field" value="Vietnam">
                </div>

                <div class="search-row">
                    <label class="form-label" for="occupation">Occupation</label>
                    <input type="text" id="occupation" class="input-field" value="Neet">
                </div>

                <div class="search-row">
                    <label class="form-label" for="ethnicity">Ethnicity</label>
                    <input type="text" id="ethnicity" class="input-field" value="">
                </div>

                <div class="search-row">
                    <label class="form-label" for="allergy">Allergy</label>
                    <input type="text" id="allergy" class="input-field" value="">
                </div>

                <div class="search-row">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" class="input-field" value="john.smith@example.com">
                </div>

                <div class="login-buttons">
                    <button type="submit" class="btn-primary">Update</button>
                    <a href="{{ url('medical_record/profile') }}" type="button" class="btn-outline">Cancel</a>
                </div>
            </form>
        </section>
    </div>

    {{-- @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient') --}}

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>
</html>
