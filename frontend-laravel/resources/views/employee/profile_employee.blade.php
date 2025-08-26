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
            <!-- Header -->
            <div class="heading">
                <div class="col-lg-7">
                    <div class="display-2">Hello System Admin</div>
                    <h2 class="text__profile-intro">This is your profile page. You can customize your profile as you want and also change pasword too</h2>
                </div>
            </div>
            <!-- Page content -->
            <div class="container">
                <div class="container-recent">
                    <div class="form-row__flex">
                        <div class="card shadow col-xl-8">
                            <div class="container-recent__heading">
                                <p class="recent__heading-title">My Account</p>
                            </div>
                            
                            <div class="container-recent__body card__body-form">
                                <form method="POST" class="">
                                    <div class="form-row">
                                        <h6 class="heading-small text-muted margin-0">User Information</h6>
                                        
                                        <br class="">

                                        <div class="form-small">
                                            <div class="form-col margin-0">
                                                <label for="" class="form-col__label">Email Address</label>
                                                <input type="text" name="customer_email" class="form-control" value="admin@mail.com">
                                            </div>

                                            <br class="">

                                            <div class="form-row__flex">
                                                <div class="form-col margin-0">
                                                    <label for="" class="form-col__label">User Name</label>
                                                    <input type="text" name="user_name" class="form-control" value>
                                                </div>

                                                <div class="form-col margin-0">
                                                    <label for="" class="form-col__label">Phone Number</label>
                                                    <input type="text" name="user_phone" class="form-control" value>
                                                </div>
                                            </div>

                                            <br class="">

                                            <div class="form-col">
                                                <div class="form-col-bottom">
                                                    <a href="" class="btn-control btn-control-add">
                                                        Submit
                                                    </a>
                                                </div>
                                            </div>        
                                        </div>

                                        <hr class="navbar__divider">

                                        
                                    </div>
                                </form>
                                <form method="POST" class="">
                                    <div class="form-row">
                                        <h6 class="heading-small text-muted">Change Password</h6>
                                        
                                        <br class="">
                                        
                                        <div class="form-small">
                                            <div class="form-col margin-0">
                                                <label for="" class="form-col__label">Old Password</label>
                                                <input type="text" name="new_password" class="form-control" value>
                                            </div>

                                            <br class="">

                                            <div class="form-col margin-0">
                                                <label for="" class="form-col__label">New Password</label>
                                                <input type="text" name="new_password" class="form-control" value>
                                            </div>
                                            
                                            <br class="">

                                            <div class="form-col margin-0">
                                                <label for="" class="form-col__label">Confirm New Password</label>
                                                <input type="text" name="" class="form-control" value>
                                            </div>

                                            <br class="">

                                            <div class="form-col">
                                                <div class="form-col-bottom">
                                                    <a href="" class="btn-control btn-control-add">
                                                        Change Password
                                                    </a>
                                                </div>
                                            </div>                
                                        </div>
                                    </div>
                                </form>     
                            </div>
                        </div>
                        <div class="card shadow col-xl-4">
                            <div class="form-row justify-content-center">
                                <div class="form-col order-lg-2">
                                    <div class="card-profile-image">
                                        <a href="{{ url('profile_employee') }}" class="">
                                            <img src="{{ asset('assets/images/smile-2_removebg.png') }}" alt="" class="rounded-circle">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="container-recent__body card__body-form">
                                <div class="card-profile-status justify-content-center">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="recent__heading-title margin-0">System Admin</p>
                                <div class="text__profile-email">
                                    admin@mail.com
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