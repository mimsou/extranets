@extends('admin.template')

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/projet.css') }}">
@endsection

@section('content')
    @include('admin.projets.modals.addCandidat')

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

                                   	<h3 class="mb-3">{{ __("Information") }}</h3>


                                    {!! Form::model($projet, ['method' => 'PATCH', 'action' => ['ProjetController@update', $projet] ]) !!}
										@include('admin.projets._formEdit')
                                    {!! Form::close() !!}

                           </div>
                       </div>

                    </div>

                    <div class="col-lg-8 mt-2">
                        @php
                            $nb_to_fill = $projet->nb_candidats - count($projet->candidats);
                        @endphp
                        <div class="row  mb-5">
                            <div class="col-6"><button class="btn btn-secondary" data-toggle="modal" data-target="#addCandidat">AJOUTER CANDIDAT</button></div>
                            <div class="col-6 text-right text-white"><strong style="font-size: 18px">{{ count($projet->candidats) }} / {{$projet->nb_candidats}}</strong></div>
                        </div>

                        @foreach ($projet->candidats as $c)
                            @include('admin.projets.partials._candidat', ['p'=>$c])
                        @endforeach


                        @for ($i = 0; $i < $nb_to_fill; $i++)
                            <div class="empty-spot my-3"></div>
                        @endfor
                    </div>

                </div>
            </div>
@endsection

@section('footer')

    <script>
        $('.select2').select2();

        $('.select2_candidats').select2();
    </script>

@endsection
