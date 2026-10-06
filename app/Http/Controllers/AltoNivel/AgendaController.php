<?php

namespace App\Http\Controllers\AltoNivel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $ano = $request->input('ano', date('Y'));
        $title = "Agenda Administrativa — SisGovernança";

        // 1. OMs para popular o select do modal
        $oms = DB::table('om_origem')
            ->select('id_om', 'nome_om', 'sigla_om')
            ->orderBy('sigla_om', 'asc')
            ->get();

        // 2. Buscar agenda do ano selecionado
        $agendaAtiva = DB::table('agendas as a')
            ->join('om_origem as om', 'om.id_om', '=', 'a.id_om')
            ->leftJoin('users as u', 'u.id_user', '=', 'a.id_user')
            ->select('a.*', 'om.sigla_om', 'om.nome_om', 'u.name as nome_usuario')
            ->where('a.ano_agenda', $ano)
            ->orderBy('a.id_agenda', 'desc')
            ->first();

        // 3. Buscar eventos vinculados à agenda + contagem de histórico
        $eventos = collect();
        if ($agendaAtiva) {
            $eventos = DB::table('eventos as e')
                ->leftJoin('users as u', 'u.id_user', '=', 'e.id_user')
                ->select(
                    'e.*',
                    'u.name as nome_usuario',
                    DB::raw('(SELECT COUNT(*) FROM eventos_historico h WHERE h.id_evento = e.id_evento) as total_historico')
                )
                ->where('e.id_agenda', $agendaAtiva->id_agenda)
                ->orderBy('e.nr_evento', 'asc')
                ->orderBy('e.data_ini', 'asc')
                ->get();
        }

        return view('alto-nivel.agenda.index', compact('title', 'oms', 'agendaAtiva', 'eventos', 'ano'));
    }

    public function storeAgenda(Request $request)
    {
        $action = $request->input('action', 'cadastrar_agenda');

        if ($action === 'cadastrar_evento') {
            return $this->storeEvento($request);
        }
        if ($action === 'atualizar_evento') {
            return $this->atualizarEvento($request);
        }

        $ano = (int) $request->input('ano_agenda', date('Y'));
        $idOm = $request->input('id_om');
        $nrDocumento = strtoupper(trim($request->input('nr_documento', '')));
        $idUser = Auth::id() ?? 1;

        if ($idOm && !empty($nrDocumento) && $ano > 0) {
            $agendaExistente = DB::table('agendas')
                ->where('ano_agenda', $ano)
                ->first();

            if ($agendaExistente) {
                return redirect("/alto-nivel/agenda?ano={$ano}&status=agenda_ja_existe");
            }

            DB::table('agendas')->insert([
                'ano_agenda'   => $ano,
                'id_om'        => $idOm,
                'nr_documento' => $nrDocumento,
                'id_user'      => $idUser
            ]);

            return redirect("/alto-nivel/agenda?ano={$ano}&status=agenda_criada");
        }

        return redirect("/alto-nivel/agenda?status=erro_dados_incompletos");
    }

    public function storeEvento(Request $request)
    {
        $idAgenda   = $request->input('id_agenda');
        $nomeEvento = trim($request->input('nome_evento', ''));
        $dataIni    = $request->input('data_ini');
        $dataFim    = $request->input('data_fim');
        $idUser     = Auth::id() ?? 1;

        if ($idAgenda && !empty($nomeEvento) && $dataIni && $dataFim) {
            $ultimo = DB::table('eventos')
                ->where('id_agenda', $idAgenda)
                ->max('nr_evento') ?? 0;

            $nrEvento = $ultimo + 1;

            DB::table('eventos')->insert([
                'id_agenda'   => $idAgenda,
                'nr_evento'   => $nrEvento,
                'nome_evento' => $nomeEvento,
                'data_ini'    => $dataIni,
                'data_fim'    => $dataFim,
                'id_user'     => $idUser
            ]);

            return redirect("/alto-nivel/agenda?status=evento_criado");
        }

        return redirect("/alto-nivel/agenda?status=erro_dados_incompletos");
    }

    public function atualizarEvento(Request $request)
    {
        $idEvento       = $request->input('id_evento');
        $nomeEvento     = trim($request->input('nome_evento', ''));
        $dataIni        = $request->input('data_ini');
        $dataFim        = $request->input('data_fim');
        $nrMsgAlteracao = strtoupper(trim($request->input('nr_msg_alteracao', '')));
        $idUser         = Auth::id() ?? 1;

        if ($idEvento && !empty($nomeEvento) && $dataIni && $dataFim) {
            try {
                DB::transaction(function () use ($idEvento, $nomeEvento, $dataIni, $dataFim, $nrMsgAlteracao, $idUser) {
                    $eventoAtual = DB::table('eventos')->where('id_evento', $idEvento)->first();

                    if ($eventoAtual) {
                        DB::table('eventos_historico')->insert([
                            'id_evento'        => $eventoAtual->id_evento,
                            'nome_evt_antigo'  => $eventoAtual->nome_evento,
                            'ini_evt_antigo'   => $eventoAtual->data_ini,
                            'fim_evt_antigo'   => $eventoAtual->data_fim,
                            'nr_msg_alteracao' => $nrMsgAlteracao,
                            'id_user'          => $idUser
                        ]);

                        DB::table('eventos')
                            ->where('id_evento', $idEvento)
                            ->update([
                                'nome_evento' => $nomeEvento,
                                'data_ini'    => $dataIni,
                                'data_fim'    => $dataFim,
                                'id_user'     => $idUser
                            ]);
                    }
                });

                return redirect("/alto-nivel/agenda?status=evento_atualizado");
            } catch (\Exception $e) {
                return redirect("/alto-nivel/agenda?status=erro_atualizacao");
            }
        }

        return redirect("/alto-nivel/agenda?status=erro_dados_incompletos");
    }

    public function obterHistorico(Request $request)
    {
        $idEvento = filter_var($request->query('id_evento'), FILTER_VALIDATE_INT);

        if (!$idEvento) {
            return response()->json(['status' => 'error', 'message' => 'ID de evento inválido'], 400);
        }

        try {
            $historico = DB::table('eventos_historico as h')
                ->leftJoin('users as u', 'u.id_user', '=', 'h.id_user')
                ->select(
                    'h.id_evthistorico',
                    'h.id_evento',
                    'h.nome_evt_antigo',
                    'h.ini_evt_antigo',
                    'h.fim_evt_antigo',
                    'h.nr_msg_alteracao',
                    'h.data_atualizacao',
                    DB::raw("COALESCE(u.name, 'Sistema') as nome_usuario")
                )
                ->where('h.id_evento', $idEvento)
                ->orderBy('h.data_atualizacao', 'desc')
                ->get();

            return response()->json($historico);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Erro ao consultar banco de dados: ' . $e->getMessage()], 500);
        }
    }
}