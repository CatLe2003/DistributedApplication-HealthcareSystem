<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule - LifeCare</title>
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
                            <p class="recent__heading-title">Your Schedules</p>
                            <a href="{{ route('employee.add_schedule') }}" class="btn-control btn-control-add">
                                <i class="fa-solid fa-calendar btn-control-icon"></i>
                                Add schedule
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column" scope="col">Schedule ID</th>
                                        <th class="text-column" scope="col">Weekday</th>
                                        <th class="text-column" scope="col">Shift</th>
                                        <th class="text-column" scope="col">Time</th>
                                        <th class="text-column" scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @forelse($schedules as $schedule)
                                        <tr>
                                            <th class="text-column-emphasis" scope="row">{{ $schedule['ScheduleID'] }}</th>
                                            <th class="text-column" scope="col">{{ $schedule['weekday']['WeekdayName'] }}
                                            </th>
                                            <th class="text-column" scope="col">{{ $schedule['shift']['ShiftName'] }}</th>
                                            <td class="text-column" scope="col">
                                                {{ $schedule['shift']['StartTime'] ?? '' }} -
                                                {{ $schedule['shift']['EndTime'] ?? '' }}
                                            </td>
                                            <th class="text-column" scope="col">
                                                <div class="text-column__action">
                                                    <form
                                                        action="{{ route('employee.delete_schedule', $schedule['ScheduleID']) }}"
                                                        method="POST" onsubmit="return confirm('Delete this schedule?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-control btn-control-delete">
                                                            <i class="fa-solid fa-trash btn-control-icon"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </th>
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