<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use Inertia\Inertia;

class VehicleController extends Controller
{
    public function index()
    {
        $bens = BemLocavel::with('marca')->get();
        return Inertia::render('Publico/Vehicles/Index', compact('bens'));
    }

    public function show($id)
    {
        $bem = BemLocavel::with('marca', 'caracteristicas', 'localizacao')->findOrFail($id);
        return Inertia::render('AreaAdmin/Admin/Vehicles/Index', compact('bem'));
    }
}
