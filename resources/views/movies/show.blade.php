@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card my-2">
            <div class="card-body">
                <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}" class="img-fluid" style="max-width: 500px; max-height: 900px;">
                <h2>{{ $movie->title }}</h2>
                <p>{{ $movie->description }}</p>

                <h2>Reviews</h2>
                @if ($movie->reviews->count() > 0)
                    <ul>
                        @foreach ($movie->reviews as $review)
                            <li>{{ $review->comment }} - {{ $review->user->name }} (Rating: {{ $review->rating }})</li>
                        @endforeach
                    </ul>
                @else
                    <p>No reviews yet.</p>
                @endif

               @auth
    <h2>Write a Review</h2>
   <form action="{{ route('movies.reviews.store', $movie->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="comment" class="form-label">Comment:</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5):</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
@else
    <p>Login to write a review.</p>
@endauth
            </div>
        </div>
    </div>
@endsection
