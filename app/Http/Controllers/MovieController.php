<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View;

use App\Models\Movie;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

class MovieController extends Controller {

    public function update(UpdateMovieRequest $request,$id) {
        Movie::query()->where('id',$id)->update([
            'title' => $request['title'],
            'image_url' => $request['image_url'],
            'published_year' => $request['published_year'],
            'is_showing' => $request['is_showing'],
            'description' => $request['description']
        ]);
        $request->session()->flash('message', "映画情報を更新しました");
        return redirect()->route('admin.home');
    }
    public function store(CreateMovieRequest $request){
        Movie::create([
            'title' => $request['title'],
            'image_url' => $request['image_url'],
            'published_year' => $request['published_year'],
            'is_showing' => $request['is_showing'],
            'description' => $request['description']
        ]);
        $request->session()->flash('message', "映画情報を新規登録しました");
        return redirect()->route('admin.home');
    }

    public function edit($id) {
        $record = Movie::query()->where('id',$id);
            //dd($id,$record->exists(),$record->first(),$record->first());
        if ($record->exists()) {
            return view('post.edit',['id'=>$id,'record' => $record->first()]);
        }else{
            $record->session()->flash('err-message', "該当idの情報が見つかりません");
            return back();
        }
    }

    public function create() {
        return view('post.create');
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