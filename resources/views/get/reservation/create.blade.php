@include('layouts.reservation.form', [
        'title' => '座席予約フォーム',
        'action' => route('reservations.store'),
        'buttonLabel' => '予約',
        'record' => $record,
        'errors' => $errors,
        
    ])