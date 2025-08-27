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
                                        <th class="text-column" scope="col">ACTION</th> 
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <tr>
                                        <th class="text-column-emphasis" scope="row">12</th> 
                                        <th class="text-column" scope="col">Patient</th> 
                                        <th class="text-column" scope="col">Doctor</th> 
                                        <th class="text-column" scope="col">Department</th> 
                                        <th class="text-column" scope="col">12/09/2025</th> 
                                        <th class="text-column" scope="col">Timeslot</th> 
                                        <th class="text-column" scope="col">Room</th> 
                                        <th class="text-column" scope="row">
                                            <span class="badge badge-success">New</span>
                                            <!-- <span class="badge badge-unsuccess">Cancel</span>
                                            <span class="badge badge-plan">In Progress</span> -->
                                        </th>
                                        <th class="text-column" scope="row">
                                            <div class="text-column__action">
                                                <!-- Chỉ hiển thị khi status="BOOKED" -->
                                                <button href="{{-- url('update_prescription') --}}" class="btn-control btn-control-delete">
                                                    <i class="fa-solid fa-trash btn-control-icon"></i>
                                                    Cancel
                                                </button>
                                                <!-- <a href="{{ url('detail_prescription') }}" class="btn-control btn-control-edit">
                                                    <i class="fa-solid fa-user-pen btn-control-icon"></i>
                                                    View Detail
                                                </a> -->
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