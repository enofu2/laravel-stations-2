<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller {
    public function create():View {
        return view('post.create');
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'title' => ['required', 'unique:movies'],
            'image_url' => ['required','url']
        ]);
    }
    public function adminMovies(){
        $movies = Movie::all();
        return view('get.admin.movies', ['movies' => $movies]);
    }

    public function index() {
        $movies = Movie::all();
        return view('get.movies', ['movies' => $movies]);
    }
}