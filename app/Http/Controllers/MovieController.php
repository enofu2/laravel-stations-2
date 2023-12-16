<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View;

use App\Models\Movie;
use App\Http\Requests\PostedMovieRequest;

class MovieController extends Controller {
    public function create() {
        return view('post.create');
    }
    public function store(PostedMovieRequest $request){
        Movie::create([
            'title' => $request['title'],
            'image_url' => $request['image_url'],
            'published_year' => $request['published_year'],
            'is_showing' => $request['is_showing'],
            'description' => $request['description']
        ]);
        $request->session()->flash('message', "映画を新規登録しました");
        return redirect()->route('admin.home');
    }
    public function adminAllMovies(){
        $movies = Movie::all();
        return view('get.admin.movies', ['movies' => $movies]);
    }

    public function index() {
        $movies = Movie::all();
        return view('get.movies', ['movies' => $movies]);
    }
}