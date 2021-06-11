<?php

namespace App\Http\Controllers;

use App\DataTables\TodoTemplatesDataTable;
use App\Mail\TodoAssigned;
use App\Models\Todo;
use App\Models\TodoAssignee;
use App\Models\TodoGroup;
use App\Models\TodoTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

/**
 * Class TodoController
 * @package App\Http\Controllers
 */
class TodoController extends Controller
{
    /**
     * Save ToDo
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $maxOrder = Todo::getMaxOrder($request->projet_id, $request->demande_id, $request->group_id) + 1;
        $todoModel = new Todo;
        $todoModel->projet_id = $request->projet_id;
        $todoModel->demande_id = $request->demande_id;
        $todoModel->to_do = $request->todo;
        $todoModel->group_id = $request->group_id;
        $todoModel->status = 0;
        $todoModel->order = $maxOrder;
        $todoModel->created_by = Auth::user()->id;
        $todoModel->save();
        $singleTodo = view('admin.projets.modals._singleTodo', ['todo' => $todoModel, 'demandeId' => $request->demande_id])->render();
        return response()->json(
            ['status' => true,
             'message' => 'Todo saved successfully!',
             'todo' => $todoModel,
             'html' => $singleTodo]);
    }

    /**
     * Get ToDo for specific demande in project
     *
     * @param $projectId
     * @param $demandeId
     * @return string
     */
    public function todoList($projectId, $demandeId)
    {
        $groups = TodoGroup::with(['todos.assigned_user.user_details'])->where(['projet_id' => $projectId, 'demande_id' => $demandeId])->get();
        return view('admin.projets.modals._todo-list', compact('groups', 'projectId', 'demandeId'))->render();
    }

    /**
     * Get list of saved Templates
     *
     * @param Request $request
     * @return string
     */
    public function templatesList(Request $request)
    {
        $todoTemplates = TodoTemplate::pluck('template_name', 'id')->prepend('Liste vide', 0);
        return view('admin.projets.modals._todoTemplates', compact('todoTemplates', 'request'))->render();
    }

    /**
     * Create Template
     *
     * @param Request $request
     * @return string
     */
    public function createTemplate(Request $request)
    {
        return view('admin.projets.modals._createTodoTemplates', ['request' => $request])->render();
    }

    /**
     * Save Template
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveTemplate(Request $request)
    {
        //$todos = Todo::where(['projet_id' => $request->project_id, 'demande_id' => $request->demande_id])->orderBy('order')->pluck('to_do');
        $todoGroup = TodoGroup::with(
            ['todos' => function($query) {
                return $query->orderBy('order');
            }])->where(['projet_id' => $request->project_id, 'demande_id' => $request->demande_id])->get();
        $todoTemplate = new TodoTemplate;
        $todoTemplate->template_name = $request->template_name;
        $todoTemplate->todos = $todoGroup->toJson();
        $todoTemplate->created_by = Auth::user()->id;
        $todoTemplate->save();
        return response()->json(['status' => true, 'message' => 'Todo template saved successfully!']);
    }

    /**
     * Mark todo task as completed or imcompleted
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        $todoModel = Todo::find($request->todo_id);
        if($request->status == 1) {
            $todoModel->completed_at = Carbon::now();
        } else {
            $todoModel->completed_at = null;
        }
        $todoModel->status = $request->status;
        $todoModel->save();
        return response()->json(['status' => true, 'message' => 'Todo status changed successfully!', 'todo' => $todoModel]);
    }

    /**
     * Change order of todo by drag and down
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTodoOrder(Request $request)
    {
        $todos = $request->todos;
        foreach($todos as $todoId => $order) {
            $todoModel = Todo::find($todoId);
            if($request->oldGroupId != $request->newGroupID) {
                $todoModel->group_id = $request->newGroupID;
            }
            $todoModel->order = $order;
            $todoModel->save();
        }
        return response()->json(['status' => true, 'message' => 'Order updated successfully!']);
    }

    /**
     * Create todos from template
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTodoFromTemplate(Request $request)
    {
        $template = TodoTemplate::find($request->template_id);
        $templateTodos = $template->todos;
        $OrderIndex = 1;
        foreach(json_decode($templateTodos, true) as $key => $groupTodo) {

            $todoGroupModel = new TodoGroup;
            $todoGroupModel->group_name = $groupTodo['group_name'];
            $todoGroupModel->status = 1;
            $todoGroupModel->demande_id = $request->demande_id;
            $todoGroupModel->projet_id = $request->projet_id;
            $todoGroupModel->sort_order = $groupTodo['sort_order'];
            $todoGroupModel->todo_title = $template->template_name;
            $todoGroupModel->save();
            if(!empty($groupTodo['todos'])) {
                foreach($groupTodo['todos'] as $key => $todo) {
                    $todoModel = new Todo;
                    $todoModel->projet_id = $request->projet_id;
                    $todoModel->group_id = $todoGroupModel->id;
                    $todoModel->demande_id = $request->demande_id;
                    $todoModel->to_do = $todo['to_do'];
                    $todoModel->created_by = Auth::user()->id;
                    $todoModel->order = $todo['order'];
                    $todoModel->save();
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Emplois créés avec succès!']);
    }

    /**
     * Delete or update Todo
     *
     * @param Request $request
     * @param $todoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTodo(Request $request, $todoId)
    {
        if($request->todo == '') {
            TodoAssignee::where(['todo_id' => $todoId])->delete();
            Todo::find($todoId)->delete();
            return response()->json(['status' => true, 'message' => 'Todo supprimé avec succès!']);
        } else {
            $todoModel = Todo::find($todoId);
            $todoModel->to_do = $request->todo;
            $todoModel->save();
            return response()->json(['status' => true, 'message' => 'Todo a été mis à jour avec succès!']);
        }
    }


    /**
     * Create new group for TodO
     *
     * @param Request $request
     * @return string
     */
    public function createGroup(Request $request)
    {
        $todoGroup = new TodoGroup;
        $todoGroupModel = new TodoGroup;
        $todoGroup->group_name = $request->group_name;
        $todoGroup->projet_id = $request->projet_id;
        $todoGroup->demande_id = $request->demande_id;
        $todoGroup->status = 1;
        $todoGroup->sort_order = $todoGroupModel->newQuery()->max('sort_order') + 1;
        $todoGroup->save();
        $groupModel = TodoGroup::with(['todos'])->find($todoGroup->id);
        return view(
            'admin.projets.modals._todo_single_group',
            ['group' => $groupModel, 'projectId' => $request->projet_id, 'demandeId' => $request->demande_id])->render();
    }

    /**
     * Assign admin user to ToDo
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignUser(Request $request)
    {
        $isAlreadyExists = false;
        $assignUser = TodoAssignee::firstOrNew(['todo_id' => $request->todo_id, 'user_id' => $request->user]);
        if($assignUser->exists) {
            $isAlreadyExists = true;
        }
        $assignUser->save();
        $assignedUser = TodoAssignee::with(['user_details'])->find($assignUser->id);
        $this->sendEmail($request->user, $request->todo_id);
        return response()->json(
            ['status' => true, 'message' => 'User assigned to todo', 'user' => $assignedUser,
             'initials' => $assignedUser->user_details->initials(), 'is_exists' => $isAlreadyExists]);
    }

    /**
     * Send email to assigned user when ToDo is assigned to him
     *
     * @param $userId
     * @param $todoId
     */
    protected function sendEmail($userId, $todoId)
    {
        $user = User::find($userId);
        $todo = Todo::find($todoId);
        Mail::to($user->email)->queue(new TodoAssigned($user, $todo));
    }

    /**
     * Remove admin assignee from Todo
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAssignee(Request $request)
    {
        TodoAssignee::find($request->id)->delete();
        return response()->json(['status' => true, 'message' => 'User deleted successfully!']);
    }

    /**
     * Update ToDo Group
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateTodoGroup(Request $request)
    {
        if($request->group_name == '') {
            $haveAnyTodo = TodoGroup::with(['todos'])->find($request->group_id);
            if(!$haveAnyTodo->todos->isEmpty()) {
                return response()->json(['status' => 'error']);
            } else {
                $haveAnyTodo->delete();
                return response()->json(['status' => 'deleted']);
            }
        } else {
            $groupModel = TodoGroup::find($request->group_id);
            $groupModel->group_name = $request->group_name;
            $groupModel->save();
            return response()->json(['status' => 'updated']);
        }
    }

    public function manageTemplates(TodoTemplatesDataTable $dataTable)
    {
        return $dataTable->render('admin.todo.templates');
    }

    public function deleteTemplate($id)
    {
        TodoTemplate::find($id)->delete();
        return redirect()->back();
    }

    public function viewTemplateContent($id)
    {
        $template = TodoTemplate::find($id);
        $todosList = collect(json_decode($template->todos, true));
        return view('admin.projets.modals._todo-list-only', ['groups' => $todosList, 'template' => $template]);
    }

    public function deleteTemplateContent(Request $request)
    {
        $todoGroups = TodoGroup::with(['todos'])
            ->where(['demande_id' => $request->demande_id, 'projet_id' => $request->projet_id])->get();
        foreach($todoGroups as $key => $todoGroup) {
            $todos = $todoGroup->todos;
            foreach($todos as $key => $todo) {
                $todo->delete();
            }
            $todoGroup->delete();
        }
        $remainTodos = Todo::where(['demande_id' => $request->demande_id, 'projet_id' => $request->projet_id])->get();
        $completedTodos = 0;
        $totalTodos = 0;
        if(!$remainTodos->isEmpty()) {
            $completedTodos = $remainTodos->where('status', 1)->count();
            $totalTodos = $remainTodos->count();
        }
        return response()->json(['status' => true, 'message' => 'Template deleted', 'completed' => $completedTodos, 'total' => $totalTodos]);
    }
}
