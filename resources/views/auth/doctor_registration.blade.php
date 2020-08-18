@extends('layouts.auth')

@section('content')
<div class="form py-4">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="user_type" value="2">
        <div class="form-head">
            <h2>Vous êtes praticien? Inscrivez vous</h2>
            <h4 class="text-light">Inscrivez vous et recevez vos patients dès aujourd'hui</h4>
        </div>
        <div class="form-group">
            <label class="text-uppercase">Secteur Médical</label>
            <select name="category" class="form-control">
                @foreach($categories as $cat)
                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                @endforeach
            </select>
            @error('email')
                <div class="text-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label class="text-uppercase">Numéro Finesse</label>
                <input id="numeroFinesse" type="text" class="form-control @error('numeroFinesse') is-invalid @enderror" name="numeroFinesse" value="{{ old('numeroFinesse') }}" required autofocus>
                @error('numeroFinesse')
                    <div class="text-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label>R.P.P.S.</label>
                <input id="rpps" type="text" class="form-control @error('rpps') is-invalid @enderror" name="rpps" value="{{ old('rpps') }}" required autofocus>
                @error('rpps')
                    <div class="text-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <div class="col-md-6">
                <label class="text-uppercase">Prénom</label>
                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required autofocus>
                @error('firstName')
                    <div class="text-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Nom</label>
                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required autofocus>
                @error('lastName')
                    <div class="text-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label class="text-uppercase">Adresse Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="new-password" autofocus>
            @error('email')
                <div class="text-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="" class="text-uppercase">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                <div class="text-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label class="text-uppercase">Numéro de Téléphone</label>
            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="new-password" autofocus>
            @error('phone')
                <div class="text-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label class="text-uppercase">Localisation</label>
            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="new-password" autofocus>
            @error('address')
                <div class="text-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <!--<h4 class="text-light mb-4">A password will be sent to your email address.</h4>-->
        <!--<div class="form-group d-flex">-->
        <!--    <input type="checkbox">-->
        <!--    <p class="text-light ml-2">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#" class="text-light text-dashed">privacy policy</a>.</p>-->
        <!--</div>-->
        <div class="form-group d-flex justify-content-between align-items-center">
            <p class="text-light m-0">Already have an account? <a href="{{url('login')}}">Login</a></p>
            <button type="submit" class="btn-primary btn-sm transition-3d-hover">
                Register
            </button>
            <!--<a href="#" class="btn-primary btn-sm transition-3d-hover">Get Started</a>-->
        </div>
    </form>
</div><!-- /form -->
@endsection
