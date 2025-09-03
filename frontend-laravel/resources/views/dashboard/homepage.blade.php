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
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <section class="topic-section">
        <div class="topic-header">
            Popular Services
            <a href="{{ url('department/list_departments') }}" class="view-all">View All &gt;&gt;</a>
        </div>
        <hr class="breakline">
        <div class="topic">
            <h class="subtopic-header"></h>
        </div>

        <!-- Department -->
            @if(isset($error))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif

            @if(empty($departments))
                <div class="info-box">
                    <p>No departments found.</p>
                </div>
            @else
                @foreach($departments as $department)
                <div class="info-box">
                    <h3>{{ $department['DepartmentName'] }}</h3>
                    <p class="paper-detail-description">
                        <strong>Description: </strong>{{ $department['Description'] ?? 'No description available' }}
                    </p>
                </div>
                @endforeach
            @endif
            
    </section>
@endsection