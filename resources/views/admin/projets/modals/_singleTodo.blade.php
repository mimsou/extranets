<div class="row single-todo-div">
    <div class="col-md-9">
        <div class="option-box-grid">
            <input id="check{{ $todo->id }}" data-todo-id="{{ $todo->id }}" {{ ($todo->status == 1)?"checked":'' }} class="todo-checkbox"  name="bigradios" type="checkbox">
            <label for="check{{ $todo->id }}"></label>
            <p class="{{ ($todo->status == 1)?"task-completed ":'' }}edit-todo" data-todo-id="{{ $todo->id }}">{{ $todo->to_do }}</p>
            @if($todo->completed_at != null)
                <small class="text-muted completed-at-todo">Completed At: {{ $todo->completed_at }}</small>
            @else
                <small class="text-muted completed-at-todo"></small>
            @endif
        </div>
    </div>
    <div class="col-md-3 text-right">
        <div class="assignee mb-2">
            <div class="assigned-users d-flex flex-wrap">
                <div class="avatar avatar-xs add-new-assignee cursor-pointer">
                    <span class="avatar-title rounded-circle"> <i class="mdi mdi-account-plus-outline add-admin-icon"></i></span>
                </div>
                <div class="assigned-user-section todo-list-sec">
                    @foreach($todo->assigned_user as $key => $assignee)
                        <div class="avatar avatar-xs ml-1 mb-1">
                            <span data-id="3" data-demand-id="8" class="remove_assignee avatar-title rounded-circle bg-dark">{{ $assignee->user_details->initials() }} <i class="fas fa-times remove_assignee_icon small-icon" data-id="{{ $assignee->id }}"></i></span>
                        </div>
                    @endforeach
                </div>
                <div class="add-new-assignee-wrapper mt-2" style="display: none">
                    <select class="form-control assign_demande" data-demande-id="{{ $demandeId }}" name="assign_user" data-todo="{{ $todo->id }}">
                        <option value="">Sélectionnez un utilisateur</option>
                        @foreach(\App\Models\User::whereIn('role_lvl', [10, 5])->get() as $user)
                            <option value="{{ $user['id'] }}"> {{ $user['full_name'] }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
        <i class="sort-handle fas fa-bars"></i>
    </div>
</div>
