<div class="row group-section" data-group-id="{{ $group->id }}">
    <div class="col-md-12 mt-3">
        <h3 class="d-inline float-left todo-group-title" data-group-id="{{ $group->id }}">{{ $group->group_name }}</h3>
        <span class="d-inline btn float-left pt-1 pl-3 cursor-pointer">
            <i class="fas fa-pencil"></i>
        </span>
    </div>
    <div class="todo-list-section sortable-todo-list col-md-12 pl-4">
        @foreach($group->todos->sortBy('order') as $key => $todo)
            @include('admin.projets.modals._singleTodo',['todo'=>$todo])
        @endforeach
    </div>
    <div class="col-md-12 mt-0 ml-1 pl-3 mb-3 add-todo-message-section">
        <i class="fas fa-plus add-todo-list cursor-pointer"></i>
        {!! Form::text('todo',null,['class'=>'todo-text','placeholder'=>'Ajouter un nouvel élément']) !!}
        <i class="fa fa-check save-todo-message" data-project-id="{{ $projectId }}"
           data-demande-id="{{ $demandeId }}" data-group-id="{{ $group->id }}"></i>
    </div>
</div>
