<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Tasks::all();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        Tasks::create($request->all());
        return redirect()->route('tasks.index');
    }

    public function edit(Tasks $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Tasks $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $task->update($request->all());
        return redirect()->route('tasks.index');
    }

    public function destroy(Tasks $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
