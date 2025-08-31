<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Patient Profile - LifeCare')</title>
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
        <section class="profile-container">
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
            <div class="profile-header">
                <img src="" alt="" class="profile-avatar">
                <h2 class="profile-name">{{ $profile['full_name'] }}</h2>
            </div>

            <div class="profile-content">
                <div class="profile-section user-details">
                    <div class="section-header">
                        <h3>User details</h3>
                        <a href="{{ url('medical_record/update_profile') }}" class="edit-profile">Edit profile</a>
                    </div>
                    <p class="user-detail"><strong>Full Name: </strong>{{ $profile['full_name'] ?? 'N/A' }}</p>
                    <p class="user-detail"><strong>Gender: </strong>{{ $profile['gender'] ?? 'N/A' }}</p>
                    <p class="user-detail"><strong>Phone Number: </strong>{{ $profile['phone_number'] ?? 'N/A' }}</p>
                    <p class="user-detail"><strong>Citizen ID: </strong>{{ $profile['citizen_id'] ?? 'N/A' }}</p>
                    <p class="user-detail"><strong>Date of Birth: </strong>{{ $profile['date_of_birth'] ?? 'N/A' }}</p>
                    <p class="user-detail"><strong>Address: </strong>{{ $profile['address'] ?? 'N/A' }}</p>
                    <p class="user-detail"><strong>Nationality: </strong>{{ $profile['nationality'] ?? 'N/A' }}</p>
                    <p class="user-detail"><strong>Occupation: </strong>{{ $profile['occupation'] ?? 'N/A' }}</p>
                    <p class="user-detail"><strong>Ethnicity: </strong>{{ $profile['ethnicity'] ?? 'N/A' }}</p>
                    <p class="user-detail"><strong>Allergy: </strong>{{ $profile['allergy'] ?? 'N/A' }}</p>
                    <p class="user-detail">
                        <strong>Email address: </strong>
                        <a class="edit-profile" href="mailto:{{ $profile['email'] ?? '' }}">
                            {{ $profile['email'] ?? 'N/A' }}
                        </a>
                    </p>
                </div>

                <div class="profile-section article-details">
                    <div class="topic">
                        <h3 class="subtopic-header">Your Appointments</h3>
                        <a href="{{ url('appointment/list_appts') }}" class="edit-profile">View All &gt;&gt;</a>
                    </div>

                    <div class="record-grid">
                        @forelse($appointments as $appt)
                            <a href="{{ url('appointment/detail_appt/' . $appt['AppointmentID']) }}" class="record-card">
                                <div class="record-title"> Meeting on
                                    {{ \Carbon\Carbon::parse($appt['AppointmentDate'])->format('d/m/Y') }}
                                    ({{ $appt['TimeSlotID'] ?? 'N/A' }}) <!--change to TimeSlot if possible-->
                                </div>
                                <p class="paper-detail-description"><strong>Department:</strong>
                                    {{ $appt['DepartmentName'] ?? 'N/A' }}</p>
                                <p class="paper-detail-description"><strong>Doctor:</strong>
                                    {{ $appt['DoctorName'] ?? 'N/A' }}</p>
                                <p class="paper-detail-description"><strong>Status:</strong> {{ ucfirst($appt['Status']) }}
                                </p>
                            </a>
                        @empty
                            <p>No appointments found.</p>
                        @endforelse
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