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
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
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
                            <p class="recent__heading-title">Detail Prescription</p>
                            <form class="container__heading-search">
                                <input type="text" class="heading-search__area" placeholder="Search by medicine name..." name>
                                <button href="" class="btn-control btn-control-search">
                                    <i class="fa-solid fa-magnifying-glass btn-control-icon"></i>
                                    Search
                                </button>
                            </form>
                        </div>

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

                        <div class="container-recent__body card__body-form">
                            <!-- Prescription Header Information -->
                            <div class="form-row">
                                <div class="form-row__flex">
                                    <div class="form-col">
                                        <label class="form-col__label">Prescription ID:</label>
                                        <input type="text" name="prescription_id" class="form-control"
                                            value="{{ $prescription['prescription_id'] ?? '' }}" readonly>
                                    </div>
                                    <div class="form-col">
                                        <label class="form-col__label">Date:</label>
                                        <input type="text" name="date" class="form-control"
                                            value="{{ $prescription['date'] ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-row__flex">
                                    <div class="form-col">
                                        <label class="form-col__label">Visit ID:</label>
                                        <input type="text" name="visit_id" class="form-control"
                                            value="{{ $prescription['visit_id'] ?? '' }}" readonly>
                                    </div>
                                    <div class="form-col">
                                        <label class="form-col__label">Status:</label>
                                        <input type="text" name="status" class="form-control"
                                            value="{{ $prescription['status'] ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-row__flex">
                                    <div class="form-col">
                                        <label class="form-col__label">Notes:</label>
                                       <input type="text" name="notes" class="form-control"
                                            value="{{ $prescription['notes'] ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <p class="recent__heading-title">Prescription Details</p>

                            <!-- Prescription Details Table -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light"> 
                                        <tr>
                                            <th class="text-column-emphasis" scope="col">No.</th> 
                                            <th class="text-column" scope="col">Medicine</th>
                                            <th class="text-column" scope="col">Dosage</th> 
                                            <th class="text-column" scope="col">Duration</th>
                                            @if(isset($canEdit) && $canEdit)
                                                <th class="text-column" scope="col">ACTION</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">
                                        @if(isset($prescriptionDetails) && count($prescriptionDetails) > 0)
                                            @foreach($prescriptionDetails as $index => $detail)
                                                <tr>
                                                    <th class="text-column-emphasis" scope="row">{{ $index + 1 }}</th>
                                                    <td class="text-column">
                                                        {{ $detail['medicine_name'] ?? $detail->MedicineName ?? 'Unknown Medicine' }}
                                                    </td>
                                                    <td class="text-column">
                                                        {{ $detail['dosage'] ?? 'N/A' }}
                                                    </td>
                                                    <td class="text-column">
                                                        {{ $detail['duration'] ?? 'N/A' }}
                                                    </td>
                                                    @if(isset($canEdit) && $canEdit)
                                                        <td class="text-column">
                                                            <div class="text-column__action">
                                                                <a href="{{ route('prescription.edit', $detail->id) }}" class="btn-control btn-control-edit">
                                                                    <i class="fa-solid fa-pen-to-square btn-control-icon"></i>
                                                                    Edit
                                                                </a>
                                                                <a href="{{ route('prescription.delete', $detail->id) }}" 
                                                                   class="btn-control btn-control-delete"
                                                                   onclick="return confirm('Are you sure you want to delete this prescription detail?')">
                                                                    <i class="fa-solid fa-trash-can btn-control-icon"></i>
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="@if(isset($canEdit) && $canEdit) 5 @else 4 @endif" class="text-center">
                                                    No prescription details found.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-row">
                                <div class="form-col margin-0">
                                    <div class="form-col-bottom">
                                        <a href="{{ route('prescriptions') }}" 
                                           class="btn-control btn-control-secondary">
                                            <i class="fa-solid fa-arrow-left btn-control-icon"></i>
                                            Back to List
                                        </a>
                                    </div>
                                </div>
                            </div>
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