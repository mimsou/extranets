<div class="col-md-12 mt-1 single-todo-div">
    <div class="option-box-grid">
        <input id="check{{ $todo->id }}" data-todo-id="{{ $todo->id }}" {{ ($todo->status == 1)?"checked":'' }} class="todo-checkbox"  name="bigradios" type="checkbox">
        <label for="check{{ $todo->id }}"></label>
        <p class="{{ ($todo->status == 1)?"task-completed":'' }} edit-todo" data-todo-id="{{ $todo->id }}">{{ $todo->to_do }}</p>
    </div>
    <i class="sort-handle fas fa-bars"></i>
</div>
