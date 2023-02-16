<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionHospitalariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestion_hospitalaria', function (Blueprint $table) {
            $table->bigIncrements('id_hospitalizacion');
            $table->string('tipo_doc_paciente', 2);
            $table->string('no_doc_paciente', 15);
            $table->string('cod_hospital', 12);
            $table->timestamp('fec_ingreso')->nullable();
            $table->timestamp('fec_salida')->nullable();
            $table->timestamp('fec_creacion')->useCurrent();

            $table->foreign('no_doc_paciente')->references('no_documento')->on('pacientes');
            $table->foreign('cod_hospital')->references('cod_hospital')->on('hospitales');
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
        Schema::dropIfExists('gestion_hospitalaria');
    }
}
