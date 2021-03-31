@extends('admin.template')

@section('head')
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/datatables.min.css') }}"></link>
    <link rel="stylesheet" href="{{ asset('atmos-assets/vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css') }}"></link>
@endsection

@section('modal')
    @include('admin.modals.confirmation', [
        'ident' => 'removeUser',
        'title' => __('Êtes-vous certain?'),
        'text' => __('Voulez-vous vraiment supprimer <strong class="del_emp_non"></strong>?'),
        'controller' => action('EmployeurController@deleteUser', $employeur->id),
        'redirect' => action('EmployeurController@userManagement', $employeur->id)
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
                    <h3>{{ $employeur->nom }} - Users</h3>
                    <a href="{{ action('EmployeurController@createUser', $employeur->id) }}" class="btn btn-danger m-t-20 m-b-50"><i class="fas fa-plus-circle pr-2"></i>Ajouter un usager</a>
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
                                <div class="table-responsive p-t-10">
                                    <table id="datatable" class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employeur->users as $user)
                                                <tr>
                                                    <td>{{ $user->full_name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        <a href="{{ action('EmployeurController@editUser', ['id' => $employeur->id, 'user_id' => $user->id]) }}" class="btn btn-sm btn-primary mr-2"><i class="fas fa-user-edit"></i></a>
                                                        <button class="btn btn-sm btn-danger delete_user" data-userid="{{ $user->id }}" data-nom="{{ $user->full_name }}"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

@section('footer')

    <script src="{{ asset('atmos-assets/vendor/DataTables/datatables.min.js') }}"></script>
    <script>
        (function ($) {
            'use strict';
            $(document).ready(function () {
                $('#datatable').DataTable();
            });
        })

         $(document).on('click', '.delete_user', function(e){
                var id = $(this).data('userid');
                var nom = $(this).data('nom');

                $('.del_emp_non').html(nom);
                $("#modalConfirmation_removeUser .modal-body .hiddenfields").html("<input type='hidden' name='user_id' value='"+id+"'>");
                $('#modalConfirmation_removeUser').modal('toggle');

            })
    </script>
@endsection
