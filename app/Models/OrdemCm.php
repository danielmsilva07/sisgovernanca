<?php

namespace App\Models;

use PDO;
use Config\Database;

class OrdemCm
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT o.*, 
                       om.sigla_om, 
                       omr.sigla_om_resp, 
                       sl.cod_sub_lider, 
                       so.nome_status_ordem
                FROM ordem_cm o
                LEFT JOIN om_origem om ON om.id_om = o.id_om
                LEFT JOIN om_responsavel omr ON omr.id_om_resp = o.id_om_resp
                LEFT JOIN subchefia_lider sl ON sl.id_sub_lider = o.id_sub_lider
                LEFT JOIN status_ordem so ON so.id_status_ordem = o.id_status_ordem
                ORDER BY o.id_ordem DESC";
        
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existsNrOrdem(int $nrOrdem): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM ordem_cm WHERE nr_ordem = :nr_ordem");
        $stmt->bindValue(':nr_ordem', $nrOrdem, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn() > 0;
    }

    public function insert(array $dados): bool
    {
        $sql = "INSERT INTO ordem_cm (
                    nr_ordem, docum_origem, data_docum, id_om, id_om_resp, 
                    id_sub_lider, id_sub_apoio, id_status_ordem, prazo, 
                    data_cump, tema_pauta, determinacao, evento, observacao, data_cadastro
                ) VALUES (
                    :nr_ordem, :docum_origem, :data_docum, :id_om, :id_om_resp, 
                    :id_sub_lider, :id_sub_apoio, :id_status_ordem, :prazo, 
                    :data_cump, :tema_pauta, :determinacao, :evento, :observacao, CURRENT_TIMESTAMP
                )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nr_ordem'        => $dados['nr_ordem'],
            ':docum_origem'    => $dados['docum_origem'],
            ':data_docum'      => $dados['data_docum'],
            ':id_om'           => $dados['id_om'],
            ':id_om_resp'      => $dados['id_om_resp'],
            ':id_sub_lider'    => $dados['id_sub_lider'],
            ':id_sub_apoio'    => $dados['id_sub_apoio'],
            ':id_status_ordem' => $dados['id_status_ordem'],
            ':prazo'           => $dados['prazo'],
            ':data_cump'       => $dados['data_cump'],
            ':tema_pauta'      => $dados['tema_pauta'],
            ':determinacao'    => $dados['determinacao'],
            ':evento'          => $dados['evento'],
            ':observacao'      => $dados['observacao']
        ]);
    }

    // Métodos para carregar os combos
    public function getOmsOrigem(): array
    {
        return $this->db->query("SELECT id_om, nome_om, sigla_om FROM om_origem ORDER BY sigla_om")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOmsResponsaveis(): array
    {
        return $this->db->query("SELECT id_om_resp, nome_om_resp, sigla_om_resp FROM om_responsavel ORDER BY sigla_om_resp")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubchefiasLider(): array
    {
        return $this->db->query("SELECT id_sub_lider, nome_sub_lider, cod_sub_lider FROM subchefia_lider ORDER BY cod_sub_lider")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubchefiasApoio(): array
    {
        return $this->db->query("SELECT id_sub_apoio, nome_sub_apoio, cod_sub_apoio FROM subchefia_apoio ORDER BY cod_sub_apoio")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatusOrdem(): array
    {
        return $this->db->query("SELECT id_status_ordem, nome_status_ordem FROM status_ordem ORDER BY id_status_ordem")->fetchAll(PDO::FETCH_ASSOC);
    }
}