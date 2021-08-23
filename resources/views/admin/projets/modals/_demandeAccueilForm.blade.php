@php
    $unik_id = uniqid();
    $typeDeDemande = [
        'Service de Base' => 'Service de Base',
        'rise en charge de l’accueil' => 'rise en charge de l’accueil',
        'Prise en charge et recherche de logement' => 'Prise en charge et recherche de logement',
        'Accueil personnalisé à facturation horaire' => 'Accueil personnalisé à facturation horaire'
    ];
@endphp

<div class="form-group col-md-10 mx-auto mb-4">
    <div class="row">
        <div class="col-md-4 text-left">
            {!! Form::label('statut','Statut de la demande') !!}
            {{ Form::select('statut', AccueilDemandeStatus(null, STATUTS_DEMANDE_ACCUEIL), null, ['class'=>'form-control text-center']) }}
        </div>
        <div class="col-md-3 form-group text-left">
            {!! Form::label('type_de_demande','Type de demande') !!}
            {!! Form::select('type_de_demande',$typeDeDemande,null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group col-md-4 mt-4">
            {{ Form::hidden('facturation_horaire', 'off') }}
            <label class="cstm-switch">
                {{ Form::checkbox('facturation_horaire', 'on', (isset($demande) && $demande->facturation_horaire == 'on')?true:false, ['class'=>'cstm-switch-input', 'id'=>'facturation_horaire_switch']) }}
                <span class="cstm-switch-indicator bg-success"></span>
                <span class="cstm-switch-description">{{ __('Facturation horaire') }}</span>
            </label>
        </div>
    </div>

</div>

<hr>


<div class="text-left">


    <div class="row">

        <div class="col-md-12">
            <h4 class="mt-3">Information sur la demande</h4>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="employeur_id">{{ __('Employeur') }}*</label>
                {{ Form::select('employeur_id', \App\Models\Employeur::orderBy('nom', 'asc')->pluck('nom', 'id'), null, ['class'=>'form-control text-center select2_employeurs_rec', 'id'=>'employeur_id_accueil', "style"=>"width:100%", 'placeholder'=>'Choisir un employeur', 'required']) }}
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="nb_candidat">{{ __('Nb. Candidat') }}</label>
                {{ Form::number('nb_candidat', null, ['class'=>'form-control text-center', 'placeholder'=>'1', 'required']) }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="date_debut_mandat">{{ __('Date de début de mandat') }}</label>
                {{ Form::date('date_debut_mandat', null, ['class'=>'form-control']) }}
            </div>
        </div>
        <div class="col-md-12 form-group">
            {!! Form::label('la_region','La région') !!}
            {!! Form::text('la_region',null,['class'=>'form-control','placeholder'=>'LA RÉGION']) !!}
        </div>
    </div>

    <hr>

    <div class="form-row">

        <div class="col-md-12">
            <h4 class="mt-4">Personne Contact</h4>
        </div>

        <div class="form-group col-md-4">
            <label for="contact_prenom">Prenom</label>
            {!! Form::text('contact_prenom', null, ['class'=>'form-control', 'id'=>'contact_prenom']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="contact_nom">Nom</label>
            {!! Form::text('contact_nom', null, ['class'=>'form-control', 'id'=>'contact_nom']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="contact_titre">Titre</label>
            {!! Form::text('contact_titre', null, ['class'=>'form-control', 'id'=>'contact_titre']) !!}
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="ville">Email</label>
            {!! Form::text('contact_email', null, ['class'=>'form-control', 'id'=>'contact_email']) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="province">Téléphone</label>
            {!! Form::text('contact_phone', null, ['class'=>'form-control', 'id'=>'contact_phone', 'data-mask'=>'(000) 000-0000', 'placeholder'=>'(000) 000-0000']) !!}
        </div>
        <div class="form-group col-md-2">
            <label for="province">Ext.</label>
            {!! Form::text('contact_ext', null, ['class'=>'form-control', 'id'=>'contact_ext', 'data-mask'=>'000000', 'placeholder'=>'000000']) !!}
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Form::label('nom_de_laccompagnateur','Nom de l’accompagnateur s’il y a lieu') !!}
            {!! Form::text('nom_de_laccompagnateur',null,['class'=>'form-control']) !!}
        </div>
    </div>



</div>

@if(Auth::user()->role_lvl > 3)
    <button type="submit" class="btn btn-lg btn-success btn-block mb-3 mt-5">{{__('SAUVEGARDER')}}</button>
@endif
