<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Detail Appointment - LifeCare')</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ asset('assets/js/function_patient.js') }}"></script>



<body>
    <div class="container">
        @include('components.header_patient')
    </div>

    <!-- Main -->
    <div class="main-container">
        <section class="paper-list-container">
            <h2 class="paper-list-title">Book An Appointment</h2>
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

            <hr class="breakline">

            <form action="{{ route('appointment.create') }}" method="POST" class="search-form">
                @csrf
                <div class="search-row">
                    <label class="form-label" for="keyword">Service</label>
                    <select id="department" name="department" class="input-field" required>
                        @foreach($departments as $department)
                            <option value="{{ $department['DepartmentID'] }}">{{ $department['DepartmentName'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="search-row">
                    <label class="form-label" for="author">Doctor</label>
                    <select id="doctor" name="doctor" class="input-field" required>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor['EmployeeID'] }}">{{ $doctor['FullName'] ?? ''}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="search-row date-row">
                    <div class="search-row">
                        <label class="form-label" for="Date">Date</label>
                        <input type="date" id="date" name="date" class="input-field" required>
                    </div>
                    <div class="search-row">
                        <label class="form-label" for="time">Time slot</label>
                        <select id="time-slot" name="time-slot" class="input-field" required>
                            <option value>-- Select a timeslot --</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="weekday-id" name="weekday_id" value="">
                <div class="search-btn-wrapper">
                    <button class="btn-primary p-center">
                        Book Appointment
                    </button>
                </div>
            </form>
        </section>
    </div>

    @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient')
</body>

</html>