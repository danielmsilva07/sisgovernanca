<!-- Sidebar fixo em telas grandes -->
<aside class="sidebar-governanca py-3 px-3 bg-white border-end h-100 d-none d-lg-block" style="min-width: 250px;">
    <nav>
        <small class="text-uppercase fw-bold text-muted fs-7 tracking-wider d-block mb-2 ps-2">Módulos do Sistema</small>
        <ul class="nav nav-pills flex-column gap-1">
            <!-- Painel Principal -->
            <li class="nav-item">
                <a href="/dashboard" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/dashboard' || $_SERVER['REQUEST_URI'] === '/' ? 'active' : 'sidebar-link' ?> d-flex align-items-center gap-2">
                    <i class="bi bi-house-door fs-5"></i>
                    <span>Início</span>
                </a>
            </li>
            <!-- Assuntos de Alto Nível -->
            <li class="nav-item">
                <a class="nav-link sidebar-link d-flex align-items-center gap-2" 
                        data-bs-toggle="collapse" href="#submenuAltoNivel" role="button" aria-expanded="false">
                    <i class="bi bi-layers fs-5"></i>
                    <span>Alto Nível</span>
                    <i class="bi bi-caret-down-fill ms-auto"></i>
                </a>
                <div class="collapse ps-3 <?= (strpos($_SERVER['REQUEST_URI'], '/alto-nivel') === 0) ? 'show' : '' ?>" id="submenuAltoNivel">
                    <ul class="nav flex-column gap-1 small">
                        <li><a href="/alto-nivel/ordens-cm" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/alto-nivel/ordens-cm') === 0 ? 'active' : 'sidebar-link' ?>">Ordens do CM</a></li>
                        <li><a href="/alto-nivel/deliberacoes" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/alto-nivel/deliberacoes' ? 'active' : 'sidebar-link' ?>">Deliberações do Almirantado</a></li>
                        <li><a href="/alto-nivel/agenda" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/alto-nivel/agenda' ? 'active' : 'sidebar-link' ?>">Agenda Administrativa</a></li>
                        <li><a href="/alto-nivel/reunioes" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/alto-nivel/reunioes' ? 'active' : 'sidebar-link' ?>">Reunião do Almirantado</a></li>
                        <li><a href="/alto-nivel/sugestoes" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/alto-nivel/sugestoes' ? 'active' : 'sidebar-link' ?>">Sugestão de Temas</a></li>
                    </ul>
                </div>
            </li>
            <!-- Medição Estratégica -->
            <li class="nav-item">
                <a href="#" class="nav-link text-secondary d-flex align-items-center gap-2 sidebar-link">
                    <i class="bi bi-bar-chart-line fs-5"></i>
                    <span>Medição Estratégica</span>
                </a>
            </li>
            <!-- Controle Interno -->
            <li class="nav-item">
                <a href="#" class="nav-link text-secondary d-flex align-items-center gap-2 sidebar-link">
                    <i class="bi bi-check2-square fs-5"></i>
                    <span>Controle Interno</span>
                </a>
            </li>
            <!-- Integridade -->
            <li class="nav-item">
                <a href="#" class="nav-link text-secondary d-flex align-items-center gap-2 sidebar-link">
                    <i class="bi bi-shield-check fs-5"></i>
                    <span>Integridade</span>
                </a>
            </li>
        </ul>
        <small class="text-uppercase fw-bold text-muted fs-7 tracking-wider d-block mt-4 mb-2 ps-2">Administração</small>
        <ul class="nav nav-pills flex-column gap-1">
            <!-- Manutenção de Usuários -->
            <li class="nav-item">
                <a href="#" class="nav-link text-secondary d-flex align-items-center gap-2 sidebar-link">
                    <i class="bi bi-people fs-5"></i>
                    <span>Manutenção de Usuários</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>