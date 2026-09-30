<?php

namespace App\Controllers\AltoNivel;

require_once ROOT_PATH . '/config/Database.php';

use Config\Database;
use PDO;

class AgendaController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function index()
    {
        $ano = $_GET['ano'] ?? date('Y');
        $title = "Agenda Administrativa — SisGovernança";

        // 1. Buscar OMs para popular o select do modal
        $stmtOm = $this->db->query("SELECT id_om, nome_om, sigla_om FROM om_origem ORDER BY sigla_om ASC");
        $oms = $stmtOm->fetchAll(PDO::FETCH_ASSOC);

        // 2. Buscar agenda do ano selecionado
        $stmtAgenda = $this->db->prepare("
            SELECT a.*, om.sigla_om, om.nome_om, u.name AS nome_usuario
            FROM agendas a
            JOIN om_origem om ON om.id_om = a.id_om
            LEFT JOIN users u ON u.id_user = a.id_user
            WHERE a.ano_agenda = :ano
            ORDER BY a.id_agenda DESC
            LIMIT 1
        ");
        $stmtAgenda->execute([':ano' => $ano]);
        $agendaAtiva = $stmtAgenda->fetch(PDO::FETCH_ASSOC);

        // 3. Buscar eventos vinculados à agenda + contagem de histórico
        $eventos = [];
        if ($agendaAtiva) {
            $stmtEventos = $this->db->prepare("
                SELECT e.*, u.name AS nome_usuario,
                       (SELECT COUNT(*) FROM eventos_historico h WHERE h.id_evento = e.id_evento) AS total_historico
                FROM eventos e
                LEFT JOIN users u ON u.id_user = e.id_user
                WHERE e.id_agenda = :id_agenda
                ORDER BY e.nr_evento ASC, e.data_ini ASC
            ");
            $stmtEventos->execute([':id_agenda' => $agendaAtiva['id_agenda']]);
            $eventos = $stmtEventos->fetchAll(PDO::FETCH_ASSOC);
        }

        ob_start();
        require_once ROOT_PATH . '/resources/views/alto-nivel/agenda/index.php';
        $content = ob_get_clean();

        require_once ROOT_PATH . '/resources/views/layouts/app.php';
    }

    public function storeAgenda()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? 'cadastrar_agenda';

            if ($action === 'cadastrar_evento') {
                return $this->storeEvento();
            }
            if ($action === 'atualizar_evento') {
                return $this->atualizarEvento();
            }

            $ano = (int)($_POST['ano_agenda'] ?? date('Y'));
            $id_om = !empty($_POST['id_om']) ? (int)$_POST['id_om'] : null;
            $nr_documento = strtoupper(trim($_POST['nr_documento'] ?? ''));
            $id_user = $_SESSION['user_id'] ?? 1;

            if ($id_om && !empty($nr_documento) && $ano > 0) {
                $stmtCheck = $this->db->prepare("SELECT id_agenda FROM agendas WHERE ano_agenda = :ano LIMIT 1");
                $stmtCheck->execute([':ano' => $ano]);
                $agendaExistente = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                if ($agendaExistente) {
                    header("Location: /alto-nivel/agenda?ano={$ano}&status=agenda_ja_existe");
                    exit;
                }

                $sql = "INSERT INTO agendas (ano_agenda, id_om, nr_documento, id_user) VALUES (:ano, :om, :doc, :user)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':ano'  => $ano,
                    ':om'   => $id_om,
                    ':doc'  => $nr_documento,
                    ':user' => $id_user
                ]);

                header("Location: /alto-nivel/agenda?ano={$ano}&status=agenda_criada");
                exit;
            }

            header("Location: /alto-nivel/agenda?status=erro_dados_incompletos");
            exit;
        }
    }

    public function storeEvento()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_agenda   = $_POST['id_agenda'] ?? null;
            $nome_evento = trim($_POST['nome_evento'] ?? '');
            $data_ini    = $_POST['data_ini'] ?? null;
            $data_fim    = $_POST['data_fim'] ?? null;
            $id_user     = $_SESSION['user_id'] ?? 1;
    
            if ($id_agenda && !empty($nome_evento) && $data_ini && $data_fim) {
                // Buscar o último número de evento já cadastrado para esta agenda
                $stmtUltimo = $this->db->prepare("SELECT MAX(nr_evento) AS ultimo FROM eventos WHERE id_agenda = :id_agenda");
                $stmtUltimo->execute([':id_agenda' => $id_agenda]);
                $ultimo = $stmtUltimo->fetch(PDO::FETCH_ASSOC)['ultimo'] ?? 0;
    
                // Define o próximo número sequencial
                $nr_evento = $ultimo + 1;
    
                $sql = "INSERT INTO eventos (id_agenda, nr_evento, nome_evento, data_ini, data_fim, id_user) 
                        VALUES (:agenda, :nr, :nome, :ini, :fim, :user)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':agenda' => $id_agenda,
                    ':nr'     => $nr_evento,
                    ':nome'   => $nome_evento,
                    ':ini'    => $data_ini,
                    ':fim'    => $data_fim,
                    ':user'   => $id_user
                ]);
            }
    
            header("Location: /alto-nivel/agenda?status=evento_criado");
            exit;
        }
    }
    

    public function atualizarEvento()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_evento        = $_POST['id_evento'] ?? null;
            $nome_evento      = trim($_POST['nome_evento'] ?? '');
            $data_ini         = $_POST['data_ini'] ?? null;
            $data_fim         = $_POST['data_fim'] ?? null;
            $nr_msg_alteracao = strtoupper(trim($_POST['nr_msg_alteracao'] ?? ''));
            $id_user          = $_SESSION['user_id'] ?? 1;

            if ($id_evento && !empty($nome_evento) && $data_ini && $data_fim) {
                try {
                    $this->db->beginTransaction();

                    $stmtAtual = $this->db->prepare("SELECT * FROM eventos WHERE id_evento = :id");
                    $stmtAtual->execute([':id' => $id_evento]);
                    $eventoAtual = $stmtAtual->fetch(PDO::FETCH_ASSOC);

                    if ($eventoAtual) {
                        $sqlHist = "INSERT INTO eventos_historico (id_evento, nome_evt_antigo, ini_evt_antigo, fim_evt_antigo, nr_msg_alteracao, id_user) 
                                    VALUES (:id_evt, :nome_ant, :ini_ant, :fim_ant, :msg, :user)";
                        $stmtHist = $this->db->prepare($sqlHist);
                        $stmtHist->execute([
                            ':id_evt'   => $eventoAtual['id_evento'],
                            ':nome_ant' => $eventoAtual['nome_evento'],
                            ':ini_ant'  => $eventoAtual['data_ini'],
                            ':fim_ant'  => $eventoAtual['data_fim'],
                            ':msg'      => $nr_msg_alteracao,
                            ':user'     => $id_user
                        ]);

                        $sqlUpd = "UPDATE eventos 
                                   SET nome_evento = :nome, data_ini = :ini, data_fim = :fim, id_user = :user 
                                   WHERE id_evento = :id";
                        $stmtUpd = $this->db->prepare($sqlUpd);
                        $stmtUpd->execute([
                            ':nome' => $nome_evento,
                            ':ini'  => $data_ini,
                            ':fim'  => $data_fim,
                            ':user' => $id_user,
                            ':id'   => $id_evento
                        ]);

                        $this->db->commit();
                    }
                } catch (\Exception $e) {
                    $this->db->rollBack();
                }
            }

            header("Location: /alto-nivel/agenda?status=evento_atualizado");
            exit;
        }
    }

    public function obterHistorico()
    {
        if (ob_get_length()) {
            ob_clean();
        }

        header('Content-Type: application/json; charset=utf-8');

        $id_evento = filter_input(INPUT_GET, 'id_evento', FILTER_VALIDATE_INT);

        if (!$id_evento) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID de evento inválido']);
            exit;
        }

        try {
            $stmt = $this->db->prepare("
                SELECT h.id_evthistorico,
                       h.id_evento,
                       h.nome_evt_antigo,
                       h.ini_evt_antigo,
                       h.fim_evt_antigo,
                       h.nr_msg_alteracao,
                       h.data_atualizacao AS data_atualizacao,
                       COALESCE(u.name, 'Sistema') AS nome_usuario
                FROM eventos_historico h
                LEFT JOIN users u ON u.id_user = h.id_user
                WHERE h.id_evento = :id_evento
                ORDER BY h.data_atualizacao DESC
            ");
            $stmt->execute([':id_evento' => $id_evento]);
            $historico = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($historico, JSON_UNESCAPED_UNICODE);
            exit;
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao consultar banco de dados: ' . $e->getMessage()]);
            exit;
        }
    }
}
?>