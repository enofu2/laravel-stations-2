@include('layouts.schedule.form', [
        'title' => 'スケジュール更新',
        'action' => route('admin.schedules.update',['id' => $record['id'] ]),
        'method' => 'PATCH',
        'buttonLabel' => '更新',
        'record' => $record,
    ])