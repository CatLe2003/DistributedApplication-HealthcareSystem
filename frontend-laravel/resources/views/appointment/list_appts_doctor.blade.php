<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Management - LifeCare</title>
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
                    <div class="container-recent-inner">
                        <div class="container-recent__heading heading__button">
                            <a href="{{ url('add_appointment') }}" class="btn-control btn-control-add">
                                <i class="fa-solid fa-calendar btn-control-icon"></i>
                                Add new appointment
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">ID</th>
                                        <th class="text-column" scope="col">Patient</th>
                                        <th class="text-column" scope="col">Doctor</th>
                                        <th class="text-column" scope="col">Department</th>
                                        <th class="text-column" scope="col">Date</th>
                                        <th class="text-column" scope="col">Timeslot</th>
                                        <th class="text-column" scope="col">Room</th>
                                        <th class="text-column" scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @forelse($appointments as $appt)
                                        <tr>
                                            <th class="text-column-emphasis" scope="row">{{ $appt['AppointmentID'] }}</th>
                                            <th class="text-column" scope="col">{{ $appt['PatientID'] }}</th> {{-- Replace
                                            with patient name if available --}}
                                            <th class="text-column" scope="col">{{ $appt['DoctorID'] }}</th> {{-- Replace
                                            with doctor name if available --}}
                                            <th class="text-column" scope="col">{{ $appt['DepartmentID'] }}</th> {{--
                                            Replace with department name if available --}}
                                            <th class="text-column" scope="col">
                                                {{ \Carbon\Carbon::parse($appt['AppointmentDate'])->format('d/m/Y') }}</th>
                                            <th class="text-column" scope="col">{{ $appt['TimeSlotID'] }}</th> {{-- Replace
                                            with timeslot label if needed --}}
                                            <th class="text-column" scope="col">{{ $appt['RoomID'] }}</th>
                                            <th class="text-column" scope="col">{{ $appt['Status'] }}</th> 
                                            {{-- <th class="text-column" scope="row">
                                                @if($appt['Status'] === 'pending')
                                                    <span class="badge badge-success">Pending</span>
                                                @elseif($appt['Status'] === 'completed')
                                                    <span class="badge badge-plan">Completed</span>
                                                @elseif($appt['Status'] === 'cancelled')
                                                    <span class="badge badge-unsuccess">Cancelled</span>
                                                @endif
                                            </th>
                                            <th class="text-column" scope="row">
                                                <div class="text-column__action">
                                                    @if($appt['Status'] === 'pending')
                                                        <form action="{{ url('appointment/cancel/' . $appt['AppointmentID']) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn-control btn-control-delete">
                                                                <i class="fa-solid fa-trash btn-control-icon"></i> Cancel
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </th> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No appointments found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

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