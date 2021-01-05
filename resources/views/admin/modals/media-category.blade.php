<div class="modal fade" id="mediaCategory" data-backdrop="static"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body py-3 m-b-30">
                {!! Form::open(['action' => ['CandidatController@addMediaCategory'] ]) !!}
                    <div class="form-group">
                        <label for="nom">{{ __('Category Title') }} *</label>
                        <?
                            $categories = mediaCategories(); 
                        ?>
                        <select name="category[]" id="ip" class="select2 select2_media_cat" multiple="multiple">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                        {{ Form::hidden('media_id', null, ['required', 'class'=>'form-control', 'id'=>'media_id_cat']) }}

                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">Add Category</button>

                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
