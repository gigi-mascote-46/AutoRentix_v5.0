<?php

namespace App\Http\Controllers\Admin;

// Ensure the base Controller exists and is imported
use App\Http\Controllers\Controller;
use App\Models\BemLocavel;
use App\Models\Marca;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreBemLocavelRequest;

class AdminVehicleController extends Controller
{
    public function index()
    {
        $bens = BemLocavel::with('marca')->get();
        return Inertia::render('Admin/Vehicles/Index', compact('bens'));
    }

    public function create()
    {
        // Para o formulário, precisas de listar marcas
        $marcas = Marca::all();
        return Inertia::render('Admin/Vehicles/Create', compact('marcas'));
    }
public function store(StoreBemLocavelRequest $request)
{
    BemLocavel::create($request->validated());

    return redirect()->route('admin.vehicles.index')->with('success', 'Viatura criada com sucesso!');
}

}
