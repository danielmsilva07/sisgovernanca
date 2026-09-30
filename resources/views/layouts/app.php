<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SisGovernança' ?></title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/dashboard.css">
    
    <style>
        body { min-height: 100vh; display: flex; flex-direction: column; }
        .main-wrapper { flex: 1; display: flex; }
        .sidebar { width: 260px; background-color: #212529; min-height: calc(100vh - 56px - 45px); }
        .content-area { flex: 1; padding: 1.5rem; background-color: #f8f9fa; }
    </style>
</head>
<body>

    <!-- Menu Horizontal Superior -->
    <?php require_once ROOT_PATH . '/resources/views/partials/navbar.php'; ?>

    <div class="main-wrapper">
        <!-- Menu Vertical Esquerda -->
        <?php require_once ROOT_PATH . '/resources/views/partials/sidebar.php'; ?>

        <!-- Conteúdo Principal -->
        <main class="content-area">
            <?= $content; ?>
        </main>
    </div>

    <!-- Rodapé -->
    <?php require_once ROOT_PATH . '/resources/views/partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>