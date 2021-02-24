<div class="form-group col-md-10 mx-auto mb-4">
    <div class="row">
        <div class="col-md-8">
            {{ Form::select('statut', demandeStatuts(), null, ['class'=>'form-control text-center']) }}
        </div>
        <div class="col-md-4">
            {{ Form::select('procedure', PROCEDURE_DEMANDE, null, ['class'=>'form-control text-center']) }}
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



        <div class="form-row">

            <div class="col-md-12">
                <h4 class="mt-3">Personne Contact</h4>
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


        <div class="row">
            <div class="col-md-12">
                <h4 class="mt-3">EIMT</h4>
                <div class="form-group">
                    <label for="eimt_date_envoi">{{ __("Date d'envoi") }}</label>
                    {{ Form::date('eimt_date_envoi', null, ['class'=>'form-control', 'id'=>'eimt_date_envoi']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_date_accuse_rec">{{ __("Date de l'acccusé réception") }}</label>
                    {{ Form::date('eimt_date_accuse_rec', null, ['class'=>'form-control', 'id'=>'eimt_date_accuse_rec']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_date_reception">{{ __("Date de approbation") }}</label>
                    {{ Form::date('eimt_date_reception', null, ['class'=>'form-control', 'id'=>'eimt_date_reception']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_date_echeance">{{ __("Date d'expiration") }}</label>
                    {{ Form::date('eimt_date_echeance', null, ['class'=>'form-control', 'id'=>'eimt_date_echeance']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_numero">{{ __("Numéro") }}</label>
                    {{ Form::text('eimt_numero', null, ['class'=>'form-control', 'id'=>'eimt_numero']) }}
                </div>
            </div>
            {{-- <div class="col-md-6">
                <h4 class="mt-3">DST</h4>
                <div class="form-group">
                    <label for="dst_date_envoi">{{ __("Date d'envoi") }}</label>
                    {{ Form::date('dst_date_envoi', null, ['class'=>'form-control', 'id'=>'dst_date_envoi']) }}
                </div>

                <div class="form-group">
                    <label for="dst_date_accuse_rec">{{ __("Date de l'acccusé réception") }}</label>
                    {{ Form::date('dst_date_accuse_rec', null, ['class'=>'form-control', 'id'=>'dst_date_accuse_rec']) }}
                </div>

                <div class="form-group">
                    <label for="dst_date_reception">{{ __("Date de réception") }}</label>
                    {{ Form::date('dst_date_reception', null, ['class'=>'form-control', 'id'=>'dst_date_reception']) }}
                </div>

                <div class="form-group">
                    <label for="dst_date_echeance">{{ __("Date d'échéance") }}</label>
                    {{ Form::date('dst_date_echeance', null, ['class'=>'form-control', 'id'=>'dst_date_echeance']) }}
                </div>

                <div class="form-group">
                    <label for="dst_numero">{{ __("Numéro") }}</label>
                    {{ Form::text('dst_numero', null, ['class'=>'form-control', 'id'=>'dst_numero']) }}
                </div>
            </div> --}}
        </div>

</div>

<button type="submit" class="btn btn-lg btn-success btn-block mb-3 mt-5">{{__('SAUVEGARDER')}}</button>
