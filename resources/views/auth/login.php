<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisGovernança - Acesso ao Sistema</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS Exclusivo para o Logotipo e Ajustes de Erro -->
    <link rel="stylesheet" href="/css/login.css">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center m-0">

<div class="card border-0 shadow-sm rounded-4 p-4 p-sm-5" style="width: 100%; max-width: 420px;">
    
    <!-- LOGOTIPO -->
    <div class="d-flex justify-content-center mb-3">
        <article class="grafico-logotipo" title="Logotipo de Governança">
            <section class="circulo-interno">
                <section class="barras">
                    <section class="barra-01" aria-hidden="true"></section>
                    <section class="barra-02" aria-hidden="true"></section>
                    <section class="barra-03" aria-hidden="true"></section>
                    <section class="barra-04" aria-hidden="true"></section>
                </section>
                <section class="linha1"><span class="span1"></span></section>
                <section class="nome-sistema">SISGOVERNANÇA</section>
                <section class="linha2"><span class="span2"></span></section>
                <section class="logotipo">
                    <section class="nome-logotipo">Sistema de Governança<sup>&#174;</sup></section>
                </section>
            </section>
        </article>
    </div>

    <!-- SUBTÍTULO -->
    <p class="text-center text-body-secondary fw-medium mb-4">Acesso restrito ao sistema</p>

    <form action="/login" method="POST">
        
        <!-- CAMPO E-MAIL / USUÁRIO COM BONECO -->
        <div class="mb-3">
            <label for="username" class="form-label text-dark fw-semibold small mb-1">E-mail</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border-secondary-subtle rounded-start-3 text-secondary ps-3">
                    <i class="bi bi-person"></i>
                </span>
                <input type="email" class="form-control form-control-lg rounded-end-3 fs-6 border-start-0 border-secondary-subtle ps-2" id="username" name="username" placeholder="Usuário" required title="Usuário">
            </div>
        </div>

        <!-- CAMPO SENHA COM CADEADO -->
        <div class="mb-3">
            <label for="password" class="form-label text-dark fw-semibold small mb-1">Senha</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border-secondary-subtle rounded-start-3 text-secondary ps-3">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" class="form-control form-control-lg rounded-end-3 fs-6 border-start-0 border-secondary-subtle ps-2" id="password" name="password" placeholder="••••••••" required title="Senha">
            </div>
        </div>

        <!-- CHECKBOX MANTER CONECTADO -->
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label text-secondary small" for="remember">
                Manter conectado
            </label>
        </div>

        <!-- BOTÃO ENTRAR -->
        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold fs-6 py-2" style="background-color: #0d6efd;">
            Acessar Sistema
        </button>
    </form>

    <!-- ÁREA FIXA RESERVADA PARA MENSAGEM DE ERRO -->
    <div class="error-container">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger border-danger-subtle text-danger-emphasis py-2 px-3 m-0 text-center small rounded-3" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- RODAPÉ MARINHA DO BRASIL -->
    <div class="text-center text-body-tertiary small mt-2">
        © 2026 Marinha do Brasil.
    </div>

</div>

</body>
</html>