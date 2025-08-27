<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Services - LifeCare')</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<script src="{{ asset('assets/js/function_patient.js') }}"></script>
<body>
    <div class="container">
        @include('components.header_patient')
    </div>

    <!-- Main -->
    <div class="main-container">
        <section class="paper-list-container">
            <h2 class="paper-list-title">Our Services</h2>
            <hr class="breakline">

            <!-- Department -->
            @if(isset($error))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif

            @if(empty($departments))
                <div class="info-box">
                    <p>No departments found.</p>
                </div>
            @else
                @foreach($departments as $department)
                <div class="info-box">
                    <h3>{{ $department['DepartmentName'] }}</h3>
                    <p class="paper-detail-description">
                        <strong>Description: </strong>{{ $department['Description'] ?? 'No description available' }}
                    </p>
                </div>
                @endforeach
            @endif
        </section>
    </div>

    @includeWhen(View::exists('components.footer_patient'), 'components.footer_patient')

    {{-- Scripts chung + stack cho từng trang/components --}}
    @stack('scripts')
</body>
</html>
