 <!-- Modal -->
 <div class="modal fade" id="todo-list-modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="close position-static" data-dismiss="modal"aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <i class="fas fa-check todo-tick"></i>
                        <h2 class="mt-3">Liste de contrôle</h2>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-7">
                        @php($numberOfCompleted = $todos->where('status',1)->count())
                        @php($numberOfTodos = $todos->count())
                        <small><span class="number-of-completed-todos">{{ $numberOfCompleted }}</span> complété sur <span class="total-todos">{{ $numberOfTodos }}</span></small>
                        <div class="time-progresssion mb-2">
                            <div class="progression todo-progress text-right" id="part_prog_" style="transition: all 0.5s ease; background-color: aquamarine; width:{{ ($numberOfTodos != 0)?(($numberOfCompleted*100)/$numberOfTodos):0 }}%; height:7px; border-radius: 13px;"></div>
                        </div>
                    </div>
                    <div class="col-md-5 text-right">
                        <small class="create-template" data-project-id="{{ $projectId }}" data-demande-id="{{ $demandeId }}"><u>En faire un gabarit</u></small>
                    </div>
                </div>
                <div class="row todo-list-div">
                    <div class="todo-list-section sortable-todo-list">
                        @foreach($todos as $key => $todo)
                            @include('admin.projets.modals._singleTodo',['todo'=>$todo])
                        @endforeach
                    </div>
                    <div class="col-md-12 mt-1 ml-1 pl-2">
                        <i class="fas fa-plus add-todo-list"></i>
                        {!! Form::text('todo',null,['class'=>'todo-text','placeholder'=>'Ajouter un nouvel élément']) !!}
                        <i class="fa fa-check save-todo-message" data-project-id="{{ $projectId }}" data-demande-id="{{ $demandeId }}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

