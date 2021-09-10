<div class="content active" id="observation">
    <div class="container-fluid pt-4">
        <h5>Observation</h5>
        <div class="list-group list-group-flush row">
            <div class="form-group col-md-12">
                <label>Ajouter une observation</label>
                <textarea id="comment-ta" rows="4" cols="50"
                          class="form-control js-autogrow-input comment-ta trumbowyg-textarea"></textarea>
            </div>
            <div class="p-t-10 text-right">
                <button class="btn btn-success btn-block add-comment-candidat" data-candidat-id="{!! $candidat->id !!}"><i class="mdi mdi-plus"></i> Ajouter</button>
            </div>
        </div>
        <hr>
        <div id="comments-content" class="list-group list-group-flush row"></div>
    </div>
</div>