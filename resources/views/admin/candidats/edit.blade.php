@extends('admin.template')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/candidat.css') }}">
@endsection

@section('modal')
    @include('admin.modals.preview-doc')
@endsection

@section('content')
    <div class="container-fluid ">
        {!! Form::model($candidat, ['method' => 'PATCH', 'action' => ['CandidatController@update', $candidat->id], 'files' => true ]) !!}
            <div class="row bg-white">
                <div class="col d-lg-block d-none p-all-0 text-white  mail-sidebar">
                    <div class="usable-height panel">
                        <div class="panel-header p-all-15 mail-sidebar-header">
                            <div class="media">
                                <div class="d-inline-block m-r-10 align-middle">
                                    <div class="avatar avatar">
                                        <span class="avatar-title rounded-circle  bg-white-translucent">
                                            @if (!is_null($candidat->getFirstMediaUrl('avatar', 'medium')))
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
                            @include('admin.candidats.partials._recrutement')
                            {{-- @include('admin.candidats.partials._administration') --}}
                            @include('admin.candidats.partials._immigration')
                            @include('admin.candidats.partials._commentaires')
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

</section>
@endsection

@php
    $uploadAddtionalResources = action("CandidatController@uploadAddtionalResources", ["candidat_id" => $candidat->id]);
@endphp

@section('footer')
    <script src="{{ asset('js/candidat.js') }}?v1.{{rand()}}"></script>
    <script src="{{ asset('atmos-assets/vendor/dropzone/dropzone.js') }}?v=2.2.2"></script>
    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#user_avatar').change(function(e) {
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
                maxFilesize: 512,
                success: function(file, response){
                    var obj = jQuery.parseJSON(file.xhr.response)
                    $('#resource_container').removeClass('d-none').addClass('d-flex');
                    $('#media_file_name').text(obj.file_name);
                    $('#media_size').text(obj.size);
                    $('#media_type').text(obj.type);
                    $('#media_url').attr('href',obj.path);
                }
            });

            $('.media-name').click(function() {
                alert('adfad');
                $('#preview_src').attr('src', $(this).data('src'))
                $('#preview_doc').modal('show')
            })

        })
    </script>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/dropzone/dropzone.css') }}"/>
@endsection
