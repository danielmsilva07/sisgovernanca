<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
    <thead>
    <tr>
        <th scope="col" class="text-center">Nº Ordem</th>
        <th scope="col">OM Origem</th>
        <th scope="col">OM Resp.</th>
        <th scope="col">Subchefia Líder</th>
        <th scope="col">Subchefia Apoio</th>
        <th scope="col">Status</th>
        <th scope="col" class="text-end">Ações</th>
    </tr>
</thead>
<tbody>
    <?php if (!empty($ordens)): ?>
        <?php foreach ($ordens as $ordem): ?>
            <tr>
                <td class="text-center fw-bold">
                    #<?= htmlspecialchars($ordem['nr_ordem'] ?? '') ?>
                </td>
                <td>
                    <span class="badge bg-light text-dark border">
                        <?= htmlspecialchars($ordem['sigla_om'] ?? 'N/A') ?>
                    </span>
                </td>
                <td>
                    <span class="badge bg-light text-dark border">
                        <?= htmlspecialchars($ordem['sigla_om_resp'] ?? 'N/A') ?>
                    </span>
                </td>
                <td>
                    <small class="fw-semibold text-secondary">
                        <?= htmlspecialchars($ordem['cod_sub_lider'] ?? 'N/A') ?>
                    </small>
                </td>
                <td>
                    <small class="fw-semibold text-secondary">
                        <?= htmlspecialchars($ordem['cod_sub_apoio'] ?? 'N/A') ?>
                    </small>
                </td>
                <td>
                    <?= htmlspecialchars($ordem['nome_status_ordem'] ?? 'Pendente') ?>
                </td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-info me-1" title="Visualizar" onclick="visualizarOrdem(<?= htmlspecialchars(json_encode($ordem)) ?>)">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary me-1" title="Editar" onclick="editarOrdem(<?= htmlspecialchars(json_encode($ordem)) ?>)">
                        <i class="bi bi-pencil"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center text-muted">Nenhuma ordem encontrada.</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table>
</div>