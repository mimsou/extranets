<div class="content" id="administration">
    <div class="container-fluid pt-4">
        <h2>Administration</h2>

        <div class="form-group mb-5">
            <label for="nom_employeur">{{ __("Nom de l'employeur") }}</label>
            {{ Form::text('nom_employeur', null, ['class'=>'form-control', 'id'=>'nom_employeur']) }}
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Projet initial</h5>
                <div class="form-group">
                    <label for="no_projet_initial">{{ __("Numéro de projet initial") }}</label>
                    {{ Form::text('no_projet_initial', null, ['class'=>'form-control', 'id'=>'no_projet_initial']) }}
                </div>

                <div class="form-group">
                    <label for="no_projet_initial">{{ __("Date création du projet") }}</label>
                    {{ Form::date('date_projet_initial', null, ['class'=>'form-control', 'id'=>'date_projet_initial']) }}
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Projet renouvellement</h5>
                <div class="form-group">
                    <label for="no_projet_renouvellement">{{ __("Numéro de projet") }}</label>
                    {{ Form::text('no_projet_renouvellement', null, ['class'=>'form-control', 'id'=>'no_projet_renouvellement']) }}
                </div>

                <div class="form-group">
                    <label for="no_projet_renouvellement">{{ __("Date création du projet") }}</label>
                    {{ Form::date('date_projet_renouvellement', null, ['class'=>'form-control', 'id'=>'date_projet_renouvellement']) }}
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <h5>Projet autre</h5>
                <div class="form-group">
                    <label for="no_projet_reautre">{{ __("Numéro de projet") }}</label>
                    {{ Form::text('no_projet_reautre', null, ['class'=>'form-control', 'id'=>'no_projet_reautre']) }}
                </div>

                <div class="form-group">
                    <label for="no_projet_reautre">{{ __("Date création du projet") }}</label>
                    {{ Form::date('date_projet_autre', null, ['class'=>'form-control', 'id'=>'date_projet_autre']) }}
                </div>
            </div>
        </div>


        <h5>Facturation</h5>

        <i>Q: À mettre dans le candidat?</i>

    </div>
</div>
