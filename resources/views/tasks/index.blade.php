{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h3 {
            color: #333;
        }

        .task {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .task a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }

        .task button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .task button:hover {
            background-color: #e60000;
        }

        .create-task {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .create-task:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    @foreach ($tasks as $task)
        <div class="task">
            <h3>{{ $task->title }}</h3>
            <p>{{ $task->description }}</p>
            <a href="{{ route('tasks.edit', $task) }}">Edit</a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    @endforeach
    <a href="{{ route('tasks.create') }}" class="create-task">Create New Task</a>
</body>
</html> --}}


@extends('layouts.app')

@section('title', 'Task List')

@section('content')
<div class="container">
    <h1 class="my-4">Task List</h1>
    
    <div class="mb-3">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create New Task</a>
    </div>

    @if($tasks->isEmpty())
        <div class="alert alert-warning">Tidak ada tugas yang ditemukan.</div>
    @else
        <div class="list-group">
            @foreach ($tasks as $task)
                <div class="list-group-item">
                    <h5>{{ $task->title }}</h5>
                    <p>{{ $task->description }}</p>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                        <small class="text-muted">Created at: {{ $task->created_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

