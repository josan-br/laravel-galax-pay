<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalaxPaySessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galax_pay_sessions', function (Blueprint $table) {
            $table->integer('id', true, true);

            $table->integer('galax_pay_client_id', false, true)
                ->index('fk_galax_pay_clients_galax_pay_sessions1_idx');
            $table->foreign('galax_pay_client_id', 'fk_galax_pay_clients_galax_pay_sessions1')
                ->references('id')->on('galax_pay_clients')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('token_type', 15);
            $table->string('access_token');
            $table->string('expires_in');
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
        Schema::dropIfExists('galax_pay_sessions');
    }
}
