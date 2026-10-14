<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ordens do CM — SisGovernança' }}</title>
    
    <!-- Bootstrap CSS e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

            {{-- Área principal de Ordens do CM --}}
            <div class="col-md-9 col-lg-10 d-flex flex-column bg-body-tertiary">
                <main class="flex-grow-1 p-4">
                    
                    {{-- CABEÇALHO DO MÓDULO --}}
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 fs-7 fw-semibold">
                                    MÓDULO: ALTO NÍVEL
                                </span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 fs-7">
                                    Última Ordem Registrada: <strong>#{{ $ultimoNumeroOrdem }}</strong>
                                </span>
                            </div>
                            <h1 class="h3 fw-bold text-dark mb-0">Ordens do Comandante da Marinha</h1>
                            <p class="text-muted small mb-0">Controle, acompanhamento e registro de determinações e subsídios do CM</p>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-primary rounded-3 px-3 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNovaOrdem">
                                <i class="bi bi-plus-lg fs-6"></i>
                                Nova Ordem do CM
                            </button>
                        </div>
                    </div>

                    {{-- ALERTA DE SUCESSO OU ERRO --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 py-2 px-3 small d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            <div class="flex-grow-1">{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 py-2 px-3 small d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                            <div class="flex-grow-1">{{ session('error') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 py-2 px-3 small mb-4" role="alert">
                            <div class="fw-bold mb-1"><i class="bi bi-exclamation-octagon-fill me-1"></i> Por favor, corrija os seguintes erros:</div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $erro)
                                    <li>{{ $erro }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- CARD PRINCIPAL COM A TABELA DE ORDENS --}}
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
                        <div class="card-header bg-white border-bottom border-light py-3 px-4 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                                <i class="bi bi-card-checklist text-primary"></i>
                                Ordens Cadastradas
                            </h6>
                            <span class="badge bg-light text-muted border">
                                Total: {{ $ordens->count() }}
                            </span>
                        </div>
                        <div class="card-body p-0">
                            @include('alto-nivel.ordens_cm.partials.ordens_table')
                        </div>
                    </div>

                </main>
            </div>

        </div>
    </div>

    {{-- Partial do Footer (largura total 100%) --}}
    @include('partials.footer')

    {{-- MODAIS DO SISTEMA DE ORDENS DO CM --}}
    @include('alto-nivel.ordens_cm.partials.modal_nova_ordem')
    @include('alto-nivel.ordens_cm.partials.modal_editar_ordem')
    @include('alto-nivel.ordens_cm.partials.modal_historico_ordem')
    @include('alto-nivel.ordens_cm.partials.modal_subsidios_ordem')

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script de Gestão das Ordens do CM -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // 1. ABRIR MODAL DE EDIÇÃO E PREENCHER CAMPOS
            document.querySelectorAll('.btn-edit-ordem').forEach(button => {
                button.addEventListener('click', function () {
                    const rawData = this.getAttribute('data-ordem');
                    if (!rawData) return;

                    const ordem = JSON.parse(rawData);
                    const form = document.getElementById('formEditarOrdem');
                    form.action = `/alto-nivel/ordens-cm/atualizar/${ordem.id_ordens_cm}`;

                    document.getElementById('edit_badge_nr').textContent = `#${ordem.nr_ordem_cm}`;
                    document.getElementById('edit_nr_ordem_cm').value = ordem.nr_ordem_cm || '';
                    document.getElementById('edit_docum_origem').value = ordem.docum_origem || '';
                    document.getElementById('edit_data_docum').value = ordem.data_docum || '';
                    document.getElementById('edit_id_om_origem').value = ordem.id_om_origem || '';
                    document.getElementById('edit_id_om_resp').value = ordem.id_om_resp || '';
                    document.getElementById('edit_id_sub_lider').value = ordem.id_sub_lider || '';
                    document.getElementById('edit_id_status_ordem').value = ordem.id_status_ordem || '';
                    document.getElementById('edit_prazo').value = ordem.prazo || '';
                    document.getElementById('edit_data_cumpr').value = ordem.data_cumpr || '';
                    document.getElementById('edit_tema_pauta').value = ordem.tema_pauta || '';
                    document.getElementById('edit_determinacao').value = ordem.determinacao || '';
                    document.getElementById('edit_evento').value = ordem.evento || '';
                    document.getElementById('edit_observacao').value = ordem.observacao || '';

                    // Marca checkboxes de Subchefias de Apoio correspondentes
                    const subApoioIds = Array.isArray(ordem.id_sub_apoio) 
                        ? ordem.id_sub_apoio.map(id => String(id)) 
                        : [];

                    document.querySelectorAll('.check-sub-apoio-edit').forEach(chk => {
                        chk.checked = subApoioIds.includes(String(chk.value));
                    });
                });
            });

            // 2. ABRIR MODAL DE HISTÓRICO DE AUDITORIA
            const modalHistorico = new bootstrap.Modal(document.getElementById('modalHistoricoOrdem'));
            document.querySelectorAll('.btn-historico-ordem').forEach(button => {
                button.addEventListener('click', function () {
                    const idOrdem = this.getAttribute('data-id');
                    const nrOrdem = this.getAttribute('data-nr');

                    document.getElementById('hist_nr_ordem').textContent = `#${nrOrdem}`;
                    document.getElementById('hist_determinacao_ordem').textContent = 'Carregando...';

                    const loading = document.getElementById('historico_loading');
                    const vazio = document.getElementById('historico_vazio');
                    const conteudo = document.getElementById('historico_conteudo');
                    const lista = document.getElementById('historico_lista');

                    loading.classList.remove('d-none');
                    vazio.classList.add('d-none');
                    conteudo.classList.add('d-none');
                    lista.innerHTML = '';

                    modalHistorico.show();

                    fetch(`/alto-nivel/ordens-cm/${idOrdem}/historico`)
                        .then(res => res.json())
                        .then(data => {
                            loading.classList.add('d-none');
                            document.getElementById('hist_determinacao_ordem').textContent = data.ordem.determinacao || 'Sem determinação descrita.';

                            if (!data.historicos || data.historicos.length === 0) {
                                vazio.classList.remove('d-none');
                                return;
                            }

                            conteudo.classList.remove('d-none');
                            let html = '<div class="list-group list-group-flush">';
                            data.historicos.forEach(h => {
                                const badgeCor = h.tipo_acao === 'Criação' ? 'bg-success' : (h.tipo_acao === 'Edição' ? 'bg-warning text-dark' : 'bg-info text-dark');
                                html += `
                                    <div class="list-group-item px-0 py-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div>
                                                <span class="badge ${badgeCor} me-2">${h.tipo_acao}</span>
                                                <strong class="small text-dark">${h.usuario}</strong>
                                            </div>
                                            <small class="text-muted">${h.data}</small>
                                        </div>
                                `;

                                if (h.tipo_acao === 'Atualização de Subsídio' && h.dados_novos) {
                                    html += `<div class="p-2 bg-white border rounded small text-secondary mt-1"><strong>Medida:</strong> ${h.dados_novos.medida_adotada || '-'}</div>`;
                                } else if (h.tipo_acao === 'Edição') {
                                    html += `<div class="p-2 bg-white border rounded small text-muted mt-1"><small>Alterações salvas com auditoria de dados anteriores e novos.</small></div>`;
                                }

                                html += `</div>`;
                            });
                            html += '</div>';
                            lista.innerHTML = html;
                        })
                        .catch(err => {
                            loading.classList.add('d-none');
                            vazio.classList.remove('d-none');
                            vazio.textContent = 'Erro ao carregar histórico: ' + err.message;
                        });
                });
            });

            // 3. ABRIR MODAL DE SUBSÍDIOS (E REGISTRO INTEGRADO)
            const modalSubsidios = new bootstrap.Modal(document.getElementById('modalSubsidiosOrdem'));
            let ordemSubsidioAtivaId = null;

            function carregarSubsidios(idOrdem) {
                const loading = document.getElementById('subsidios_loading');
                const vazio = document.getElementById('subsidios_vazio');
                const conteudo = document.getElementById('subsidios_conteudo');
                const lista = document.getElementById('subsidios_lista');

                loading.classList.remove('d-none');
                vazio.classList.add('d-none');
                conteudo.classList.add('d-none');
                lista.innerHTML = '';

                fetch(`/alto-nivel/ordens-cm/${idOrdem}/subsidios`)
                    .then(res => res.json())
                    .then(data => {
                        loading.classList.add('d-none');
                        document.getElementById('sub_determinacao_ordem').textContent = data.ordem.determinacao || 'Sem determinação descrita.';
                        document.getElementById('sub_contador').textContent = `${data.subsidios.length} registros`;

                        if (!data.subsidios || data.subsidios.length === 0) {
                            vazio.classList.remove('d-none');
                            return;
                        }

                        conteudo.classList.remove('d-none');
                        let html = '';
                        data.subsidios.forEach(s => {
                            html += `
                                <div class="card border border-light-subtle shadow-sm rounded-3 bg-white">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-bold small text-primary"><i class="bi bi-person me-1"></i>${s.usuario}</span>
                                            <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i>${s.data}</small>
                                        </div>
                                        <p class="mb-0 small text-dark" style="white-space: pre-wrap;">${s.medida_adotada}</p>
                                    </div>
                                </div>
                            `;
                        });
                        lista.innerHTML = html;
                    })
                    .catch(err => {
                        loading.classList.add('d-none');
                        vazio.classList.remove('d-none');
                        vazio.textContent = 'Erro ao carregar subsídios: ' + err.message;
                    });
            }

            document.querySelectorAll('.btn-subsidios-ordem').forEach(button => {
                button.addEventListener('click', function () {
                    const idOrdem = this.getAttribute('data-id');
                    const nrOrdem = this.getAttribute('data-nr');

                    ordemSubsidioAtivaId = idOrdem;
                    document.getElementById('sub_nr_ordem').textContent = `#${nrOrdem}`;
                    document.getElementById('sub_id_ordem').value = idOrdem;
                    document.getElementById('sub_medida_adotada').value = '';

                    const formSub = document.getElementById('formNovoSubsidio');
                    formSub.action = `/alto-nivel/ordens-cm/${idOrdem}/subsidios`;

                    carregarSubsidios(idOrdem);
                    modalSubsidios.show();
                });
            });

            // Envio do formulário de novo subsídio via AJAX
            document.getElementById('formNovoSubsidio').addEventListener('submit', function (e) {
                e.preventDefault();
                const medida = document.getElementById('sub_medida_adotada').value.trim();
                if (!medida || !ordemSubsidioAtivaId) return;

                const btnSalvar = document.getElementById('btnSalvarSubsidio');
                btnSalvar.disabled = true;
                btnSalvar.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Salvando...';

                fetch(`/alto-nivel/ordens-cm/${ordemSubsidioAtivaId}/subsidios`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ medida_adotada: medida })
                })
                .then(res => res.json())
                .then(res => {
                    btnSalvar.disabled = false;
                    btnSalvar.innerHTML = '<i class="bi bi-send-check me-1"></i> Adicionar Subsídio';
                    if (res.success) {
                        document.getElementById('sub_medida_adotada').value = '';
                        carregarSubsidios(ordemSubsidioAtivaId);
                    } else {
                        alert(res.message || 'Erro ao registrar subsídio.');
                    }
                })
                .catch(err => {
                    btnSalvar.disabled = false;
                    btnSalvar.innerHTML = '<i class="bi bi-send-check me-1"></i> Adicionar Subsídio';
                    alert('Falha na comunicação: ' + err.message);
                });
            });
        });
    </script>
</body>
</html>
