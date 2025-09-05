<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - LifeCare</title>
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
    @include('components.sidebar_' . (session('user_role', 'admin')))
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
                            <p class="recent__heading-title">Add Medical Visit</p>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
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
                        <div class="container-recent__body card__body-form">
                            <form method="POST" action="{{ route('add_medvisit.post') }}">
                                @csrf
                                {{-- Patient Dropdown --}}
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="patient_id" class="form-col__label">Patient</label>
                                            <select name="patient_id" id="patient_id" class="form-control" required>
                                                <option value="">-- Select Patient --</option>
                                                @foreach($patients as $patient)
                                                    <option value="{{ $patient['id'] }}">
                                                        {{ $patient['full_name'] }} ({{ $patient['phone_number'] }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Doctor --}}
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="doctor_id" class="form-col__label">Doctor</label>
                                            <input type="hidden" name="doctor_id"
                                                value="{{ $doctor['EmployeeID'] ?? '' }}">
                                            <input type="text" class="form-control"
                                                value="{{ $doctor['FullName'] ?? 'N/A' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- Department --}}
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="department_id" class="form-col__label">Department</label>
                                            <input type="hidden" name="department_id"
                                                value="{{ $department['DepartmentID'] ?? '' }}">
                                            <input type="text" class="form-control"
                                                value="{{ $department['DepartmentName'] ?? 'N/A' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- Visit Date --}}
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="visit_date" class="form-col__label">Visit Date</label>
                                            <input type="datetime-local" name="visit_date" id="visit_date"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- Diagnosis --}}
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="diagnosis" class="form-col__label">Diagnosis</label>
                                            <input type="text" name="diagnosis" id="diagnosis" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                {{-- Symptoms --}}
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="symptoms" class="form-col__label">Symptoms</label>
                                            <input type="text" name="symptoms" id="symptoms" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                {{-- Notes --}}
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="notes" class="form-col__label">Notes</label>
                                            <input type="text" name="notes" id="notes" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <br>
                                <div class="form-row">
                                    <div class="form-col margin-0">
                                        <div class="form-col-bottom">
                                            <input type="submit" value="Add Medical Visit"
                                                class="btn-control btn-control-add">
                                        </div>
                                    </div>
                                </div>
                            </form>
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