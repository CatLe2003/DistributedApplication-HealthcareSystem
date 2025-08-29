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
                            <p class="recent__heading-title">Detail Medical Visit</p>
                        </div>

                        <div class="container-recent__body card__body-form">
                            <form method="" class="">
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Department Name</label>
                                            <input type="text" name="department_name" class="form-control" value="{{ $medicalVisit['department_name'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Doctor Name</label>
                                            <input type="text" name="doctor_name" class="form-control" value="{{ $medicalVisit['doctor_name'] ?? '' }}">
                                        </div>

                                        <div class="form-col">
                                            <label for="" class="form-col__label">Visit Date</label>
                                            <input type="text" name="visit_date" class="form-control" value="{{ $medicalVisit['visit_date'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Symptoms</label>
                                            <input type="text" name="symptoms" class="form-control" value="{{ $medicalVisit['symptoms'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Diagnosis</label>
                                            <input type="text" name="diagnosis" class="form-control" value="{{ $medicalVisit['diagnosis'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Notes</label>
                                            <input type="text" name="notes" class="form-control" value="{{ $medicalVisit['notes'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col margin-0">
                                <a href="{{ route('add_prescription', ['visit_id' => $medicalVisit['id']]) }}" class="btn-control btn-control-add">
                                <i class="fa-solid fa-pills btn-control-icon"></i>
                                Add new prescription
                                </a>
                            </div>
                        </div>
                        <br class=""> 

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