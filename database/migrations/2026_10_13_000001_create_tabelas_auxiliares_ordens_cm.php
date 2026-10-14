<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabela Auxiliar: om_origem
        Schema::create('om_origem', function (Blueprint $table) {
            $table->bigIncrements('id_om_origem');
            $table->string('nome_om_origem');
            $table->string('sigla_om_origem');
            $table->timestamps();
        });

        // 2. Tabela Auxiliar: om_responsavel
        Schema::create('om_responsavel', function (Blueprint $table) {
            $table->bigIncrements('id_om_resp');
            $table->string('nome_om_resp');
            $table->string('sigla_om_resp');
            $table->timestamps();
        });

        // 3. Tabela Auxiliar: subchefia_lider
        Schema::create('subchefia_lider', function (Blueprint $table) {
            $table->bigIncrements('id_sub_lider');
            $table->string('nome_sub_lider');
            $table->string('sigla_sub_lider');
            $table->timestamps();
        });

        // 4. Tabela Auxiliar: subchefia_apoio
        Schema::create('subchefia_apoio', function (Blueprint $table) {
            $table->bigIncrements('id_sub_apoio');
            $table->string('nome_sub_apoio');
            $table->string('sigla_sub_apoio');
            $table->timestamps();
        });

        // 5. Tabela Auxiliar: status_ordem
        Schema::create('status_ordem', function (Blueprint $table) {
            $table->bigIncrements('id_status_ordem');
            $table->string('nome_status_ordem');
            $table->timestamps();
        });

        // Inserção dos dados iniciais de referência institucional da Marinha do Brasil
        $now = now();

        DB::table('om_origem')->insert([
            ['nome_om_origem' => 'Comandante da Marinha', 'sigla_om_origem' => 'CM', 'created_at' => $now, 'updated_at' => $now],
            ['nome_om_origem' => 'Gabinete do Comandante da Marinha', 'sigla_om_origem' => 'GCM', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('om_responsavel')->insert([
            ['nome_om_resp' => 'Estado-Maior da Armada', 'sigla_om_resp' => 'EMA', 'created_at' => $now, 'updated_at' => $now],
            ['nome_om_resp' => 'Comando de Operações Navais', 'sigla_om_resp' => 'ComOpNav', 'created_at' => $now, 'updated_at' => $now],
            ['nome_om_resp' => 'Diretoria-Geral do Material da Marinha', 'sigla_om_resp' => 'DGMM', 'created_at' => $now, 'updated_at' => $now],
            ['nome_om_resp' => 'Diretoria-Geral de Navegação', 'sigla_om_resp' => 'DGN', 'created_at' => $now, 'updated_at' => $now],
            ['nome_om_resp' => 'Diretoria-Geral de Pessoal da Marinha', 'sigla_om_resp' => 'DGPM', 'created_at' => $now, 'updated_at' => $now],
            ['nome_om_resp' => 'Secretaria-Geral da Marinha', 'sigla_om_resp' => 'SGM', 'created_at' => $now, 'updated_at' => $now],
            ['nome_om_resp' => 'Diretoria-Geral de Desenvolvimento Nuclear e Tecnológico da Marinha', 'sigla_om_resp' => 'DGDNTM', 'created_at' => $now, 'updated_at' => $now],
            ['nome_om_resp' => 'Comando-Geral do Corpo de Fuzileiros Navais', 'sigla_om_resp' => 'CGCFN', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('subchefia_lider')->insert([
            ['nome_sub_lider' => 'Subchefia de Organização', 'sigla_sub_lider' => 'M-10', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_lider' => 'Subchefia de Orçamento e Plano Diretor', 'sigla_sub_lider' => 'M-20', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_lider' => 'Subchefia de Estratégia', 'sigla_sub_lider' => 'M-30', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_lider' => 'Subchefia de Logística', 'sigla_sub_lider' => 'M-40', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_lider' => 'Subchefia de Assuntos Marítimos', 'sigla_sub_lider' => 'M-50', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_lider' => 'Subchefia de Assuntos Internacionais', 'sigla_sub_lider' => 'M-60', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('subchefia_apoio')->insert([
            ['nome_sub_apoio' => 'Subchefia de Organização', 'sigla_sub_apoio' => 'M-10', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_apoio' => 'Subchefia de Orçamento e Plano Diretor', 'sigla_sub_apoio' => 'M-20', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_apoio' => 'Subchefia de Estratégia', 'sigla_sub_apoio' => 'M-30', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_apoio' => 'Subchefia de Logística', 'sigla_sub_apoio' => 'M-40', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_apoio' => 'Subchefia de Assuntos Marítimos', 'sigla_sub_apoio' => 'M-50', 'created_at' => $now, 'updated_at' => $now],
            ['nome_sub_apoio' => 'Subchefia de Assuntos Internacionais', 'sigla_sub_apoio' => 'M-60', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('status_ordem')->insert([
            ['nome_status_ordem' => 'Em Andamento', 'created_at' => $now, 'updated_at' => $now],
            ['nome_status_ordem' => 'Cumprida', 'created_at' => $now, 'updated_at' => $now],
            ['nome_status_ordem' => 'Pendente', 'created_at' => $now, 'updated_at' => $now],
            ['nome_status_ordem' => 'Cancelada', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_ordem');
        Schema::dropIfExists('subchefia_apoio');
        Schema::dropIfExists('subchefia_lider');
        Schema::dropIfExists('om_responsavel');
        Schema::dropIfExists('om_origem');
    }
};
