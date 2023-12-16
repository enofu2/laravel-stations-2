<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View;

use App\Models\Movie;
use App\Http\Requests\Movie\CreateMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;

class MovieController extends Controller {

    public function delete($id){
        $record = Movie::query()->where('id',$id);
        //dd($id,$record->exists(),$record->first(),$record->first());
        if ($record->exists()) {
            $record->delete();
            session()->flash('message', "[id:{$id}]の情報削除しました");            
            return redirect()->route('admin.home');
        }else{
            session()->flash('err-message', "該当idの情報が見つかりません");
            return response()->view('get.admin.movies',['movies' => MovieController::getMovies()],404);
        }
    }
    
    public function update(UpdateMovieRequest $request,$id) {
        Movie::query()->where('id',$id)->update([
            'title' => $request['title'],
            'image_url' => $request['image_url'],
            'published_year' => $request['published_year'],
            'is_showing' => $request['is_showing'],
            'description' => $request['description']
        ]);
        session()->flash('message', "映画情報を更新しました");
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
        session()->flash('message', "映画情報を新規登録しました");
        return redirect()->route('admin.home');
    }

    public function edit($id) {
        $record = Movie::query()->where('id',$id);
            //dd($id,$record->exists(),$record->first(),$record->first());
        if ($record->exists()) {
            return view('post.edit',['id'=>$id,'record' => $record->first()]);
        }else{
            session()->flash('err-message', "該当idの情報が見つかりません");
            return back();
        }
    }

    public function create() {
        return view('post.create');
    }

    public function adminPage(){
        $movies = Movie::all();
        return view('get.admin.movies', ['movies' => $movies]);
    }

    public function index(Request $request) {
        $is_showing = $request->query('is_showing');
        $keyword = $request->query('keyword');
        
        $movies = new Movie;
        //dd($is_showing,$keyword);
        //if( !(isset($is_showing)) ){
            if($is_showing == '1') {
                $movies = $movies->where('is_showing','1');
            }else if($is_showing == '0'){
                $movies = $movies->where('is_showing','0');
            }
        //}
        //dd($is_showing,$keyword,$movies,$is_showing == '0',$is_showing == '1');
        if( !(empty($keyword)) ){
            $movies = $movies->where('title','like', '%'.$keyword .'%')
                ->orWhere('description','like', '%'.$keyword .'%');
        }

        $movies = $movies->paginate(20);
        //dd($movies);
        return view('get.movies', [
            'movies' => $movies,
            'is_showing' => $is_showing,
            'keyword' => $keyword,
        ]);
    }

    public function getMovies(){
        return Movie::all();
    }
}