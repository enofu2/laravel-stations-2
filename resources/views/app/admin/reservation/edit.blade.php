<?php
/**
 * @var App\Properties\Reservation\ReservationProperties $dto
 */
?>
@include('layouts.reservation.adminForm', [
        'title' => '管理者 | 予約編集フォーム',
        'action' => route('admin.reservations.update',['id' => $dto->id]),
        'buttonLabel' => '更新',
        'method' => 'PATCH',
        'dto' => $dto,
        'deleteButton' => true,
    ])