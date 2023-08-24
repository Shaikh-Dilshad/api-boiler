<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProgramPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_program_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('title',100)->nullable();
            $table->string('type',100)->nullable();
            $table->string('category',100)->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_program_posts');
    }
}
