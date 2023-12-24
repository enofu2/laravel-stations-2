@include('layouts.schedule.form', [
        'title' => 'スケジュール更新',
        'action' => route('admin.schedule.update',['id' => $record['id'] ]),
        'method' => 'PATCH',
        'buttonLabel' => '更新',
        'record' => $record,
        'errors' => $errors,
    ])