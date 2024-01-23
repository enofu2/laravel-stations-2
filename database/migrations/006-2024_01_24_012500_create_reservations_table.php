<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('上映日');
            $table->unsignedBigInteger('schedule_id')->comment('スケジュールID');
            $table->unsignedBigInteger('sheet_id')->comment('シートID');
            $table->string('email')->comment('予約者メールアドレス');
            $table->string('name')->comment('予約者');
            $table->boolean('is_canceled')->default(false)->comment('予約キャンセル済み');
            $table->timestamps();
            
            $table->unique(['schedule_id','sheet_id']);
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('sheet_id')->references('id')->on('sheets')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
