<!-- NAV BAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top border-bottom border-secondary shadow-sm navbar-custom px-2">
    <div class="container-fluid px-3">
        <button class="btn btn-outline-light d-md-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
            <i class="bi bi-list"></i>
        </button>

        <a class="navbar-brand d-flex align-items-center me-auto me-lg-4 py-0" href="{{ route('dashboard') }}" title="SisGovernança - Início">
            <div class="logo-navbar-wrapper">
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
        </a>

        @php
            $loggedUser = auth()->user();
            if (!$loggedUser && session()->has('user_id')) {
                $loggedUser = \App\Models\User::find(session('user_id'));
            }
            if (!$loggedUser && session()->has('pending_user_id')) {
                $loggedUser = \App\Models\User::find(session('pending_user_id'));
            }
            $userName = $loggedUser ? ($loggedUser->name ?: $loggedUser->username) : (\App\Models\User::first()?->name ?? 'Administrador');
            $userInitial = strtoupper(mb_substr($userName, 0, 1));
        @endphp

        <div class="d-flex align-items-center gap-3 ms-auto">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar-circle bg-primary text-white fw-bold me-2">
                        {{ $userInitial }}
                    </div>
                    <span class="d-none d-md-inline small fw-semibold">{{ $userName }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 text-small" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Configurações</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Sair
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>