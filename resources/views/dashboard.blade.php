<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Governança da Marinha do Brasil</title>
    
    <!-- Bootstrap CSS e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="d-flex flex-column min-vh-100 bg-body-tertiary">

    {{-- Partial da Navbar --}}
    @include('partials.navbar')

    {{-- Conteúdo Central (Sidebar + Área Principal) --}}
    <div class="container-fluid flex-grow-1 p-0 d-flex flex-column">
        <div class="row g-0 flex-grow-1">
            
            {{-- Partial da Sidebar --}}
            <div class="col-md-3 col-lg-2 bg-dark border-end border-secondary d-flex flex-column">
                @include('partials.sidebar')
            </div>

            {{-- Área principal do Dashboard --}}
            <div class="col-md-9 col-lg-10 d-flex flex-column bg-body-tertiary">
                <main class="flex-grow-1 p-4">
                    
                    <!-- Banner Hero -->
                    <section class="hero-banner bg-dark text-white p-4 p-md-5 rounded-4 shadow-sm mb-4">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <span class="badge bg-info text-dark fw-bold mb-2 px-3 py-2 rounded-pill">Plataforma Institucional da MB</span>
                                <h1 class="h3 fw-bold mb-2 text-white">Sistema de Governança da Marinha do Brasil</h1>
                                <p class="text-white text-opacity-75 mb-0 leading-relaxed">
                                    Solução estratégica para consolidação de dados setoriais, monitoramento contínuo e automação de relatórios gerenciais voltados ao assessoramento da <strong class="text-white">Alta Administração Naval</strong>.
                                </p>
                            </div>
                            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                                <a href="{{ route('relatorios.gestao') }}" class="btn btn-outline-light rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-file-earmark-text fs-6"></i>
                                    Relatório de Gestão
                                </a>
                            </div>
                        </div>
                    </section>

                    <!-- Cards de Métricas KPIs -->
                    <section class="row g-3 mb-4">
                        <div class="col-md-6 col-xl-3">
                            <div class="card card-kpi border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <small class="text-muted fw-bold d-block text-uppercase fs-7 mb-1">Projetos Monitorados</small>
                                        <span class="h3 fw-bold text-dark mb-0">{{ $projetosMonitorados ?? 21 }}</span>
                                    </div>
                                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-3">
                                        <i class="bi bi-folder-check fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card card-kpi border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <small class="text-muted fw-bold d-block text-uppercase fs-7 mb-1">Controle Interno</small>
                                        <span class="h3 fw-bold text-success mb-0">{{ isset($controleInterno) ? number_format($controleInterno, 1, ',', '.') . '%' : '94,8%' }}</span>
                                    </div>
                                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-3">
                                        <i class="bi bi-check2-square fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card card-kpi border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <small class="text-muted fw-bold d-block text-uppercase fs-7 mb-1">Índice de Integridade</small>
                                        <span class="h3 fw-bold text-warning mb-0">{{ isset($indiceIntegridade) ? number_format($indiceIntegridade, 2, ',', '.') . '%' : '35,64%' }}</span>
                                    </div>
                                    <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-3">
                                        <i class="bi bi-shield-check fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card card-kpi border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <small class="text-muted fw-bold d-block text-uppercase fs-7 mb-1">Capacitação Setorial</small>
                                        <span class="h3 fw-bold text-info mb-0">{{ isset($horasCapacitacao) ? number_format($horasCapacitacao, 0, ',', '.') . ' hrs' : '35.314 hrs' }}</span>
                                    </div>
                                    <div class="icon-box bg-info bg-opacity-10 text-info rounded-3">
                                        <i class="bi bi-mortarboard fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </main>
            </div>

        </div>
    </div>

    {{-- Partial do Footer (largura total 100%) --}}
    @include('partials.footer')

    <!-- Scripts do JS/Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>