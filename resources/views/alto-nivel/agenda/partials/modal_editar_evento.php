<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold" id="modalEditarLabel">Editar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form action="/alto-nivel/agenda/evento/atualizar" method="POST" id="form_editar_evento">
                <div class="modal-body">
                    <input type="hidden" name="id_evento" id="edit_id_evento">

                    <div class="mb-3">
                        <label for="edit_nome_evento" class="form-label small fw-bold">Nome do Evento</label>
                        <input type="text" class="form-control form-control-sm" id="edit_nome_evento" name="nome_evento" required>
                    </div>

                    <div class="row g-2">
                        <div class="col">
                            <label for="edit_data_ini" class="form-label small fw-bold">Data Início</label>
                            <input type="date" class="form-control form-control-sm" id="edit_data_ini" name="data_ini" required>
                        </div>
                        <div class="col">
                            <label for="edit_data_fim" class="form-label small fw-bold">Data Fim</label>
                            <input type="date" class="form-control form-control-sm" id="edit_data_fim" name="data_fim" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nr_msg_alteracao" class="form-label small fw-bold">Mensagem de Alteração</label>
                        <input type="text" class="form-control form-control-sm" id="nr_msg_alteracao" name="nr_msg_alteracao" required placeholder="Ex: MSG-123/2026">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>