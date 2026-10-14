<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th scope="col" class="text-center" style="width: 110px;">Nº Ordem</th>
                <th scope="col" style="width: 140px;">OM Resp.</th>
                <th scope="col">Determinação</th>
                <th scope="col" style="width: 150px;">Subchefia Líder</th>
                <th scope="col" style="width: 140px;">Status</th>
                <th scope="col" class="text-end" style="width: 160px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ordens as $ordem)
                @php
                    $statusNome = $ordem->statusOrdem->nome_status_ordem ?? 'Pendente';
                    $badgeClass = match (mb_strtolower($statusNome)) {
                        'cumprida'      => 'bg-success bg-opacity-10 text-success border border-success border-opacity-25',
                        'em andamento'  => 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25',
                        'pendente'      => 'bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25',
                        'cancelada'     => 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25',
                        default         => 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25'
                    };
                @endphp
                <tr>
                    {{-- 1. nr_ordem --}}
                    <td class="text-center fw-bold text-primary">
                        <span class="badge bg-light text-primary border fs-7 px-2 py-1">
                            #{{ $ordem->nr_ordem_cm }}
                        </span>
                    </td>

                    {{-- 2. sigla_om_resp --}}
                    <td>
                        <span class="badge bg-dark bg-opacity-75 text-white">
                            {{ $ordem->omResponsavel->sigla_om_resp ?? 'Não informada' }}
                        </span>
                    </td>

                    {{-- 3. determinação --}}
                    <td>
                        <div class="fw-semibold text-dark text-truncate" style="max-width: 380px;" title="{{ $ordem->determinacao }}">
                            {{ $ordem->determinacao ?: 'Sem determinação descrita.' }}
                        </div>
                        @if ($ordem->tema_pauta)
                            <small class="text-muted text-truncate d-block" style="max-width: 380px;">
                                <strong>Tema:</strong> {{ $ordem->tema_pauta }}
                            </small>
                        @endif
                    </td>

                    {{-- 4. sigla_sub_lider --}}
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $ordem->subchefiaLider->sigla_sub_lider ?? '-' }}
                        </span>
                        @if ($ordem->subchefias_apoio_siglas !== '-')
                            <small class="d-block text-muted" style="font-size: 0.72rem;">
                                Apoio: {{ $ordem->subchefias_apoio_siglas }}
                            </small>
                        @endif
                    </td>

                    {{-- 5. status_ordem --}}
                    <td>
                        <span class="badge {{ $badgeClass }} rounded-pill px-3 py-1 fw-semibold" style="font-size: 0.78rem;">
                            {{ $statusNome }}
                        </span>
                    </td>

                    {{-- 6. Ações (Edição, Histórico de Alterações, Histórico de Subsídios) --}}
                    <td class="text-end">
                        <div class="btn-group btn-group-sm" role="group">
                            {{-- Botão de Edição --}}
                            <button type="button" 
                                    class="btn btn-outline-primary btn-edit-ordem" 
                                    title="Editar Ordem" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditarOrdem"
                                    data-ordem="{{ json_encode([
                                        'id_ordens_cm'    => $ordem->id_ordens_cm,
                                        'nr_ordem_cm'     => $ordem->nr_ordem_cm,
                                        'docum_origem'    => $ordem->docum_origem,
                                        'data_docum'      => $ordem->data_docum ? $ordem->data_docum->format('Y-m-d') : '',
                                        'id_om_origem'    => $ordem->id_om_origem,
                                        'id_om_resp'      => $ordem->id_om_resp,
                                        'id_sub_lider'    => $ordem->id_sub_lider,
                                        'id_sub_apoio'    => $ordem->id_sub_apoio ?? [],
                                        'id_status_ordem' => $ordem->id_status_ordem,
                                        'prazo'           => $ordem->prazo ? $ordem->prazo->format('Y-m-d') : '',
                                        'data_cumpr'      => $ordem->data_cumpr ? $ordem->data_cumpr->format('Y-m-d') : '',
                                        'tema_pauta'      => $ordem->tema_pauta,
                                        'determinacao'    => $ordem->determinacao,
                                        'evento'          => $ordem->evento,
                                        'observacao'      => $ordem->observacao,
                                    ]) }}">
                                <i class="bi bi-pencil"></i>
                            </button>

                            {{-- Botão de Histórico de Alterações --}}
                            <button type="button" 
                                    class="btn btn-outline-secondary btn-historico-ordem" 
                                    title="Histórico de Alterações" 
                                    data-id="{{ $ordem->id_ordens_cm }}"
                                    data-nr="{{ $ordem->nr_ordem_cm }}">
                                <i class="bi bi-clock-history"></i>
                            </button>

                            {{-- Botão de Histórico de Subsídios --}}
                            <button type="button" 
                                    class="btn btn-outline-info btn-subsidios-ordem" 
                                    title="Histórico de Subsídios" 
                                    data-id="{{ $ordem->id_ordens_cm }}"
                                    data-nr="{{ $ordem->nr_ordem_cm }}">
                                <i class="bi bi-chat-left-text"></i>
                                @if ($ordem->subsidios->count() > 0)
                                    <span class="badge bg-info text-white ms-1 rounded-pill" style="font-size: 0.65rem;">
                                        {{ $ordem->subsidios->count() }}
                                    </span>
                                @endif
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                        Nenhuma Ordem do CM cadastrada até o momento.
                        <div class="mt-2">
                            <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalNovaOrdem">
                                <i class="bi bi-plus-lg me-1"></i> Cadastrar Primeira Ordem
                            </button>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
