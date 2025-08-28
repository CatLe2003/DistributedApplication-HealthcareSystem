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

            <form action="{{ url('appointment/payment_confirm') }}" class="search-form">
                <div class="search-row">
                    <label class="form-label" for="keyword">Service</label>
                    <select id="department" class="input-field" require>
                        @foreach($departments as $department)
                            <option value="{{ $department['DepartmentID'] }}">{{ $department['DepartmentName'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="search-row">
                    <label class="form-label" for="author">Doctor</label>
                    <select id="doctor"  class="input-field" require>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor['EmployeeID'] }}">{{ $doctor['FullName'] ?? ''}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="search-row date-row">
                    <div class="search-row">
                        <label class="form-label" for="Date">Date</label>
                        <input type="date" id="date" class="input-field" require>
                    </div>
                    <div class="search-row">
                        <label class="form-label" for="time">Time slot</label>
                        <select id="time-slot" class="input-field" require>
                            <option value>-- Select a timeslot --</option>
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
</body>

</html>