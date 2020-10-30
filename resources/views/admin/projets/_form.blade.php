<div class="form-row">
    <div class="form-group col-md-6">
        <label for="titre">Titre du projet *</label>
        {!! Form::text('titre', null, ['class'=>'form-control', 'required']) !!}
    </div>
    <div class="form-group col-md-3">
        <label for="numero">No. de projet *</label>
        {!! Form::text('numero', null, ['class'=>'form-control', 'required']) !!}
    </div>

    <div class="form-group col-md-3">
        <label for="date_creation">Date création *</label>
        {!! Form::date('date_creation', null, ['class'=>'form-control', 'required']) !!}
    </div>

</div>



<div class="form-row">
    <div class="form-group col-md-8">
        <label for="employeur_id">Employeur *</label>
        {!! Form::select('employeur_id', \App\Models\Employeur::orderBy('nom', 'ASC')->pluck('nom', 'id'), null, ['class'=>'form-control', 'required', 'placeholder'=>"Veuillez choisir employeur"]) !!}
    </div>
    <div class="form-group col-md-4">
        <label for="nb_candidats">NB de candidat *</label>
        {!! Form::text('nb_candidats', null, ['class'=>'form-control', 'required']) !!}
    </div>
</div>




<div class="form-row">
    <div class="form-group col-md-12">
        <label for="type_emploi">Poste *</label>
        {!! Form::select('type_emploi[]', \App\Models\Emploi::pluck('title', 'id'), null, ['class'=>'form-control select2', 'multiple']) !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="territoires[]">Territoires</label>
        {!! Form::select('territoires[]', \App\Models\Pays::pluck('title', 'id'), null, ['class'=>'form-control select2', 'multiple']) !!}
    </div>
</div>


<button type="submit" class="btn btn-success btn-cta">Enregistrer</button>
