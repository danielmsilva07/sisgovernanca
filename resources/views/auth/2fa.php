<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisGovernança - Validação 2FA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center m-0">

<div class="card border-0 shadow-sm rounded-4 p-4 p-sm-5" style="width: 100%; max-width: 440px;">

    <div class="text-center mb-4">
        <i class="bi bi-shield-lock-fill text-primary display-4"></i>
        <h4 class="fw-bold mt-2 mb-1">Verificação de Segurança</h4>
        <p class="text-secondary small mb-0">Autenticação em Duas Etapas (2FA)</p>
    </div>

    <?php if (!empty($isSetup)): ?>
        <!-- FLUXO 1: PRIMEIRO ACESSO (EXIBE QR CODE) -->
        <div class="text-center mb-3">
            <p class="text-muted small">Escaneie o QR Code abaixo usando o aplicativo <strong>Google Authenticator</strong>:</p>
            
            <div class="p-2 border rounded-3 bg-white d-inline-block mb-2 shadow-sm">
                <img src="<?= $qrCodeUrl ?>" alt="QR Code 2FA" style="width: 180px; height: 180px;">
            </div>

            <p class="text-muted small mb-1">Ou insira a chave manualmente:</p>
            <code class="d-block bg-light border p-2 rounded text-dark fw-bold text-break small mb-3"><?= chunk_split($secret, 4, ' ') ?></code>
        </div>
    <?php else: ?>
        <!-- FLUXO 2: LOGINS SUBSEQUENTES (RECORRENTE) -->
        <p class="text-center text-muted small mb-4">
            Abra o aplicativo <strong>Google Authenticator</strong> e informe o código de 6 dígitos gerado.
        </p>
    <?php endif; ?>

    <form action="/2fa" method="POST">
        <div class="mb-3">
            <label for="code" class="form-label fw-semibold small">Código de Validação</label>
            <input type="text" 
                   class="form-control form-control-lg text-center fw-bold fs-4 tracking-wider" 
                   id="code" 
                   name="code" 
                   placeholder="000000" 
                   maxlength="6" 
                   required 
                   autofocus 
                   autocomplete="off">
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold fs-6 py-2">
            <?= !empty($isSetup) ? 'Ativar e Acessar' : 'Validar e Entrar' ?>
        </button>
    </form>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger border-danger-subtle text-danger-emphasis py-2 px-3 mt-3 text-center small rounded-3" role="alert">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="/logout" class="text-decoration-none text-secondary small">
            <i class="bi bi-arrow-left"></i> Voltar para o Login
        </a>
    </div>

</div>

</body>
</html>