@extends('admin.template')

@section('head')
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}"></link>
@endsection

@section('modal')
    @include('admin.modals.confirmation', [
		'ident' => 'removeEmp',
		'title' => __('Êtes-vous certain?'),
		'text' => __('Voulez-vous vraiment supprimer <strong class="del_emp_non"></strong>?'),
		'controller' => action('AssociationUsersController@remove'),
		'redirect' => route('association.users',request()->assoc_group_id)
    ])
@endsection

@section('content')


    <div class="bg-dark bg-dots m-b-55">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mx-auto text-white p-t-30">
                    <div class="m-b-10">
                        <div class="avatar avatar-lg ">
                            <div class="avatar-title bg-info rounded-circle fas fa-user-tie "></div>
                        </div>
                    </div>
                    <h3>{{ $association->title }} - Users</h3>
                    <a href="{{ route('association.users.create',request()->assoc_group_id) }}" class="btn btn-warning m-t-20 m-b-50"><i class="mdi mdi-plus"></i> {{ __('Créer un utilisateur') }}</a>
                </div>
            </div>
        </div>

    </div>
    <section class="pull-up">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if(1 != 1)
                                <h4 class="text-center m-t-30 m-b-30">Aucun usager n'est associé à ce compte</h4>
                            @else
                                <div class="table-responsive p-t-10">
                                    {!! $dataTable->table(['class'=>'table','style'=>'width:100%']) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('footer')
    <script src="{{ asset('atmos-assets/vendor/DataTables/datatables.min.js') }}"></script>
    {!! $dataTable->scripts() !!}
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click', '.delete_assoc_user', function(e){
                var id = $(this).data('groupid');
                var userid = $(this).data('assocuserid');
                var nom = $(this).data('nom');

                $('.del_emp_non').html(nom);
                $("#modalConfirmation_removeEmp .modal-body .hiddenfields").html("<input type='hidden' name='group_id' value='"+id+"'><input type='hidden' name='user_id' value='"+userid+"'>");
                $('#modalConfirmation_removeEmp').modal('toggle');

            })
        });
    </script>

@endsection
