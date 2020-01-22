<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjandaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajanda', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 500);
            $table->string('url', 500)->nullable();
            $table->string('color', 500)->nullable();
            $table->string('year', 500)->nullable();

            $table->string('startmonth', 500)->nullable();
            $table->string('startday', 500)->nullable();
            $table->string('starthour', 500)->nullable();

            $table->string('endmonth', 500)->nullable();
            $table->string('endday', 500)->nullable();
            $table->string('endhour', 500)->nullable();

            $table->timestamp('olusturma_tarihi')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('guncelleme_tarihi')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ajanda');
    }
}
