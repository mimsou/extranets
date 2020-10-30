@php
    $statuts = ['new_projet'=>__('new_projet'),
                'Immigration' => [
                    'imm_eimt_dst_pt'=>__('imm_eimt_dst_pt'),
                    'imm_eimt_dst_pt_ave'=>__('imm_eimt_dst_pt_ave'),
                    'imm_pt'=>__('imm_pt'),
                    'imm_pt_ave'=>__('imm_pt_ave'),
                    'imm_conf_pt'=>__('imm_conf_pt'),
                    'imm_individu'=>__('imm_individu'),
                    'imm_autre'=>__('imm_autre')],
                'Recrutement' => [
                    'rec_mission_dedie'=>__('rec_mission_dedie'),
                    'rec_mission_partagee'=>__('rec_mission_partagee'),
                    'rec_mission_partenaire'=>__('rec_mission_partenaire'),
                    'rec_garantie'=>__('rec_garantie'),
                    'rec_cdts_qualifies'=>__('rec_cdts_qualifies'),
                ],
                'acc_accueil' => __('acc_accueil')];
@endphp

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="statut">Type de projet</label>
        {!! Form::select('statut', $statuts, null, ['class'=>'form-control', 'required']) !!}
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-12">
        <label for="titre">Titre du projet *</label>
        {!! Form::text('titre', null, ['class'=>'form-control', 'required']) !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="numero">No. de projet *</label>
        {!! Form::text('numero', null, ['class'=>'form-control', 'required']) !!}
    </div>
    <div class="form-group col-md-6">
        <label for="date_creation">Date création *</label>
        {!! Form::date('date_creation', null, ['class'=>'form-control', 'required']) !!}
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-12">
        <label for="employeur_id">Employeur *</label>
        {!! Form::select('employeur_id', \App\Models\Employeur::orderBy('nom', 'ASC')->pluck('nom', 'id'), null, ['class'=>'form-control', 'required', 'placeholder'=>"Veuillez choisir employeur"]) !!}
    </div>
    <div class="form-group col-md-12">
        <label for="nb_candidats">NB de candidat *</label>
        {!! Form::text('nb_candidats', null, ['class'=>'form-control', 'required']) !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="type_emploi[]">Poste *</label>
        {!! Form::select('type_emploi[]', \App\Models\Emploi::pluck('title', 'id'), null, ['class'=>'form-control select2', 'multiple']) !!}
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-12">
        <label for="territoires[]">Territoires *</label>
        {!! Form::select('territoires[]', \App\Models\Pays::pluck('title', 'id'), null, ['class'=>'form-control select2', 'multiple']) !!}
    </div>
</div>


<h5 class="mt-4">Date importantes</h5>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="date_selection">Début de sélection</label>
        {!! Form::date('date_selection', null, ['class'=>'form-control']) !!}
    </div>
</div>



<button type="submit" class="btn btn-success btn-cta mt-4">Enregistrer</button>
