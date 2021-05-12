<div id="demande_notes" class="active">
    <div class="note_window_container">
        <div class="row see-all-comments" data-demande-id="{{ $demande->id }}">
            <div class="col-md-12 text-center">
                <a href="javascript:void(0)">Voir tous les commentaires</a>
            </div>
        </div>
        <div class="demande_old_messages_shadow"></div>
        <div id="note-messages">
            @if($notes->isEmpty())
                <i id="no-comment">No any comment yet</i>
            @endif
            @foreach($notes as $n)
                @include('admin.partials._message', ['n'=>$n])
            @endforeach
        </div>

        <div id="note-comment-form" data-url="{{ action('UserController@saveComment', Auth::user()->id) }}">
            <textarea class="note form-control" id="note_message" name="message"></textarea>
            <button class="btn" type="button" data-scope="{{ $scope }}"><i class="fas fa-paper-plane"></i></button>
            <input type="hidden" name="model_id" id="note_model_id" value="{{ $demande->id }}"/>
            <input type="hidden" name="model_type" id="note_model_type" value="App\Models\Demande"/>
            <input type="hidden" name="category" id="note_category" value=""/>
        </div>
    </div>
</div>
