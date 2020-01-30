<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIceriklerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icerikler', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sayfasi')->nullable();
            $table->string('name', 500)->nullable();
            $table->string('label', 500)->nullable();
            $table->string('slug', 500)->nullable();
            $table->boolean('visible')->default(1);
            $table->text('icerik');
            
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
        Schema::dropIfExists('icerikler');
    }
}
