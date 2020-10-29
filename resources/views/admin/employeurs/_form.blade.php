<div class="form-row">
    <div class="form-group col-md-9">
        <label for="firstname">Nom de la compagnie *</label>
        {!! Form::text('nom', null, ['class'=>'form-control', 'required']) !!}
    </div>
    <div class="form-group col-md-3">
        <label for="firstname">Regroupement</label>
        {!! Form::select('regroupement_id', \App\Models\Regroupement::orderBy('title', 'asc')->pluck('title', 'id'), null, ['class'=>'form-control', 'placeholder'=>'NA']) !!}
    </div>
</div>


<h5 class="mt-4">Adresse de la compagnie</h5>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="firstname">Adresse</label>
        {!! Form::text('adresse', null, ['class'=>'form-control mb-1']) !!}
        {!! Form::text('adresse_2', null, ['class'=>'form-control']) !!}
    </div>
</div>

@php
    $province = null;
    $pays = null; //Canada
    if(!isset($employeur)){
        $province = 'QC';
        $pays = 16; //Canada
    }
@endphp


<div class="form-row">
    <div class="form-group col-md-8">
        <label for="ville">Ville</label>
        {!! Form::text('ville', null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group col-md-4">
        <label for="province">Province</label>
        {!! Form::text('province', $province, ['class'=>'form-control', 'placeholder'=>'Ex: QC']) !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="ville">Pays</label>
        {!! Form::select('pays', \App\Models\Pays::orderBy('title', 'asc')->pluck('title', 'id'), $pays, ['class'=>'form-control', 'placeholder'=>'Veuillez choisir']) !!}
    </div>
    <div class="form-group col-md-6">
        <label for="zip">Code postale</label>
        {!! Form::text('zip', null, ['class'=>'form-control', 'style'=>'text-transform: uppercase', 'data-mask'=>'S0S 0S0']) !!}
    </div>
</div>


<h5 class="mt-4">Contact principal</h5>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="contact_prenom">Prenom</label>
        {!! Form::text('contact_prenom', null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group col-md-4">
        <label for="contact_nom">Nom</label>
        {!! Form::text('contact_nom', null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group col-md-4">
        <label for="contact_titre">Titre</label>
        {!! Form::text('contact_titre', null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-8">
        <label for="ville">Email</label>
        {!! Form::text('contact_email', null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group col-md-4">
        <label for="province">Téléphone</label>
        {!! Form::text('contact_phone', null, ['class'=>'form-control', 'data-mask'=>'(000) 000-0000', 'placeholder'=>'(000) 000-0000']) !!}
    </div>
</div>


<div class="form-group col-md-12 mt-3 mb-4">
    <label class="cstm-switch">
        <input type="checkbox" name="has_secondary_contact" value="yes" id="has_secondary_contact_switch" class="cstm-switch-input"
        {{ (old('has_secondary_contact', $employeur->has_secondary_contact) == 'yes') ? ' checked' : '' }}>
        <span class="cstm-switch-indicator bg-success"></span>
        <span class="cstm-switch-description">{{ __('Ajouter second contact') }}</span>
    </label>
</div>


<div class="secondary_contact mb-4">
    <h5 class="mt-3">Contact secondaire</h5>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="secondary_contact_prenom">Prenom</label>
            {!! Form::text('secondary_contact_prenom', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="secondary_contact_nom">Nom</label>
            {!! Form::text('secondary_contact_nom', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="secondary_contact_titre">Titre</label>
            {!! Form::text('secondary_contact_titre', null, ['class'=>'form-control']) !!}
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="ville">Email</label>
            {!! Form::text('secondary_contact_email', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="province">Téléphone</label>
            {!! Form::text('secondary_contact_phone', null, ['class'=>'form-control', 'data-mask'=>'(000) 000-0000', 'placeholder'=>'(000) 000-0000']) !!}
        </div>
    </div>
</div>

<button type="submit" class="btn btn-success btn-cta">Enregistrer</button>
