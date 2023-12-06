<!-- resources/views/admin/movie_form.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add/Edit Movie</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ isset($movie) ? route('admin.save_movie', $movie->id) : route('admin.save_movie') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Movie Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ isset($movie) ? $movie->title : old('title') }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ isset($movie) ? $movie->description : old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Movie Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            @if(isset($movie) && $movie->image)
                <img src="{{ asset('storage/' . $movie->image) }}" alt="Movie Image" style="max-width: 300px; max-height: 200px;">
            @endif

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save Movie</button>
            </div>
        </form>
    </div>
@endsection
