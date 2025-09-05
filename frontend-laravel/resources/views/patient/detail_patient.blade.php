<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Prescription - LifeCare</title>
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Sidebar -->
    @include('components.sidebar_employee')
    <!-- Main content -->
    <div class="main-content">
        <div class="content">
            <!-- Top navbar -->
            @include('components.header_employee')
            <!-- Page content -->
            <div class="container">
                <div class="container-recent">
                    <div class="card shadow">
                        <div class="container-recent__heading">
                            <p class="recent__heading-title">Patient Detail</p>
                        </div>

                        <div class="container-recent__body card__body-form">
                            <!-- Patient Info -->
                            <div class="form-row">
                                <div class="form-row__flex">
                                    <div class="form-col">
                                        <label class="form-col__label">Full Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ $patient['full_name'] ?? '' }}" readonly>
                                    </div>
                                    <div class="form-col">
                                        <label class="form-col__label">Phone Number</label>
                                        <input type="text" class="form-control"
                                            value="{{ $patient['phone_number'] ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row__flex">
                                    <div class="form-col">
                                        <label class="form-col__label">Date of Birth</label>
                                        <input type="text" class="form-control"
                                            value="{{ $patient['date_of_birth'] ?? '' }}" readonly>
                                    </div>
                                    <div class="form-col">
                                        <label class="form-col__label">Gender</label>
                                        <input type="text" class="form-control" value="{{ $patient['gender'] ?? '' }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row__flex">
                                    <div class="form-col">
                                        <label for="" class="form-col__label">Address</label>
                                        <input type="text" name="address" class="form-control"
                                            value="{{ $patient['address'] ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row__flex">
                                    <div class="form-col">
                                        <label class="form-col__label">Occupation</label>
                                        <input type="text" class="form-control"
                                            value="{{ $patient['occupation'] ?? '' }}" readonly>
                                    </div>
                                    <div class="form-col">
                                        <label class="form-col__label">Nationality</label>
                                        <input type="text" class="form-control" value="{{ $patient['nationality'] ?? '' }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row__flex">
                                    <div class="form-col">
                                        <label class="form-col__label">Email</label>
                                        <input type="text" class="form-control"
                                            value="{{ $patient['email'] ?? '' }}" readonly>
                                    </div>
                                    <div class="form-col">
                                        <label class="form-col__label">Citizen ID</label>
                                        <input type="text" class="form-control" value="{{ $patient['citizen_id'] ?? '' }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row__flex">
                                    <div class="form-col">
                                        <label for="" class="form-col__label">Allergy</label>
                                        <input type="text" name="allergy" class="form-control"
                                            value="{{ $patient['allergy'] ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br class="clear">

                    <!-- Medical Visits -->
                    <div class="card shadow">
                        <div class="container-recent__heading">
                            <p class="recent__heading-title">Medical Visits</p>
                        </div>
                        <div class="table-responsive">
                            @if(count($medicalVisits) > 0)
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-column-emphasis" scope="col">ID</th>
                                            <th class="text-column" scope="col">Patient ID</th>
                                            <th class="text-column" scope="col">Doctor ID</th>
                                            <th class="text-column" scope="col">Department ID</th>
                                            <th class="text-column" scope="col">Visit Date</th>
                                            <th class="text-column" scope="col">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">
                                        @foreach($medicalVisits as $visit)
                                            <tr>
                                                <th class="text-column-emphasis" scope="row">{{ $visit['id'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $visit['patient_id'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $visit['doctor_id'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $visit['department_id'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $visit['visit_date'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">
                                                    <div class="text-column__action">
                                                        <a href={{ url('medical_record/detail_medvisit_staff/' . $visit['id']) }}
                                                            class="btn-control btn-control-edit">
                                                            <i class="fa-solid fa-user-pen btn-control-icon"></i>
                                                            View Detail
                                                        </a>
                                                    </div>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No medical visits found for this patient.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            @include('components.footer_employee')
       </div>
    </div>
    <!-- Argon Scripts -->

</body>

</html>