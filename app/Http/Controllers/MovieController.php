<?php
namespace App\Http\Controllers;
use App\Models\Movie;

class MovieController extends Controller {
    public function moviesTableView(){
        $movies = Movie::all();
        return view('getMoviesTableView', ['movies' => $movies]);
    }

    public function index() {
        $movies = Movie::all();
        return view('getMovies', ['movies' => $movies]);
    }
}