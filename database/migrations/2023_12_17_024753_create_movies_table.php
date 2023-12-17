<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        DB::unprepared('ALTER TABLE timeline_events
        ADD UNIQUE key unique_title (title(64))'
        );
        */
        Schema::create('movies', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->text('title')->comment('映画タイトル');
            $table->text('image_url')->comment('画像URL');
            $table->integer('published_year')->comment('公開年');
            $table->tinyInteger('is_showing')->comment('上映中かどうか');
            $table->text('description')->comment('概要');
            $table->unsignedBigInteger('genre')->comment('ジャンル名');
            $table->timestamps();

            $table->unique([DB::raw('title(50)')], 'movies_title_unique');
            $table->foreign('genre')->references('id')->on('genres');
        });
        /*
        DB::statement('CREATE INDEX movies_title_unique ON movies (title(100));');

        Schema::table('movies', function (Blueprint $table) {
            $table->unique('title');
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropIndex('movies_title_unique');
        });
        Schema::dropIfExists('movies');
    }
}
