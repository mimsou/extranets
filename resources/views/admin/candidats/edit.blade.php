@extends('admin.template')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/candidat.css') }}">
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/dropzone/dropzone.css') }}"/>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('atmos-assets/vendor/summernote/summernote.css') }}">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/ui/trumbowyg.min.css"--}}
{{--          integrity="sha512-nwpMzLYxfwDnu68Rt9PqLqgVtHkIJxEPrlu3PfTfLQKVgBAlTKDmim1JvCGNyNRtyvCx1nNIVBfYm8UZotWd4Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />--}}
@endsection


@section('modal')
    @include('admin.modals.preview-doc')
    @include('admin.modals.media-category')
    @include('admin.modals.update-avatar', [
		'candidat' => $candidat
    ])
    @include('admin.modals.confirmation', [
		'ident' => 'removeFile',
		'title' => __('Êtes-vous certain?'),
		'text' => __('Voulez-vous vraiment supprimer le fichier? <br><h5>Cette action est irréversible.</h5>'),
		'controller' => action('CandidatController@removeMedia'),
		'redirect' => action('CandidatController@edit', $candidat->id)
    ])
@endsection

@section('content')



    <div class="container-fluid ">
        {!! Form::model($candidat, ['method' => 'PATCH', 'action' => ['CandidatController@update', $candidat->id], 'files' => true, 'class' => 'candidat-frm' ]) !!}
            <div class="row bg-white">
                <div class="col d-lg-block d-none p-all-0 text-white  mail-sidebar">
                    <div class="usable-height panel">
                        <div class="panel-header p-all-15 mail-sidebar-header">
                            <div class="media">
                                <div class="d-inline-block m-r-10 align-middle">
                                    <div class="avatar avatar">
                                        <span class="avatar-title rounded-circle  bg-white-translucent" @if (!is_null($candidat->getFirstMediaUrl('avatar', 'medium')) && $candidat->getFirstMediaUrl('avatar', 'medium') != "") data-toggle="modal" data-target="#modalUpdateAvatar" @endif>
                                            @if (!is_null($candidat->getFirstMediaUrl('avatar', 'medium')) && $candidat->getFirstMediaUrl('avatar', 'medium') != "")
                                                <img src="{{ $candidat->getFirstMediaUrl('avatar', 'medium') }}" class="avatar-img rounded-circle" />
                                            @else
                                            {!! $candidat->statutIconHTML() !!}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <p class="font-secondary m-b-0">{{ $candidat->nom }}</p>
                                    <p class=" m-b-0 opacity-75">
                                        #{{ $candidat->numero }}
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class=".panel-body p-t-10 border-white side-sub-menu">
                            <div class="p-all-15">
                                <button type="submit" class="btn btn-success btn-block js-compose-toggle">Enregistrer</a>
                            </div>

                            @include('admin.candidats.partials._submenu')


                        </div>


                    </div>
                </div>
                <div class="col p-all-0">
                    <div class="usable-height  mail-window">

                        @include('admin.candidats.partials._header')

                        <div class=" mail-window-body">

                            @include('admin.candidats.partials._informations')
                            @include('admin.candidats.partials._observation')
                            @include('admin.candidats.partials._recrutement')
                            {{-- @include('admin.candidats.partials._administration') --}}
                            @include('admin.candidats.partials._immigration')
                            @include('admin.candidats.partials._accueil')
                            {{-- @include('admin.candidats.partials._commentaires') --}}
                            @include('admin.candidats.partials._historique')





                        </div>

                    </div>
                </div>
            </div>
        {!! Form::close() !!}

    </div>


    <div class="compose-wrapper">
        <div class="compose-container">
            <div class="panel compose-dialog">
                <div class="panel-header  text-white compose-header">
                    <div class="row compose-toolbar bg-dark align-items-center">
                        <div class="col-6 ">
                            New Message
                        </div>
                        <div class="col-6  text-right">
                            <a href="#" class="js-compose-close ">
                                <i class="mdi mdi-18px mdi-close"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row ">

                        <div class="col-12 border-bottom ">
                            <input type="text" placeholder="Recipients" class="form-control form-control-plaintext">
                        </div>
                        <div class="col-12   ">
                            <input type="text" placeholder="Subject" class="form-control form-control-plaintext">
                        </div>
                    </div>
                </div>
                <div class="compose-body   ">


                    <textarea id="trumbowyg-compose" class="form-control"   cols="30" rows="10"></textarea>


                </div>
                <div class="panel-footer compose-footer">
                    <div class="row">
                        <div class="col-6 my-auto">
                            <a href="#" class="btn btn-primary js-compose-close">Send Mail</a>
                        </div>
                        <div class="col-6 my-auto text-right">
                            <a href="#" class="mdi mdi-delete mdi-18px js-compose-close"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.candidats.partials._menumobile')

</section>
@endsection

@php
    $uploadAddtionalResources = action("CandidatController@uploadAddtionalResources", ["candidat_id" => $candidat->id]);
    $uploadAvatar = action("CandidatController@updateAvatar", ["candidat_id" => $candidat->id]);
@endphp

@section('footer')
    <script src="{{ asset('js/candidat.js') }}?v1.{{rand()}}"></script>
    <script src="{{ asset('atmos-assets/vendor/dropzone/dropzone.js') }}?v=2.2.2"></script>
    <script src="{{ asset('atmos-assets/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('atmos-assets/vendor/summernote/summernote.min.js') }}"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/trumbowyg.min.js"></script>--}}

    <script>
        Dropzone.autoDiscover = false;

        var user_role = '{{ Auth::user()->role_lvl }}';
        var obs_summernote;

        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({ headers: { 'X-CSRF-Token' : CSRF_TOKEN } });

            $('#datatable').DataTable({
                "order": [[ 1, "desc" ]]
            });

            $('#user_avatar_preview').change(function(e) {
                var fileName = e.target.files[0].name;
                $('#avatar').text(fileName);
            });




            $("div#additional_resources").dropzone({
                url: '{{ $uploadAddtionalResources }}',
                headers: {
                        'x-csrf-token': CSRF_TOKEN,
                    },
                chunking: true,
                method: "POST",
                chunkSize: 30000000,
                timeout: 2400000,
                maxFilesize: 5120,
                success: function(file, response){
                    var obj = jQuery.parseJSON(file.xhr.response)
                    $('#resource_container').removeClass('d-none').addClass('d-flex');
                    $('#media_file_name').text(obj.file_name);
                    $('#media_size').text(obj.size);
                    $('#media_type').text(obj.type);
                    $('#media_url').attr('href',obj.path);
                }
            });

            $("div#avatar").dropzone({
                url: '{{ $uploadAvatar }}',
                headers: {
                        'x-csrf-token': CSRF_TOKEN,
                    },
                method: "POST",
                success: function(file, response){
                }
            });

            $("div#update-avatar").dropzone({
                url: '{{ $uploadAvatar }}',
                headers: {
                        'x-csrf-token': CSRF_TOKEN,
                    },
                method: "POST",
                success: function(file, response){
                    window.location.reload()
                },
                error: function(jqXHR, status, error){
                    console.log(jqXHR, status, error);
                    window.location.reload();
                }
            });


            var embed = '';
            var src = '';
            var height = 'style="min-height:200px"';

            $(document).on('click', '.media-name', function() {
                height = 'style="min-height:200px"';
                src = $(this).data('src');

                var isdoc = false;
                var mimetype = $(this).data('type');

                if(mimetype == 'audio/mp4' || mimetype == 'video/mp4'){
                    height = 'style="min-height:400px"';
                }
                console.log(mimetype);
                if(mimetype == 'application/msword' ||
                    mimetype == 'application/vnd.ms-excel' ||
                    mimetype == 'application/zip' ||
                    mimetype == 'application/pdf' ||
                    mimetype.includes('wordprocessingml') ||
                    mimetype.includes('spreadsheetml')){
                        height = 'style="min-height:800px"';
                        isdoc =  true;
                    }

                    if (isdoc) {
                        window.open(src, '_blank').focus();
                        // embed = '<iframe id="doc_preview" src="https://docs.google.com/gview?url='+ src +'&embedded=true" width="100%" '+height+'>'
                    } else {
                        embed = '<embed id="preview_src" src="' + src + '" width="100%" '+height+'/>';
                        $('#preview_doc').modal('show');
                        $('#preview_src').html(embed);
                    }



            })

            $('#preview_doc').on('hide.bs.modal', function () {
                $('#preview_src').html('');
            })

            $('.cat-modal').click(function() {
                var media_id = $(this).data('media-id');
                $('#media_id_cat').val($(this).data('media-id'));
                $.ajax({
                    url: "{{ action('CandidatController@getMediaCategories') }}",
                    type: 'POST',
                    data: {"media_id":media_id},
                    success: function(data) {
                       $('.select2_media_cat').val(data).trigger('change');
                    },
                    error: function(jqXHR, status, error){
                        console.log(jqXHR, status, error);
                    }
                });
            })

            $('.select2_media_cat').select2({
                placeholder: 'Entrer un category',
                tags: true,
                width: 'element',
            });


             $(document).on('click', '.delete_media', function(e){
                e.preventDefault();
                var id = $(this).data('mediaid');
                $("#modalConfirmation_removeFile .modal-body .hiddenfields").html("<input type='hidden' name='mediaid' value='"+id+"'>");
                $('#modalConfirmation_removeFile').modal('toggle');
            });

            let isAssociateUser = '{{ is_associate_user() }}';

            if(user_role == 3 || isAssociateUser === 'true') {
                $('.candidat-frm :input').prop("disabled", true);
                $(".dz-hidden-input").prop("disabled",true);
            }

            // Make sur Observations field are available ALWAYS
            $("#observation :input").prop("disabled", false);



            var summernote_options = {
                minHeight: 150,
                // width: 100%,
                popover: { image: [], link: [], air: [] },
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    // ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    // ['height', ['height']]
                ]
            }

            obs_summernote = $('#observation #comment-ta').summernote(summernote_options);



            $('.add-comment-candidat').click(function(event) {

                event.preventDefault();

                var candidat_id = $(this).data('candidat-id');
                var body = $.trim($('#comment-ta').val());
                $.ajax({
                    url: "{{ route('candidat_add_comment',['candidat_id' => $candidat->id]) }}",
                    type: 'POST',
                    data: {
                        "body":body,
                    },
                    success: function(data) {
                        $('#comments-content').html(data.view);
                        obs_summernote.summernote('reset')
                    },
                    error: function(jqXHR, status, error){
                        console.log(jqXHR, status, error);
                    }
                });
            })

            $(function() {
                $.ajax({
                    url: "{{ route('candidat_get_comment',['candidat_id' => $candidat->id]) }}",
                    type: 'GET',
                    data: {
                        "candidat_id": {!! $candidat->id !!},
                    },
                    success: function(data) {
                        $('#comments-content').html(data.view);
                    },
                    error: function(jqXHR, status, error){
                        console.log(jqXHR, status, error);
                    }
                });
            });
        })
    </script>


@endsection
