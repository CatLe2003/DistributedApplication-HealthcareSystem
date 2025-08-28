<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Medical Records - LifeCare')</title>
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
            <h2 class="paper-list-title">Phiếu khám</h2>
            <hr class="breakline">
            {{-- Show message if no records --}}
            @if(empty($medical_visits) || count($medical_visits) === 0)
                <div class="info-box">
                    Bạn chưa có bệnh án nào. Vui lòng <a href="{{ url('appointment/add_appt') }}" class="link">đặt lịch
                        khám</a>.
                </div>
            @endif

            {{-- Medical Records --}}
            @if(!empty($medical_visits) && count($medical_visits) > 0)
                <div class="record-grid">
                    @foreach($medical_visits as $visit)
                        <a href="{{ url('medical_record/detail_medrecord/' . $visit['id']) }}" class="record-card" tabindex="0"
                            data-date="{{ \Carbon\Carbon::parse($visit['visit_date'])->format('d/m/Y (H:i)') }}"
                            data-dept="{{ $visit['department_name'] ?? 'N/A' }}"
                            data-doctor="{{ $visit['doctor_name'] ?? 'N/A' }}" data-symptoms="{{ $visit['symptoms'] ?? '' }}"
                            data-diagnosis="{{ $visit['diagnosis'] ?? '' }}"
                            data-prescription="{{ $visit['prescription'] ?? '' }}" data-tests="{{ $visit['tests'] ?? '' }}"
                            data-notes="{{ $visit['notes'] ?? '' }}">

                            <div class="record-title">Khám ngày
                                {{ \Carbon\Carbon::parse($visit['visit_date'])->format('d/m/Y') }}</div>
                            <p class="paper-detail-description"><strong>Department:</strong>
                                {{ $visit['department_name'] ?? 'N/A' }}</p>
                            <p class="paper-detail-description"><strong>Doctor:</strong> {{ $visit['doctor_name'] ?? 'N/A' }}
                            </p>
                            <p class="paper-detail-description"><strong>Visit Date:</strong>
                                {{ \Carbon\Carbon::parse($visit['visit_date'])->format('d/m/Y (H:i)') }}</p>
                        </a>
                    @endforeach
                </div>
            @endif

            <ul class="pagination">
                <li><a href="#">«</a></li>
                <li><a class="active" href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
            </ul>

        </section>
    </div>

    @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient')

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>

</html>