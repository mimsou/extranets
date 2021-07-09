@extends('admin.template')

@section('head')

    <link rel="stylesheet" type="text/css" href="{{ mix('css/projet.css') }}">
@endsection

@section('content')
    @include('admin.partials._notes', ['model'=>$projet])
    @include('admin.projets.modals.addCandidat')
    @include('admin.projets.modals.addDemande')
    @include('admin.projets.modals.addDemandeRec')
    @include('admin.projets.modals.editDemande')


    <div class="bg-dark bg-dots m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">

                <div class="col-lg-8 text-white p-b-30">
                    <h1>{{ $projet->titre }}</h1>
                    <h3 class="opacity-50">{{ $projet->numero }}</h3>
                </div>


            </div>
        </div>
    </div>
    <section class="pull-up">
        <div class="container">
            <div class="row ">
                <div class="col-lg-4 mt-2">
                    <div class="card py-3 m-b-30">
                        <div class="card-body">

                            <h3 class="mb-3">{{ __('Information') }}</h3>

                            {!! Form::model($projet, ['method' => 'PATCH', 'action' => ['ProjetController@update', $projet], 'class' => 'projet-frm']) !!}
                            @include('admin.projets._formEdit')
                            {!! Form::close() !!}

                        </div>
                    </div>

                </div>

                <div class="col-lg-8 mt-2">
                    <div class="row  mb-5">
                        <div class="col-12 height-35">
                            @if (Auth::user()->role_lvl != 3) {{-- Dont't show this if logged in user is employer --}}
                                @if (Str::contains($projet->statut, 'imm') || Str::contains($projet->statut, 'new'))
                                    <button class="btn btn-danger mr-2" data-toggle="modal" data-target="#addDemande"><i
                                            class="fas fa-plus-circle pr-2"></i> DEMANDE D'IMMIGRATION</button>
                                @endif
                                @if (Str::contains($projet->statut, 'rec') || Str::contains($projet->statut, 'new'))
                                    <button class="btn btn-secondary mr-2" data-toggle="modal"
                                        data-target="#addDemandeRec"><i class="fas fa-plus-circle pr-2"></i> DEMANDE DE
                                        RECRUTEMENT</button>
                                @endif
                            @endif
                        </div>
                        {{-- <div class="col-4 text-right text-white"><strong style="font-size: 18px"></strong></div> --}}
                    </div>

                    @foreach ($projet->demandes as $d)
                        @if (Auth::user()->role_lvl > 3 || ($projet->employeur_id == Auth::user()->employeur_id || $d->employeur_id == Auth::user()->employeur_id))
                            @include('admin.projets.partials._demande-'.$d->type, ['p'=>$d])
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
    @endsection

    @section('footer')
        <script>
            // $('.select2').select2({
            //     'placeholder': "Sélectionnez un utilisateur", //Should be text not placeholder
            //     allowClear: true
            // });

            $(".assign_demande").select2({
                'placeholder': "Sélectionnez un utilisateur", //Should be text not placeholder
            });

            $('.select2_candidats').select2();
           $('.select2_employeurs_rec').select2();
           $('.select2_employeurs').select2();

            var user_role = '{{ Auth::user()->role_lvl }}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.addCandidat', function() {
                var demande_id = $(this).data('demandeid');
                $('#modal_demande_id').val(demande_id);
                $('#addCandidat').modal('toggle');
            });

            $(document).on('click', '.editdemande', function() {

                $('#editDemande .modal_loading').show();
                $('#editDemande .modal_edit_content').html('').hide();

                $('#editDemande').modal('toggle');

                var demande_id = $(this).data('demandeid');

                $.ajax({
                    url: "{{ action('ProjetController@demandeDetails', $projet->id) }}",
                    type: 'POST',
                    data: {
                        "demande_id": demande_id
                    },
                    success: function(data) {

                        $('#editDemande .modal_loading').hide();
                        $('#editDemande .modal_edit_content').html(data).show();

                        $('#editDemande .select2').select2();

                        if (user_role == 3) {
                            $('.demande-frm :input').prop('disabled', true);
                        }

                    },
                    error: function(jqXHR, status, error) {
                        console.log(jqXHR, status, error);
                        alert(error);
                    }
                });



            });


            $(document).on('change', "#addDemande #employeur_id", function() {
                var employeur_id = $(this).val();
                $.ajax({
                    url: "{{ action('ProjetController@getEmployeurContact', $projet->id) }}",
                    type: 'POST',
                    data: {
                        "employeur_id": employeur_id
                    },
                    success: function(data) {
                        if (data !== "") {
                            $('#addDemande #contact_prenom').val(data.contact_prenom);
                            $('#addDemande #contact_nom').val(data.contact_nom);
                            $('#addDemande #contact_titre').val(data.contact_titre);
                            $('#addDemande #contact_phone').val(data.contact_phone);
                            $('#addDemande #contact_ext').val(data.contact_ext);
                            $('#addDemande #contact_email').val(data.contact_email);
                        } else {
                            $('#addDemande #contact_prenom').val("");
                            $('#addDemande #contact_nom').val("");
                            $('#addDemande #contact_titre').val("");
                            $('#addDemande #contact_phone').val("");
                            $('#addDemande #contact_ext').val("");
                            $('#addDemande #contact_email').val("");
                        }


                    },
                    error: function(jqXHR, status, error) {
                        console.log(jqXHR, status, error);
                        alert(error);
                    }
                });
            });

            $(document).on('change', "#addDemandeRec #employeur_id_rec", function() {
                var employeur_id = $(this).val();
                $.ajax({
                    url: "{{ action('ProjetController@getEmployeurContact', $projet->id) }}",
                    type: 'POST',
                    data: {
                        "employeur_id": employeur_id
                    },
                    success: function(data) {
                        if (data !== "") {
                            $('#addDemandeRec #contact_prenom').val(data.contact_prenom);
                            $('#addDemandeRec #contact_nom').val(data.contact_nom);
                            $('#addDemandeRec #contact_titre').val(data.contact_titre);
                            $('#addDemandeRec #contact_phone').val(data.contact_phone);
                            $('#addDemandeRec #contact_ext').val(data.contact_ext);
                            $('#addDemandeRec #contact_email').val(data.contact_email);
                        } else {
                            $('#addDemandeRec #contact_prenom').val("");
                            $('#addDemandeRec #contact_nom').val("");
                            $('#addDemandeRec #contact_titre').val("");
                            $('#addDemandeRec #contact_phone').val("");
                            $('#addDemandeRec #contact_ext').val("");
                            $('#addDemandeRec #contact_email').val("");
                        }


                    },
                    error: function(jqXHR, status, error) {
                        console.log(jqXHR, status, error);
                        alert(error);
                    }
                });
            });

            if (user_role == 3) {
                $('.projet-frm :input').prop('disabled', true);
            }

            window.targetClick = null;
            // show assign dropdown
            $('.edit-immigration .add-new-assignee').click(function(e) {
                window.targetClick = $(e.target);
                $(this).parents('.assignee').find('.add-new-assignee-wrapper').slideToggle();
                e.stopPropagation();

            });
            $('body').click(function(e){
                let target = $(e.target);
                console.log(e.target.className);
                if(e.target.className != 'select2-selection__placeholder' &&
                    e.target.className != 'select2-selection__rendered' &&
                    e.target.className != 'select2-selection select2-selection--single'
                    && !target.is('.select2-dropdown')) {
                    $('.edit-immigration .assignee').find('.add-new-assignee-wrapper').slideUp();
                }

            });


            // assign user to demande
            $('.assign_demande').change(function(e) {
                e.stopPropagation();
                let elem = $(this);
                var user_id = $(this).val();
                console.log(user_id);
                if(user_id != '' && user_id != null){
                    var demande_id = $(this).data('demande-id')
                    $.ajax({
                        url: "{{ action('DemandeController@assingUser') }}",
                        type: 'POST',
                        data: {
                            "user_id": user_id,
                            "demande_id": demande_id
                        },
                        success: function(data) {
                            if(data.status == true){
                                $('.assignee').find('.add-new-assignee-wrapper').slideUp();
                                $('.assignee').find('.add-new-assignee-wrapper').find('select').val('').trigger('change');
                                elem.parents('.assignee').find('.assigned-users').append('<div class="avatar avatar-sm ml-1">' +
                                    '<span class="avatar-title rounded-circle bg-dark remove_assignee"  data-id="'+user_id+'" data-demand-id="'+demande_id+'">' + data.initials +
                                    '<i class="fas fa-times remove_assignee_icon"></i></span>' +
                                    '</div>')
                            }else{
                                $('.assignee').find('.add-new-assignee-wrapper').slideUp();
                                $('.assignee').find('.add-new-assignee-wrapper').find('select').val('').trigger('change');
                            }
                        },
                        error: function(jqXHR, status, error) {
                            console.log(jqXHR, status, error);
                            alert(error);
                        }
                    });
                }
            });

            @if(auth()->user()->role_lvl == 2)
                $('input,select,button').prop('disabled',true).addClass('disabled');
            @endif

        </script>

    @endsection
