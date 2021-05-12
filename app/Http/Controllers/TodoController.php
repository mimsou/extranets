<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\TodoTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $maxOrder = Todo::getMaxOrder($request->projet_id, $request->demande_id) + 1;
        $todoModel = new Todo;
        $todoModel->projet_id = $request->projet_id;
        $todoModel->demande_id = $request->demande_id;
        $todoModel->to_do = $request->todo;
        $todoModel->status = 0;
        $todoModel->order = $maxOrder;
        $todoModel->created_by = Auth::user()->id;
        $todoModel->save();
        $singleTodo = view('admin.projets.modals._singleTodo', ['todo' => $todoModel])->render();
        return response()->json(['status' => true,
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
        $todos = Todo::getTodos($projectId, $demandeId);
        return view('admin.projets.modals._todo-list', compact('todos', 'projectId', 'demandeId'))->render();
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
        $todos = Todo::where(['projet_id' => $request->project_id, 'demande_id' => $request->demande_id])->orderBy('order')->pluck('to_do');
        $todoTemplate = new TodoTemplate;
        $todoTemplate->template_name = $request->template_name;
        $todoTemplate->todos = $todos->toJson();
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
        $todoModel->status = $request->status;
        $todoModel->save();
        return response()->json(['status' => true, 'message' => 'Todo status changed successfully!']);
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
        foreach ($todos as $todoId => $order) {
            $todoModel = Todo::find($todoId);
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
        $templateTodos = TodoTemplate::find($request->template_id)->todos;
        $OrderIndex = 1;
        foreach (json_decode($templateTodos, true) as $key => $todo) {
            $todoModel = new Todo;
            $todoModel->projet_id = $request->projet_id;
            $todoModel->demande_id = $request->demande_id;
            $todoModel->to_do = $todo;
            $todoModel->created_by = Auth::user()->id;
            $todoModel->order = $OrderIndex;
            $todoModel->save();
            $OrderIndex++;
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
        if ($request->todo == '') {
            Todo::find($todoId)->delete();
            return response()->json(['status' => true, 'message' => 'Todo supprimé avec succès!']);
        } else {
            $todoModel = Todo::find($todoId);
            $todoModel->to_do = $request->todo;
            $todoModel->save();
            return response()->json(['status' => true, 'message' => 'Todo a été mis à jour avec succès!']);
        }
    }
}
