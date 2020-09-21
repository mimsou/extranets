@extends('admin.template')

@section('content')

    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">

                <div class="col-md-7 m-auto text-white p-b-30">
                    <h1 class="">Bonjour, {{Auth::user()->firstname}}!</h1>
                    <p class="opacity-75">
                        Bienvenue dans votre nouveau tableau de bord! Vous trouverez ici une grande quantité d'information utile. N'hésitez surtout pas à nous contacter si vous désirez modifier le contenu de ce dernier afin de combler tous vos besoins d'entreprise.
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

            <div class="col-lg-7">
                <div class="card shadow-lg m-b-30">
                    <div class="card-body">
                        <h3>Suivi du développement</h3>
                        <p>Progression générale</p>
                        <div class="progress">
                            <div class="progress-bar" style="width: 95%"></div>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Module</th>
                                        <th>Avancement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Interface administrateur</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 100%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Interface administrateur</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-secondary" style="width: 100%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Interface administrateur</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-info" style="width: 100%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Évaluation 360 - V1</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" style="width: 90%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Évaluation 360 - V1</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-danger" style="width: 90%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td>Système de rapport KPI's</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 1%"></div>
                                            </div>
                                        </td>
                                    </tr> --}}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h3>Message center</h3>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="media">
                                    <div class="d-inline-block m-r-10 align-middle">
                                        <div class="avatar avatar">
                                            <span class="avatar-title rounded-circle  bg-dark">JCG</span>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <p class="font-secondary m-b-0">Jean-Christophe Gaudette <span class="text-muted font-primary m-l-10">{{ \Carbon\Carbon::parse('2019-05-30 16:50:00')->diffForHumans() }}</span></p>
                                        <div></div>
                                        <div class="text-muted">
                                            <p>Bonjour Impact Évolution! Je suis très heureux de vous accueillir dans ce qui deviendra bientôt votre nouveau système de gestion.</p>
                                            <p>Si vous avez des questions, n'hésitez surtout pas à nous contacter.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>





            </div>

        </div>
    </div>

@endsection
