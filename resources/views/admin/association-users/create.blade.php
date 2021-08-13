@extends('admin.template')

@section('head')
@endsection

@section('content')
	<div class="bg-dark bg-dots m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">

                    <div class="col-lg-8 text-center mx-auto text-white p-b-30">
                        <div class="m-b-10">
                            <div class="avatar avatar-lg ">
                                <div class="avatar-title bg-info rounded-circle mdi mdi-plus "></div>
                            </div>
                        </div>
                        <h3>{{ __("Création d'un utilisateur") }}</h3>
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

                                   	<h3 class="">{{ __("Information personnel") }}</h3>
                                   	<p class="text-muted">
                                       Utiliser cette page pour créer un nouvel utilisateur
                                   	</p>

                                   	{!! Form::open(['route' => ['association.users.save',request()->assoc_group_id] ]) !!}
                                        @include('admin.association-users._form')
                                    {!! Form::close() !!}

                           </div>
                       </div>

                    </div>

                </div>
            </div>
@endsection
