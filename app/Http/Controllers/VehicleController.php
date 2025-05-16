<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use Inertia\Inertia;

class VehicleController extends Controller
{
    public function index()
    {
        $bens = BemLocavel::with('marca', 'caracteristicas', 'localizacao')->get();
        return Inertia::render('Vehicles/Index', compact('bens'));
    }

    public function show($id)
    {
        $bem = BemLocavel::with('marca', 'caracteristicas', 'localizacao')->findOrFail($id);
        return Inertia::render('Vehicles/Show', compact('bem'));
    }
}
