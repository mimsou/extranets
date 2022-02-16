@extends('admin.atmos-jumbo')

@section('content')


<div class="mx-auto col-md-8">

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="p-b-10 text-center">
                <img src="{{ asset('assets/IE_SIMPLE_LOGO.png') }}" width="240" alt="">

        </div>
        <h3 class="text-center p-b-20 fw-400">{{ __('Connexion') }}</h3>


        <form class="needs-validation" action="{{ route('login') }}">
            @csrf

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
            </div>

            <div class=" m-b-10">
                <label class="cstm-switch">
                    <input type="checkbox" name="remember" value="1" class="cstm-switch-input" {{ old('remember') ? 'checked' : '' }}>
                    <span class="cstm-switch-indicator "></span>
                    <span class="cstm-switch-description">{{ __('Se souvenir de moi') }} </span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">{{ __('Connexion') }}</button>

        </form>
        @if (Route::has('password.request'))
            <p class="text-right p-t-10">
                <a href="{{ route('password.request') }}" class="text-underline">{{ __('Mot de passe oublié?') }}</a>
            </p>
        @endif
    </form>
</div>


@endsection




