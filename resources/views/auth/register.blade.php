@extends('layouts.home')
@section('page-style')
    <style>
        .card:hover {
            box-shadow: 0 3px 5px 5px rgba(0, 160, 223, .2)
        }
    </style>
@endsection
@section('content')
<div class="container space-2 w-lg-80 w-xl-50 mx-auto">
    <div class="text-center w-md-80 w-lg-60 mx-auto">
        <div class="mb-4">
            <h2 class="h1 text-primary">Inscription <strong>Urgolive</strong></h2>
            <p class="text-secondary">devenez member et passez live afin d'utiliser les services de mise en relation patient et praticion.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 text-center">
            <div class="card p-5 m-4">
                <img src="{{asset('images/patient.png')}}" alt="" class="w-75 d-block mx-auto">
                <a href="{{url('patient-register')}}" class="btn btn-primary transition-3d-hover mt-2" style="white-space: normal">Patient Registration</a>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <div class="card p-5 m-4">
                <img src="{{asset('images/doctor.png')}}" alt="" class="w-75 mx-auto d-block">
                <a href="{{url('doctor-register')}}" class="btn btn-primary transition-3d-hover mt-2" style="white-space: normal">Doctor Registration</a>
            </div>
        </div>
    </div>
</div>
@endsection
