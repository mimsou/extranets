@extends('admin.template')

@section('content')

    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">

                <div class="col-md-7 m-auto text-white p-b-30">
                    <h1 class="">Bonjour, {{Auth::user()->firstname}}!</h1>
                    <p class="opacity-75">
                        Tableau de bord
                    </p>
                </div>

                <div class="col-md-5 m-auto text-white p-t-40 p-b-30">
                    <div class="text-md-right">
                        {{-- ADD SOME CONTENT HERE --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pull-up">

        <div class="row">
            <div class="col-md-6 m-b-30">
                @include('admin.dashboard.modules.rec_projetencours')
            </div>
            <div class="col-md-6">
                @include('admin.dashboard.modules.imm_demandeseimt')
            </div>
        </div>




    </div>

@endsection
