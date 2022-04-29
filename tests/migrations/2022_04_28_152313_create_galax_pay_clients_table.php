<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalaxPayClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galax_pay_clients', function (Blueprint $table) {
            $table->integer('id', true, true);

            $table->string('entity');
            $table->integer('entity_id');

            $table->string('galax_id');
            $table->string('galax_hash');
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
        Schema::dropIfExists('galax_pay_clients');
    }
}