<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGaleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 800)->nullable();
            $table->text('data')->nullable();
            $table->string('img', 800)->nullable();
            $table->integer('sayfa')->nullable();
            $table->integer('urun')->nullable();
            $table->integer('proje')->nullable();
            $table->integer('sortable')->nullable();
            $table->boolean('visible')->default(1);

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
        Schema::dropIfExists('galeri');
    }
}
