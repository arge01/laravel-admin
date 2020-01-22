<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAltsliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('altslider', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 500);
            $table->string('slug', 500);
            $table->string('img', 800);
            $table->string('label', 800)->nullable();
            $table->string('link', 500)->nullable();
            $table->text('icerik')->nullable();
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
        Schema::dropIfExists('altslider');
    }
}
