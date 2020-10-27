
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="firstname">Prénom</label>
        {!! Form::text('firstname', null, ['required', 'class'=>'form-control', 'placeholder'=>'Prénom']) !!}
    </div>
    <div class="form-group col-md-6">
        <label for="lastname">Nom de famille</label>
        {!! Form::text('lastname', null, ['required', 'class'=>'form-control', 'placeholder'=>'Nom']) !!}    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-6">
        <label for="email">Email</label>
        {!! Form::text('email', null, ['required', 'class'=>'form-control', 'placeholder'=>'Email']) !!}
    </div>
    <div class="form-group col-md-6">
        @php
            $roles = [10=>'Super-admin', 5=>'Admin'];
            $disabled = '';
            if(Auth::user()->role_lvl < 10){
                $disabled = 'disabled';
            }
        @endphp
        <label for="role_lvl">Role</label>
        {!! Form::select('role_lvl', $roles, null, ['class'=>'form-control', $disabled]) !!}
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-6">
        <label for="new_password">Mot de passe</label>
        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Password" value="">
    </div>
    <div class="form-group col-md-6">
        <label for="new_password_confirm">Confirmation du nouveau mot de passe</label>
        <input type="password" class="form-control" name="new_password_confirm" id="new_password_confirm" placeholder="Password" value="">
    </div>
</div>

<button type="submit" class="btn btn-success btn-cta mt-3">Enregistrer</button>
