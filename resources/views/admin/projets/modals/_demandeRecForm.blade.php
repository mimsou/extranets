@php
    $unik_id = uniqid();
@endphp

<div class="form-group col-md-10 mx-auto mb-4">
    <div class="row">
        <div class="col-md-8">
            {{ Form::select('statut', demandeStatuts(null, STATUTS_DEMANDE_REC), null, ['class'=>'form-control text-center']) }}
        </div>
        <div class="form-group col-md-4 mt-2">
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
                    {{ Form::select('employeur_id', \App\Models\Employeur::orderBy('nom', 'asc')->pluck('nom', 'id'), null, ['class'=>'form-control text-center select2_employeurs', 'id'=>'employeur_id', "style"=>"width:100%", 'placeholder'=>'Choisir un employeur', 'required']) }}
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
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type_emploi[]">Poste</label>
                    {!! Form::select('type_emploi[]', \App\Models\Emploi::pluck('title', 'id'), null, ['class'=>'form-control select2', 'multiple', 'style'=>"width:100%"]) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="territoires[]">Territoires</label>
                    {!! Form::select('territoires[]', \App\Models\Pays::pluck('title', 'id'), null, ['class'=>'form-control select2', 'multiple', 'style'=>"width:100%"]) !!}
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <div>Convention collective*</div>
            <div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('conv_collective', 'oui', null, ['id'=>'convcol1'.$unik_id, 'class'=>'custom-control-input', 'required']) !!}
                    <label class="custom-control-label" for="convcol1{{$unik_id}}">Oui</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('conv_collective', 'Non', null, ['id'=>'convcol2'.$unik_id, 'class'=>'custom-control-input']) !!}
                    <label class="custom-control-label" for="convcol2{{$unik_id}}">Non</label>
                </div>
            </div>
        </div>

        <hr>


        <div class="d-flex justify-content-between">
            <div>Catégorie*</div>
            <div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('rec_categorie', 'O', null, ['id'=>'catO'.$unik_id, 'class'=>'custom-control-input', 'required']) !!}
                    <label class="custom-control-label" for="catO{{$unik_id}}">O</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('rec_categorie', 'A', null, ['id'=>'catA'.$unik_id, 'class'=>'custom-control-input']) !!}
                    <label class="custom-control-label" for="catA{{$unik_id}}">A</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('rec_categorie', 'B', null, ['id'=>'catB'.$unik_id, 'class'=>'custom-control-input']) !!}
                    <label class="custom-control-label" for="catB{{$unik_id}}">B</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('rec_categorie', 'C', null, ['id'=>'catC'.$unik_id, 'class'=>'custom-control-input']) !!}
                    <label class="custom-control-label" for="catC{{$unik_id}}">C</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('rec_categorie', 'D', null, ['id'=>'catD'.$unik_id, 'class'=>'custom-control-input']) !!}
                    <label class="custom-control-label" for="catD{{$unik_id}}">D</label>
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <div>Test pratique*</div>
            <div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('test_pratique', 'oui', null, ['id'=>'test_oui'.$unik_id, 'class'=>'custom-control-input', 'required']) !!}
                    <label class="custom-control-label" for="test_oui{{$unik_id}}">Oui</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('test_pratique', 'non', null, ['id'=>'test_non'.$unik_id, 'class'=>'custom-control-input']) !!}
                    <label class="custom-control-label" for="test_non{{$unik_id}}">Non</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('test_pratique', 'a_determiner', null, ['id'=>'test_na'.$unik_id, 'class'=>'custom-control-input']) !!}
                    <label class="custom-control-label" for="test_na{{$unik_id}}">À déterminer</label>
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <div>Est-ce que le client a une limite pour poste à bas salaire?*</div>
            <div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('bas_salaire', 'oui', null, ['id'=>'bassal1'.$unik_id, 'class'=>'custom-control-input', 'required']) !!}
                    <label class="custom-control-label" for="bassal1{{$unik_id}}">Oui</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('bas_salaire', 'non', null, ['id'=>'bassal2'.$unik_id, 'class'=>'custom-control-input']) !!}
                    <label class="custom-control-label" for="bassal2{{$unik_id}}">Non</label>
                </div>
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

        <hr>


        <h4 class="mt-5">Détails du poste</h4>

        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label for="description_poste">Description du poste</label>
                    {!! Form::textarea('description_poste', null, ['class'=>'form-control', 'rows'=>'3']) !!}
                </div>
                <div class="form-group">
                    <label for="poste_fonctions">Principales fonctions</label>
                    {!! Form::textarea('poste_fonctions', null, ['class'=>'form-control', 'rows'=>'3']) !!}
                </div>
                <div class="form-group">
                    <label for="poste_competences">Compétences</label>
                    {!! Form::textarea('poste_competences', null, ['class'=>'form-control', 'rows'=>'3']) !!}
                </div>
                <div class="form-group">
                    <label for="autre_information">Autres informations utiles</label>
                    {!! Form::textarea('autre_information', null, ['class'=>'form-control', 'rows'=>'3']) !!}
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="annee_exp">{{ __("Nombre d'année d'expérience") }}</label>
                    {{ Form::number('annee_exp', null, ['class'=>'form-control', 'step'=>'1']) }}
                </div>

                <div class="form-group">
                    <label for="diplome">{{ __("Diplôme") }}</label>
                    {{ Form::text('diplome', null, ['class'=>'form-control']) }}
                </div>

                <div class="form-group">
                    <label for="langue">{{ __("Langue") }}</label>
                    {{ Form::select('langue', ['fr'=>'Français', 'en'=>'Anglais', 'bi'=>'Bilingue'], null, ['class'=>'form-control']) }}
                </div>

                <div class="form-group">
                    <label for="salaire">{{ __("Salaire") }}</label>
                    {{ Form::text('salaire', null, ['class'=>'form-control']) }}
                </div>

                <div class="form-group">
                    <label for="lieu_travail">{{ __("Lieu de travail") }}</label>
                    {{ Form::text('lieu_travail', null, ['class'=>'form-control']) }}
                </div>

                <div class="form-group">
                    <label for="code_cnp">{{ __("Code CNP") }}</label>
                    {{ Form::text('code_cnp', null, ['class'=>'form-control']) }}
                </div>
            </div>
        </div>


</div>

@if(Auth::user()->role_lvl > 3)
    <button type="submit" class="btn btn-lg btn-success btn-block mb-3 mt-5">{{__('SAUVEGARDER')}}</button>
@endif
