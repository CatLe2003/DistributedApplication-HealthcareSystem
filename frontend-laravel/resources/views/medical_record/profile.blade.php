<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Patient Profile - LifeCare')</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<script src="{{ asset('assets/js/function_patient.js') }}"></script>
<body>
    <div class="container">
        @include('components.header_patient')
    </div>
    
    <!-- Main -->
    <div class="main-container">
        <section class="profile-container">
            <div class="profile-header">
                <img src="" alt="" class="profile-avatar">
                <h2 class="profile-name">John Smith</h2>
            </div>

            <div class="profile-content">
                <div class="profile-section user-details">
                    <div class="section-header">
                        <h3>User details</h3>
                        <a href="{{ url('medical_record/update_profile') }}" class="edit-profile">Edit profile</a>
                    </div>
                    <p class="user-detail"><strong>Gender: </strong>Male</p>
                    <p class="user-detail"><strong>Phone Number: </strong>094543545</p>
                    <p class="user-detail"><strong>Citizen ID: </strong>830534546785</p>
                    <p class="user-detail"><strong>Date of Birth: </strong>20/08/2025</p>
                    <p class="user-detail"><strong>Address: </strong>12 ABC Street</p>
                    <p class="user-detail"><strong>Nationality: </strong>Vietnam</p>
                    <p class="user-detail"><strong>Occupation: </strong>Neet</p>
                    <p class="user-detail"><strong>Ethnicity: </strong>...</p>
                    <p class="user-detail"><strong>Allergry: </strong>...</p>
                    <p class="user-detail"><strong>Email address: </strong><a class="edit-profile"
                            href="mailto:john.smith@example.com">john.smith@example.com</a></p>
                </div>

                <div class="profile-section article-details">
                    <div class="topic">
                        <h3 class="subtopic-header">Your Appointments</h3>
                        <a href="{{ url('appointment/list_appts') }}" class="edit-profile">View All &gt;&gt;</a>
                    </div>

                    <div class="record-grid">
                        <a href="{{ url('appointment/detail_appt') }}" class="record-card">
                            <div class="record-title">15/08/2025 (8:00 - 8:30)</div>
                            <p class="paper-detail-description"><strong>Department:</strong> Tai Mũi Họng</p>
                            <p class="paper-detail-description"><strong>Doctor:</strong> BS. Nguyễn Văn Chung</p>
                            <p class="paper-detail-description"><strong>Status:</strong> New</p>
                        </a>

                        <a href="{{ url('appointment/detail_appt') }}" class="record-card">
                            <div class="record-title">14/08/2025 (8:00 - 8:30)</div>
                            <p class="paper-detail-description"><strong>Department:</strong> Tai Mũi Họng</p>
                            <p class="paper-detail-description"><strong>Doctor:</strong> BS. Nguyễn Văn Chung</p>
                            <p class="paper-detail-description"><strong>Status:</strong> New</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient')

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>
</html>
