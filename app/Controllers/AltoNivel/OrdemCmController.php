<?php

namespace App\Controllers\AltoNivel;

use Core\View;
use App\Models\OrdemCm;

class OrdemCmController
{
    private OrdemCm $ordemCmModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['authenticated'])) {
            header('Location: /login');
            exit;
        }

        $this->ordemCmModel = new OrdemCm();
    }

    public function index(): void
    {
        // Busca os dados para popular o formulário e a listagem
        $ordens          = $this->ordemCmModel->getAll();
        $omsOrigem       = $this->ordemCmModel->getOmsOrigem();
        $omsResp         = $this->ordemCmModel->getOmsResponsaveis();
        $subchefiasLider = $this->ordemCmModel->getSubchefiasLider();
        $subchefiasApoio = $this->ordemCmModel->getSubchefiasApoio();
        $statusOrdem     = $this->ordemCmModel->getStatusOrdem();

        View::render('alto-nivel.ordens_cm.index', [
            'title'           => 'Ordens do CM — SisGovernança',
            'ordens'          => $ordens,
            'omsOrigem'       => $omsOrigem,
            'omsResp'         => $omsResp,
            'subchefiasLider' => $subchefiasLider,
            'subchefiasApoio' => $subchefiasApoio,
            'statusOrdem'     => $statusOrdem
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /alto-nivel/ordens-cm');
            exit;
        }

        $nrOrdem = !empty($_POST['nr_ordem']) ? (int)$_POST['nr_ordem'] : null;

        // 1. Validação de Unicidade do Número da Ordem
        if ($nrOrdem && $this->ordemCmModel->existsNrOrdem($nrOrdem)) {
            $_SESSION['error'] = "Já existe uma Ordem do CM cadastrada com o número {$nrOrdem}.";
            header('Location: /alto-nivel/ordens-cm');
            exit;
        }

        // 2. Trata múltiplos checkboxes de Subchefia de Apoio
        $subApoioStr = null;
        if (!empty($_POST['id_sub_apoio']) && is_array($_POST['id_sub_apoio'])) {
            $subApoioStr = implode(',', array_map('intval', $_POST['id_sub_apoio']));
        }

        // 3. Monta o array de dados
        $dados = [
            'nr_ordem'        => $nrOrdem,
            'docum_origem'    => trim($_POST['docum_origem'] ?? ''),
            'data_docum'      => !empty($_POST['data_docum']) ? $_POST['data_docum'] : null,
            'id_om'           => !empty($_POST['id_om']) ? (int)$_POST['id_om'] : null,
            'id_om_resp'      => !empty($_POST['id_om_resp']) ? (int)$_POST['id_om_resp'] : null,
            'id_sub_lider'    => !empty($_POST['id_sub_lider']) ? (int)$_POST['id_sub_lider'] : null,
            'id_sub_apoio'    => $subApoioStr,
            'id_status_ordem' => !empty($_POST['id_status_ordem']) ? (int)$_POST['id_status_ordem'] : null,
            'prazo'           => !empty($_POST['prazo']) ? $_POST['prazo'] : null,
            'data_cump'       => !empty($_POST['data_cump']) ? $_POST['data_cump'] : null,
            'tema_pauta'      => trim($_POST['tema_pauta'] ?? ''),
            'determinacao'    => trim($_POST['determinacao'] ?? ''),
            'evento'          => trim($_POST['evento'] ?? ''),
            'observacao'      => trim($_POST['observacao'] ?? '')
        ];

        if ($this->ordemCmModel->insert($dados)) {
            $_SESSION['success'] = "Ordem do CM nº {$nrOrdem} cadastrada com sucesso!";
        } else {
            $_SESSION['error'] = "Erro ao cadastrar a Ordem do CM no banco de dados.";
        }

        header('Location: /alto-nivel/ordens-cm');
        exit;
    }
}