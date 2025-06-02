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
     * Display a listing of available vehicles/properties
     */
    public function index(Request $request)
    {
        try {
            // Base query with eager loading
            $query = BemLocavel::query()
                ->with(['tipoBem', 'marca', 'localizacao', 'caracteristicas'])
            ->where('disponivel', true);

        // Apply filters if provided
        if ($request->filled('tipo_bem_id')) {
            $query->where('tipo_bem_id', $request->tipo_bem_id);
        }

        if ($request->filled('marca_id')) {
            $query->where('marca_id', $request->marca_id);
        }

        if ($request->filled('localizacao_id')) {
            $query->where('localizacao_id', $request->localizacao_id);
        }

        if ($request->filled('preco_min')) {
            $query->where('preco_por_dia', '>=', $request->preco_min);
        }

        if ($request->filled('preco_max')) {
            $query->where('preco_por_dia', '<=', $request->preco_max);
        }

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

            // Date availability filter
            if ($request->filled('data_inicio') && $request->filled('data_fim')) {
                $dataInicio = $request->data_inicio;
                $dataFim = $request->data_fim;

                // Exclude vehicles that have reservations in the requested period
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

            // Get paginated results
        $vehicles = $query->paginate(12)->withQueryString();

        // Get filter options
            $tiposBem = TipoBem::all(['id', 'nome']);
            $marcas = Marca::all(['id', 'nome']);
            $localizacoes = Localizacao::all(['id', 'nome']);
            $caracteristicas = Caracteristica::all(['id', 'nome']);

        return Inertia::render('Publico/Vehicles/Index', [
            'vehicles' => $vehicles,
            'filters' => [
                'tiposBem' => $tiposBem,
                'marcas' => $marcas,
                'localizacoes' => $localizacoes,
                'caracteristicas' => $caracteristicas,
            ],
                'queryParams' => $request->query() ?: [],
        ]);

        } catch (\Exception $e) {
            Log::error('Error in VehicleController@index: ' . $e->getMessage());

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
     * Display the specified vehicle/property
     */
    public function show($id)
    {
        try {
            $vehicle = BemLocavel::with(['tipoBem', 'marca', 'localizacao', 'caracteristicas'])
                ->findOrFail($id);

            // Get similar vehicles (same type, different vehicle)
            $similarVehicles = BemLocavel::with(['tipoBem', 'marca', 'localizacao'])
                ->where('tipo_bem_id', $vehicle->tipo_bem_id)
                ->where('id', '!=', $vehicle->id)
                ->where('disponivel', true)
                ->limit(4)
                ->get();

            return Inertia::render('Publico/Vehicles/Show', [
                'vehicle' => $vehicle,
                'similarVehicles' => $similarVehicles,
            ]);

        } catch (\Exception $e) {
            Log::error('Error in VehicleController@show: ' . $e->getMessage());

            return redirect()->route('vehicles.index')
                ->with('error', 'Veículo não encontrado.');
        }
    }
}
