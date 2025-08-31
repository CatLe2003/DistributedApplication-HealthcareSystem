<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine - LifeCare</title>
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
                            <p class="recent__heading-title">Add New Medicine</p>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success" id="profile-alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger" id="profile-alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="container-recent__body card__body-form">
                            <form method="POST" action="{{ route('medicine.add') }}" class="form">
                                @csrf
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Name</label>
                                            <input type="text" name="MedicineName" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Ingredient</label>
                                            <input type="text" name="Ingredient" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Dosage Instruction</label>
                                            <input type="text" name="DosageInstruction" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Unit Name</label>
                                            <select name="UnitID" class="form-control" required>
                                                <option value="">-- Select --</option>
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit['UnitID'] }}">
                                                        {{ $unit['UnitName'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-col">
                                            <label for="" class="form-col__label">Manufacturer</label>
                                            <select name="ManufacturerID" class="form-control" required>
                                                <option value="">-- Select --</option>
                                                @foreach($manufacturers as $manufacturer)
                                                    <option value="{{ $manufacturer['ManufacturerID'] }}">
                                                        {{ $manufacturer['ManufacturerName'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">In Stock</label>
                                            <input type="number" name="InStock" class="form-control" value="">
                                        </div>
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Price</label>
                                            <input type="number" name="Price" class="form-control" value="">
                                        </div>
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Form Name</label>
                                            <select name="FormID" class="form-control" required>
                                                <option value="">-- Select --</option>
                                                @foreach($forms as $form)
                                                    <option value="{{ $form['FormID'] }}">
                                                        {{ $form['FormName'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="Status" class="form-control" value="ACTIVE" hidden>

                                <br class="">

                                <div class="form-row">
                                    <div class="form-col margin-0">
                                        <div class="form-col-bottom">
                                            <input type="submit" name="addMedicine" value="Add Medicine"
                                                class="btn-control btn-control-add">
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