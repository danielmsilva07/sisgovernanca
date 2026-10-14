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
        // 1. Tabela de Subsídios para Acompanhamento da Ordem do CM
        Schema::create('subsidios_ordens_cm', function (Blueprint $table) {
            $table->bigIncrements('id_subsidios_ordens_cm');
            $table->unsignedBigInteger('id_ordens_cm');
            $table->foreign('id_ordens_cm')
                  ->references('id_ordens_cm')
                  ->on('ordens_cm')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->nullOnDelete();

            $table->text('medida_adotada');
            $table->timestamps();
        });

        // 2. Tabela de Histórico e Auditoria de Modificações na Ordem do CM
        Schema::create('historico_ordens_cm', function (Blueprint $table) {
            $table->bigIncrements('id_historico_ordens_cm');
            $table->unsignedBigInteger('id_ordens_cm');
            $table->foreign('id_ordens_cm')
                  ->references('id_ordens_cm')
                  ->on('ordens_cm')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->nullOnDelete();

            $table->string('tipo_acao'); // 'Criação', 'Edição', 'Atualização de Subsídio'
            $table->json('dados_anteriores')->nullable();
            $table->json('dados_novos')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_ordens_cm');
        Schema::dropIfExists('subsidios_ordens_cm');
    }
};
