
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="firstname">Prénom</label>
        {!! Form::text('firstname', null, ['required', 'class'=>'form-control', 'placeholder'=>'Prénom']) !!}
        @error('firstname')
            <span class="help-block text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="lastname">Nom de famille</label>
        {!! Form::text('lastname', null, ['required', 'class'=>'form-control', 'placeholder'=>'Nom']) !!}
        @error('lastname')
            <span class="help-block text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-12">
        <label for="email">Email</label>
        {!! Form::text('email', null, ['required', 'class'=>'form-control', 'placeholder'=>'Email']) !!}
        @error('email')
            <span class="help-block text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-6">
        <label for="new_password">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="new_password" placeholder="Password" value="">
        @if(isset($user))
            <small class="text-gray-400">Leave blank if you do not want to update</small>
        @endif
        @error('password')
        <span class="help-block text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="form-group col-md-6">
        <label for="new_password_confirm">Confirmation du nouveau mot de passe</label>
        <input type="password" class="form-control" name="password_confirmation" id="new_password_confirm" placeholder="Password" value="">
        @error('confirm_password')
        <span class="help-block text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>

<button type="submit" class="btn btn-success btn-cta mt-3">Enregistrer</button>
