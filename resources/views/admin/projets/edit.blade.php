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
    @include('admin.projets.modals.timeTracking')

    @if(request()->has('demande'))
        {!! Form::hidden('open_modal',request()->demande) !!}
    @endif
    <div class="bg-dark bg-dots m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">

                <div class="col-lg-8 text-white p-b-30">
                    <h1>{{ $projet->titre }}</h1>
                    <h3 class="opacity-50">{{ $projet->numero }}</h3>
                </div>
                @if(is_admin_user())
                <div class="col-lg-4 text-right text-white p-b-30">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#timeTracking">
                        <i class="fas fa-business-time fa-2x"></i>
                    </button>
                </div>
                @endif
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
                        @elseif(is_associate_user())
                            @if(it_has_demande($d->id))
                                @include('admin.projets.partials._demande-'.$d->type, ['p'=>$d])
                            @endif
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
    @endsection

    @section('footer')
        <script>
            //
            //----o Time Tracking code
            //
            $('#timeTracking').on('show.bs.modal', function (e) {
                loadTimeTrackingContent();
            })

            function emptyTimeTrackingFormInput(){
                $('#tt_task_type').prop("selectedIndex", 0).val();
                if(document.getElementById('tt_user_id')){
                    document.getElementById('tt_user_id').value = $auth_user_id;
                }
                document.getElementById('tt_description').value ='';
                document.getElementById('tt_duration').value ='';
            }

            function loadTimeTrackingContent(){
                $('#timeTracking .modal_loading').show();
                $('#timeTracking .modal_edit_content').hide();
                $.ajax({
                    type: "GET",
                    url: "{!! route('time_tracking_show',['id'=> $projet->id]) !!}",
                    success: function(data)
                    {
                        setTimeout(function(){
                            $('#timeTracking .modal_loading').hide();
                            $('#timeTracking .modal_edit_content').html(data).show();
                        }, 1000);
                    },
                    error: function(jqXHR, status, error) {
                        fetchErrorNotifications("Erreur", "Il y a eu un problème.");
                    }
                });
            }

            $("#time_tracking_form").submit(function(e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                let form = $(this);
                let url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        fetchSuccessNotifications("Succès", "Enregistrement a été créé avec succès.");
                        emptyTimeTrackingFormInput();
                        loadTimeTrackingContent();
                    },
                    error: function(jqXHR, status, error) {
                        fetchErrorNotifications("Erreur", "Il y a eu un problème.");
                    }
                });
            });

            //
            //---o Time Tracking - Initiate TextArea counter and duration mask
            //
            $(document).ready(function(){
                let $auth_user_id = {!! \Auth::user()->id !!};
                let tt_description_text_max = 200;
                $('#count_message').html('0 / ' + tt_description_text_max );

                let inputTimeMaskBehavior = function (val) {
                        return val.replace(/\D/g, '')[0] === '2' ? 'AE:CD' : 'AB:CD';
                    },
                    spOptions = {
                        onKeyPress: function(val, e, field, options) {
                            field.mask(inputTimeMaskBehavior.apply({}, arguments), options);
                        },
                        translation: {
                            "A": { pattern: /[0-9]/, optional: false},
                            "B": { pattern: /[0-9]/, optional: false},
                            "C": { pattern: /[0-5]/, optional: false},
                            "D": { pattern: /[0-9]/, optional: false},
                            "E": { pattern: /[0-9]/, optional: false}
                        },
                        clearIfNotMatch: true
                    };
                $('#tt_duration').mask(inputTimeMaskBehavior, spOptions);
            });

            $('#tt_description').keyup(function() {
                var text_length = $('#tt_description').val().length;
                var text_remaining = tt_description_text_max - text_length;
                $('#count_message').html(text_length + ' / ' + tt_description_text_max);
            });

            //
            //---o Flash for Ajax
            //
            function fetchSuccessNotifications($title, $message) {
                $.ajax({
                    url: '{{ route('flash.notifications') }}',
                    type: 'GET',
                    success: function (result) {
                        // Fetch any notifications if we have any
                        //http://bootstrap-notify.remabledesigns.com/
                        notification_template_ajax = result;
                        jQuery.notify({
                            // options
                            icon: 'mdi mdi-check',
                            title: $title,
                            message: $message
                        }, {
                            placement: {
                                align: "right",
                                from: "top"
                            },
                            showProgressbar: true,
                            timer: 120,
                            z_index: 10031,
                            offset: {
                                x: 50,
                                y: 10
                            },
                            // settings
                            type: 'success',
                            template: notification_template_ajax
                        });
                    },
                    error: function(jqXHR, status, error) {
                        console.log(jqXHR, status, error);
                        fetchErrorNotifications("Erreur", "Il y a eu un problème.");
                    }
                });
            }

            function fetchErrorNotifications($title, $message) {
                $.ajax({
                    url: '{{ route('flash.notifications') }}',
                    type: 'GET',
                    success: function (result) {
                        // Fetch any notifications if we have any
                        //http://bootstrap-notify.remabledesigns.com/
                        notification_template_ajax = result;
                        jQuery.notify({
                            // options
                            icon: 'mdi mdi-exclamation',
                            title: $title,
                            message: $message
                        }, {
                            placement: {
                                align: "right",
                                from: "top"
                            },
                            showProgressbar: true,
                            timer: 120,
                            z_index: 10031,
                            offset: {
                                x: 50,
                                y: 10
                            },
                            // settings
                            type: 'danger',
                            template: notification_template_ajax
                        });
                    },
                    error: function(jqXHR, status, error) {
                        console.log(jqXHR, status, error);
                        fetchErrorNotifications("Erreur", "Il y a eu un problème.");
                    }
                });
            }
        </script>
        <script>
            //
            //----o Projet edit code
            //
            $(".assign_demande").select2({
                'placeholder': "Sélectionnez un utilisateur",
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

            //
            //---o Click event
            //
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
                // console.log(e.target.className);
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
                // console.log(user_id);
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

            $(document).ready(function(){
                let modalDemande = $('input[name=open_modal]').val();
                $('i[data-demande-id='+modalDemande+']').click();
            });

            @if(auth()->user()->role_lvl == 2)
                $('input,select,button').prop('disabled',true).addClass('disabled');
            @endif

        </script>
        <script>
            $('#flash-overlay-modal').modal();
        </script>
    @endsection
