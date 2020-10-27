@extends('admin.atmos-jumbo')

@section('content')



<div class="mx-auto col-md-8">


    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="p-b-20 text-center">
                <img src="{{ asset('assets/images/impact_evolution_logo_black_md.png') }}" width="240" alt="">
        </div>
        <h3 class="text-center p-b-20 fw-400">{{ __('Réinitialisation') }}</h3>
        <p>{{ __('Vous avez oublié votre mot de passe? Aucun problème! Simplement inscrire votre courriel ci-bas, ceci nous permettra de vous envoyer un courriel incluant un lien de réinitialisation.') }}</p>

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
            </div>




            <button type="submit" class="btn btn-primary btn-block btn-lg">{{ __('Envoyer un lien de réinitialisation') }}</button>

    </form>
</div>


@endsection
