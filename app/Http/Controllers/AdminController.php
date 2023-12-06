<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\User; // Add this if your User model is in a different namespace
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AdminController;

class AdminController extends Controller
{
     public function search(Request $request)
    {
        $search = $request->input('search');
        $movies = Movie::where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->get();

        return view('admin.search_results', compact('movies'));
    }
    
    public function __construct()
{
    $this->middleware('noCache', ['only' => ['showLoginForm']]);
}
    // Admin login view
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Admin login action
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        if ($this->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }

        // If not an admin, logout and show an error message
        Auth::logout();
        return back()->withErrors(['email' => 'You do not have permission to access the admin area.']);
    }

    // Authentication failed
    return back()->withErrors(['email' => 'Invalid credentials']);
}

    // Check if the authenticated user has admin role or other criteria
    private function isAdmin()
    {
        return Auth::user()->is_admin; // Adjust this according to your User model and database structure
    }

    // Add movie view for admin
    public function showAddMovieForm()
    {
        // Check if the authenticated user has admin role or other criteria
        if (!$this->isAdmin()) {
            return redirect()->route('movies.index')->withErrors(['error' => 'You do not have permission to access this page.']);
        }

        return view('admin.add_movie');
    }

    // Add movie action
    public function addMovie(Request $request)
    {
        // Check if the authenticated user has admin role or other criteria
        if (!$this->isAdmin()) {
            return redirect()->route('movies.index')->withErrors(['error' => 'You do not have permission to perform this action.']);
        }

        // Logic for adding a movie goes here
        // You can access form data using $request->input('fieldname')
        // Add the movie to the database

        return redirect()->route('movies.index'); // Redirect to the movies index after adding
    }
    public function showDashboard(Request $request)
    {
        $movies = Movie::query();

        // Check if there is a search query
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $movies->where('title', 'like', "%$searchTerm%")
                   ->orWhere('description', 'like', "%$searchTerm%");
        }

        $movies = $movies->get();

        return view('admin.dashboard', compact('movies'));
    }

    // Show form to add/edit movie
    public function showMovieForm($id = null)
    {
        // Check if the authenticated user is an admin
        if (!$this->isAdmin()) {
            return redirect('/home')->withErrors(['error' => 'You do not have permission to perform this action.']);
        }

        // If $id is provided, fetch the movie for editing
        $movie = $id ? Movie::findOrFail($id) : null;

        return view('admin.movie_form', compact('movie'));
    }

    // Handle adding/editing movie
    public function saveMovie(Request $request, $id = null)
{
    // Check if the authenticated user is an admin
    if (!$this->isAdmin()) {
        return redirect('/home')->withErrors(['error' => 'You do not have permission to perform this action.']);
    }

    // Validation
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // If $id is provided, update the existing movie; otherwise, create a new one
    $movie = $id ? Movie::findOrFail($id) : new Movie;

    // Update movie details
    $movie->title = $request->input('title');
    $movie->description = $request->input('description');

    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('movies', 'public');
        $movie->image = $imagePath;
    }

    $movie->save();

    return redirect()->route('admin.dashboard')->with('success', 'Movie saved successfully.');
}

    // Delete movie
    public function deleteMovie($id)
    {
        // Check if the authenticated user is an admin
        if (!$this->isAdmin()) {
            return redirect('/home')->withErrors(['error' => 'You do not have permission to perform this action.']);
        }

        // Find and delete the movie
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Movie deleted successfully.');
    }

}
