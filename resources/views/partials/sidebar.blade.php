<!-- SIDE BAR -->
<aside class="sidebar-wrapper bg-dark h-100 d-flex flex-column">
    <div class="offcanvas-md offcanvas-start bg-dark text-white flex-grow-1 d-flex flex-column h-100" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu Principal</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 d-flex flex-column flex-grow-1">
            <ul class="nav nav-pills flex-column mb-auto px-3 pt-2 pb-3 gap-2">
                {{-- 1. Início --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') || request()->is('/') ? 'active' : '' }}" aria-current="{{ request()->routeIs('dashboard') || request()->is('/') ? 'page' : 'false' }}">
                        <i class="bi bi-house-door me-2 fs-5"></i>
                        <span>Início</span>
                    </a>
                </li>

                {{-- 2. Alto Nível (com submenu desdobrável) --}}
                @php
                    $isAltoNivelActive = request()->is('alto-nivel*') || request()->is('assuntos-alto-nivel*');
                @endphp
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center justify-content-between {{ $isAltoNivelActive ? 'text-white' : '' }}" 
                       data-bs-toggle="collapse" 
                       href="#menuAltoNivel" 
                       role="button" 
                       aria-expanded="{{ $isAltoNivelActive ? 'true' : 'false' }}" 
                       aria-controls="menuAltoNivel">
                        <span class="d-flex align-items-center">
                            <i class="bi bi-diagram-3 me-2 fs-5"></i>
                            <span>Alto Nível</span>
                        </span>
                        <i class="bi bi-chevron-down small transition-icon"></i>
                    </a>
                    <div class="collapse {{ $isAltoNivelActive ? 'show' : '' }}" id="menuAltoNivel">
                        <ul class="nav flex-column ms-3 ps-2 border-start border-secondary mt-1 gap-1 sidebar-submenu">
                            <li class="nav-item">
                                <a href="{{ url('alto-nivel/ordens-cm') }}" class="nav-link {{ request()->is('alto-nivel/ordens-cm*') ? 'active' : '' }}">
                                    <i class="bi bi-file-earmark-check me-2"></i>
                                    <span>Ordens do CM</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('alto-nivel/deliberacoes') }}" class="nav-link {{ request()->is('alto-nivel/deliberacoes*') || request()->is('alto-nivel/agenda*') ? 'active' : '' }}">
                                    <i class="bi bi-journal-text me-2"></i>
                                    <span>Deliberações do Almirantado</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- 3. Controle Interno --}}
                <li class="nav-item">
                    <a href="{{ url('controle-interno') }}" class="nav-link {{ request()->is('controle-interno*') ? 'active' : '' }}">
                        <i class="bi bi-check2-square me-2 fs-5"></i>
                        <span>Controle Interno</span>
                    </a>
                </li>

                {{-- 4. Integridade --}}
                <li class="nav-item">
                    <a href="{{ url('integridade') }}" class="nav-link {{ request()->is('integridade*') ? 'active' : '' }}">
                        <i class="bi bi-shield-check me-2 fs-5"></i>
                        <span>Integridade</span>
                    </a>
                </li>

                {{-- 5. Portfólio Estratégico --}}
                <li class="nav-item">
                    <a href="{{ url('portfolio-estrategico') }}" class="nav-link {{ request()->is('portfolio-estrategico*') ? 'active' : '' }}">
                        <i class="bi bi-folder-check me-2 fs-5"></i>
                        <span>Portfólio Estratégico</span>
                    </a>
                </li>

                {{-- 6. Manutenção de Usuários --}}
                <li class="nav-item">
                    <a href="{{ url('usuarios') }}" class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2 fs-5"></i>
                        <span>Manutenção de Usuários</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>