<div class="content" id="accueil">
    @if(Auth::user()->role_lvl > 3)
        @include('admin.partials._notes', ['model'=>$candidat, 'category'=>'immigration'])
    @endif
    <div class="container-fluid pt-4">
        <h2 class="mb-3">Accueil</h2>

        @php
            $last_demande = null;
            $demandes = $candidat->demandesAccueil;

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
            $etatCivil = [
                'célibataire' => 'Célibataire',
                'mari' => 'Mari',
                'divorcé' => 'Divorcé',
                'fiancé' => 'Fiancé',
                'en_fréquentation' => 'En fréquentation'
            ];

        @endphp

        <div class="row">
            <div class="col-md-12">
                <h4>Information général</h4>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('etat_civil','Etat civil') !!}
                {!! Form::select('etat_civil',$etatCivil,null,['class'=>'form-control','placeholder'=>'Etat civil']) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('nombre_d_enfants','Nombre d’enfants') !!}
                {!! Form::number('nombre_d_enfants',null,['class'=>'form-control','placeholder'=>'1','min'=>0]) !!}
            </div>
            <div class="rep_age">
                @if(isset($candidat) && $candidat->age_d_enfants != '')
                    @php
                        $ageData = unserialize($candidat->age_d_enfants);
                    @endphp
                    @foreach($ageData as $key => $age)
                        <div class="form-group col-md-3">
                            <div class="age_field">
                                <label>Âge des enfants</label>
                                <input type="number" name="age_d_enfants[]" value="{{ $age }}" class="form-control" placeholder="Age" />
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <h4>Adresse</h4>
            </div>
            <div class="col-md-4">
                {!! Form::label('address_1','Adresse') !!}
                {!! Form::text('address_1',null,['class'=>'form-control']) !!}
                {!! Form::text('address_2',null,['class'=>'form-control mt-1']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('city','Vile') !!}
                {!! Form::text('city',null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::label('province','Province') !!}
                {!! Form::text('province',null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4 mt-3">
                {!! Form::label('country','Pays') !!}
                {!! Form::select('country',\App\Models\Pays::orderBy('title', 'asc')->pluck('title', 'id'),null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4 mt-3">
                {!! Form::label('postal_code','Code postal') !!}
                {!! Form::text('postal_code',null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4 mt-3">
                {!! Form::label('date_d_arrivee','Date d’Arrivee') !!}
                {!! Form::date('date_d_arrivee',null,['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h4>Autres</h4>
            </div>
            <div class="col-md-4 mt-1">
                {!! Form::label('nom_de_l_accompagnateur','Nom de l’accompagnateur s’il y a lieu') !!}
                {!! Form::text('nom_de_l_accompagnateur',null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4 mt-1">
                {!! Form::label('la_region_de_lemploi','La région de l’emploi') !!}
                {!! Form::text('la_region_de_lemploi',null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4 mt-1">
                {!! Form::label('contact_telephonique','Contact Téléphonique') !!}
                {!! Form::text('contact_telephonique',null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4 mt-1">
                {!! Form::label('lien_facebook','Lien facebook/Groupe messenger') !!}
                {!! Form::text('lien_facebook',null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-4 mt-1">
                {!! Form::label('whatsapp','Whatsapps') !!}
                {!! Form::text('whatsapp',null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-12 mt-4">
                {!! Form::label('commentaires_generaux','Commentaires généraux') !!}
                {!! Form::textarea('commentaires_generaux',null,['class'=>'form-control','rows'=>3]) !!}
            </div>
        </div>

        <br>

        <h2 class="mt-4">Demandes d'accueil associées</h2>

        @if (!$candidat->demandesImmigration()->wherePivot('statut','approved')->count())
            <p><i>Aucun projet en immigration n'est associé à ce candidat. Veuillez vous rendre dans <a href="{{action('ProjetController@index')}}" style="text-decoration:underline">la section projet</a> pour créer un nouveau projet ou l'associer à un existant.</i></p>
        @endif

        @foreach ($candidat->demandesAccueil()->wherePivot('statut','approved')->get() as $p)
            @include('admin.candidats.partials._projet-accueil', ['p'=>$p])
        @endforeach

    </div>
</div>
