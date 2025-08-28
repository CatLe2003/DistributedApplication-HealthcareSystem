<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'List Appointment - LifeCare')</title>
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
            <h2 class="paper-list-title">Detail Medical Record</h2>
            <hr class="breakline">

            <div class="info-box">
                <div class="record-title">Visit on
                    {{ \Carbon\Carbon::parse($medicalVisit['visit_date'])->format('d/m/Y') }}
                </div>
                <p class="paper-detail-description"><strong>Department:</strong>
                    {{ $medicalVisit['department_name'] ?? 'N/A' }}</p>
                <p class="paper-detail-description"><strong>Doctor:</strong> {{ $medicalVisit['doctor_name'] ?? 'N/A' }}
                </p>
                <p class="paper-detail-description"><strong>Visit Date:</strong>
                    {{ \Carbon\Carbon::parse($medicalVisit['visit_date'])->format('d/m/Y (H:i)') }}</p>
                <p class="paper-detail-description"><strong>Symptoms:</strong> {{ $medicalVisit['symptoms'] ?? 'N/A' }}
                </p>
                <p class="paper-detail-description"><strong>Diagnosis:</strong>
                    {{ $medicalVisit['diagnosis'] ?? 'N/A' }}
                </p>
                <p class="paper-detail-description"><strong>Notes:</strong> {{ $medicalVisit['notes'] ?? 'N/A' }}
                </p>
            </div>

            <!-- KẾT QUẢ TETST -->
            <div class="container">
                <div class="container-recent">
                    <div class="card shadow">
                        <div class="container-recent__heading">
                            <p class="recent__heading-title">Test Result</p>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">Test</th>
                                        <th class="text-column" scope="col">Date</th>
                                        <th class="text-column" scope="col">Status</th>
                                        <th class="text-column" scope="col">Result</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @forelse($orders as $order)
                                        <tr>
                                            <th class="text-column-emphasis" scope="row">
                                                {{ $order['test_id'] ?? 'N/A' }}</th>
                                            <th class="text-column" scope="row">
                                                {{ \Carbon\Carbon::parse($order['order_date'])->format('d/m/Y (H:i)') ?? 'N/A' }}
                                            </th>
                                            <th class="text-column" scope="row">
                                                {{ $order['status'] ?? 'N/A' }}</th>
                                            <th class="text-column" scope="row">
                                                {{ $order['result'] ?? 'N/A' }}</th>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No test orders available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <!-- TOA THUỐC -->
            <div class="container">
                <div class="container-recent">
                    <div class="card shadow">
                        <div class="container-recent__heading">
                            <p class="recent__heading-title">Prescription</p>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">Medicine</th>
                                        <th class="text-column" scope="col">Dosage</th>
                                        <th class="text-column" scope="col">Duration</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @forelse($prescriptions as $prescription)
                                        @forelse($prescription['details'] as $detail)
                                            <tr>
                                                <th class="text-column-emphasis" scope="row">
                                                    {{ $detail['medicine_name'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $detail['dosage'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $detail['duration'] ?? 'N/A' }}</th>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No medicine details available.</td>
                                            </tr>
                                        @endforelse
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No prescriptions available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- KẾT QUẢ FOLLOW UP -->
            <div class="container">
                <div class="container-recent">
                    <div class="card shadow">
                        <div class="container-recent__heading">
                            <p class="recent__heading-title">Follow Up</p>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column" scope="col">Date</th>
                                        <th class="text-column" scope="col">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @forelse($followups as $followup)
                                        <tr>
                                            <th class="text-column" scope="row">
                                                {{ \Carbon\Carbon::parse($followup['date'])->format('d/m/Y (H:i)') ?? 'N/A' }}</th>
                                            <th class="text-column" scope="row">
                                                {{ $followup['notes'] ?? 'N/A' }}</th>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No follow-up information available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login-buttons">
                <a href="{{ url('medical_record/medical_records') }}" type="submit" class="btn-outline">Back</a>
            </div>

        </section>
    </div>

    @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient')

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>

</html>