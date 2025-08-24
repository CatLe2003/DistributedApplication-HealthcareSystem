<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// $page_title = "Add New Paper - BBB";
include(__DIR__ . '/../components/header_patient.blade.php');
?>
<script src="/DistributedApplication-HealthcareSystem/Frontend/assets/js/function_patient.js"></script>

<div class="main-container">
    <section class="intro-section">
        <div class="intro-left">
            <h2>Book appointments quickly – Manage your records easily</h2>
            <p>
                Access your medical information anytime, anywhere.
            </p>
            <a href="../appointment/add_appt.blade.php" class="btn-primary">Book an appointment</a>
        </div>
        <div class="intro-right">
            <img src="/DistributedApplication-HealthcareSystem/Frontend/assets/images/banner.png" alt="Banner image">
        </div>
    </section>

    <section class="topic-section">
        <div class="topic-header">
            Popular Services
            <a href="../department/list_departments.blade.php" class="view-all">View All &gt;&gt;</a>
        </div>

        <hr class="breakline">

        <div class="topic">
            <h class="subtopic-header"></h>
        </div>

        <div class="info-box">
            <h3>Tai Mũi Họng</h3>
            <p class="paper-detail-description"><strong>Description: </strong>Khám tai-mũi-họng</p>
        </div>


    </section>
</div>

<?php
include(__DIR__ . '/../components/footer_patient.blade.php');
?>