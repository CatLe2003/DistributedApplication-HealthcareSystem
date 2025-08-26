@extends('layouts.patient')

@section('title', 'Homepage - LifeCare')

@section('content')
<section class="intro-section">
    <div class="intro-left">
        <h2>Book appointments quickly – Manage your records easily</h2>
        <p>Access your medical information anytime, anywhere.</p>
        <a href="{{ url('appointment/add_appt') }}" class="btn-primary">Book an appointment</a>
    </div>
    <div class="intro-right">
        <img src="{{ asset('assets/images/banner.png') }}" alt="Banner image">
    </div>
</section>

<section class="topic-section">
    <div class="topic-header">
        Popular Services
        <a href="{{ url('list_departments') }}" class="view-all">View All &gt;&gt;</a>
    </div>
    <hr class="breakline">
    <div class="topic"><h class="subtopic-header"></h></div>

    <div class="info-box">
        <h3>Tai Mũi Họng</h3>
        <p class="paper-detail-description"><strong>Description: </strong>Khám tai-mũi-họng</p>
    </div>
</section>
@endsection
