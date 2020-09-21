<div class="form-row">
    <div class="form-group col-md-6">
        <label for="firstname">Prénom</label>
        <input type="text" value="{{ old('firstname', $user->firstname) }}" class="form-control" name="firstname" id="firstname" placeholder="Prénom">
    </div>
    <div class="form-group col-md-6">
        <label for="lastname">Nom de famille</label>
        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom" value="{{ old('lastname', $user->lastname) }}">
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-6">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email', $user->email) }}">
    </div>
    <div class="form-group col-md-6">
        <label for="role_id">Role</label>
        <select name="role_id" id="role_id" class="form-control">
            <option value="1">Super-admin</option>
        </select>
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

<div class="form-group">
    <label for="nova_cal_link">Lien calendrier NOVA</label>
    <input type="text" class="form-control" name="nova_cal_link" id="nova_cal_link" value="{{ old('nova_cal_link', $user->nova_cal_link) }}">
</div>

<div class="form-group">
    <label for="retro_cal_link">Lien calendrier 360</label>
    <input type="text" class="form-control" name="retro_cal_link" id="retro_cal_link" value="{{ old('retro_cal_link', $user->retro_cal_link) }}">
</div>

<div class="form-group">
    <label for="bilan_cal_link">Lien calendrier Bilan</label>
    <input type="text" class="form-control" name="bilan_cal_link" id="bilan_cal_link" value="{{ old('bilan_cal_link', $user->bilan_cal_link) }}">
</div>

<button type="submit" class="btn btn-success btn-cta">Enregistrer</button>
