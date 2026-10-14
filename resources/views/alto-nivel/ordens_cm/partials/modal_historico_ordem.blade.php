<div class="modal fade" id="modalHistoricoOrdem" tabindex="-1" aria-labelledby="modalHistoricoOrdemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white rounded-top-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-secondary fs-4"></i>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="modalHistoricoOrdemLabel">
                            Histórico de Alterações — Ordem <span class="badge bg-primary fs-6 ms-1" id="hist_nr_ordem"></span>
                        </h5>
                        <small class="text-white-50">Auditoria completa de modificações e ações registradas para esta ordem</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                {{-- Linha da Determinação da Ordem --}}
                <div class="card mb-3 border-0 shadow-sm rounded-3">
                    <div class="card-body p-3">
                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.7rem;">Determinação da Ordem:</small>
                        <p class="mb-0 fw-semibold text-dark small" id="hist_determinacao_ordem">-</p>
                    </div>
                </div>

                {{-- Container para a Linha do Tempo / Lista de Auditoria --}}
                <div id="historico_loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Carregando histórico...</span>
                    </div>
                    <div class="small text-muted mt-2">Carregando registros de auditoria...</div>
                </div>

                <div id="historico_vazio" class="alert alert-secondary text-center small d-none">
                    Nenhum histórico registrado para esta ordem.
                </div>

                <div id="historico_conteudo" class="d-none">
                    <div class="timeline" id="historico_lista">
                        {{-- Injetado dinamicamente via JavaScript --}}
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-white rounded-bottom-4 py-2">
                <button type="button" class="btn btn-secondary rounded-3 px-3 btn-sm" data-bs-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>
