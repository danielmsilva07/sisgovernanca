<div class="modal fade" id="modalNovoEvento" tabindex="-1" aria-labelledby="modalNovoEventoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-6 fw-bold" id="modalNovoEventoLabel">Cadastrar Novo Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form action="/alto-nivel/agenda/evento/salvar" method="POST" id="form_novo_evento">
                <div class="modal-body">
                    <input type="hidden" name="id_agenda" value="<?= $agendaAtiva['id_agenda'] ?? '' ?>">

                    <div class="mb-3">
                        <label for="nome_evento" class="form-label small fw-bold">Nome do Evento</label>
                        <input type="text" class="form-control form-control-sm" id="nome_evento" name="nome_evento" required>
                    </div>

                    <div class="row g-2">
                        <div class="col">
                            <label for="data_ini" class="form-label small fw-bold">Data Início</label>
                            <input type="date" class="form-control form-control-sm" id="data_ini" name="data_ini" required>
                        </div>
                        <div class="col">
                            <label for="data_fim" class="form-label small fw-bold">Data Fim</label>
                            <input type="date" class="form-control form-control-sm" id="data_fim" name="data_fim" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Criar Evento</button>
                </div>
            </form>
        </div>
    </div>
</div>