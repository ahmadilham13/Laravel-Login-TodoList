<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodoListController extends Controller
{

    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }
    public function todoList(Request $request)
    {
        return response()
            ->view('todolist.todolist', [
                "title" => "To Do List",
                "todolist" => $this->todolistService->getTodolist()
            ]);
    }
    public function addTodo(Request $request)
    {
        $todo = $request->input("todo");
        if(empty($todo)) {
            return response()
                ->view('todolist.todolist', [
                    "title" => "To Do List",
                    "todolist" => $this->todolistService->getTodolist(),
                    "error" =>"Todo is Required"
                ]);
        }
        $this->todolistService->saveTodo(uniqid(), $todo);
        return redirect()->action([TodoListController::class, 'todoList']);
    }
    public function removeTodo(Request $request, string $todoId): RedirectResponse
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodoListController::class, "todoList"]);
    }
}
