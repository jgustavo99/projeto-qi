<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('entity_id')->unsigned();
            $table->foreign('entity_id')->references('id')->on('entities');
            $table->text('title');
            $table->string('slug');
            $table->text('description');
            $table->string('image');
            $table->decimal('amount_goal', 12, 2);
            $table->date('close_at');
            $table->tinyInteger('status')->default(1);
            /*
             * 1 => Ativa
             * 2 => Encerrada
             */
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
        Schema::dropIfExists('campaigns');
    }
}
