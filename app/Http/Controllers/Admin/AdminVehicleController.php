<?php

namespace App\Http\Controllers\Admin;

// Ensure the base Controller exists and is imported
use App\Http\Controllers\Controller;
use App\Models\BemLocavel;
use App\Models\Marca;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreBemLocavelRequest;

use Illuminate\Support\Facades\Storage;

class AdminVehicleController extends Controller
{
    public function index()
    {
        $bens = BemLocavel::with('marca')->get();
        return Inertia::render('AreaAdmin/Admin/Vehicles/Index', compact('bens'));
    }

    public function create()
    {
        // Para o formulário, precisas de listar marcas
        $marcas = Marca::all();
        return Inertia::render('AreaAdmin/Admin/Vehicles/Create', compact('marcas'));
    }

    public function store(StoreBemLocavelRequest $request)
    {
        BemLocavel::create($request->validated());

        return redirect()->route('admin.vehicles.index')->with('success', 'Viatura criada com sucesso!');
    }

    public function edit($id)
    {
        $bem = BemLocavel::with('marca', 'photos')->findOrFail($id);
        $marcas = Marca::all();
        return Inertia::render('AreaAdmin/Admin/Vehicles/Edit', compact('bem', 'marcas'));
    }

    public function update(Request $request, $id)
    {
        $bem = BemLocavel::findOrFail($id);
        $bem->update($request->validated());

        // Handle photo uploads
        if ($request->hasFile('photos') && is_array($request->file('photos'))) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('vehicles', 'public');
                $bem->photos()->create(['photo_path' => $path]);
            }
        }

        return redirect()->route('admin.vehicles.index')->with('success', 'Viatura atualizada com sucesso!');
    }
}
