<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'LifeCare' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        @include('components.header_patient')
    </div>

    <div class="main-container">
        {{-- Nội dung của trang bệnh nhân --}}
        <section class="intro-section">
            <div class="intro-left">
                <h2>Book appointments quickly – Manage your records easily</h2>
                <p>Access your medical information anytime, anywhere.</p>
                <a href="{{ url('appt/add_appt') }}" class="btn-primary">Book an appointment</a>
            </div>
            <div class="intro-right">
                <img src="{{ asset('Frontend/assets/images/banner.png') }}" alt="Banner image">
            </div>
        </section>

        <section class="topic-section">
            <div class="topic-header">
                Popular Services
                <a href="{{ url('list_departments') }}" class="view-all">View All &gt;&gt;</a>
            </div>
            <hr class="breakline">
            <div class="topic"><h class="subtopic-header"></h></div>

            <div class="info-box">
                <h3>Tai Mũi Họng</h3>
                <p class="paper-detail-description"><strong>Description: </strong>Khám tai-mũi-họng</p>
            </div>
        </section>
    </div>

    @include('components.footer_patient')
</body>
</html>
