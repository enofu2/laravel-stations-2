@include('layouts.schedule.form', [
        'title' => 'スケジュール新規作成',
        'action' => route('admin.schedules.store',['id' => $id]),
        'buttonLabel' => '新規作成',
        'record' => $record,
    ])
