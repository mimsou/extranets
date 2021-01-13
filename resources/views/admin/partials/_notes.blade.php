@php
    $ident = uniqid();
    $cat = null;
    if(isset($category) && !is_null($category)) $cat = [$category];
@endphp

<div id="{{$ident}}">
    <div id="note_trigger" class="" data-scope='{{$ident}}'>
        @if (count($model->getNotes($cat)))
        <div class="note_counter">{{ count($model->getNotes($cat)) }}</div>
        @endif

        <i class="fas fa-comment-lines"></i>
    </div>

    <div id="note_window" class="">
        <div class="note_window_container">
            <div class="note_window_header">
                <div class="note_window_header_text">Commentaires</div>
                <div id="close-comments" data-scope='{{$ident}}'><i class="fas fa-times"></i></div>
            </div>

            <div id="note-messages">

                @if (!count($model->getNotes($cat)))
                    <p class="first-comment"><i>Soyez le premier à laisser un commentaire</i></p>
                @endif

                @foreach ($model->getNotes($cat) as $n)
                    @include('admin.partials._message', ['n'=>$n])
                @endforeach

            </div>

            <div id="note-comment-form" data-url="{{ action('UserController@saveComment', Auth::user()->id) }}">
                <textarea class="note form-control" id="note_message" name="message"></textarea>
                <button class="btn" type="button" data-scope='{{$ident}}'> <i class="fas fa-paper-plane"></i> </button>
                <input type="hidden" name="model_id" id="note_model_id" value="{{ $model->id ?? NULL }}">
                <input type="hidden" name="model_type" id="note_model_type" value="{{ get_class($model) ?? NULL }}">
                <input type="hidden" name="category" id="note_category" value="{{ $category ?? NULL }}">
            </div>
        </div>

    </div>
</div>
