<div class="table-responsive">
    <table class="table table-hover align-middle mb-0 table-sm">
        <thead class="table-light">
            <tr>
                <th class="ps-3 text-nowrap" style="width: 5%">Nº do evento</th>
                <th class="text-wrap" style="width: 50%">Nome do Evento</th>
                <th class="text-nowrap" style="width: 20%">Período</th>
                <th class="text-nowrap" style="width: 15%">Registro</th>
                <th class="text-end pe-3 text-nowrap" style="width: 10%">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($eventos) && is_array($eventos)): ?>
                <?php foreach ($eventos as $index => $evento): ?>
                    <tr>
                        <td class="ps-3 fw-semibold text-muted">
                            <?= sprintf('%02d', $evento['nr_evento'] ?? ($index + 1)) ?>
                        </td>
                        <td class="fw-medium text-wrap text-break">
                            <?= htmlspecialchars($evento['nome_evento']) ?>
                        </td>
                        <td class="text-nowrap">
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?= date('d/m/Y', strtotime($evento['data_ini'])) ?> à <?= date('d/m/Y', strtotime($evento['data_fim'])) ?>
                            </span>
                        </td>
                        <td class="small text-nowrap text-truncate">
                            <?= htmlspecialchars($evento['nome_usuario'] ?? 'Sistema') ?>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end gap-1 flex-wrap">
                                <!-- Botão Ver Histórico -->
                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm btn-ver-historico"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHistorico"
                                        data-id="<?= $evento['id_evento'] ?>"
                                        data-nome="<?= htmlspecialchars($evento['nome_evento']) ?>"
                                        title="Ver Histórico de Alterações (<?= $evento['total_historico'] ?? 0 ?>)">
                                    <i class="bi bi-clock-history"></i>
                                    <?php if (!empty($evento['total_historico'])): ?>
                                        <span class="badge bg-secondary ms-1">
                                            <?= $evento['total_historico'] ?>
                                        </span>
                                    <?php endif; ?>
                                </button>

                                <!-- Botão Editar Evento -->
                                <button type="button"
                                        class="btn btn-outline-primary btn-sm btn-editar-evento"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditar"
                                        data-id="<?= $evento['id_evento'] ?>"
                                        data-nome="<?= htmlspecialchars($evento['nome_evento']) ?>"
                                        data-ini="<?= $evento['data_ini'] ?>"
                                        data-fim="<?= $evento['data_fim'] ?>"
                                        title="Editar Evento">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        Nenhum evento cadastrado nesta agenda. Clique em
                        <strong class="text-primary">+ Novo Evento</strong> acima para incluir.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>