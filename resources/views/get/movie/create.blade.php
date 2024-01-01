@include('layouts.movie.form', [
        'title' => '管理者：映画登録画面',
        'action' => route('admin.movies.store') ,
        'buttonLabel' => '新規登録',
        'record' => $record,
    ])
