<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToDoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_favorite', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->unsignedInteger('to_do_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->index('to_do_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo_favorite');
    }
}
