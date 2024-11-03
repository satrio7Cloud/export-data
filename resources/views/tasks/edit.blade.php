@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="container">
    <div class="form-container">
        <h2 class="text-center">Edit Task</h2>
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" value="{{ $task->title }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required>{{ $task->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
        
        <a href="{{ route('tasks.index') }}" class="d-block text-center mt-3">Back to Task List</a>
    </div>
</div>
@endsection

<style>
    .form-container {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: auto;
    }

    .form-label {
        font-weight: bold;
        color: #555;
    }
</style>
