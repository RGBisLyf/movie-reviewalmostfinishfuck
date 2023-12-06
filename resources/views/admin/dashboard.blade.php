@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Admin Dashboard</h2>
        
        <!-- Add Movie Button -->
        <div class="mb-3">
            <a href="{{ route('admin.movie_form') }}" class="btn btn-secondary">Add Movie</a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Form -->
        <form action="{{ route('admin.dashboard') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </div>
        </form>

        <!-- Display Movies -->
        @foreach($movies as $movie)
            <div class="card my-2">
                <div class="card-body">
                    <h5 class="card-title">{{ $movie->title }}</h5>
                    <p class="card-text">{{ $movie->description }}</p>
                
                    <img src="{{ asset('storage/' . $movie->image) }}" alt="Movie Image" style="width: 300px; height: 200px; object-fit: cover;">
                    
                    <a href="{{ route('admin.movie_form', $movie->id) }}" class="btn btn-secondary">Edit</a>
                    <a href="{{ route('admin.delete_movie', $movie->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this movie?')">Delete</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
