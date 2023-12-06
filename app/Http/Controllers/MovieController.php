<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Log; // Import the Log facade

class MovieController extends Controller
{
    
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movies.show', compact('movie'));
    }

    public function __construct()
    {
          $this->middleware('auth')->except(['index', 'show']);
    }
}
