<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Book An Appointment - LifeCare')</title>
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
            <h2 class="paper-list-title">Detail Appointment</h2>
            <hr class="breakline">
            <form action="">
                <div class="info-box">
                    <h3>Khám ngày 15/08/2025</h3>
                    <p class="paper-detail-description"><strong>Department: </strong>Tai Mũi Họng</p>
                    <p class="paper-detail-description"><strong>Doctor: </strong>Dr. Nguyễn Văn Chung</p>
                    <p class="paper-detail-description"><strong>Time Slot: </strong>8:00 - 8:30</p>
                    <p class="paper-detail-description"><strong>Transaction: </strong>12</p>
                    <p class="paper-detail-description"><strong>Status: </strong>New</p>
                </div>
                <div class="login-buttons">
                    <button type="button" class="btn-primary">Cancel Appointment</button>
                    <a href="{{ url('medical_record/profile') }}" type="submit" class="btn-outline">Close</a>
                </div>

            </form>
        </section>
    </div>

    {{-- @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient') --}}

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>
</html>
