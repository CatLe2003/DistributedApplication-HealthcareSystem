<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescriptions Management - LifeCare</title>
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
                    <div class="container-recent-inner">
                        <div class="container-recent__heading heading__button">
                            <a href="{{ url('add_prescription') }}" class="btn-control btn-control-add">
                                <i class="fa-solid fa-pills btn-control-icon"></i>
                                Add new prescription
                            </a>
                            <!-- <p class="recent__heading-title">Prescriptions</p> -->
                            <form class="container__heading-search">
                                <input type="text" class="heading-search__area" placeholder="Search by notes..." name>
                                <button href="" class="btn-control btn-control-search">
                                    <i class="fa-solid fa-magnifying-glass btn-control-icon"></i>
                                    Search
                                </button>

                            </form>

                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">ID</th>
                                        <th class="text-column-emphasis" scope="col">VISIT ID</th>
                                        <th class="text-column" scope="col">Notes</th>
                                        <th class="text-column" scope="col">Date</th>
                                        <th class="text-column" scope="col">Status</th>
                                        <th class="text-column" scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    <tr>
                                        @forelse($prescriptions as $prescription)
                                            <tr>
                                                <th class="text-column" scope="row">{{ $prescription['id'] ?? 'N/A' }}
                                                </th>
                                                <th class="text-column-emphasis" scope="row">
                                                    {{ $prescription['visit_id'] ?? 'N/A' }}
                                                </th>
                                                <th class="text-column" scope="row">{{ $prescription['notes'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $prescription['status'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">{{ $prescription['date'] ?? 'N/A' }}</th>
                                                <th class="text-column" scope="row">
                                                    <div class="text-column__action">
                                                        <a href="{{ url('update_prescription') }}"
                                                            class="btn-control btn-control-delete">
                                                            <i class="fa-solid fa-square-check btn-control-icon"></i>
                                                            Update
                                                        </a>
                                                        <a href="{{ url('detail_prescription') }}"
                                                            class="btn-control btn-control-edit">
                                                            <i class="fa-solid fa-user-pen btn-control-icon"></i>
                                                            View Detail
                                                        </a>
                                                    </div>
                                                </th>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No prescriptions found</td>
                                        </tr>
                                    @endforelse
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