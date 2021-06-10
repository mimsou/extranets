<a href="javascript:void(0)" class="btn btn-primary btn-sm view-template" data-id="{{ $model->id }}">
    View
</a>
<a class="btn btn-danger btn-sm" href="{{ action('TodoController@deleteTemplate', $model->id) }}" onclick="return confirm('Are you sure to delete?')">
    Delete
</a>