<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Medical Records - LifeCare";
include(__DIR__ . '/../components/header_patient.blade.php');
?>
<script src="/DistributedApplication-HealthcareSystem/Frontend/assets/js/function_patient.js"></script>

<!-- Main -->
<div class="main-container">
    <section class="paper-list-container">
        <h2 class="paper-list-title">Your Medical Records</h2>
        <hr class="breakline">

        <div class="info-box">
            Bạn chưa có bệnh án nào. Vui lòng <a href="../appointment/add_appt.blade.php" class="link">đặt lịch khám</a>.
        </div>

        <!-- Medical Records -->
        <div class="record-grid">
            <!-- 1 -->
            <a href="detail_medrecord.blade.php" class="record-card" tabindex="0" 
                data-date="15/08/2025 (8:00 - 8:30)" 
                data-dept="Tai Mũi Họng"
                data-doctor="BS. Nguyễn Văn Chung" 
                data-symptoms="Đau họng, nghẹt mũi, ho nhẹ"
                data-diagnosis="Viêm họng cấp"
                data-prescription="Paracetamol 500mg x 3/ngày; Xịt mũi NaCl 0,9% x 3/ngày"
                data-tests="Công thức máu; CRP" 
                data-notes="Tái khám sau 7 ngày hoặc khi sốt > 38.5°C kéo dài"
                >
                <div class="record-title">Khám ngày 15/08/2025</div>
                <p class="paper-detail-description"><strong>Department:</strong> Tai Mũi Họng</p>
                <p class="paper-detail-description"><strong>Doctor:</strong> BS. Nguyễn Văn Chung</p>
                <p class="paper-detail-description"><strong>Datetime:</strong> 15/08/2025 (8:00 - 8:30)</p>
            </a>

            <!-- 2 -->
            <a href="detail_medrecord.blade.php" class="record-card" tabindex="0" 
            data-date="02/06/2025 (14:00 - 14:30)" 
            data-dept="Nội Tổng Quát"
                data-doctor="BS. Trần Minh Anh" 
                data-symptoms="Mệt mỏi, giảm ăn" 
                data-diagnosis="Thiếu máu nhẹ"
                data-prescription="Sắt fumarate 1 viên/ngày sau ăn; Vitamin C 500mg/ngày"
                data-tests="Công thức máu; Ferritin; Vitamin B12"
                data-notes="Ăn uống đủ chất; tái khám sau 1 tháng"
                >
                <div class="record-title">Khám ngày 02/06/2025</div>
                <p class="paper-detail-description"><strong>Department:</strong> Nội Tổng Quát</p>
                <p class="paper-detail-description"><strong>Doctor:</strong> BS. Trần Minh Anh</p>
                <p class="paper-detail-description"><strong>Datetime:</strong> 02/06/2025 (14:00 - 14:30)</p>
            </a>
        </div>

        <ul class="pagination">
            <li><a href="#">«</a></li>
            <li><a class="active" href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">»</a></li>
        </ul>

    </section>
</div>

<?php
include(__DIR__ . '/../components/footer_patient.blade.php');
?>