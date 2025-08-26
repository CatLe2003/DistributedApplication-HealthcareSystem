<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeCare</title>
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
            <!-- Header Card -->
            <div class="header">
                <div class="container header__body">
                    <div class="header-body__card">
                        <div class="body__card">
                            <div class="body__card-inner">
                                <div class="card-inner__title">CUSTOMERS</div>
                                <div class="card-inner__number">14</div>
                            </div>
                            <i class="fa-solid fa-users card__icon bg-danger"></i>
                        </div>
                    </div>

                    <div class="header-body__card">
                        <div class="body__card">
                            <div class="body__card-inner">
                                <div class="card-inner__title">PRODUCTS</div>
                                <div class="card-inner__number">26</div>
                            </div>
                            <i class="fa-solid fa-utensils card__icon bg-update"></i>
                        </div>
                    </div>

                    <div class="header-body__card">
                        <div class="body__card">
                            <div class="body__card-inner">
                                <div class="card-inner__title">ODERS</div>
                                <div class="card-inner__number">11</div>
                            </div>
                            <i class="fa-solid fa-cart-shopping card__icon bg-warning"></i>
                        </div>
                    </div>

                    <div class="header-body__card">
                        <div class="body__card">
                            <div class="body__card-inner">
                                <div class="card-inner__title">SALES</div>
                                <div class="card-inner__number">$139</div>
                            </div>
                            <i class="fa-solid fa-dollar-sign card__icon bg-green"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container">
                <div class="container-recent">
                    <div class="container-recent-inner">
                        <div class="container-recent__heading">
                            <p class="recent__heading-title">Recent Appointments</p>
                            <a href="appointment_records.html" class="btn-control btn-control-search">See all</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">ID Appointment</th>
                                        <th class="text-column" scope="col">PATIENT NAME</th>
                                        <th class="text-column" scope="col">DOCTOR</th>
                                        <th class="text-column" scope="col">DEPARTMENT</th>
                                        <th class="text-column" scope="col">Date</th>
                                        <th class="text-column" scope="col">TIME SLOT</th>
                                        <th class="text-column" scope="col">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <tr>
                                        <th class="text-column-emphasis" scope="row">1</th>
                                        <th class="text-column" scope="row">Nguyễn Văn Ách</th>
                                        <th class="text-column" scope="row">Bồi Đầm Già</th>
                                        <th class="text-column" scope="row">Thần kinh</th>
                                        <th class="text-column" scope="row">12/2/2023</th>
                                        <th class="text-column" scope="row">8:00 - 9:00</th>
                                        <th class="text-column" scope="row">
                                            <span class="badge badge-success">New</span>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th class="text-column-emphasis" scope="row">2</th>
                                        <th class="text-column" scope="row">Bún Riêu Cua</th>
                                        <th class="text-column" scope="row">Bún Bò</th>
                                        <th class="text-column" scope="row">Tai mũi họng</th>
                                        <th class="text-column" scope="row">12/2/2023</th>
                                        <th class="text-column" scope="row">11:00 - 12:00</th>
                                        <th class="text-column" scope="row">
                                            <span class="badge badge-unsuccess">Cancel</span>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th class="text-column-emphasis" scope="row">3</th>
                                        <th class="text-column" scope="row">Bùn Ngủ Quá</th>
                                        <th class="text-column" scope="row">Đi Dề</th>
                                        <th class="text-column" scope="row">Da liễu</th>
                                        <th class="text-column" scope="row">12/2/2023</th>
                                        <th class="text-column" scope="row">11:00 - 12:00</th>
                                        <th class="text-column" scope="row">
                                            <span class="badge badge-plan">Upcoming</span>
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