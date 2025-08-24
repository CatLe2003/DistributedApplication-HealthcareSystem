<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "Update Profile - LifeCare";
include(__DIR__ . '/../components/header_patient.blade.php');
?>
<script src="/DistributedApplication-HealthcareSystem/Frontend/assets/js/function_patient.js"></script>

        <!-- Main -->
        <div class="main-container">
            <section class="paper-list-container">
                <h2 class="paper-list-title">Edit Profile</h2>
                <hr class="breakline">

                <form class="search-form">
                    <div class="profile-header">
                        <img src="" alt="" class="profile-avatar" id="avatar-preview">
                        <!-- <input type="file" id="upload-photo" accept="image/*" hidden>
                        <button type="button" class="btn-primary"
                            onclick="document.getElementById('upload-photo').click()">New photo</button> -->
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="fullname">Fullname</label>
                        <input type="text" id="fullname" class="input-field" value="John Smith">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="gender">Gender</label>
                        <select id="gender" class="input-field">
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="text" id="phone" class="input-field" value="094543545">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="citizen">Citizen ID</label>
                        <input type="text" id="citizen" class="input-field" value="830534546785">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="dob">Date of Birth</label>
                        <input type="date" id="dob" class="input-field" value="2025-08-20">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" id="address" class="input-field" value="12 ABC Street">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="nationality">Nationality</label>
                        <input type="text" id="nationality" class="input-field" value="Vietnam">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="occupation">Occupation</label>
                        <input type="text" id="occupation" class="input-field" value="Neet">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="ethnicity">Ethnicity</label>
                        <input type="text" id="ethnicity" class="input-field" value="">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="allergy">Allergy</label>
                        <input type="text" id="allergy" class="input-field" value="">
                    </div>

                    <div class="search-row">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" class="input-field" value="john.smith@example.com">
                    </div>

                    <div class="login-buttons">
                        <button type="submit" class="btn-primary">Update</button>
                        <a href="profile.blade.php" type="button" class="btn-outline">Cancel</a>
                    </div>
                </form>
            </section>
        </div>

<?php
include(__DIR__ . '/../components/footer_patient.blade.php');
?>