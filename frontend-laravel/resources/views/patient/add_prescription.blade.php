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
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<script src="{{ asset('assets/js/function_staff.js') }}"></script>

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
                            <p class="recent__heading-title">Add New Prescription</p>

                            <form class="container__heading-search">
                                <input type="text" class="heading-search__area" placeholder="Search by medical record..." name>
                                <button href="" class="btn-control btn-control-search">
                                    <i class="fa-solid fa-magnifying-glass btn-control-icon"></i>
                                    Search
                                </button>                        

                            </form>
                        </div>

                        <div class="container-recent__body card__body-form">
                            <form method="POST" class="">
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Date</label>
                                            <input type="date" name="visit_date" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Diagnosis</label>
                                            <input type="text" name="diagnosis" class="form-control" value="">
                                        </div>

                                        <div class="form-col">
                                            <label for="" class="form-col__label">Dosage</label>
                                            <input type="text" name="dosage" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Notes</label>
                                            <input type="text" name="notes" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                 <br class="">

                                <p class="recent__heading-title">Detail Prescription</p>

                                <div class="table-responsive">
                                    <table class="table" id="prescriptionTable">
                                        <thead class="thead-light"> 
                                            <tr>
                                                <th class="text-column-emphasis" scope="col">No.</th> 
                                                <th class="text-column" scope="col">Medicine</th> <!-- Tên thuốc -->
                                                <th class="text-column" scope="col">Dosage</th> 
                                                <th class="text-column" scope="col">Duration</th> 
                                                <th class="text-column" scope="col">ACTION</th> 
                                            </tr>
                                        </thead>
                                        <tbody class="table-body" id="prescriptionBody">
                                            <tr>
                                                <td class="text-column-emphasis" scope="row">1</td>
                                                <td class="text-column" scope="row">
                                                    <select name="medicine_id" class="form-control" required>
                                                        <option value="">-- Select --</option>
                                                        <option value="1">Paracetamol</option>
                                                        <option value="2">Amoxicillin</option>
                                                        <option value="3">Ibuprofen</option>
                                                    </select>                                                
                                                </td> 
                                                <td class="text-column" scope="row">
                                                    <input type="text" name="dosage" value="2 viên/ngày" class="form-control" required>
                                                </td> 
                                                <td class="text-column" scope="row">
                                                    <input type="text" name="duration" value="Max 200 mg/day" class="form-control">
                                                </td> 
                                                <td class="text-column" scope="row">
                                                    <div class="text-column__action">
                                                        <a href="" class="btn-control btn-control-delete" onclick="removeRow(this)">
                                                            <i class="fa-solid fa-trash-can btn-control-icon"></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                </td> 
                                            </tr>

                                        </tbody>
                                    </table>
                                    <!-- Add new row button -->
                                     <button type="submit" class="btn-control btn-control-edit" onclick="addNewRow()">
                                        <i class="fa-solid fa-plus btn-control-icon"></i>
                                        Add new row
                                    </button>
                                </div>

                                <br class="">

                                <div class="form-row">
                                    <div class="form-col margin-0">
                                        <div class="form-col-bottom">
                                            <input type="submit" name="addPrescription" value="Add Prescription" class="btn-control btn-control-add">
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