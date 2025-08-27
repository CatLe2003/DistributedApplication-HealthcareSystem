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
                            <p class="recent__heading-title">Your Schedules</p>
                            <form class="container__heading-search">
                                <select class="heading-search__area" name="weekday" id="weekday" class="form-cotrol" onchange="getStatus(this.value)">
                                    <option value="1">Thứ 2</option>
                                    <option value="2">Thứ 3</option>
                                    <option value="3">Thứ 4</option>
                                    <option value="4">Thứ 5</option>
                                    <option value="5">Thứ 6</option>
                                    <option value="6">Thứ 7</option>
                                    <option value="7">Chủ nhật</option>
                                </select>
                                <select class="heading-search__area" name="shift" id="shift" class="form-cotrol" onchange="getStatus(this.value)">
                                    <option value="Monday">9:00 - 9:30</option>
                                    <option value="Monday">9:30 - 10:00</option>
                                </select>
                                <button class="btn-control btn-control-search" name="btn-add-schedule">
                                    <!-- <i class="fa-solid fa-hand-dots btn-control-icon"></i> -->
                                    Add Schedule
                                </button>                        
                            </form>

                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">No.</th> <!-- Tăng tự động? -->
                                        <th class="text-column" scope="col">Weekday</th> 
                                        <th class="text-column" scope="col">Shift</th> 
                                        <!-- <th class="text-column" scope="col">Actions</th>  -->
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <tr>
                                        <th class="text-column-emphasis" scope="row">1</th> 
                                        <th class="text-column" scope="row">Thứ 2</th> 
                                        <th class="text-column" scope="row">9:00 - 9:30</th> 
                                        <!-- <th class="text-column" scope="row">
                                            <a href="{{ asset('update_medicalrecord') }}" class="btn-control btn-control-edit">
                                                <i class="fa-solid fa-square-check btn-control-icon"></i>
                                                Delete
                                            </a>
                                        </th> -->
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