<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('document');
            $table->text('description_payment');
            $table->integer('document_type');
            /*
             * 1 => Pessoa física
             * 2 => Pessoa jurídica
             */
            $table->string('corporate_name');
            $table->string('name');
            $table->string('image');
            $table->string('phone');
            $table->string('address');
            $table->string('neighborhood');
            $table->string('cep');
            $table->softDeletes();
            $table->unique(['document', 'deleted_at']);
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
        Schema::dropIfExists('entities');
    }
}
