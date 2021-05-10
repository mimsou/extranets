<?php

namespace App\Http\Controllers;

use App\Models\TodoTemplate;
use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function save(Request $request){
        $maxOrder = Todo::getMaxOrder($request->projet_id,$request->demande_id) + 1;
        $todoModel = new Todo;
        $todoModel->projet_id = $request->projet_id;
        $todoModel->demande_id = $request->demande_id;
        $todoModel->to_do = $request->todo;
        $todoModel->status = 0;
        $todoModel->order = $maxOrder;
        $todoModel->created_by = Auth::user()->id;
        $todoModel->save();
        $singleTodo = view('admin.projets.modals._singleTodo',['todo'=>$todoModel])->render();
        return response()->json(['status'=>true,'message'=>'Todo saved successfully!','todo'=>$todoModel,'html'=>$singleTodo]);
    }

    public function todoList($projectId, $demandeId){
        $todos = Todo::getTodos($projectId,$demandeId);
        return view('admin.projets.modals._todo-list',compact('todos','projectId','demandeId'))->render();
    }

    public function templatesList(Request $request){
        $todoTemplates = TodoTemplate::pluck('template_name','id')->prepend('Liste vide',0);
        return view('admin.projets.modals._todoTemplates',compact('todoTemplates','request'))->render();
    }

    public function createTemplate(Request $request){
        return view('admin.projets.modals._createTodoTemplates',['request'=>$request])->render();
    }

    public function saveTemplate(Request $request){
        $todos = Todo::where(['projet_id'=>$request->project_id,'demande_id'=>$request->demande_id])->orderBy('order')->pluck('to_do');
        $todoTemplate = new TodoTemplate;
        $todoTemplate->template_name = $request->template_name;
        $todoTemplate->todos = $todos->toJson();
        $todoTemplate->created_by = Auth::user()->id;
        $todoTemplate->save();
        return response()->json(['status'=>true,'message'=>'Todo template saved successfully!']);
    }

    public function updateStatus(Request $request){
        $todoModel = Todo::find($request->todo_id);
        $todoModel->status = $request->status;
        $todoModel->save();
        return response()->json(['status'=>true,'message'=>'Todo status changed successfully!']);
    }
    public function updateTodoOrder(Request $request){
        $todos = $request->todos;
        foreach($todos as $todoId => $order){
            $todoModel = Todo::find($todoId);
            $todoModel->order = $order;
            $todoModel->save();
        }
        return response()->json(['status'=>true,'message'=>'Order updated successfully!']);
    }

    public function createTodoFromTemplate(Request $request){
        $templateTodos = TodoTemplate::find($request->template_id)->todos;
        $OrderIndex = 1;
        foreach(json_decode($templateTodos,true) as $key => $todo){
            $todoModel = new Todo;
            $todoModel->projet_id = $request->projet_id;
            $todoModel->demande_id = $request->demande_id;
            $todoModel->to_do = $todo;
            $todoModel->created_by = Auth::user()->id;
            $todoModel->order = $OrderIndex;
            $todoModel->save();
            $OrderIndex++;
        }
        return response()->json(['status'=>true,'message'=>'Emplois créés avec succès!']);
    }

    public function updateTodo(Request $request, $todoId){
        if($request->todo == ''){
            Todo::find($todoId)->delete();
            return response()->json(['status'=>true,'message'=>'Todo supprimé avec succès!']);
        }else{
            $todoModel = Todo::find($todoId);
            $todoModel->to_do = $request->todo;
            $todoModel->save();
            return response()->json(['status'=>true,'message'=>'Todo a été mis à jour avec succès!']);
        }
    }
}
