<?php require ROOT_PATH . '/resources/views/partials/status_alert.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Ordens do CM') ?></title>
    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-4">
    <!-- CABEÇALHO DA TELA -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="text-muted small fw-bold">MÓDULO: ALTO NÍVEL</span>
            <h3 class="fw-bold m-0 text-primary">Ordens do Comandante da Marinha</h3>
        </div>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovaOrdem">
            <i class="bi bi-plus-lg me-1"></i> Nova Ordem do CM
        </button>
    </div>

    <!-- Feedback de Mensagens -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show small" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Tabela de Dados -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <?php require __DIR__ . '/partials/ordens_table.php'; ?>
        </div>
    </div>
</div>

<!-- MODAL DE NOVA ORDEM DO CM -->
<?php require ROOT_PATH . '/resources/views/alto-nivel/ordens_cm/partials/modal_nova_ordem.php'; ?>

<!-- MODAL DE EDIÇÃO DE ORDEM DO CM -->
<?php require ROOT_PATH . '/resources/views/alto-nivel/ordens_cm/partials/modal_editar_ordem.php'; ?>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SCRIPTS DE MANIPULAÇÃO -->
<script src="/js/ordens_cm.js"></script>

</body>
</html>