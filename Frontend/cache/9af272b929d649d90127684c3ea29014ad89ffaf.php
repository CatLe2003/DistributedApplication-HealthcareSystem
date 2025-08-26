

<?php $__env->startSection('title', 'Homepage - LifeCare'); ?>

<?php $__env->startSection('content'); ?>
<section class="intro-section">
    <div class="intro-left">
        <h2>Book appointments quickly – Manage your records easily</h2>
        <p>Access your medical information anytime, anywhere.</p>
        
        <a href="/appt/add_appt" class="btn-primary">Book an appointment</a>
    </div>
    <div class="intro-right">
        
    </div>
</section>

<section class="topic-section">
    <div class="topic-header">
        Popular Services
        
        <a href="/list_departments" class="view-all">View All &gt;&gt;</a>
    </div>
    <hr class="breakline">
    <div class="topic"><h class="subtopic-header"></h></div>

    <div class="info-box">
        <h3>Tai Mũi Họng</h3>
        <p class="paper-detail-description"><strong>Description: </strong>Khám tai-mũi-họng</p>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/views/dashboard/homepage.blade.php ENDPATH**/ ?>