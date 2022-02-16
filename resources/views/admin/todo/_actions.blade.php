<a href="javascript:void(0)" class="btn btn-primary btn-sm view-template" data-id="{{ $model->id }}">
    Aperçu
</a>
<a class="btn btn-danger btn-sm" href="{{ route('delete.template',['id'=>$model->id]) }}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer?')">
    Supprimer
</a>