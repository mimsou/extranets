@php
    $statuts = \App\Models\Projet::getProjetDeType();
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
    <div class="form-group col-md-12">
        <label for="numero">No. de projet *</label>
        {!! Form::text('numero', null, ['class'=>'form-control', 'required']) !!}
    </div>
</div>


 <div class="form-row">
    <div class="form-group col-md-12">
        <label for="employeur_id">Employeur *</label>
        {!! Form::select('employeur_id', \App\Models\Employeur::orderBy('nom', 'ASC')->pluck('nom', 'id'), null, ['class'=>'form-control', 'required', 'placeholder'=>"Veuillez choisir employeur"]) !!}
    </div>
    {{-- <div class="form-group col-md-12">
        <label for="nb_candidats">NB de candidat *</label>
        {!! Form::text('nb_candidats', null, ['class'=>'form-control', 'required']) !!}
    </div> --}}
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        @php
            $users = \App\Models\User::orderBy('lastname', 'ASC')->where('role_lvl', '>', 3)->get();
            $users_array = [];

            foreach ($users as $u) {
                $users_array[$u->id] = $u->lastname .', '. $u->firstname;
            }
        @endphp
        <label for="responsable_id">Personne responsable</label>
        {!! Form::select('responsable_id', $users_array, null, ['class'=>'form-control', 'placeholder'=>'NA']) !!}
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="associations[]">Projets associés</label>
        {!! Form::select('associations[]', \App\Models\Projet::orderBy('numero', 'DESC')->pluck('numero', 'id'), null, ['class'=>'form-control select2', 'multiple'=>'multiple']) !!}
    </div>

    @if (isset($projet) && count($projet->associations))
        @foreach ($projet->associations as $a)
            @php
                $tp = \App\Models\Projet::find($a);
            @endphp

            @if(!is_null($tp))
                <a href="{{ action('ProjetController@edit', $a) }}"><span class="badge badge-{{ (Str::contains($tp->statut, 'imm'))?'danger':'secondary' }} mr-1 mb-3 ml-1">{{ $tp->numero }}</span></a>
            @endif
        @endforeach
    @endif
</div>


{{--
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="type_emploi[]">Poste</label>
        {!! Form::select('type_emploi[]', \App\Models\Emploi::pluck('title', 'id'), null, ['class'=>'form-control select2', 'multiple']) !!}
    </div>
</div>


<div class="form-row">
    <div class="form-group col-md-12">
        <label for="territoires[]">Territoires</label>
        {!! Form::select('territoires[]', \App\Models\Pays::pluck('title', 'id'), null, ['class'=>'form-control select2', 'multiple']) !!}
    </div>
</div> --}}


<h5 class="mt-4">Date importantes</h5>
<div class="form-row">

    <div class="form-group col-md-12">
        <label for="date_creation">Date de création *</label>
        {!! Form::date('date_creation', null, ['class'=>'form-control', 'required']) !!}
    </div>

    <div class="form-group col-md-12">
        <label for="date_selection">Début de sélection</label>
        {!! Form::date('date_selection', null, ['class'=>'form-control']) !!}
    </div>
</div>


@if(Auth::user()->role_lvl > 3)
    <button type="submit" class="btn btn-success btn-cta mt-4">Enregistrer</button>
@endif
