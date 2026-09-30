<div class="modal fade" id="modalCadastrarAgenda" tabindex="-1" aria-labelledby="modalCadastrarAgendaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold" id="modalCadastrarAgendaLabel">Cadastrar Nova Agenda Anual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/alto-nivel/agenda/salvar" method="POST" id="form_cadastrar_agenda">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ano_agenda" class="form-label small fw-bold">Ano do Exercício</label>
                        <input type="number" class="form-control form-control-sm" id="ano_agenda" name="ano_agenda" value="<?= date('Y') ?>" required>
                    </div>

                    <!-- Select dinâmico da tabela om_origem -->
                    <div class="mb-3">
                        <label for="id_om" class="form-label small fw-bold">OM Demandante</label>
                        <select class="form-select form-select-sm" id="id_om" name="id_om" required>
                            <option value="" selected disabled>Selecione a OM Demandante...</option>
                            <?php if (!empty($oms) && is_array($oms)): ?>
                                <?php foreach ($oms as $om): ?>
                                    <option value="<?= $om['id_om'] ?>">
                                        <?= htmlspecialchars($om['sigla_om'] . ' - ' . $om['nome_om']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nr_documento" class="form-label small fw-bold">Mensagem / Documento de Origem</label>
                        <input type="text" class="form-control form-control-sm" id="nr_documento" name="nr_documento" required placeholder="Ex: R-022030ZAGO2026">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-sm">Criar Agenda</button>
                </div>
            </form>
        </div>
    </div>
</div>