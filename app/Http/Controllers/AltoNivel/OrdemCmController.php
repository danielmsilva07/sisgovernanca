<?php

namespace App\Http\Controllers\AltoNivel;

use App\Http\Controllers\Controller;
use App\Models\OrdemCm;
use Illuminate\Http\Request;

class OrdemCmController extends Controller
{
    public function index()
    {
        $ordens          = OrdemCm::all();
        $omsOrigem       = OrdemCm::getOmsOrigem();
        $omsResp         = OrdemCm::getOmsResponsaveis();
        $subchefiasLider = OrdemCm::getSubchefiasLider();
        $subchefiasApoio = OrdemCm::getSubchefiasApoio();
        $statusOrdem     = OrdemCm::getStatusOrdem();

        return view('alto-nivel.ordens_cm.index', [
            'title'           => 'Ordens do CM — SisGovernança',
            'ordens'          => $ordens,
            'omsOrigem'       => $omsOrigem,
            'omsResp'         => $omsResp,
            'subchefiasLider' => $subchefiasLider,
            'subchefiasApoio' => $subchefiasApoio,
            'statusOrdem'     => $statusOrdem
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validação de dados e unicidade do número da ordem
        $request->validate([
            'nr_ordem' => ['nullable', 'integer', 'unique:ordem_cm,nr_ordem'],
        ], [
            'nr_ordem.unique' => 'Já existe uma Ordem do CM cadastrada com esse número.',
        ]);

        // 2. Trata múltiplos checkboxes de Subchefia de Apoio
        $subApoioStr = null;
        if ($request->has('id_sub_apoio') && is_array($request->id_sub_apoio)) {
            $subApoioStr = implode(',', array_map('intval', $request->id_sub_apoio));
        }

        // 3. Monta o array de dados usando $request
        $dados = [
            'nr_ordem'        => $request->filled('nr_ordem') ? (int) $request->nr_ordem : null,
            'docum_origem'    => trim($request->input('docum_origem', '')),
            'data_docum'      => $request->input('data_docum'),
            'id_om'           => $request->filled('id_om') ? (int) $request->id_om : null,
            'id_om_resp'      => $request->filled('id_om_resp') ? (int) $request->id_om_resp : null,
            'id_sub_lider'    => $request->filled('id_sub_lider') ? (int) $request->id_sub_lider : null,
            'id_sub_apoio'    => $subApoioStr,
            'id_status_ordem' => $request->filled('id_status_ordem') ? (int) $request->id_status_ordem : null,
            'prazo'           => $request->input('prazo'),
            'data_cump'       => $request->input('data_cump'),
            'tema_pauta'      => trim($request->input('tema_pauta', '')),
            'determinacao'    => trim($request->input('determinacao', '')),
            'evento'          => trim($request->input('evento', '')),
            'observacao'      => trim($request->input('observacao', ''))
        ];

        // 4. Inserção no banco via Eloquent Model
        if (OrdemCm::create($dados)) {
            return redirect('/alto-nivel/ordens-cm')
                ->with('success', "Ordem do CM cadastrada com sucesso!");
        }

        return redirect('/alto-nivel/ordens-cm')
            ->with('error', "Erro ao cadastrar a Ordem do CM no banco de dados.");
    }
}