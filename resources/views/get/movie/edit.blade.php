@include('layouts.movie.form', [
        'title' => '管理者：映画編集画面',
        'action' => route('admin.update',['id'=>$record['id']]) ,
        'method' => 'PATCH',
        'buttonLabel' => '更新',
        'record' => $record,
    ])
