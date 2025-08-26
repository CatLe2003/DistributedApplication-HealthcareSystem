<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Detail Appointment - LifeCare')</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('Frontend/assets/css/style.css') }}"> --}}
    {{-- <link rel="stylesheet" href="Frontend/views/assets/css/style.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<script src="{{ asset('Frontend/assets/js/function_patient.js') }}"></script>
<body>
    <div class="container">
        @include('components.header_patient')
    </div>

    <!-- Main -->
    <div class="main-container">
        <section class="paper-list-container">
            <h2 class="paper-list-title">Book An Appointment</h2>
            <hr class="breakline">

            <!-- Patient Check Section -->
            <div class="info-box">
                <h3>Patient Information</h3>
                <p class="paper-detail-description">Have you visited our hospital before?</p>
                <label class="paper-detail-description">
                    <input type="radio" name="patient_status" value="yes" checked>
                    Yes, I have
                </label>
                <label class="paper-detail-description">
                    <input type="radio" name="patient_status" value="no">
                    No, I’m a new patient
                </label>
            </div>

            <hr class="breakline">

            <form action="{{ url('appointment/payment_confirm }}" class="search-form">
                <div class="search-row">
                    <label class="form-label" for="keyword">Department</label>
                    <select id="department" class="input-field">
                        <option value>Tai-Mũi-Họng</option>
                    </select>
                </div>

                <div class="search-row">
                    <label class="form-label" for="author">Doctor</label>
                    <select id="conference" class="input-field">
                        <option value>Chung</option>
                    </select>
                </div>

                <div class="search-row date-row">
                    <div class="search-row">
                        <label class="form-label" for="Date">Date</label>
                        <input type="date" id="date" class="input-field">
                    </div>
                    <div class="search-row">
                        <label class="form-label" for="time">Time slot</label>
                        <select id="conference" class="input-field">
                            <option value>8:00 - 8:30</option>
                        </select>
                    </div>
                </div>

                <div class="search-btn-wrapper">
                    <button class="btn-primary p-center">
                        Book Appointment
                    </button>
                </div>
            </form>
        </section>
    </div>

    @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient')

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>
</html>
