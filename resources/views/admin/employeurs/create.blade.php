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
                        <h3>{{ __("Création d'un employeur") }}</h3>
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
                                       Utiliser cette page pour créer un employeur
                                   	</p>

                                    {!! Form::open(['action' => ['EmployeurController@store'] ]) !!}
										@include('admin.employeurs._form')
                                    {!! Form::close() !!}

                           </div>
                       </div>

                    </div>

                </div>
            </div>
@endsection

@section('footer')

    <script>
        $(document).on('change', '#has_secondary_contact_switch', function(e){
            toggleSecondary();
        });

        $(document).on('change', '#has_third_contact_switch', function(e){
            toggleThird();
        });

        function toggleSecondary(){
            if($('#has_secondary_contact_switch').is(":checked")){
                $('.secondary_contact').show();
            }else{
                $('.secondary_contact').hide();
            }
        }

        function toggleThird(){
            if($('#has_third_contact_switch').is(":checked")){
                $('.third_contact').show();
            }else{
                $('.third_contact').hide();
            }
        }

        toggleSecondary();
        toggleThird();
    </script>

@endsection
