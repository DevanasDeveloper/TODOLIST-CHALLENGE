<?php

namespace App\Http\Controllers\Api;

use App\Models\Todo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\TodoRequest;
use Carbon\Carbon;

class TodoController extends Controller
{
    // Get all todos by logged user
    public function index(Request $request)
    {
        $user = $request->user();
        $todos = $user->todos()->with('user')->orderByDesc('id')->get();
        return response()->json([
            'icon' => 'success',
            'todos' => $todos,
        ], 200);
    }

    // Get all todos by logged user
    public function statistic(Request $request)
    {
        $user = $request->user();
        $todos = $user->todos()->with('user')->orderByDesc('id')->count();
        $todos_completed = $user->todos()->where('completed',true)->with('user')->orderByDesc('id')->count();
        $todos_no_completed = $user->todos()->where('completed',false)->with('user')->orderByDesc('id')->count();
        return response()->json([
            'icon' => 'success',
            'count_todos' => $todos,
            'count_todos_completed' => $todos_completed,
            'count_todos_no_completed' => $todos_no_completed,
        ], 200);
    }
    
    // Store new todo
    public function store(TodoRequest $request)
    {
        $user = $request->user();
        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($todo = $user->todos()->create($data)) {
            return response()->json([
                'icon' => 'success',
                'message' => 'The todo has been successfully created.',
                'todo' => $todo,
            ], 200);
        } else {
            return response()->json([
                'icon' => 'error',
                'message' => 'The todo has not been created.',
            ], 500);
        }
    }
    
    //Show todo
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $todo = $user->todos()->find($id);

        if (!$todo) {
            return response()->json([
                'icon' => 'warning',
                'message' => "The todo with id: $id does not exist.",
            ], 404);
        }

        return response()->json([
            'icon' => 'success',
            'todo' => $todo,
        ], 200);
    }

    // Edit todo
    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $todo = $user->todos()->find($id);

        if (!$todo) {
            return response()->json([
                'icon' => 'warning',
                'message' => "The todo with id: $id does not exist.",
            ], 404);
        }

        return response()->json([
            'icon' => 'success',
            'todo' => $todo,
        ], 200);
    }
    
    // Update todo
    public function update(TodoRequest $request, $id)
    {
        $user = $request->user();
        $todo = $user->todos()->find($id);

        if (!$todo) {
            return response()->json([
                'icon' => 'warning',
                'message' => "The todo with id: $id does not exist.",
            ], 404);
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($todo->update($data)) {
            return response()->json([
                'icon' => 'success',
                'message' => 'The todo has been successfully updated.',
                'todo' => $todo,
            ], 200);
        } else {
            return response()->json([
                'icon' => 'error',
                'message' => 'The todo has not been updated.',
            ], 500);
        }
    }

    // Delete todo
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $todo = $user->todos()->find($id);

        if (!$todo) {
            return response()->json([
                'icon' => 'warning',
                'message' => "The todo with id: $id does not exist.",
            ], 201);
        }

        if ($todo->delete()) {
            return response()->json([
                'icon' => 'success',
                'message' => 'The todo has been successfully deleted.',
            ], 200);
        } else {
            return response()->json([
                'icon' => 'warning',
                'message' => 'The todo has not been deleted.',
            ], 201);
        }
    }

    // Change todo status
    public function toggleComplete(Request $request, $id)
    {
        $user = $request->user();
        $todo = $user->todos()->find($id);
    
        if (!$todo) {
            return response()->json([
                'icon' => 'warning',
                'message' => "The todo with id: $id does not exist.",
            ], 201);
        }
    
        $todo->completed = !$todo->completed;
        $todo->completed_at = $todo->completed ? Carbon::now() : null;
    
        if ($todo->save()) {
            return response()->json([
                'icon' => 'success',
                'message' => 'The todo has been successfully updated.',
                'todo' => $todo,
            ], 200);
        } else {
            return response()->json([
                'icon' => 'warning',
                'message' => 'The todo has not been updated.',
            ], 201);
        }
    }
}
