<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordens_cm', function (Blueprint $table) {
            $table->bigIncrements('id_ordens_cm');
            $table->unsignedInteger('nr_ordem_cm')->unique();
            $table->string('docum_origem')->nullable();
            $table->date('data_docum')->nullable();
            
            // Relacionamentos FK
            $table->unsignedBigInteger('id_om_origem')->nullable();
            $table->foreign('id_om_origem')->references('id_om_origem')->on('om_origem')->nullOnDelete();

            $table->unsignedBigInteger('id_om_resp')->nullable();
            $table->foreign('id_om_resp')->references('id_om_resp')->on('om_responsavel')->nullOnDelete();

            $table->unsignedBigInteger('id_sub_lider')->nullable();
            $table->foreign('id_sub_lider')->references('id_sub_lider')->on('subchefia_lider')->nullOnDelete();

            // Múltiplas subchefias de apoio selecionadas via checkboxes (armazenadas em formato JSON)
            $table->json('id_sub_apoio')->nullable();

            $table->unsignedBigInteger('id_status_ordem')->nullable();
            $table->foreign('id_status_ordem')->references('id_status_ordem')->on('status_ordem')->nullOnDelete();

            $table->date('prazo')->nullable();
            $table->text('tema_pauta')->nullable();
            $table->text('determinacao')->nullable();
            $table->text('evento')->nullable();
            $table->text('observacao')->nullable();
            $table->date('data_cumpr')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordens_cm');
    }
};
