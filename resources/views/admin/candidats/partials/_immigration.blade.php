<div class="content" id="immigration">

    @include('admin.partials._notes', ['model'=>$candidat, 'category'=>'immigration'])

    <div class="container-fluid pt-4">
        <h2 class="mb-3">Immigration</h2>

        {{-- <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="immigration_user_id">{{ __('Nom du responsable du projet en immigration') }}</label>
                    {{ Form::select('immigration_user_id', \App\Models\User::all()->pluck('firstname', 'id'), null, ['class'=>'form-control', 'placeholder'=>'Choisir un recruteur', 'id'=>'recruteur_id']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date_mandat_immigration">{{ __("Date de début du mandat en immigration") }}</label>
                    {{ Form::date('date_mandat_immigration', null, ['class'=>'form-control', 'placeholder'=>'Choisir un emploi', 'id'=>'date_mandat_immigration']) }}
                </div>
            </div>
        </div> --}}

        @php
            $last_demande = null;
            $demandes = $candidat->demandesImmigration;

            // EIMT
            $eimt_date_envoi = null;
            $eimt_date_echeance = null;
            $eimt_date_accuse_rec = null;
            $eimt_date_reception = null;
            $eimt_numero = null;

            foreach ($demandes as $d) {
                $eimt_date_envoi = $d->eimt_date_envoi;
                $eimt_date_echeance = $d->eimt_date_echeance;
                $eimt_date_accuse_rec = $d->eimt_date_accuse_rec;
                $eimt_date_reception = $d->eimt_date_reception;
                $eimt_numero = $d->eimt_numero;
            }

            // DST
            $dst_date_envoi = null;
            $dst_date_echeance = null;
            $dst_date_accuse_rec = null;
            $dst_date_reception = null;
            $dst_numero = null;

            foreach ($demandes as $d) {
                $dst_date_envoi = (is_null($candidat->dst_date_envoi))?$d->dst_date_envoi:$candidat->dst_date_envoi;
                $dst_date_echeance = (is_null($candidat->dst_date_echeance))?$d->dst_date_echeance:$candidat->dst_date_echeance;
                $dst_date_accuse_rec = (is_null($candidat->dst_date_accuse_rec))?$d->dst_date_accuse_rec:$candidat->dst_date_accuse_rec;
                $dst_date_reception = (is_null($candidat->dst_date_reception))?$d->dst_date_reception:$candidat->dst_date_reception;
                $dst_numero = (is_null($candidat->dst_numero))?$d->dst_numero:$candidat->dst_numero;
            }

        @endphp

        <div class="row">
            <div class="col-md-4">
                <h4>EIMT</h4>
                <div class="form-group">
                    <label for="eimt_date_envoi">{{ __("Date d'envoi") }}</label>
                    {{ Form::date('eimt_date_envoi', $eimt_date_envoi, ['class'=>'form-control', 'readonly', 'id'=>'eimt_date_envoi']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_date_accuse_rec">{{ __("Date de l'acccusé réception") }}</label>
                    {{ Form::date('eimt_date_accuse_rec', $eimt_date_accuse_rec, ['class'=>'form-control', 'readonly', 'id'=>'eimt_date_accuse_rec']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_date_reception">{{ __("Date d'approbation") }}</label>
                    {{ Form::date('eimt_date_reception', $eimt_date_reception, ['class'=>'form-control', 'readonly', 'id'=>'eimt_date_reception']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_date_echeance">{{ __("Date d'expiration") }}</label>
                    {{ Form::date('eimt_date_echeance', $eimt_date_echeance, ['class'=>'form-control', 'readonly', 'id'=>'eimt_date_echeance']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_numero">{{ __("Numéro") }}</label>
                    {{ Form::text('eimt_numero', $eimt_numero, ['class'=>'form-control', 'readonly', 'id'=>'eimt_numero']) }}
                </div>
            </div>
            <div class="col-md-4">
                <h4>DST</h4>
                <div class="form-group">
                    <label for="dst_date_envoi">{{ __("Date d'envoi") }}</label>
                    {{ Form::date('dst_date_envoi', $dst_date_envoi, ['class'=>'form-control', 'id'=>'dst_date_envoi']) }}
                </div>

                <div class="form-group">
                    <label for="dst_date_accuse_rec">{{ __("Date de l'acccusé réception") }}</label>
                    {{ Form::date('dst_date_accuse_rec', $dst_date_accuse_rec, ['class'=>'form-control', 'id'=>'dst_date_accuse_rec']) }}
                </div>

                <div class="form-group">
                    <label for="dst_date_reception">{{ __("Date de réception") }}</label>
                    {{ Form::date('dst_date_reception', $dst_date_reception, ['class'=>'form-control', 'id'=>'dst_date_reception']) }}
                </div>

                <div class="form-group">
                    <label for="dst_date_echeance">{{ __("Date d'échéance") }}</label>
                    {{ Form::date('dst_date_echeance', $dst_date_echeance, ['class'=>'form-control', 'id'=>'dst_date_echeance']) }}
                </div>

                <div class="form-group">
                    <label for="dst_numero">{{ __("Numéro") }}</label>
                    {{ Form::text('dst_numero', $dst_numero, ['class'=>'form-control', 'id'=>'dst_numero']) }}
                </div>
            </div>
            <div class="col-md-4">
                <h4>Permis de travail</h4>
                <div class="form-group">
                    <label for="permis_date_envoi">{{ __("Statut du permis") }}</label>
                    {{ Form::select('statut_pt', permisTravailStatuts(), null, ['class'=>'form-control', 'id'=>'permis_date_envoi']) }}
                </div>
                <div class="form-group">
                    <label for="permis_date_envoi">{{ __("Date d'envoi de la demande") }}</label>
                    {{ Form::date('permis_date_envoi', null, ['class'=>'form-control', 'id'=>'permis_date_envoi']) }}
                </div>
                <div class="form-group">
                    <label for="permis_date_reception">{{ __("Date de réception") }}</label>
                    {{ Form::date('permis_date_reception', null, ['class'=>'form-control', 'id'=>'permis_date_reception']) }}
                </div>
                <div class="form-group">
                    <label for="permis_date_echeance">{{ __("Date d'échéance du permis en vigueur") }}</label>
                    {{ Form::date('permis_date_echeance', null, ['class'=>'form-control', 'id'=>'permis_date_echeance']) }}
                </div>
                <div class="form-group">
                    <label for="permis_date_renouvellement">{{ __("Date de la dernière demande de renouvellement") }}</label>
                    {{ Form::date('permis_date_renouvellement', null, ['class'=>'form-control', 'id'=>'permis_date_renouvellement']) }}
                </div>
            </div>
        </div>

        <br>

        <h2 class="mt-4">Demandes d'immigration associées</h2>

        @if (!$candidat->demandesImmigration()->count())
            <p><i>Aucun projet en immigration n'est associé à ce candidat. Veuillez vous rendre dans <a href="{{action('ProjetController@index')}}" style="text-decoration:underline">la section projet</a> pour créer un nouveau projet ou l'associer à un existant.</i></p>
        @endif

        @foreach ($candidat->demandesImmigration as $p)
            @include('admin.candidats.partials._projet-immigration', ['p'=>$p])
        @endforeach

    </div>
</div>
