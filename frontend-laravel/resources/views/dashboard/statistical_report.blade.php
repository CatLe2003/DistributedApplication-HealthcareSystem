<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistical Report - LifeCare</title>
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
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
                    <div class="container-recent-inner">
                        <div class="container-recent__heading heading__button">
                            <p class="recent__heading-title">Patient Statistics</p>
                            <!-- <p class="recent__heading-title">Prescriptions</p> -->
                            <form class="container__heading-search">
                                <input type="month" class="heading-search__area form-control" name="month_year" id="month_year" max="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                                <select class="heading-search__area" name="doctor" id="doctor" class="form-cotrol" onchange="getStatus(this.value)">
                                    <option value="Monday">Select Doctor</option>
                                    <option value="12">All</option>
                                    <option value="11">ABC</option>
                                </select>
                                <button class="btn-control btn-control-search" name="btn-add-schedule">
                                    <i class="fa-solid fa-filter btn-control-icon"></i>
                                    Filter
                                </button>                        
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">Patient Id</th>
                                        <th class="text-column" scope="col">FULL NAME</th>
                                        <th class="text-column" scope="col">Gender</th>
                                        <th class="text-column" scope="col">Phone Number</th>
                                        <th class="text-column" scope="col">Address</th>
                                        <th class="text-column" scope="col">DOB</th>
                                        <th class="text-column" scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @forelse($patients as $patient)
                                        <tr>
                                            <th class="text-column-emphasis" scope="row">{{ $patient['id'] ?? 'N/A' }}</th>
                                            <th class="text-column" scope="row">{{ $patient['full_name'] ?? 'N/A' }}</th>
                                            <th class="text-column" scope="row">{{ $patient['gender'] ?? 'N/A' }}</th>
                                            <th class="text-column" scope="row">{{ $patient['phone_number'] ?? 'N/A' }}</th>
                                            <th class="text-column" scope="row">{{ $patient['address'] ?? 'N/A' }}</th>
                                            <th class="text-column" scope="row">{{ $patient['date_of_birth'] ?? 'N/A' }}</th>
                                            <th class="text-column" scope="row">
                                                <div class="text-column__action">
                                                    <a href="#" class="btn-control btn-control-delete">
                                                        <i class="fa-solid fa-trash-can btn-control-icon"></i>
                                                        Delete
                                                    </a>
                                                    <a href="{{-- url('detail_patient/' . $patient['id']) --}}"
                                                        class="btn-control btn-control-edit">
                                                        <i class="fa-solid fa-user-pen btn-control-icon"></i>
                                                        View Detail
                                                    </a>
                                                </div>
                                            </th>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No patients found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="container-recent">
                    <div class="container-recent-inner">
                        <div class="container-recent__heading heading__button">
                            <p class="recent__heading-title">Prescription Statistics</p>
                            <!-- <p class="recent__heading-title">Prescriptions</p> -->
                            <form class="container__heading-search">
                                <select class="heading-search__area" name="month" id="month" class="form-cotrol" onchange="getStatus(this.value)">
                                    <option value="Monday">Select Doctor</option>
                                    <option value="1">All</option>
                                    <option value="2">2025-09</option>
                                </select>
                                <select class="heading-search__area" name="doctor" id="doctor" class="form-cotrol" onchange="getStatus(this.value)">
                                    <option value="Monday">Select Patient</option>
                                    <option value="12">All</option>
                                    <option value="11">ABC</option>
                                </select>
                                <button class="btn-control btn-control-search" name="btn-add-schedule">
                                    <i class="fa-solid fa-filter btn-control-icon"></i>
                                    Filter
                                </button>                        
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light"> 
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">Prescription ID</th> 
                                        <th class="text-column" scope="col">VISIT ID</th> 
                                        <th class="text-column" scope="col">Notes</th> 
                                        <th class="text-column" scope="col">Date</th> 
                                        <th class="text-column" scope="col">Status</th> 
                                        <th class="text-column" scope="col">ACTION</th> 
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <tr>
                                        @forelse($prescriptions as $prescription)
                                            <tr>
                                                <th class="text-column-emphasis" scope="row">{{ $prescription['id'] ?? 'N/A' }}
                                                </th>
                                                <th class="text-column" scope="row">
                                                    {{ $prescription['visit_id'] ?? 'N/A' }}
                                                </th>
                                                <th class="text-column" scope="row">{{ $prescription['notes'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $prescription['status'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $prescription['date'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">
                                                    <div class="text-column__action">
                                                        <a href="{{ url('update_prescription') }}"
                                                            class="btn-control btn-control-delete">
                                                            <i class="fa-solid fa-square-check btn-control-icon"></i>
                                                            Update
                                                        </a>
                                                        <a href="{{ url('detail_prescription') }}"
                                                            class="btn-control btn-control-edit">
                                                            <i class="fa-solid fa-user-pen btn-control-icon"></i>
                                                            View Detail
                                                        </a>
                                                    </div>
                                                </th>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No prescriptions found</td>
                                        </tr>
                                    @endforelse
                                    </tr>

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