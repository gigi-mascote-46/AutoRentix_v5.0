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
        $reservations = \App\Models\Reservation::where('registo_unico_publico', $id)->get();
        return Inertia::render('Publico/Vehicles/Show', compact('bem', 'reservations'));
    }
}
