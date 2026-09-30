<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'agenda_criada'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Agenda criada com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif ($_GET['status'] === 'agenda_ja_existe'): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            ⚠️ Já existe uma agenda cadastrada para este ano.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif ($_GET['status'] === 'erro_dados_incompletos'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ❌ Erro: dados incompletos para cadastro da agenda.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif ($_GET['status'] === 'evento_criado'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Evento criado com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif ($_GET['status'] === 'evento_atualizado'): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            ✏️ Evento atualizado com sucesso!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
<?php endif; ?>