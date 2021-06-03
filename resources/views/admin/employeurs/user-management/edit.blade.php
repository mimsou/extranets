@extends('admin.template')

@section('head')

@endsection

@section('content')

	<div class="bg-dark bg-dots m-b-30">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mx-auto text-white p-t-30">
                    <div class="m-b-10">
                        <div class="avatar avatar-lg ">
                            <div class="avatar-title bg-info rounded-circle fas fa-user-tie "></div>
                        </div>
                    </div>
                    <h3>{{ $employeur->nom }}</h3>
                </div>
            </div>

            <div class="row justify-content-end p-b-45">
                <div class="col-lg-4 text-right">
{{--                    <a href="{{ action('EmployeurController@userManagement', $employeur->id) }}" class="btn btn-primary">User Management</a>--}}
                </div>
            </div>
        </div>

    </div>
        <section class="pull-up">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-8 mx-auto  mt-2">
                       <div class="card py-3 m-b-30">
                           <div class="card-body">
                                <h3 class="">{{ __("Information") }}</h3>
                                <p class="text-muted">
                                    Utiliser cette page pour modifier les informations d'un employeur
                                </p>

                                {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UserController@update', $user] ]) !!}
                                    @include('admin.employeurs.user-management._form')
                                {!! Form::close() !!}
                           </div>
                       </div>

                    </div>



                </div>
            </div>
@endsection


@section('footer')


@endsection
