document.addEventListener('DOMContentLoaded', function () {
    // PREENCHER MODAL DE EDIÇÃO
    const btnsEditar = document.querySelectorAll('.btn-editar-evento');
    btnsEditar.forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('edit_id_evento').value = this.dataset.id || '';
            document.getElementById('edit_nome_evento').value = this.dataset.nome || '';
            document.getElementById('edit_data_ini').value = this.dataset.ini || '';
            document.getElementById('edit_data_fim').value = this.dataset.fim || '';
        });
    });

    // CARREGAR E EXIBIR HISTÓRICO VIA AJAX
    const btnsHistorico = document.querySelectorAll('.btn-ver-historico');
    btnsHistorico.forEach(btn => {
        btn.addEventListener('click', function () {
            const idEvento = this.dataset.id;
            const nomeEvento = this.dataset.nome;
            
            const elementNome = document.getElementById('hist_nome_evento');
            if (elementNome) elementNome.textContent = nomeEvento;

            const tbody = document.getElementById('lista_historico_body');
            if (!tbody) return;

            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div> Carregando histórico...</td></tr>';

            fetch('/alto-nivel/agenda/evento/historico?id_evento=' + idEvento, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(async response => {
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                return response.json();
            })
            .then(data => {
                tbody.innerHTML = '';
                if (!Array.isArray(data) || data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-3 text-muted">Nenhum registro de alteração encontrado.</td></tr>';
                    return;
                }

                let htmlRows = '';
                data.forEach(item => {
                    let iniFormatted = item.ini_evt_antigo || '';
                    let fimFormatted = item.fim_evt_antigo || '';

                    if (iniFormatted.includes('-')) {
                        const partsIni = iniFormatted.split(' ')[0].split('-');
                        if (partsIni.length === 3) iniFormatted = `${partsIni[2]}/${partsIni[1]}/${partsIni[0]}`;
                    }
                    if (fimFormatted.includes('-')) {
                        const partsFim = fimFormatted.split(' ')[0].split('-');
                        if (partsFim.length === 3) fimFormatted = `${partsFim[2]}/${partsFim[1]}/${partsFim[0]}`;
                    }

                    let dataRegFormatted = '-';
                    const rawData = item.data_atualizacao;
                    if (rawData) {
                        const [dataPart, horaPart] = rawData.split(' ');
                        if (dataPart && dataPart.includes('-')) {
                            const [ano, mes, dia] = dataPart.split('-');
                            const horaMinuto = horaPart ? horaPart.substring(0, 5) : '';
                            dataRegFormatted = `${dia}/${mes}/${ano}${horaMinuto ? ' ' + horaMinuto : ''}`;
                        }
                    }

                    htmlRows += `
                        <tr class="small align-middle">
                            <td class="ps-3 fw-semibold">${item.nome_evt_antigo || '-'}</td>
                            <td class="text-nowrap"><span class="badge bg-light text-dark border">${iniFormatted} à ${fimFormatted}</span></td>
                            <td class="text-nowrap"><strong class="text-primary">${item.nr_msg_alteracao || '-'}</strong></td>
                            <td class="text-nowrap">${item.nome_usuario || 'Sistema'}</td>
                            <td class="pe-3 text-nowrap text-muted">${dataRegFormatted}</td>
                        </tr>
                    `;
                });
                tbody.innerHTML = htmlRows;
            })
            .catch(error => {
                console.error("Erro na busca do histórico:", error);
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-3 text-danger"><i class="bi bi-exclamation-circle me-1"></i> Erro ao carregar o histórico.</td></tr>`;
            });
        });
    });
});