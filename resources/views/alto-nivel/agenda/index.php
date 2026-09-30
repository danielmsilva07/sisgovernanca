<?php require ROOT_PATH . '/resources/views/partials/status_alert.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Agenda Administrativa') ?></title>
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-4">
    <!-- CABEÇALHO DA TELA -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Agenda Administrativa</h3>
            <p class="text-muted small mb-0">Eventos institucionais do CM</p>
        </div>
        
        <!-- AÇÕES SUPERIORES: SELEÇÃO DE ANO, NOVO EVENTO E NOVA AGENDA -->
        <div class="d-flex gap-2 align-items-center">
            <!-- Seleção do Exercício -->
            <form method="GET" action="/alto-nivel/agenda" class="m-0">
                <select name="ano" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                    <option value="2026" <?= (!isset($_GET['ano']) || $_GET['ano'] == '2026') ? 'selected' : '' ?>>Exercício 2026</option>
                    <option value="2025" <?= (isset($_GET['ano']) && $_GET['ano'] == '2025') ? 'selected' : '' ?>>Exercício 2025</option>
                </select>
            </form>

            <!-- Botão para Incluir Evento na Agenda do Ano Selecionado -->
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovoEvento" title="Adicionar evento a esta agenda" <?= empty($agendaAtiva) ? 'disabled' : '' ?>>
                <i class="bi bi-calendar-plus me-1"></i> Novo Evento
            </button>

            <!-- Botão para Cadastrar Nova Agenda Anual -->
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCadastrarAgenda" title="Criar agenda para outro exercício">
                <i class="bi bi-journal-plus me-1"></i> Cadastrar Agenda
            </button>
        </div>
    </div>

    <!-- CARD DA AGENDA DO EXERCÍCIO -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <!-- DADOS DA AGENDA -->
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 bg-primary-subtle text-primary rounded">
                        <i class="bi bi-journal-bookmark fs-4"></i>
                    </div>
                    <div>
                        <span class="badge bg-secondary mb-1">OM Demandante: <?= htmlspecialchars($agendaAtiva['sigla_om'] ?? 'N/A') ?></span>
                        <h6 class="fw-bold mb-0">Mensagem de Origem: <?= htmlspecialchars($agendaAtiva['nr_documento'] ?? 'Nenhuma agenda ativa') ?></h6>
                    </div>
                </div>
                <div class="text-end small text-muted">
                    Cadastrado por: <strong><?= htmlspecialchars($agendaAtiva['nome_usuario'] ?? 'Sistema') ?></strong>
                </div>
            </div>

            <!-- TABELA DE EVENTOS VINCULADOS À AGENDA -->
            <?php require ROOT_PATH . '/resources/views/alto-nivel/agenda/partials/eventos_table.php'; ?>
        </div>
    </div>
</div>

<!-- MODAL DE CADASTRAR AGENDA ANUAL -->
<?php require ROOT_PATH . '/resources/views/alto-nivel/agenda/partials/modal_cadastrar_agenda.php'; ?>

<!-- MODAL DE NOVO EVENTO -->
<?php require ROOT_PATH . '/resources/views/alto-nivel/agenda/partials/modal_novo_evento.php'; ?>

<!-- MODAL DE HISTÓRICO DE ALTERAÇÕES -->
<?php require ROOT_PATH . '/resources/views/alto-nivel/agenda/partials/modal_historico.php'; ?>

<!-- MODAL DE EDIÇÃO -->
<?php require ROOT_PATH . '/resources/views/alto-nivel/agenda/partials/modal_editar_evento.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SCRIPTS DE MANIPULAÇÃO -->
<script src="/js/agenda.js"></script>

</body>
</html>