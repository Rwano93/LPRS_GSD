<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->string('CV')->nullable();
            $table->text('description');
            $table->enum('type', ['stage', 'CDD', 'CDI']);
            $table->enum('etat', ['ouverte', 'clôturée']);
            $table->unsignedBigInteger('id_entreprise')->nullable();
            $table->foreign('id_entreprise')->references('id')->on('fiche_entreprises')->onDelete('set null');
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
        Schema::dropIfExists('offres');
    }
}
