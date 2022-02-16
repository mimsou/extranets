@extends('admin.atmos-jumbo')

@section('content')



<div class="mx-auto col-md-8">


    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="p-b-20 text-center">
            <p>
                <img src="{{ asset('assets/images/impact_evolution_logo_black_md.png') }}" width="240" alt="">
            </p>
            <p class="admin-brand-content">
                {{-- {{ env('APP_NAME') }} --}}
            </p>
        </div>
        <h3 class="text-center p-b-20 fw-400">{{ __('Connexion') }}</h3>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="form-row">
                <div class="form-group floating-label col-md-12">
                    <label>{{ __('Adresse courriel') }}</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Adresse courriel') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group floating-label col-md-12">
                    <label>{{ __('Mot de passe') }}</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Mot de passe') }}" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group floating-label col-md-12">
                    <label>{{ __('Confirmation mot de passe') }}</label>
                    <input id="password_confirmation" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="{{ __('Confirmation mot de passe') }}" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>




            <button type="submit" class="btn btn-primary btn-block btn-lg">{{ __('Réinitialiser mon mot de passe') }}</button>

    </form>
</div>



@endsection
