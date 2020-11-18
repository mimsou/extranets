{!! Form::model($demande, ['method' => 'PATCH', 'action' => ['ProjetController@editDemande', $projet->id, $demande->id] ]) !!}

    {!! Form::hidden('projet_id', $projet->id) !!}

    <h3 class="pt-3 ">{{ __("Modifier la demande") }}</h3>

    @include('admin.projets.modals._demandeForm')
{!! Form::close() !!}
