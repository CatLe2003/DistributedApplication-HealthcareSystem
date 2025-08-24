<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Patient Profile - LifeCare";
include(__DIR__ . '/../components/header_patient.blade.php');
?>
<script src="/DistributedApplication-HealthcareSystem/Frontend/assets/js/function_patient.js"></script>

<!-- Main -->
<div class="main-container">
    <section class="profile-container">
        <div class="profile-header">
            <img src="" alt="" class="profile-avatar">
            <h2 class="profile-name">John Smith</h2>
        </div>

        <div class="profile-content">
            <div class="profile-section user-details">
                <div class="section-header">
                    <h3>User details</h3>
                    <a href="update_profile.blade.php" class="edit-profile">Edit profile</a>
                </div>
                <p class="user-detail"><strong>Gender: </strong>Male</p>
                <p class="user-detail"><strong>Phone Number: </strong>094543545</p>
                <p class="user-detail"><strong>Citizen ID: </strong>830534546785</p>
                <p class="user-detail"><strong>Date of Birth: </strong>20/08/2025</p>
                <p class="user-detail"><strong>Address: </strong>12 ABC Street</p>
                <p class="user-detail"><strong>Nationality: </strong>Vietnam</p>
                <p class="user-detail"><strong>Occupation: </strong>Neet</p>
                <p class="user-detail"><strong>Ethnicity: </strong>...</p>
                <p class="user-detail"><strong>Allergry: </strong>...</p>
                <p class="user-detail"><strong>Email address: </strong><a class="edit-profile"
                        href="mailto:john.smith@example.com">john.smith@example.com</a></p>
            </div>

            <div class="profile-section article-details">
                <div class="topic">
                    <h3 class="subtopic-header">Your Appointments</h3>
                    <a href="../appointment/list_appts.blade.php" class="edit-profile">View All &gt;&gt;</a>
                </div>

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
            </div>
        </div>
    </section>

</div>

<?php
include(__DIR__ . '/../components/footer_patient.blade.php');
?>