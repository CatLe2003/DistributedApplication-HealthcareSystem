<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Detail Medical Record - LifeCare";
include(__DIR__ . '/../components/header_patient.blade.php');
?>
<script src="/DistributedApplication-HealthcareSystem/Frontend/assets/js/function_patient.js"></script>

<!-- Main -->
<div class="main-container">
    <section class="paper-list-container">
        <h2 class="paper-list-title">Detail Medical Record</h2>
        <hr class="breakline">

        <div class="info-box">
            <h3>Khám ngày 15/08/2025</h3>
            <p class="paper-detail-description"><strong>Department:</strong> Tai Mũi Họng</p>
            <p class="paper-detail-description"><strong>Doctor:</strong> BS. Nguyễn Văn Chung</p>
            <p class="paper-detail-description"><strong>Datetime:</strong> 15/08/2025 (8:00 - 8:30)</p>
            <p class="paper-detail-description"><strong>Symptoms:</strong> Không làm</p>
            <p class="paper-detail-description"><strong>Diagnosis:</strong> Lười</p>

        </div>

        <!-- KẾT QUẢ TETS -->
        <div class="container">
            <div class="container-recent">
                <div class="card shadow">
                    <div class="container-recent__heading">
                        <p class="recent__heading-title">Test Result</p>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-column-emphasis" scope="col">Test</th> 
                                    <th class="text-column" scope="col">Date</th> 
                                    <th class="text-column" scope="col">Status</th> 
                                    <th class="text-column" scope="col">Reuslt</th> 
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr>
                                    <th class="text-column-emphasis" scope="row">CRP</th> 
                                    <th class="text-column" scope="row">15/08/2025</th> 
                                    <th class="badge badge-success" scope="row">Ordered</th> <!-- badge-plan - Completed -->
                                    <th class="text-column" scope="row">6mg/l</th> 
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!-- TOA THUỐC -->
        <div class="container">
            <div class="container-recent">
                <div class="card shadow">
                    <div class="container-recent__heading">
                        <p class="recent__heading-title">Prescription</p>
                        <!-- <div class="container__heading-search">
                            <input type="text" class="heading-search__area" placeholder="Medicine" name="contraindication_text">
                            <button class="btn-control btn-control-search" name="btn-add-contraindication">
                                <i class="fa-solid fa-hand-dots btn-control-icon"></i>
                                Add
                            </button>                        
                        </div> -->

                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-column-emphasis" scope="col">Medicine</th> 
                                    <th class="text-column" scope="col">Dosage</th> 
                                    <th class="text-column" scope="col">Duration</th> 
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                <tr>
                                    <th class="text-column-emphasis" scope="row">Paracetamol 500mg</th> 
                                    <th class="text-column" scope="row">1v x3/ngày</th> 
                                    <th class="text-column" scope="row">5 ngày</th> 
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="login-buttons">
            <a href="../medical_record/medical_records.blade.php" type="submit" class="btn-outline">Back</a>
        </div>

    </section>
</div>

<?php
include(__DIR__ . '/../components/footer_patient.blade.php');
?>