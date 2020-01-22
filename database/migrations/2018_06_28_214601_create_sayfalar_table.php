<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSayfalarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sayfalar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 500);
            $table->integer('belong')->nullable();
            $table->string('slug', 500);
            $table->integer('sortable')->nullable();
            $table->boolean('content')->default(0);
            $table->boolean('visible')->default(1);
            $table->boolean('link')->default(0);
            $table->string('target', 500)->nullable();
            $table->string('url', 800)->nullable();

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
        Schema::dropIfExists('sayfalar');
    }
}
