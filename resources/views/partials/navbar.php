<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary sticky-top shadow-sm px-3 py-2 navbar-custom">
    <div class="container-fluid p-0">
        <div class="d-flex align-items-center gap-2">
            <!-- Botão Hambúrguer (visível apenas em telas menores) -->
            <button class="navbar-toggler d-lg-none border-0 p-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- LOGOTIPO -->
            <a class="navbar-brand d-flex align-items-center m-0 p-0" href="/dashboard">
                <div class="logo-navbar-wrapper">
                    <article class="grafico-logotipo" title="Logotipo de Governança">
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
                    </article>
                </div>
            </a>
        </div>

        <!-- ÁREA DIREITA (USUÁRIO E SAIR) -->
        <div class="d-flex align-items-center gap-3 ms-auto">
            <span class="text-light small d-none d-sm-inline">
                <i class="bi bi-person-circle me-1"></i> 
                <?= htmlspecialchars($_SESSION['user_name'] ?? 'Operador') ?>
            </span>
            <a href="/logout" class="btn btn-danger btn-sm px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>
    </div>
</nav>

<!-- Offcanvas Sidebar (menu lateral retrátil em telas menores) -->
<div class="offcanvas offcanvas-start bg-white border-end" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h5 id="sidebarMenuLabel">Módulos do Sistema</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body p-0">
        <nav>
            <small class="text-uppercase fw-bold text-muted fs-7 tracking-wider d-block mb-2 ps-2">Módulos do Sistema</small>
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/dashboard' || $_SERVER['REQUEST_URI'] === '/' ? 'active' : 'sidebar-link' ?> d-flex align-items-center gap-2">
                        <i class="bi bi-house-door fs-5"></i>
                        <span>Início</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-link d-flex align-items-center gap-2" data-bs-toggle="collapse" href="#submenuAltoNivelMobile" role="button" aria-expanded="false">
                        <i class="bi bi-layers fs-5"></i>
                        <span>Alto Nível</span>
                        <i class="bi bi-caret-down-fill ms-auto"></i>
                    </a>
                    <div class="collapse ps-3 <?= (strpos($_SERVER['REQUEST_URI'], '/alto-nivel') === 0) ? 'show' : '' ?>" id="submenuAltoNivelMobile">
                        <ul class="nav flex-column gap-1 small">
                            <li><a href="/alto-nivel/ordens" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/alto-nivel/ordens' ? 'active' : 'sidebar-link' ?>">Ordens do CM</a></li>
                            <li><a href="/alto-nivel/deliberacoes" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/alto-nivel/deliberacoes' ? 'active' : 'sidebar-link' ?>">Deliberações do Almirantado</a></li>
                            <li><a href="/alto-nivel/agenda" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/alto-nivel/agenda' ? 'active' : 'sidebar-link' ?>">Agenda Administrativa</a></li>
                            <li><a href="/alto-nivel/reunioes" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/alto-nivel/reunioes' ? 'active' : 'sidebar-link' ?>">Reunião do Almirantado</a></li>
                            <li><a href="/alto-nivel/sugestoes" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/alto-nivel/sugestoes' ? 'active' : 'sidebar-link' ?>">Sugestão de Temas</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-secondary d-flex align-items-center gap-2 sidebar-link">
                        <i class="bi bi-bar-chart-line fs-5"></i>
                        <span>Medição Estratégica</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-secondary d-flex align-items-center gap-2 sidebar-link">
                        <i class="bi bi-check2-square fs-5"></i>
                        <span>Controle Interno</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-secondary d-flex align-items-center gap-2 sidebar-link">
                        <i class="bi bi-shield-check fs-5"></i>
                        <span>Integridade</span>
                    </a>
                </li>
            </ul>
            <small class="text-uppercase fw-bold text-muted fs-7 tracking-wider d-block mt-4 mb-2 ps-2">Administração</small>
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item">
                    <a href="#" class="nav-link text-secondary d-flex align-items-center gap-2 sidebar-link">
                        <i class="bi bi-people fs-5"></i>
                        <span>Manutenção de Usuários</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>