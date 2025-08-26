<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','List Appointment - LifeCare')</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('Frontend/assets/css/style.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<script src="{{ asset('Frontend/assets/js/function_patient.js') }}"></script>

<body>
    {{-- <div class="container">
        @include('components.header_patient')
    </div> --}}
    
    <!-- Main -->
    <div class="main-container">
        <section class="paper-list-container">
            <h2 class="paper-list-title">Your Appointments</h2>
            <hr class="breakline">

            <!-- Appointments -->
            <div class="record-grid">
                <a href="../appointment/detail_appt.blade.php" class="record-card">
                    <div class="record-title">15/08/2025 (8:00 - 8:30)</div>
                    <p class="paper-detail-description"><strong>Department:</strong> Tai Mũi Họng</p>
                    <p class="paper-detail-description"><strong>Doctor:</strong> BS. Nguyễn Văn Chung</p>
                    <p class="paper-detail-description"><strong>Status:</strong> New</p>
                </a>

                <a href="../appointment/detail_appt.blade.php" class="record-card">
                    <div class="record-title">14/08/2025 (8:00 - 8:30)</div>
                    <p class="paper-detail-description"><strong>Department:</strong> Tai Mũi Họng</p>
                    <p class="paper-detail-description"><strong>Doctor:</strong> BS. Nguyễn Văn Chung</p>
                    <p class="paper-detail-description"><strong>Status:</strong> New</p>
                </a>
            </div>

            <!-- Go Back Button -->
            <div class="search-btn-wrapper">
                <a href="{{ url('medical_record/profile') }}" type="submit" class="btn-outline p-center">
                    Back
                </a>
            </div>
        </section>
    </div>

    {{-- @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient') --}}

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>
</html>
