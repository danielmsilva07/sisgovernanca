<?php

namespace App\Http\Controllers\AltoNivel;

use App\Http\Controllers\Controller;
use App\Models\HistoricoOrdemCm;
use App\Models\OmOrigem;
use App\Models\OmResponsavel;
use App\Models\OrdemCm;
use App\Models\StatusOrdem;
use App\Models\SubchefiaApoio;
use App\Models\SubchefiaLider;
use App\Models\SubsidioOrdemCm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdemCmController extends Controller
{
    /**
     * Exibe a listagem principal das Ordens do CM com dados para modais
     */
    public function index()
    {
        $ordens = OrdemCm::with([
            'omOrigem',
            'omResponsavel',
            'subchefiaLider',
            'statusOrdem',
            'subsidios',
            'historicos',
        ])
            ->orderBy('nr_ordem_cm', 'desc')
            ->get();

        $omsOrigem = OmOrigem::orderBy('sigla_om_origem')->get();
        $omsResp = OmResponsavel::orderBy('sigla_om_resp')->get();
        $subchefiasLider = SubchefiaLider::orderBy('sigla_sub_lider')->get();
        $subchefiasApoio = SubchefiaApoio::orderBy('sigla_sub_apoio')->get();
        $statusOrdem = StatusOrdem::all();

        // Número da última ordem cadastrada (caso não tenha ordem, exibe 1)
        $ultimoNumeroOrdem = OrdemCm::getUltimoNumeroOrdem();
        $proximoNumeroOrdem = OrdemCm::getProximoNumeroOrdem();

        return view('alto-nivel.ordens_cm.index', [
            'title' => 'Ordens do CM — SisGovernança',
            'ordens' => $ordens,
            'omsOrigem' => $omsOrigem,
            'omsResp' => $omsResp,
            'subchefiasLider' => $subchefiasLider,
            'subchefiasApoio' => $subchefiasApoio,
            'statusOrdem' => $statusOrdem,
            'ultimoNumeroOrdem' => $ultimoNumeroOrdem,
            'proximoNumeroOrdem' => $proximoNumeroOrdem,
        ]);
    }

    /**
     * Salva uma nova Ordem do CM no banco de dados e gera o histórico de criação
     */
    public function store(Request $request)
    {
        $request->validate([
            'nr_ordem_cm' => ['required', 'integer', 'min:1', 'unique:ordens_cm,nr_ordem_cm'],
            'docum_origem' => ['nullable', 'string', 'max:255'],
            'data_docum' => ['nullable', 'date'],
            'id_om_origem' => ['nullable', 'integer', 'exists:om_origem,id_om_origem'],
            'id_om_resp' => ['nullable', 'integer', 'exists:om_responsavel,id_om_resp'],
            'id_sub_lider' => ['nullable', 'integer', 'exists:subchefia_lider,id_sub_lider'],
            'id_sub_apoio' => ['nullable', 'array'],
            'id_sub_apoio.*' => ['integer', 'exists:subchefia_apoio,id_sub_apoio'],
            'id_status_ordem' => ['nullable', 'integer', 'exists:status_ordem,id_status_ordem'],
            'prazo' => ['nullable', 'date'],
            'data_cumpr' => ['nullable', 'date'],
            'tema_pauta' => ['nullable', 'string'],
            'determinacao' => ['nullable', 'string'],
            'evento' => ['nullable', 'string'],
            'observacao' => ['nullable', 'string'],
        ], [
            'nr_ordem_cm.required' => 'O número da ordem é obrigatório.',
            'nr_ordem_cm.min' => 'O número da ordem não pode ser zero ou negativo.',
            'nr_ordem_cm.unique' => 'Já existe uma Ordem do CM cadastrada com esse número.',
        ]);

        DB::beginTransaction();
        try {
            // Converte array de subchefias de apoio selecionadas para inteiros
            $subApoio = $request->has('id_sub_apoio') && is_array($request->id_sub_apoio)
                ? array_values(array_map('intval', $request->id_sub_apoio))
                : [];

            $ordem = OrdemCm::create([
                'nr_ordem_cm' => (int) $request->nr_ordem_cm,
                'docum_origem' => $request->input('docum_origem'),
                'data_docum' => $request->input('data_docum'),
                'id_om_origem' => $request->filled('id_om_origem') ? (int) $request->id_om_origem : null,
                'id_om_resp' => $request->filled('id_om_resp') ? (int) $request->id_om_resp : null,
                'id_sub_lider' => $request->filled('id_sub_lider') ? (int) $request->id_sub_lider : null,
                'id_sub_apoio' => $subApoio,
                'id_status_ordem' => $request->filled('id_status_ordem') ? (int) $request->id_status_ordem : null,
                'prazo' => $request->input('prazo'),
                'data_cumpr' => $request->input('data_cumpr'),
                'tema_pauta' => $request->input('tema_pauta'),
                'determinacao' => $request->input('determinacao'),
                'evento' => $request->input('evento'),
                'observacao' => $request->input('observacao'),
            ]);

            // Auditoria automática: Registra Histórico de Criação
            HistoricoOrdemCm::create([
                'id_ordens_cm' => $ordem->id_ordens_cm,
                'id_user' => Auth::id() ?? 1,
                'tipo_acao' => 'Criação',
                'dados_anteriores' => null,
                'dados_novos' => $ordem->toArray(),
                'created_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('alto-nivel.ordens-cm')
                ->with('success', "Ordem do CM nº {$ordem->nr_ordem_cm} cadastrada com sucesso!");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('alto-nivel.ordens-cm')
                ->with('error', 'Erro ao cadastrar a Ordem do CM: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Atualiza os dados de uma Ordem do CM existente e registra o histórico de edição
     */
    public function update(Request $request, $id)
    {
        $ordem = OrdemCm::findOrFail($id);

        $request->validate([
            'nr_ordem_cm' => ['required', 'integer', 'min:1', 'unique:ordens_cm,nr_ordem_cm,'.$id.',id_ordens_cm'],
            'docum_origem' => ['nullable', 'string', 'max:255'],
            'data_docum' => ['nullable', 'date'],
            'id_om_origem' => ['nullable', 'integer', 'exists:om_origem,id_om_origem'],
            'id_om_resp' => ['nullable', 'integer', 'exists:om_responsavel,id_om_resp'],
            'id_sub_lider' => ['nullable', 'integer', 'exists:subchefia_lider,id_sub_lider'],
            'id_sub_apoio' => ['nullable', 'array'],
            'id_sub_apoio.*' => ['integer', 'exists:subchefia_apoio,id_sub_apoio'],
            'id_status_ordem' => ['nullable', 'integer', 'exists:status_ordem,id_status_ordem'],
            'prazo' => ['nullable', 'date'],
            'data_cumpr' => ['nullable', 'date'],
            'tema_pauta' => ['nullable', 'string'],
            'determinacao' => ['nullable', 'string'],
            'evento' => ['nullable', 'string'],
            'observacao' => ['nullable', 'string'],
        ], [
            'nr_ordem_cm.required' => 'O número da ordem é obrigatório.',
            'nr_ordem_cm.min' => 'O número da ordem não pode ser zero ou negativo.',
            'nr_ordem_cm.unique' => 'Já existe outra Ordem do CM cadastrada com esse número.',
        ]);

        DB::beginTransaction();
        try {
            $dadosAnteriores = $ordem->toArray();

            $subApoio = $request->has('id_sub_apoio') && is_array($request->id_sub_apoio)
                ? array_values(array_map('intval', $request->id_sub_apoio))
                : [];

            $ordem->update([
                'nr_ordem_cm' => (int) $request->nr_ordem_cm,
                'docum_origem' => $request->input('docum_origem'),
                'data_docum' => $request->input('data_docum'),
                'id_om_origem' => $request->filled('id_om_origem') ? (int) $request->id_om_origem : null,
                'id_om_resp' => $request->filled('id_om_resp') ? (int) $request->id_om_resp : null,
                'id_sub_lider' => $request->filled('id_sub_lider') ? (int) $request->id_sub_lider : null,
                'id_sub_apoio' => $subApoio,
                'id_status_ordem' => $request->filled('id_status_ordem') ? (int) $request->id_status_ordem : null,
                'prazo' => $request->input('prazo'),
                'data_cumpr' => $request->input('data_cumpr'),
                'tema_pauta' => $request->input('tema_pauta'),
                'determinacao' => $request->input('determinacao'),
                'evento' => $request->input('evento'),
                'observacao' => $request->input('observacao'),
            ]);

            // Auditoria automática: Registra Histórico de Edição
            $dadosNovos = $ordem->fresh() ? $ordem->fresh()->toArray() : $ordem->toArray();
            HistoricoOrdemCm::create([
                'id_ordens_cm' => $ordem->id_ordens_cm,
                'id_user' => Auth::id() ?? 1,
                'tipo_acao' => 'Edição',
                'dados_anteriores' => $dadosAnteriores,
                'dados_novos' => $dadosNovos,
                'created_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('alto-nivel.ordens-cm')
                ->with('success', "Ordem do CM nº {$ordem->nr_ordem_cm} atualizada com sucesso!");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('alto-nivel.ordens-cm')
                ->with('error', 'Erro ao atualizar a Ordem do CM: '.$e->getMessage());
        }
    }

    /**
     * Registra um novo subsídio (medida adotada) para acompanhamento da ordem
     */
    public function storeSubsidio(Request $request, $id)
    {
        $ordem = OrdemCm::findOrFail($id);

        $request->validate([
            'medida_adotada' => ['required', 'string', 'min:3'],
        ], [
            'medida_adotada.required' => 'A medida adotada deve ser preenchida.',
            'medida_adotada.min' => 'A medida adotada deve conter pelo menos 3 caracteres.',
        ]);

        DB::beginTransaction();
        try {
            $subsidio = SubsidioOrdemCm::create([
                'id_ordens_cm' => $ordem->id_ordens_cm,
                'id_user' => Auth::id() ?? 1,
                'medida_adotada' => trim($request->medida_adotada),
            ]);

            $dataSubsidio = $subsidio->created_at ? $subsidio->created_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i');

            // Auditoria automática: Registra Histórico de Atualização de Subsídio
            HistoricoOrdemCm::create([
                'id_ordens_cm' => $ordem->id_ordens_cm,
                'id_user' => Auth::id() ?? 1,
                'tipo_acao' => 'Atualização de Subsídio',
                'dados_anteriores' => null,
                'dados_novos' => [
                    'id_subsidios_ordens_cm' => $subsidio->id_subsidios_ordens_cm,
                    'medida_adotada' => $subsidio->medida_adotada,
                    'created_at' => $dataSubsidio,
                ],
                'created_at' => now(),
            ]);

            DB::commit();

            /** @var User|null $currentUser */
            $currentUser = Auth::user();
            $nomeUsuario = $currentUser ? $currentUser->name : 'Usuário';

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Subsídio registrado com sucesso!',
                    'subsidio' => [
                        'id' => $subsidio->id_subsidios_ordens_cm,
                        'medida_adotada' => $subsidio->medida_adotada,
                        'usuario' => $nomeUsuario,
                        'data' => $dataSubsidio,
                    ],
                ]);
            }

            return redirect()->route('alto-nivel.ordens-cm')
                ->with('success', "Subsídio registrado com sucesso para a Ordem nº {$ordem->nr_ordem_cm}!");

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }

            return redirect()->route('alto-nivel.ordens-cm')
                ->with('error', 'Erro ao registrar subsídio: '.$e->getMessage());
        }
    }

    /**
     * Retorna a lista de subsídios de uma ordem em JSON para preencher o modal
     */
    public function getSubsidios($id)
    {
        $ordem = OrdemCm::with(['subsidios.user'])->findOrFail($id);

        $subsidios = $ordem->subsidios->map(function ($s) {
            return [
                'id' => $s->id_subsidios_ordens_cm,
                'medida_adotada' => $s->medida_adotada,
                'usuario' => $s->user->name ?? 'Sistema',
                'data' => $s->created_at ? $s->created_at->format('d/m/Y H:i') : '-',
            ];
        });

        return response()->json([
            'ordem' => [
                'id_ordens_cm' => $ordem->id_ordens_cm,
                'nr_ordem_cm' => $ordem->nr_ordem_cm,
                'determinacao' => $ordem->determinacao,
            ],
            'subsidios' => $subsidios,
        ]);
    }

    /**
     * Retorna a lista de histórico de auditoria de uma ordem em JSON para preencher o modal
     */
    public function getHistorico($id)
    {
        $ordem = OrdemCm::with(['historicos.user'])->findOrFail($id);

        $historicos = $ordem->historicos->map(function ($h) {
            return [
                'id' => $h->id_historico_ordens_cm,
                'tipo_acao' => $h->tipo_acao,
                'usuario' => $h->user->name ?? 'Sistema',
                'data' => $h->created_at ? $h->created_at->format('d/m/Y H:i:s') : '-',
                'dados_anteriores' => $h->dados_anteriores,
                'dados_novos' => $h->dados_novos,
            ];
        });

        return response()->json([
            'ordem' => [
                'id_ordens_cm' => $ordem->id_ordens_cm,
                'nr_ordem_cm' => $ordem->nr_ordem_cm,
                'determinacao' => $ordem->determinacao,
            ],
            'historicos' => $historicos,
        ]);
    }
}
