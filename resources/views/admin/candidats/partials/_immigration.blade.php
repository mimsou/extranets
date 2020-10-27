<div class="content" id="immigration">
    <div class="container-fluid pt-4">
        <h2 class="mb-3">Immigration</h2>

        <div class="row mb-4">
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
        </div>

        <div class="row">
            <div class="col-md-4">
                <h4>EIMT</h4>
                <div class="form-group">
                    <label for="eimt_date_envoi">{{ __("Date d'envoi") }}</label>
                    {{ Form::date('eimt_date_envoi', null, ['class'=>'form-control', 'id'=>'eimt_date_envoi']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_date_accuse_rec">{{ __("Date de l'acccusé réception") }}</label>
                    {{ Form::date('eimt_date_accuse_rec', null, ['class'=>'form-control', 'id'=>'eimt_date_accuse_rec']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_date_reception">{{ __("Date de réception") }}</label>
                    {{ Form::date('eimt_date_reception', null, ['class'=>'form-control', 'id'=>'eimt_date_reception']) }}
                </div>

                <div class="form-group">
                    <label for="eimt_numero">{{ __("Numéro") }}</label>
                    {{ Form::text('eimt_numero', null, ['class'=>'form-control', 'id'=>'eimt_numero']) }}
                </div>
            </div>
            <div class="col-md-4">
                <h4>DST</h4>
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
                    <label for="dst_numero">{{ __("Numéro") }}</label>
                    {{ Form::text('dst_numero', null, ['class'=>'form-control', 'id'=>'dst_numero']) }}
                </div>
            </div>
            <div class="col-md-4">
                <h4>Permis de travail</h4>
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

        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="com_immigration">{{ __("Commentaires en immigration des individus") }}</label>
                    {{ Form::textarea('com_immigration', null, ['class'=>'form-control', 'placeholder'=>'Entrer vos commentaires ici', 'id'=>'com_immigration']) }}
                </div>
            </div>
        </div>
    </div>
</div>
