<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prescription - LifeCare</title>
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
                            <p class="recent__heading-title">Add New Prescription</p>

                            <form class="container__heading-search">
                                <input type="text" class="heading-search__area"
                                    placeholder="Search by medical record..." name>
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
                            <form method="POST" action="{{ route('prescription.createPrescription') }}">
                                @csrf
                                <input type="hidden" name="visit_id" value="{{ $visit_id }}">

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Date</label>
                                            <input type="date" name="date" class="form-control" required>
                                        </div>
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Visit ID</label>
                                            <input name="visit_id" value="{{ $visit_id }}" class="form-control"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Notes</label>
                                            <input type="text" name="notes" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <p class="recent__heading-title">Detail Prescription</p>

                                <div class="table-responsive">
                                    <table class="table" id="prescriptionTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Medicine</th>
                                                <th>Dosage</th>
                                                <th>Duration</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="prescriptionBody">
                                            <tr>
                                                <td>
                                                    <select name="medicine_id[]" class="form-control" required>
                                                        <option value="">-- Select --</option>
                                                        @foreach($medicines as $med)
                                                            <option value="{{ $med['MedicineID'] }}">
                                                                {{ $med['MedicineName'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="dosage[]" class="form-control" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="duration[]" class="form-control">
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn-control btn-control-delete"
                                                        onclick="removeRow(this)">
                                                        <i class="fa-solid fa-trash-can btn-control-icon"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <button type="button" class="btn-control btn-control-edit" onclick="addNewRow()">
                                        <i class="fa-solid fa-plus btn-control-icon"></i> Add new row
                                    </button>
                                </div>

                                <br>
                                <div class="form-row">
                                    <div class="form-col margin-0">
                                        <div class="form-col-bottom">
                                            <input type="submit" value="Add Prescription"
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
    <script>
        // This generates <option> tags directly from $medicines
       window.medicinesOptionsHtml = `{!! collect($medicines)->map(function ($med) {
    return "<option value='{$med['MedicineID']}'>{$med['MedicineName']}</option>";
})->implode('') !!}`;
    </script>

    <script src="{{ asset('assets/js/function_staff.js') }}"></script>
</body>

</html>