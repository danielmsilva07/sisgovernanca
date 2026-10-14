<div class="modal fade" id="modalEditarOrdem" tabindex="-1" aria-labelledby="modalEditarOrdemLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-dark text-white rounded-top-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square text-warning fs-4"></i>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="modalEditarOrdemLabel">
                            Editar Ordem do CM <span class="badge bg-primary fs-6 ms-2" id="edit_badge_nr"></span>
                        </h5>
                        <small class="text-white-50">Altere os dados necessários e salve para registrar o histórico de auditoria</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <form action="" method="POST" id="formEditarOrdem">
                @csrf
                <div class="modal-body p-4 bg-light">
                    
                    {{-- SEÇÃO 1: IDENTIFICAÇÃO E ORIGEM --}}
                    <div class="card mb-3 border-0 shadow-sm rounded-3">
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-primary mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-card-heading"></i> Identificação e Origem
                            </h6>
                            <div class="row g-3">
                                {{-- Número da Ordem --}}
                                <div class="col-md-3">
                                    <label for="edit_nr_ordem_cm" class="form-label fw-semibold small mb-1">
                                        Nº da Ordem <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white">#</span>
                                        <input type="number" 
                                               class="form-control" 
                                               id="edit_nr_ordem_cm" 
                                               name="nr_ordem_cm" 
                                               min="1" 
                                               required 
                                               placeholder="Ex: 102">
                                    </div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Valor positivo (> 0)</small>
                                </div>

                                {{-- Documento de Origem --}}
                                <div class="col-md-3">
                                    <label for="edit_docum_origem" class="form-label fw-semibold small mb-1">Documento de Origem</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_docum_origem" name="docum_origem">
                                </div>

                                {{-- Data do Documento --}}
                                <div class="col-md-3">
                                    <label for="edit_data_docum" class="form-label fw-semibold small mb-1">Data do Documento</label>
                                    <input type="date" class="form-control form-control-sm" id="edit_data_docum" name="data_docum">
                                </div>

                                {{-- OM de Origem --}}
                                <div class="col-md-3">
                                    <label for="edit_id_om_origem" class="form-label fw-semibold small mb-1">OM de Origem</label>
                                    <select class="form-select form-select-sm" id="edit_id_om_origem" name="id_om_origem">
                                        <option value="">Selecione...</option>
                                        @foreach ($omsOrigem as $om)
                                            <option value="{{ $om->id_om_origem }}">
                                                {{ $om->sigla_om_origem }} - {{ $om->nome_om_origem }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEÇÃO 2: RESPONSABILIDADES E SUBCHEFIAS --}}
                    <div class="card mb-3 border-0 shadow-sm rounded-3">
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-primary mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-people"></i> Responsabilidades
                            </h6>
                            <div class="row g-3">
                                {{-- OM Responsável --}}
                                <div class="col-md-4">
                                    <label for="edit_id_om_resp" class="form-label fw-semibold small mb-1">OM Responsável</label>
                                    <select class="form-select form-select-sm" id="edit_id_om_resp" name="id_om_resp">
                                        <option value="">Selecione...</option>
                                        @foreach ($omsResp as $omResp)
                                            <option value="{{ $omResp->id_om_resp }}">
                                                {{ $omResp->sigla_om_resp }} - {{ $omResp->nome_om_resp }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Subchefia Líder --}}
                                <div class="col-md-4">
                                    <label for="edit_id_sub_lider" class="form-label fw-semibold small mb-1">Subchefia Líder</label>
                                    <select class="form-select form-select-sm" id="edit_id_sub_lider" name="id_sub_lider">
                                        <option value="">Selecione...</option>
                                        @foreach ($subchefiasLider as $subLider)
                                            <option value="{{ $subLider->id_sub_lider }}">
                                                {{ $subLider->sigla_sub_lider }} - {{ $subLider->nome_sub_lider }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Status da Ordem --}}
                                <div class="col-md-4">
                                    <label for="edit_id_status_ordem" class="form-label fw-semibold small mb-1">Status da Ordem</label>
                                    <select class="form-select form-select-sm" id="edit_id_status_ordem" name="id_status_ordem">
                                        <option value="">Selecione...</option>
                                        @foreach ($statusOrdem as $st)
                                            <option value="{{ $st->id_status_ordem }}">
                                                {{ $st->nome_status_ordem }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Subchefia(s) de Apoio - CHECKBOXES (Múltipla Seleção) --}}
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-semibold small d-flex align-items-center justify-content-between mb-2">
                                        <span>
                                            <i class="bi bi-check2-square text-primary me-1"></i>
                                            Subchefia(s) de Apoio
                                            <span class="badge bg-secondary-subtle text-secondary border ms-1">Múltipla Seleção</span>
                                        </span>
                                        <small class="text-muted fw-normal">Selecione uma ou mais opções</small>
                                    </label>
                                    <div class="p-3 border rounded-3 bg-white">
                                        <div class="row g-2">
                                            @foreach ($subchefiasApoio as $subApoio)
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input check-sub-apoio-edit" 
                                                               type="checkbox" 
                                                               name="id_sub_apoio[]" 
                                                               value="{{ $subApoio->id_sub_apoio }}" 
                                                               id="edit_sub_apoio_{{ $subApoio->id_sub_apoio }}">
                                                        <label class="form-check-label small" for="edit_sub_apoio_{{ $subApoio->id_sub_apoio }}">
                                                            <strong>{{ $subApoio->sigla_sub_apoio }}</strong> 
                                                            <span class="text-muted">- {{ $subApoio->nome_sub_apoio }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEÇÃO 3: PRAZOS E DETALHAMENTO DA ORDEM --}}
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-primary mb-3 border-bottom pb-2 d-flex align-items-center gap-2">
                                <i class="bi bi-calendar-event"></i> Prazos e Conteúdo
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="edit_prazo" class="form-label fw-semibold small mb-1">Prazo Limite</label>
                                    <input type="date" class="form-control form-control-sm" id="edit_prazo" name="prazo">
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_data_cumpr" class="form-label fw-semibold small mb-1">Data de Cumprimento</label>
                                    <input type="date" class="form-control form-control-sm" id="edit_data_cumpr" name="data_cumpr">
                                </div>

                                <div class="col-12">
                                    <label for="edit_tema_pauta" class="form-label fw-semibold small mb-1">Tema / Pauta</label>
                                    <input type="text" class="form-control form-control-sm" id="edit_tema_pauta" name="tema_pauta" maxlength="500">
                                </div>

                                <div class="col-md-6">
                                    <label for="edit_determinacao" class="form-label fw-semibold small mb-1">Determinação</label>
                                    <textarea class="form-control form-control-sm" id="edit_determinacao" name="determinacao" rows="3"></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="edit_evento" class="form-label fw-semibold small mb-1">Evento</label>
                                    <textarea class="form-control form-control-sm" id="edit_evento" name="evento" rows="3"></textarea>
                                </div>

                                <div class="col-12">
                                    <label for="edit_observacao" class="form-label fw-semibold small mb-1">Observações</label>
                                    <textarea class="form-control form-control-sm" id="edit_observacao" name="observacao" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-white rounded-bottom-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-3" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning rounded-3 px-4 fw-semibold text-dark shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
