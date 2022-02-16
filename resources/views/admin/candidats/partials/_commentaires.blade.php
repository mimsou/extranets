<div class="content" id="commentaires">
    <div class="container-fluid pt-4">
        <h2>Commentaires</h2>

        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="com_bureau_etranger">{{ __("Commentaires bureau à l'étranger") }}</label>
                    {{ Form::textarea('com_bureau_etranger', null, ['class'=>'form-control', 'placeholder'=>'Entrer vos commentaires ici', 'id'=>'com_bureau_etranger']) }}
                </div>
            </div>
        </div>


    </div>
</div>
