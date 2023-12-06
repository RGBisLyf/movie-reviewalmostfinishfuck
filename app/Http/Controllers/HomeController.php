<?php

// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        // Search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        // Filter by initial letter
        if ($request->has('letter')) {
            $query->where('title', 'like', $request->input('letter') . '%');
        }

        $movies = $query->get();

        // Check if it's an Ajax request
        if ($request->ajax()) {
            try {
                return view('movies.movies_partial')->with('movies', $movies)->render();
            } catch (\Throwable $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        // If it's a regular request, return the full HTML with the layout
        try {
            return view('home', compact('movies'));
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
