<?php

namespace App\Http\Controllers;
use App\Models\Movie; // Update the namespace if needed
use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
  public function create($movieId)
{
    $movie = Movie::findOrFail($movieId);
    return view('reviews.create', compact('movie'));
}

public function store(Request $request, $movieId)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|max:255',
    ]);

    $user = auth()->user();
    $movie = Movie::findOrFail($movieId);

    // Check if the user has already reviewed the movie
    if ($user->reviews()->where('movie_id', $movie->id)->exists()) {
        return redirect()->route('home')->with('error', 'You can only review a movie once.');
    }

     $review = new Review([
    'user_id' => auth()->id(),
    'movie_id' => $movieId, // Replace the hardcoded value with $movieId
    'rating' => $request->input('rating'),
    'comment' => $request->input('comment'),
    'content' => $request->input('content'),
]);
    $review->save();

    return redirect()->route('home')->with('success', 'Review submitted successfully.');
}
public function __construct()
{
    $this->middleware('auth');
}
}
