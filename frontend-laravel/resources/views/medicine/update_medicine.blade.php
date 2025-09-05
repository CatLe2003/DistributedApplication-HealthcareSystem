<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medicine - LifeCare</title>
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
    @include('components.sidebar_admin')
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
                            <p class="recent__heading-title">Update Medicine</p>
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
                            <form method="POST" action="{{ route('medicine.update', $medicine['MedicineID']) }}" class="form">
                                @csrf
                                @method('PATCH')
                                
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Medicine ID</label>
                                            <input type="text" class="form-control" value="{{ $medicine['MedicineID'] ?? '' }}" readonly>
                                            <input type="hidden" name="MedicineID" value="{{ $medicine['MedicineID'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Name</label>
                                            <input type="text" name="MedicineName" class="form-control" 
                                                value="{{ old('MedicineName', $medicine['MedicineName'] ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Ingredient</label>
                                            <input type="text" name="Ingredient" class="form-control" 
                                                value="{{ old('Ingredient', $medicine['Ingredient'] ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Dosage Instruction</label>
                                            <input type="text" name="DosageInstruction" class="form-control" 
                                                value="{{ old('DosageInstruction', $medicine['DosageInstruction'] ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Contraindication</label>
                                            <input type="text" name="Contraindication" class="form-control" 
                                                value="{{ old('Contraindication', $medicine['Contraindication'] ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Side Effect</label>
                                            <input type="text" name="SideEffect" class="form-control" 
                                                value="{{ old('SideEffect', $medicine['SideEffect'] ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Storage</label>
                                            <input type="text" name="Storage" class="form-control" 
                                                value="{{ old('Storage', $medicine['Storage'] ?? '') }}">
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
                                                    <option value="{{ $unit['UnitID'] }}" 
                                                        {{ (old('UnitID', $medicine['UnitID'] ?? '') == $unit['UnitID']) ? 'selected' : '' }}>
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
                                                    <option value="{{ $manufacturer['ManufacturerID'] }}" 
                                                        {{ (old('ManufacturerID', $medicine['ManufacturerID'] ?? '') == $manufacturer['ManufacturerID']) ? 'selected' : '' }}>
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
                                            <input type="number" name="InStock" class="form-control" 
                                                value="{{ old('InStock', $medicine['InStock'] ?? '') }}">
                                        </div>
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Price</label>
                                            <input type="number" step="0.01" name="Price" class="form-control" 
                                                value="{{ old('Price', $medicine['Price'] ?? '') }}">
                                        </div>
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Form Name</label>
                                            <select name="FormID" class="form-control" required>
                                                <option value="">-- Select --</option>
                                                @foreach($forms as $form)
                                                    <option value="{{ $form['FormID'] }}" 
                                                        {{ (old('FormID', $medicine['FormID'] ?? '') == $form['FormID']) ? 'selected' : '' }}>
                                                        {{ $form['FormName'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row__flex">
                                        <div class="form-col">
                                            <label for="" class="form-col__label">Status</label>
                                            <input type="text" name="Status" class="form-control" 
                                                value="{{ old('Status', $medicine['Status'] ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <br class="">

                                <div class="form-row">
                                    <div class="form-col margin-0">
                                        <div class="form-col-bottom">
                                            <input type="submit" name="updateMedicine" value="Update Medicine"
                                                class="btn-control btn-control-edit">
                                            <a href="{{ route('medicine_management') }}" class="btn-control btn-control-secondary">
                                                <i class="fa-solid fa-arrow-left btn-control-icon"></i>
                                                Cancel
                                            </a>
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