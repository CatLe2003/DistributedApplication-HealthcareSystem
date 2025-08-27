<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Prescription - LifeCare</title>
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
                            <!-- <a href="{{ url('add_prescription') }}" class="btn-control btn-control-add">
                                <i class="fa-solid fa-pills btn-control-icon"></i>
                                Add new prescription
                            </a> -->
                            <p class="recent__heading-title">Detail Prescription</p>
                            <form class="container__heading-search">
                                <input type="text" class="heading-search__area" placeholder="Search by date, notes..." name>
                                <!-- <button href="" class="btn-control btn-control-search">
                                    <i class="fa-solid fa-magnifying-glass btn-control-icon"></i>
                                    Search
                                </button>                         -->

                            </form>

                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light"> 
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">No.</th> 
                                        <th class="text-column" scope="col">Medicine</th> <!-- Tên thuốc -->
                                        <th class="text-column" scope="col">Dosage</th> 
                                        <th class="text-column" scope="col">Duration</th> 
                                        <th class="text-column" scope="col">ACTION</th> 
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <tr>
                                        <th class="text-column-emphasis" scope="row">1</th>  <!-- Tăng tự động -->
                                        <th class="text-column" scope="row">
                                            <input type="text" name="medicine" value="21" placeholder="Paracetamol" class="form-control" required>
                                        </th> 
                                        <th class="text-column" scope="row">
                                            <input type="text" name="dosage" value="2 viên/ngày" class="form-control" required>
                                        </th> 
                                        <th class="text-column" scope="row">
                                            <input type="text" name="duration" value="Max 200 mg/day" class="form-control">
                                        </th> 
                                        <th class="text-column" scope="row">
                                            <div class="text-column__action">
                                                <!-- <a href="" class="btn-control btn-control-delete">
                                                    <i class="fa-solid fa-trash-can btn-control-icon"></i>
                                                    Delete
                                                </a> -->
                                                <button type="submit" class="btn-control btn-control-edit">
                                                    <i class="fa-solid fa-square-check btn-control-icon"></i>
                                                    Save
                                                </button>
                                            </div>
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