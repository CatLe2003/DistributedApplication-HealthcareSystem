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
    @include('components.sidebar_admin')    
    <!-- Main content -->
    <div class="main-content">
        <div class="content">
            <!-- Top navbar -->
            @include('components.header_employee')            
            <!-- Header Card -->
            <div class="header">
                <div class="container header__body">
                    <div class="header-body__card">
                        <div class="body__card">
                            <div class="body__card-inner">
                                <div class="card-inner__title">DOCTORS</div>
                                @if(empty($doctors) || count($doctors) === 0)
                                    <div class="card-inner__number">No doctors found.</div>
                                @else
                                    <div class="card-inner__number">{{ count($doctors) }}</div>
                                @endif
                            </div>
                            <i class="fa-solid fa-user-doctor card__icon bg-green"></i>
                        </div>
                    </div>

                    <div class="header-body__card">
                        <div class="body__card">
                            <div class="body__card-inner">
                                <div class="card-inner__title">PATIENTS</div>
                                @if(empty($patients) || count($patients) === 0)
                                    <div class="card-inner__number">No patients found.</div>
                                @else
                                    <div class="card-inner__number">{{ count($patients) }}</div>
                                @endif
                            </div>
                            <i class="fa-solid fa-users card__icon bg-danger"></i>
                        </div>
                    </div>

                    <div class="header-body__card">
                        <div class="body__card">
                            <div class="body__card-inner">
                                <div class="card-inner__title">MEDICINES</div>
                                @if(empty($medicines) || count($medicines) === 0)
                                    <div class="card-inner__number">No medicines found.</div>
                                @else
                                    <div class="card-inner__number">{{ count($medicines) }}</div>
                                @endif
                            </div>
                            <i class="fa-solid fa-pills card__icon bg-update"></i>
                        </div>
                    </div>

                    <div class="header-body__card">
                        <div class="body__card">
                            <div class="body__card-inner">
                                <div class="card-inner__title">PRESCRIPTIONS</div>
                                @if(empty($prescriptions) || count($prescriptions) === 0)
                                    <div class="card-inner__number">No prescriptions found.</div>
                                @else
                                    <div class="card-inner__number">{{ count($prescriptions) }}</div>
                                @endif
                            </div>
                            <i class="fa-solid fa-prescription-bottle card__icon bg-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container">
                <div class="container-recent">
                    <div class="container-recent-inner">
                        <div class="container-recent__heading heading__button">
                            <p class="recent__heading-title">Patient Statistics</p>
                            <form class="container__heading-search" method="GET" action="">
                                <input type="month" class="heading-search__area form-control" name="from" id="from_month_year" max="{{ \Carbon\Carbon::now()->format('Y-m') }}" value="{{ request('from') }}">
                                <input type="month" class="heading-search__area form-control" name="to" id="to_month_year" max="{{ \Carbon\Carbon::now()->format('Y-m') }}" value="{{ request('to') }}">
                                <button class="btn-control btn-control-search" type="submit" name="btn-filter">
                                    <i class="fa-solid fa-filter btn-control-icon"></i>
                                    Filter
                                </button>                        
                            </form>
                        </div>

                        @php
                            $from = request('from');
                            $to = request('to');
                            $filteredPatients = collect($patients)->filter(function($patient) use ($from, $to) {
                                if (empty($patient['date_of_birth'])) return false;
                                $dob = \Carbon\Carbon::parse($patient['date_of_birth']);
                                if ($from) {
                                    $fromDate = \Carbon\Carbon::parse($from . '-01');
                                    if ($dob->lt($fromDate)) return false;
                                }
                                if ($to) {
                                    // Get last day of the 'to' month
                                    $toDate = \Carbon\Carbon::parse($to . '-01')->endOfMonth();
                                    if ($dob->gt($toDate)) return false;
                                }
                                return true;
                            });
                            $resultCount = $filteredPatients->count();
                        @endphp

                        @if(request()->has('from') || request()->has('to'))
                        <div class="result-count">
                            <p class="">
                                {{ $resultCount }} result{{ $resultCount !== 1 ? 's' : '' }} found
                            </p>
                        </div>
                        @endif

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
                                    @forelse($filteredPatients as $patient)
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
                                                    <a href="#" class="btn-control btn-control-edit">
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
                            <form class="container__heading-search" method="GET">
                                <input type="month" class="heading-search__area form-control" name="month_year" id="month_year" max="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                                <select class="heading-search__area form-control" name="patient" id="patient">
                                    <option value="">Select Patient</option>
                                    <option value="all">All</option>
                                    @forelse($patients as $patient)
                                        <option value="{{ $patient['id'] ?? '' }}">{{ $patient['full_name'] ?? 'N/A' }}</option>
                                    @empty
                                        <option value="">No patients found</option>
                                    @endforelse
                                </select>
                                <button class="btn-control btn-control-search" name="btn-add-prescfilter">
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