<div class="row">
    <div class="col-md-12 mt-4">
        <h3 class="color-light-blue">Commentaires</h3>
        <p class="font-weight-bold ml-1 color-light-blue see-all-comments"
           data-demande-id="{{ $p->id }}"><span class="show-comment-text">Voir tous
                                les commenataires</span> ( <span
                class="comment-counts">{{ $notes->count()}}</span> )</p>
    </div>
    <div class="col-md-12">
        <div id="demande_notes" class="active">
            <div class="note_window_container">
                <div class="demande_old_messages_shadow"></div>
                <div id="note-messages">
                    @if($notes->isEmpty())
                        <i id="no-comment">Aucun commentaire pour le moment</i>
                    @endif
                    @foreach($notes->reverse() as $n)
                        @include('admin.partials._message', ['n'=>$n,'p'=>$p])
                    @endforeach
                </div>

                <div id="note-comment-form" data-url="{{ action('UserController@saveComment', Auth::user()->id) }}">
                    <textarea class="note form-control" id="note_message" name="message"></textarea>
                    <button class="btn" type="button" data-scope="{{ $scope }}"><i class="fas fa-paper-plane"></i>
                    </button>
                    <input type="hidden" name="model_id" id="note_model_id" value="{{ $demande->id }}"/>
                    <input type="hidden" name="model_type" id="note_model_type" value="App\Models\Demande"/>
                    <input type="hidden" name="category" id="note_category" value=""/>
                </div>
            </div>
        </div>
    </div>
</div>
