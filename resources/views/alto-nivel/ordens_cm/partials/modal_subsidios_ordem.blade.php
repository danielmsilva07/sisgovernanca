<div class="modal fade" id="modalSubsidiosOrdem" tabindex="-1" aria-labelledby="modalSubsidiosOrdemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white rounded-top-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-chat-left-quote text-info fs-4"></i>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="modalSubsidiosOrdemLabel">
                            Histórico de Subsídios — Ordem <span class="badge bg-primary fs-6 ms-1" id="sub_nr_ordem"></span>
                        </h5>
                        <small class="text-white-50">Medidas adotadas e andamento do cumprimento da ordem institucional</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body p-4 bg-light">
                {{-- Linha da Determinação da Ordem --}}
                <div class="card mb-3 border-0 shadow-sm rounded-3">
                    <div class="card-body p-3">
                        <small class="text-muted fw-bold d-block text-uppercase" style="font-size: 0.7rem;">Determinação:</small>
                        <p class="mb-0 fw-semibold text-dark small" id="sub_determinacao_ordem">-</p>
                    </div>
                </div>

                {{-- FORMULÁRIO DE REGISTRO DE NOVO SUBSÍDIO --}}
                <div class="card mb-4 border-0 shadow-sm rounded-3 bg-white">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-primary mb-2 d-flex align-items-center gap-2">
                            <i class="bi bi-plus-circle-fill"></i> Registrar Novo Subsídio / Medida Adotada
                        </h6>
                        <form id="formNovoSubsidio" method="POST" action="">
                            @csrf
                            <input type="hidden" name="id_ordens_cm" id="sub_id_ordem">
                            <div class="mb-2">
                                <textarea class="form-control form-control-sm" 
                                          id="sub_medida_adotada" 
                                          name="medida_adotada" 
                                          rows="3" 
                                          required 
                                          placeholder="Descreva a medida adotada ou andamento realizado para cumprimento desta ordem..."></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-sm px-3 rounded-pill fw-semibold shadow-sm" id="btnSalvarSubsidio">
                                    <i class="bi bi-send-check me-1"></i> Adicionar Subsídio
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- LISTAGEM DE SUBSÍDIOS JÁ REGISTRADOS --}}
                <h6 class="fw-bold text-secondary mb-3 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-journal-text me-1"></i> Subsídios Registrados</span>
                    <span class="badge bg-secondary-subtle text-secondary border" id="sub_contador">0 registros</span>
                </h6>

                <div id="subsidios_loading" class="text-center py-4">
                    <div class="spinner-border text-info" role="status">
                        <span class="visually-hidden">Carregando subsídios...</span>
                    </div>
                    <div class="small text-muted mt-2">Carregando histórico de medidas...</div>
                </div>

                <div id="subsidios_vazio" class="alert alert-secondary text-center small d-none">
                    Nenhum subsídio registrado para esta ordem até o momento. Utilize o formulário acima para cadastrar a primeira medida.
                </div>

                <div id="subsidios_conteudo" class="d-none">
                    <div class="d-flex flex-column gap-2" id="subsidios_lista">
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
