<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_tag', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->unsignedInteger('to_do_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->index('to_do_id');
            $table->index('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo_tag');
    }
}
