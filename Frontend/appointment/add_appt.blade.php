<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Book An Appointment - LifeCare";
include(__DIR__ . '/../components/header_patient.blade.php');
?>
<script src="/DistributedApplication-HealthcareSystem/Frontend/assets/js/function_patient.js"></script>

<!-- Main -->
<div class="main-container">
    <section class="paper-list-container">
        <h2 class="paper-list-title">Book An Appointment</h2>
        <hr class="breakline">

        <!-- Patient Check Section -->
        <div class="info-box">
            <h3>Patient Information</h3>
            <p class="paper-detail-description">Have you visited our hospital before?</p>
            <label class="paper-detail-description">
                <input type="radio" name="patient_status" value="yes" checked>
                Yes, I have
            </label>
            <label class="paper-detail-description">
                <input type="radio" name="patient_status" value="no">
                No, I’m a new patient
            </label>
        </div>

        <hr class="breakline">

        <form action="payment_confirm.blade.php" class="search-form">
            <div class="search-row">
                <label class="form-label" for="keyword">Department</label>
                <select id="department" class="input-field">
                    <option value>Tai-Mũi-Họng</option>
                </select>
            </div>

            <div class="search-row">
                <label class="form-label" for="author">Doctor</label>
                <select id="conference" class="input-field">
                    <option value>Chung</option>
                </select>
            </div>

            <div class="search-row date-row">
                <div class="search-row">
                    <label class="form-label" for="Date">Date</label>
                    <input type="date" id="date" class="input-field">
                </div>
                <div class="search-row">
                    <label class="form-label" for="time">Time slot</label>
                    <select id="conference" class="input-field">
                        <option value>8:00 - 8:30</option>
                    </select>
                </div>
            </div>

            <div class="search-btn-wrapper">
                <button class="btn-primary p-center">
                    Book Appointment
                </button>
            </div>
        </form>
    </section>
</div>

<?php
include(__DIR__ . '/../components/footer_patient.blade.php');
?>