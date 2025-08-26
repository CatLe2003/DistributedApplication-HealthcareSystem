<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Payment Confirmation - LifeCare')</title>
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
        <section class="payment-container">
            <h2 class="paper-list-title">Payment Confirmation</h2>
            <hr class="breakline">

            <!-- Appointment Details -->
            <div class="info-box">
                <h3>Appointment Details</h3>
                <p class="paper-detail-description"><strong>Department: </strong>Tai-Mũi-Họng</p>
                <p class="paper-detail-description"><strong>Doctor: </strong>Dr. Chung</p>
                <p class="paper-detail-description"><strong>Date: </strong>20/08/2025</p>
                <p class="paper-detail-description"><strong>Time: </strong>09:30</p>
                <p class="paper-detail-description"><strong>Room: </strong>203A</p>
            </div>

            <!-- Payment Details -->
            <div class="info-box">
                <h3>Payment Details</h3>
                <p class="paper-detail-description"><strong>Consultation Fee: </strong>300.000 VNĐ</p>

                <p class="paper-detail-description"><strong>Payment Method</strong></p>
                <select class="input-field">
                    <option>Credit/Debit Card</option>
                    <option>MoMo</option>
                    <option>VNPay</option>
                </select>
            </div>

            <!-- Confirm Button -->
            <div class="search-btn-wrapper">
                <button type="submit" class="btn-primary p-center">
                    Confirm & Pay
                </button>
            </div>
        </section>
    </div>
    <!-- Payment Success Popup -->
    <div id="payment-popup" class="popup-overlay">
        <div class="popup-box">
            <h3 class="paper-list-title">Payment Successful</h3>
            <p class="paper-detail-description">Your appointment has been booked successfully!</p>
            <button id="close-popup" class="btn-primary">OK</button>
        </div>
    </div>

    @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient')

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>
</html>
