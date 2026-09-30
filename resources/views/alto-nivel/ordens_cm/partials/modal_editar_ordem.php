<div class="modal fade" id="modalEditarOrdem" tabindex="-1" aria-labelledby="modalEditarOrdemLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalEditarOrdemLabel">Editar Ordem do CM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form action="/alto-nivel/ordens-cm/atualizar" method="POST">
                <input type="hidden" name="id_ordem" id="edit_id_ordem">
                <div class="modal-body">
                    <p class="text-muted small">Campos para atualização dos dados da ordem.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Atualizar Ordem</button>
                </div>
            </form>
        </div>
    </div>
</div>