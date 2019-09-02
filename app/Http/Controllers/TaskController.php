<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\User;
use DB;

class TaskController extends Controller
{
    private $responseOk = 200;
    private $responseBad = 502;

    public function index(){
        $taskCount = Task::count();
        $task = Task::select("tasks.id", 'tasks.task', 'tasks.created_at', "tasks.status")->get();

        if($taskCount != 0){
            return $task;
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }

    public function getTaskByUser($id){
        $count = Task::find($id)->count();
        $data = DB::table("tasks")
        ->select("tasks.id", 'tasks.task', 'tasks.created_at', "tasks.status")
        ->join("users", "users.id", "=", "tasks.user_id")
        ->where(["users.id"=>$id])
        ->orderBy("created_at", "desc")
        ->get();

        if($count >0){
            return $data;
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }

    public function getTaskByUserWithStatus($id, $status){
        $count = Task::find($id)->count();
        $data = DB::table("tasks")
        ->select("tasks.id", 'tasks.task', 'tasks.created_at', "tasks.status")
        ->join("users", "users.id", "=", "tasks.user_id")
        ->where(["users.id"=>$id, 'status'=>$status])
        ->get();

        if($count >0){
            return $data;
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }

    public function createTask(Request $request){
        $task = new Task;
        $task->task = $request->task;
        $task->user_id = $request->user_id;
        $task->status = 'process';

        if($task->save()){
            return response()->json(
                [
                    "status" => $this->responseOk
                ]
            );
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }

    public function deleteTask($id){
        $task = Task::find($id);
        if($task->delete()){
            return response()->json([
                "status" => $this->responseOk
            ]);
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }

    public function updateTaskStatus(Request $request, $id){
        $task = Task::find($id);
        $task->status = $request->status;

        if($task->save()){
            return response()->json([
                "status" => $this->responseOk
            ]);
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }
}
