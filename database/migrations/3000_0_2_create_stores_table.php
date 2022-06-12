<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) { 
            $table->id();
            $table->string('name');
            $table->string('url_map');
            $table->string('days');
            $table->string('location');
            $table->string('ico');
            $table->string('logo');
            $table->text('mision');
            $table->text('vision');
            $table->integer('phone');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('tik_tok');
            $table->string('youtube');
            $table->integer('whatsapp');
            $table->string('qr');
            $table->boolean('is_open');
            $table->integer('days_subscription');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
