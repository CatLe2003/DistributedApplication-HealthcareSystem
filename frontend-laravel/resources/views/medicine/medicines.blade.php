<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicines Management - LifeCare</title>
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
    @include('components.sidebar_' . (session('user_role', 'admin')))

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
                            <a href="{{ url('add_medicine') }}" class="btn-control btn-control-add">
                                <i class="fa-solid fa-calendar btn-control-icon"></i>
                                Add new medicine
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light"> 
                                    <tr>
                                        <th class="text-column-emphasis" scope="col">ID</th> 
                                        <th class="text-column" scope="col">Medicine Name</th> 
                                        <th class="text-column" scope="col">Ingredient</th> 
                                        <th class="text-column" scope="col">Unit</th> 
                                        <th class="text-column" scope="col">Dosage</th> 
                                        <th class="text-column" scope="col">Form</th> 
                                        <th class="text-column" scope="col">Contraindication</th> 
                                        <th class="text-column" scope="col">Side Effects</th> 
                                        <th class="text-column" scope="col">Storage</th>
                                        <th class="text-column" scope="col">Manufacturer</th> 
                                        <th class="text-column" scope="col">In Stock</th> 
                                        <th class="text-column" scope="col">Price</th> 
                                        <th class="text-column" scope="col">Status</th> 
                                        <th class="text-column" scope="col">ACTION</th> 
                                    </tr>
                                </thead>
                                
                                @if(empty($medicines) || count($medicines) === 0)
                                    <tbody>
                                        <tr>
                                            <td colspan="14">
                                                <div class="info-box">
                                                    <p>No medicines found.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody class="table-body">
                                        @foreach($medicines as $medicine)
                                            <tr>
                                                <td class="text-column-emphasis">{{ $medicine['MedicineID'] }}</td>
                                                <td class="text-column">{{ $medicine['MedicineName'] ?? '-' }}</td>
                                                <td class="text-column">{{ $medicine['Ingredient'] ?? '-' }}</td>
                                                <td class="text-column">{{ $medicine['unit']['UnitName'] ?? $medicine['UnitID'] ?? '-' }}</td>
                                                <td class="text-column">{{ $medicine['DosageInstruction'] ?? '-' }}</td>
                                                <td class="text-column">{{ $medicine['form']['FormName'] ?? $medicine['FormID'] ?? '-' }}</td>
                                                <td class="text-column">{{ $medicine['Contraindication'] ?? '-' }}</td>
                                                <td class="text-column">{{ $medicine['SideEffects'] ?? $medicine['SideEffect'] ?? '-' }}</td>
                                                <td class="text-column">{{ $medicine['Storage'] ?? '-' }}</td>
                                                <td class="text-column">{{ $medicine['manufacturer']['ManufacturerName'] ?? '-' }}</td>
                                                <td class="text-column">{{ $medicine['InStock'] ?? 0 }}</td>
                                                <td class="text-column">{{ isset($medicine['Price']) ? number_format((float)$medicine['Price'], 0, ',', '.') : '-' }}</td>
                                                <td class="text-column">{{ $medicine['Status'] ?? '-' }}</td>
                                                <td class="text-column">
                                                    <div class="text-column__action">
                                                        <!-- <a href="{{ url('delete_medicine/'.$medicine['MedicineID']) }}" class="btn-control btn-control-delete" onclick="return confirm('Delete this medicine?')">
                                                            <i class="fa-solid fa-trash btn-control-icon"></i>
                                                            Delete
                                                        </a> -->
                                                    <form action="{{ route('medicine.delete', $medicine['MedicineID']) }}" method="POST" onsubmit="return confirm('Delete this medicine?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-control btn-control-delete">
                                                            <i class="fa-solid fa-trash btn-control-icon"></i> Delete
                                                        </button>
                                                    </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
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