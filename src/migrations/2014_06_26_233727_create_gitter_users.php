<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGitterUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gitter_users', function(Blueprint $table)
        {
            $table->string('id', 24);
            $table->primary('id');
            $table->string('username', 255);
            $table->string('displayName', 255);
            $table->string('url', 255);
            $table->string('avatarUrlSmall', 255);
            $table->string('avatarUrlMedium', 255);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gitter_users');
    }

}
