<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use App\Models\TipoBem;
use Illuminate\Http\Request;
use Inertia\Inertia;
class PageController extends Controller
{
    public function home()
    {
        $locations = Localizacao::all();
        $vehicleTypes = TipoBem::all();
        return Inertia::render('Publico/Home', [
            'locations' => $locations,
            'vehicleTypes' => $vehicleTypes,
        ]);
    }

    public function about()
    {
        return Inertia::render('Publico/About');
    }

    public function contact()
    {
        return Inertia::render('Publico/Contact');
    }

    public function help()
    {
        return Inertia::render('Publico/Help');
    }

    public function terms()
    {
        return Inertia::render('Publico/Terms');
    }

    public function refund()
    {
        return Inertia::render('Publico/Refund');
    }

    public function complaint()
    {
        return Inertia::render('Publico/Complaint');
    }
}
