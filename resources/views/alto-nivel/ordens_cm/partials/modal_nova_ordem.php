<div class="modal fade" id="modalNovaOrdem" tabindex="-1" aria-labelledby="modalNovaOrdemLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-primary" id="modalNovaOrdemLabel">
                    <i class="bi bi-file-earmark-plus me-2"></i>Cadastrar Nova Ordem do CM
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <form action="/alto-nivel/ordens-cm/salvar" method="POST" id="formNovaOrdem">
                <div class="modal-body py-3">
                    
                    <!-- SEÇÃO 1: IDENTIFICAÇÃO E ORIGEM -->
                    <div class="card mb-3 border-light bg-light">
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                                <i class="bi bi-info-circle me-1"></i> Identificação e Origem
                            </h6>
                            <div class="row g-3">
                                <!-- Número da Ordem -->
                                <div class="col-md-3">
                                    <label for="nr_ordem" class="form-label fw-semibold small mb-1">Nº da Ordem <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm" id="nr_ordem" name="nr_ordem" required placeholder="Ex: 102">
                                </div>

                                <!-- Documento de Origem -->
                                <div class="col-md-3">
                                    <label for="docum_origem" class="form-label fw-semibold small mb-1">Doc. de Origem</label>
                                    <input type="text" class="form-control form-control-sm" id="docum_origem" name="docum_origem" placeholder="Ex: Off. nº 45/2026">
                                </div>

                                <!-- Data do Documento -->
                                <div class="col-md-3">
                                    <label for="data_docum" class="form-label fw-semibold small mb-1">Data do Doc.</label>
                                    <input type="date" class="form-control form-control-sm" id="data_docum" name="data_docum">
                                </div>

                                <!-- OM de Origem -->
                                <div class="col-md-3">
                                    <label for="id_om" class="form-label fw-semibold small mb-1">OM Origem</label>
                                    <select class="form-select form-select-sm" id="id_om" name="id_om">
                                        <option value="">Selecione...</option>
                                        <?php if (!empty($omsOrigem)): ?>
                                            <?php foreach ($omsOrigem as $om): ?>
                                                <option value="<?= $om['id_om'] ?>"><?= htmlspecialchars($om['sigla_om'] . ' - ' . $om['nome_om']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEÇÃO 2: RESPONSABILIDADES E SUBCHEFIAS -->
                    <div class="card mb-3 border-light bg-light">
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                                <i class="bi bi-people me-1"></i> Responsabilidades
                            </h6>
                            <div class="row g-3">
                                <!-- OM Responsável -->
                                <div class="col-md-4">
                                    <label for="id_om_resp" class="form-label fw-semibold small mb-1">OM Responsável</label>
                                    <select class="form-select form-select-sm" id="id_om_resp" name="id_om_resp">
                                        <option value="">Selecione...</option>
                                        <?php if (!empty($omsResp)): ?>
                                            <?php foreach ($omsResp as $omResp): ?>
                                                <option value="<?= $omResp['id_om_resp'] ?>"><?= htmlspecialchars($omResp['sigla_om_resp']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Subchefia Líder (Select Único) -->
                                <div class="col-md-4">
                                    <label for="id_sub_lider" class="form-label fw-semibold small mb-1">Subchefia Líder</label>
                                    <select class="form-select form-select-sm" id="id_sub_lider" name="id_sub_lider">
                                        <option value="">Selecione...</option>
                                        <?php if (!empty($subchefiasLider)): ?>
                                            <?php foreach ($subchefiasLider as $subLider): ?>
                                                <option value="<?= $subLider['id_sub_lider'] ?>"><?= htmlspecialchars($subLider['cod_sub_lider'] . ' - ' . $subLider['nome_sub_lider']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Status da Ordem -->
                                <div class="col-md-4">
                                    <label for="id_status_ordem" class="form-label fw-semibold small mb-1">Status da Ordem</label>
                                    <select class="form-select form-select-sm" id="id_status_ordem" name="id_status_ordem">
                                        <option value="">Selecione...</option>
                                        <?php if (!empty($statusOrdem)): ?>
                                            <?php foreach ($statusOrdem as $st): ?>
                                                <option value="<?= $st['id_status_ordem'] ?>"><?= htmlspecialchars($st['nome_status_ordem']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Subchefia de Apoio (Checkboxes Múltiplos) -->
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-semibold small d-block mb-2">
                                        Subchefia(s) de Apoio <span class="text-muted fw-normal">(Marque uma ou mais opções)</span>
                                    </label>
                                    <div class="p-2 border rounded bg-white" style="max-height: 120px; overflow-y: auto;">
                                        <div class="row g-2">
                                            <?php if (!empty($subchefiasApoio)): ?>
                                                <?php foreach ($subchefiasApoio as $subApoio): ?>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="id_sub_apoio[]" value="<?= $subApoio['id_sub_apoio'] ?>" id="sub_apoio_<?= $subApoio['id_sub_apoio'] ?>">
                                                            <label class="form-check-label small" for="sub_apoio_<?= $subApoio['id_sub_apoio'] ?>">
                                                                <?= htmlspecialchars($subApoio['cod_sub_apoio'] . ' - ' . $subApoio['nome_sub_apoio']) ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="col-12 text-muted small">Nenhuma Subchefia de Apoio cadastrada.</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEÇÃO 3: PRAZOS E DETALHAMENTO DA ORDEM -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="prazo" class="form-label fw-semibold small mb-1">Prazo Limite</label>
                            <input type="date" class="form-control form-control-sm" id="prazo" name="prazo">
                        </div>
                        <div class="col-md-6">
                            <label for="data_cump" class="form-label fw-semibold small mb-1">Data de Cumprimento</label>
                            <input type="date" class="form-control form-control-sm" id="data_cump" name="data_cump">
                        </div>

                        <div class="col-12">
                            <label for="tema_pauta" class="form-label fw-semibold small mb-1">Tema / Pauta</label>
                            <input type="text" class="form-control form-control-sm" id="tema_pauta" name="tema_pauta" maxlength="500" placeholder="Descrição resumida do tema ou pauta">
                        </div>

                        <div class="col-md-6">
                            <label for="determinacao" class="form-label fw-semibold small mb-1">Determinação</label>
                            <textarea class="form-control form-control-sm" id="determinacao" name="determinacao" rows="3" placeholder="Detalhamento da determinação do CM..."></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="evento" class="form-label fw-semibold small mb-1">Evento</label>
                            <textarea class="form-control form-control-sm" id="evento" name="evento" rows="3" placeholder="Evento relacionado à ordem..."></textarea>
                        </div>

                        <div class="col-12">
                            <label for="observacao" class="form-label fw-semibold small mb-1">Observações</label>
                            <textarea class="form-control form-control-sm" id="observacao" name="observacao" rows="2" placeholder="Observações adicionais..."></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-lg me-1"></i> Salvar Ordem
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>