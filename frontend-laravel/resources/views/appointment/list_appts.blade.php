<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Book An Appointment - LifeCare')</title>
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
            <h2 class="paper-list-title">Your Appointments</h2>
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

            <div class="record-grid">
                @forelse($appointments as $appt)
                    <a href="{{ url('appointment/detail_appt/' . $appt['AppointmentID']) }}" class="record-card">
                        <div class="record-title">
                            {{ \Carbon\Carbon::parse($appt['AppointmentDate'])->format('d/m/Y') }}
                            ({{ $appt['TimeSlotID'] ?? 'N/A' }}) <!--change to TimeSlot if possible-->
                        </div>
                        <p class="paper-detail-description"><strong>Department:</strong>
                            {{ $appt['DepartmentID'] ?? 'N/A' }}</p>
                        <p class="paper-detail-description"><strong>Doctor:</strong> {{ $appt['DoctorID'] ?? 'N/A' }}</p>
                        <p class="paper-detail-description"><strong>Status:</strong> {{ ucfirst($appt['Status']) }}</p>
                    </a>
                @empty
                    <p>No appointments found.</p>
                @endforelse
            </div>

            <!-- Go Back Button -->
            <div class="search-btn-wrapper">
                <a href="{{ url('medical_record/profile') }}" type="submit" class="btn-outline p-center">
                    Back
                </a>
            </div>
        </section>
    </div>

    @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient')

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>

</html>