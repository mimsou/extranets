<div class="form-row">
    <div class="form-group col-md-2">
        <label for="abrev">ABREV *</label>
        {!! Form::text('abrev', null, ['class'=>'form-control', 'required']) !!}
    </div>
    <div class="form-group col-md-10">
        <label for="title">Nom du pays *</label>
        {!! Form::text('title', null, ['class'=>'form-control', 'required']) !!}
    </div>
</div>


<button type="submit" class="btn btn-success btn-cta">Enregistrer</button>
