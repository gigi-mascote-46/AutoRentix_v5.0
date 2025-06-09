<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use App\Models\TipoBem;
use App\Models\Marca;
use App\Models\Localizacao;
use App\Models\Caracteristica;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    /**
     * Exibe a lista de veículos/propriedades disponíveis
     */
    public function index(Request $request)
    {
        try {
            // Query base com eager loading para evitar N+1
            $query = BemLocavel::query()
                ->with(['tipoBem', 'marca', 'caracteristicas']);
                // Se quiseres só disponíveis, podes descomentar:
                // ->where('disponivel', true);

            // Aplicar filtros se existirem no pedido

            if ($request->filled('tipo_bem_id')) {
                $query->where('tipo_bem_id', $request->tipo_bem_id);
            }

            if ($request->filled('marca_id')) {
                $query->where('marca_id', $request->marca_id);
            }

            if ($request->filled('localizacao_id')) {
                $query->whereHas('localizacao', function ($q) use ($request) {
                    $q->where('id', $request->localizacao_id);
                });
            }

            if ($request->filled('preco_min')) {
                $query->where('preco_por_dia', '>=', $request->preco_min);
            }

            if ($request->filled('preco_max')) {
                $query->where('preco_por_dia', '<=', $request->preco_max);
            }

            // Pesquisa por nome ou descrição (query LIKE)
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                      ->orWhere('descricao', 'like', "%{$search}%");
                });
            }

            // Filtrar por disponibilidade nas datas pedidas
            if ($request->filled('data_inicio') && $request->filled('data_fim')) {
                $dataInicio = $request->data_inicio;
                $dataFim = $request->data_fim;

                // Excluir veículos que tenham reservas conflitantes
                $query->whereDoesntHave('reservations', function ($q) use ($dataInicio, $dataFim) {
                    $q->where('status', '!=', 'cancelada')
                      ->where(function ($q) use ($dataInicio, $dataFim) {
                          $q->whereBetween('data_inicio', [$dataInicio, $dataFim])
                            ->orWhereBetween('data_fim', [$dataInicio, $dataFim])
                            ->orWhere(function ($q) use ($dataInicio, $dataFim) {
                                $q->where('data_inicio', '<=', $dataInicio)
                                  ->where('data_fim', '>=', $dataFim);
                            });
                      });
                });
            }

            // Paginar os resultados para melhor performance e UX
            $vehicles = $query->paginate(12)->withQueryString();

            // Obter opções para filtros a mostrar na view
            $tiposBem = TipoBem::all(['id', 'nome']);
            $marcas = Marca::all(['id', 'nome']);
            // Aqui foi mudado para obter 'cidade' pois 'nome' não existe na localizacao
            $localizacoes = Localizacao::all(['id', 'cidade']);
            $caracteristicas = Caracteristica::all(['id', 'nome']);

            // Retornar a view com os dados e filtros usando Inertia
            return Inertia::render('Publico/Vehicles/Index', [
                'vehicles' => $vehicles,
                'filters' => [
                    'tiposBem' => $tiposBem,
                    'marcas' => $marcas,
                    'localizacoes' => $localizacoes,
                    'caracteristicas' => $caracteristicas,
                ],
                'queryParams' => $request->query() ?: [], // mantém os filtros atuais na query string
            ]);

        } catch (\Exception $e) {
            // Em caso de erro, regista no log para análise futura
            Log::error('Error in VehicleController@index: ' . $e->getMessage());

            // Retorna view com erro e sem veículos para não quebrar a página
            return Inertia::render('Publico/Vehicles/Index', [
                'vehicles' => collect([]),
                'filters' => [
                    'tiposBem' => [],
                    'marcas' => [],
                    'localizacoes' => [],
                    'caracteristicas' => [],
                ],
                'queryParams' => [],
                'error' => 'Erro ao carregar veículos. Tente novamente.'
            ]);
        }
    }

    /**
     * Exibe o detalhe de um veículo/propriedade específico
     */
    public function show($id)
    {
        try {
            // Carrega veículo com relacionamentos necessários
            $vehicle = BemLocavel::with(['tipoBem', 'marca', 'caracteristicas'])
                ->findOrFail($id);

            // Obtém veículos similares (mesmo tipo, diferente id, disponíveis)
            $similarVehicles = BemLocavel::with(['tipoBem', 'marca', 'caracteristicas'])
                ->where('tipo_bem_id', $vehicle->tipo_bem_id)
                ->where('id', '!=', $vehicle->id)
                ->where('disponivel', true)
                ->limit(4)
                ->get();

            // Renderiza a view de detalhe com veículo e similares
            return Inertia::render('Publico/Vehicles/Show', [
                'vehicle' => $vehicle,
                'similarVehicles' => $similarVehicles,
            ]);

        } catch (\Exception $e) {
            // Regista erro no log
            Log::error('Error in VehicleController@show: ' . $e->getMessage());

            // Redireciona para a lista com mensagem de erro amigável
            return redirect()->route('vehicles.index')
                ->with('error', 'Veículo não encontrado.');
        }
    }
}
