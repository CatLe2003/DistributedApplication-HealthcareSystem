<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "List Appointments - LifeCare";
include(__DIR__ . '/../components/header_patient.blade.php');
?>
<script src="/DistributedApplication-HealthcareSystem/Frontend/assets/js/function_patient.js"></script>

<!-- Main -->
<div class="main-container">
    <section class="paper-list-container">
        <h2 class="paper-list-title">Your Appointments</h2>
        <hr class="breakline">

        <!-- Appointments -->
        <div class="record-grid">
            <a href="../appointment/detail_appt.blade.php" class="record-card">
                <div class="record-title">15/08/2025 (8:00 - 8:30)</div>
                <p class="paper-detail-description"><strong>Department:</strong> Tai Mũi Họng</p>
                <p class="paper-detail-description"><strong>Doctor:</strong> BS. Nguyễn Văn Chung</p>
                <p class="paper-detail-description"><strong>Status:</strong> New</p>
            </a>

            <a href="../appointment/detail_appt.blade.php" class="record-card">
                <div class="record-title">14/08/2025 (8:00 - 8:30)</div>
                <p class="paper-detail-description"><strong>Department:</strong> Tai Mũi Họng</p>
                <p class="paper-detail-description"><strong>Doctor:</strong> BS. Nguyễn Văn Chung</p>
                <p class="paper-detail-description"><strong>Status:</strong> New</p>
            </a>
        </div>

        <!-- Go Back Button -->
        <div class="search-btn-wrapper">
            <a href="../medical_record/profile.blade.php" type="submit" class="btn-outline p-center">
                Back
            </a>
        </div>
    </section>
</div>

<?php
include(__DIR__ . '/../components/footer_patient.blade.php');
?>