<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities');

            // Se for um usuário de entidade
            $table->bigInteger('entity_id')->unsigned()->nullable();
            $table->foreign('entity_id')->references('id')->on('entities');

            $table->string('name');
            $table->string('email');
            $table->string('document')->nullable();
            $table->string('phone')->nullable();
            //$table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_entity')->default(0); // É entidade ou usuário doador
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->unique(['email', 'deleted_at']);
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
        Schema::dropIfExists('users');
    }
}
