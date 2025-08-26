<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - LifeCare</title>
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
                    <div class="card shadow">
                        <div class="container-recent__heading">
                            <p class="recent__heading-title">Medical Record</p>
                        </div>
                        
                        <div class="container-recent__body card__body-form">
                            <form method="POST" class="">
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Paitent Name</label>
                                            <input type="text" name="paitent_name" class="form-control" value="Vô Diện" readonly>
                                        </div>
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Gender</label>
                                            <input type="text" name="paitent_gender" class="form-control" value="Male" readonly>
                                            <!-- <select name="paitent_gender" id="ptGender" class="form-cotrol" onchange="getCustomer(this.value)">
                                                <option value="" class="">Select Gender</option>
                                                <option value="" class="">Nam</option>
                                                <option value="" class="">Nữ</option>
                                            </select> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- <hr class="navbar__divider"> -->

                                <div class="form-row">
                                    <div class="form-row__flex">

                                        <div class="form-col">
                                            <label for="" class="form-col__label">Phone Number</label>
                                            <input type="text" name="paintent_phone" class="form-control" value="046834872" readonly>
                                        </div>

                                        <div class="form-col">
                                            <label for="" class="form-col__label">Date Of Birth</label>
                                            <input type="date" name="paitent_dob" class="form-control" value readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Occupation</label>
                                            <input type="text" name="paitent_occupation" class="form-control" value readonly>
                                        </div>

                                        <div class="form-col">
                                            <label for="" class="form-col__label">Ethnicity</label>
                                            <input type="text" name="paitent_ethnicity" class="form-control" value readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Nationality</label>
                                            <input type="text" name="paitent_nationality" class="form-control" value readonly>
                                        </div>

                                        <div class="form-col">
                                            <label for="" class="form-col__label">Paitent Address</label>
                                            <input type="text" name="paitent_address" class="form-control" value="Street 5" readonly>
                                        </div>
                                    </div>
                                </div>

                                <br class="">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Contraindication -->
            <div class="container">
                <div class="container-recent">
                    <div class="card shadow">
                        <div class="container-recent__heading">
                            <p class="recent__heading-title">Allergy</p>
                            <div class="container__heading-search">
                                <input type="text" class="heading-search__area" placeholder="Medicine" name="contraindication_text">
                                <button class="btn-control btn-control-search" name="btn-add-contraindication">
                                    <i class="fa-solid fa-hand-dots btn-control-icon"></i>
                                    Add
                                </button>                        
                            </div>

                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">Id</th> 
                                        <th class="text-column" scope="col">Medicine Name</th> 
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <tr>
                                        <th class="text-column-emphasis" scope="row">1</th> 
                                        <th class="text-column" scope="row">Thuốc gì đó</th> 
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Select Medical Visit -->
            <div class="container">
                <div class="container-recent">
                    <div class="card shadow">
                        <div class="container-recent__heading">
                            <p class="recent__heading-title">Medical Records</p>
                            <!-- <a href="add_treatmentplans.html" class="btn-control btn-control-add">
                                <i class="fa-solid fa-square-check btn-control-icon"></i>
                                Add new record
                            </a> -->
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">Id</th> 
                                        <th class="text-column" scope="col">Symptoms</th> 
                                        <th class="text-column" scope="col">Diagnosis</th> 
                                        <th class="text-column" scope="col">Visit Date</th> 
                                        <!-- <th class="text-column" scope="col">Status</th>  -->
                                        <th class="text-column" scope="col">Notes</th> 
                                        <th class="text-column" scope="col">Actions</th> 
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <tr>
                                        <th class="text-column-emphasis" scope="row">1</th> 
                                        <th class="text-column" scope="row">Symptoms</th> 
                                        <th class="text-column" scope="row">Diagnosis</th> 
                                        <th class="text-column" scope="row">12/12/2023</th> 
                                        <th class="text-column" scope="row">12</th> 
                                        <!-- <th class="text-column" scope="row">
                                            <span class="badge badge-success">Đã hoàn thành</span>
                                            <span class="badge badge-unsuccess">Đã hủy</span>
                                            <span class="badge badge-plan">Kế hoạch</span>
                                        </th>  -->
                                        <th class="text-column" scope="row">
                                            <a href="{{ asset('update_medicalrecord') }}" class="btn-control btn-control-edit">
                                                <i class="fa-solid fa-square-check btn-control-icon"></i>
                                                Update
                                            </a>
                                        </th>
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