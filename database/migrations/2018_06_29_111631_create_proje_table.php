<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proje', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 500);
            $table->text('label')->nullable();
            $table->string('slug', 500)->nullable();
            $table->string('img', 900);
            $table->string('katalog', 900)->nullable();
            $table->integer('kategori')->nullable();
            $table->text('icerik');
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
        Schema::dropIfExists('proje');
    }
}
