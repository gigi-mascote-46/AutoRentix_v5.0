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
     * Show list of available vehicles/properties
     */
    public function index(Request $request)
    {
        try {
            $query = BemLocavel::query()
                ->with(['tipoBem', 'marca', 'caracteristicas', 'localizacao']);

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

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                        ->orWhere('descricao', 'like', "%{$search}%");
                });
            }

            if ($request->filled('data_inicio') && $request->filled('data_fim')) {
                $query->whereDoesntHave('reservations', function ($q) use ($request) {
                    $q->where('status', '!=', 'cancelada')
                        ->where(function ($q) use ($request) {
                            $q->where('data_inicio', '<=', $request->data_fim)
                                ->where('data_fim', '>=', $request->data_inicio);
                        });
                });
            }

            $vehicles = $query->paginate(12)->withQueryString();

            // Fetch data for filters (localizações únicas por cidade)
            $locations = Localizacao::select('cidade')
                ->groupBy('cidade')
                ->get();

            return Inertia::render('Publico/Vehicles/Index', [
                'vehicles' => $vehicles,
                'filters' => [
                    'types' => TipoBem::select('id', 'nome')->get(),
                    'brands' => Marca::select('id', 'nome')->get(),
                    'locations' => $locations,
                    'features' => Caracteristica::select('id', 'nome')->get(),
                ],
                'queryParams' => $request->query(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error in VehicleController@index', [
                'exception' => $e,
                'request' => $request->all()
            ]);

            // In case of error, return view with empty data and error message
            return Inertia::render('Publico/Vehicles/Index', [
                'vehicles' => [],
                'filters' => [
                    'types' => [],
                    'brands' => [],
                    'locations' => [],
                    'features' => [],
                ],
                'queryParams' => [],
                'error' => 'Error loading vehicles: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show a single vehicle/property details
     */
    public function show($id)
    {
        try {
            $vehicle = BemLocavel::with(['marca', 'localizacao'])->findOrFail($id);
            return Inertia::render('Publico/Vehicles/Show', [
                'bem' => $vehicle,
            ]);

            $similarVehicles = BemLocavel::with(['tipoBem', 'marca', 'caracteristicas'])
                ->where('tipo_bem_id', $vehicle->tipo_bem_id)
                ->where('id', '!=', $vehicle->id)
                ->where('disponivel', true)
                ->limit(4)
                ->get();

            return Inertia::render('Publico/Vehicles/Show', [
                'bem' => $vehicle, // Use "bem" para corresponder ao Vue
                'reservations' => $vehicle->reservations ?? [],
                'similarVehicles' => $similarVehicles,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in VehicleController@show', [
                'exception' => $e,
                'vehicle_id' => $id,
            ]);

            return redirect()->route('publico.vehicles.index')
                ->with('error', 'Vehicle not found: ' . $e->getMessage());
        }
    }
}
