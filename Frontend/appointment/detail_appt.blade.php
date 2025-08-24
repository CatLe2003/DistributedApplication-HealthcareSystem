<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Detail Appointment - LifeCare";
include(__DIR__ . '/../components/header_patient.blade.php');
?>
<script src="/DistributedApplication-HealthcareSystem/Frontend/assets/js/function_patient.js"></script>

        <!-- Main -->
        <div class="main-container">
            <section class="paper-list-container">
                <h2 class="paper-list-title">Detail Appointment</h2>
                <hr class="breakline">
                <form action="">
                    <div class="info-box">
                        <h3>Khám ngày 15/08/2025</h3>
                        <p class="paper-detail-description"><strong>Department: </strong>Tai Mũi Họng</p>
                        <p class="paper-detail-description"><strong>Doctor: </strong>Dr. Nguyễn Văn Chung</p>
                        <p class="paper-detail-description"><strong>Time Slot: </strong>8:00 - 8:30</p>
                        <p class="paper-detail-description"><strong>Transaction: </strong>12</p>
                        <p class="paper-detail-description"><strong>Status: </strong>New</p>
                    </div>
                    <div class="login-buttons">
                        <button type="button" class="btn-primary">Cancel Appointment</button>
                        <a href="../medical_record/profile.blade.php" type="submit" class="btn-outline">Close</a>
                    </div>

                </form>
            </section>
        </div>

<?php
include(__DIR__ . '/../components/footer_patient.blade.php');
?>