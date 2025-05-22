<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function about()
    {
        return Inertia::render('Publico/About');
    }

    public function contact()
    {
        return Inertia::render('Publico/Contact');
    }

    public function terms()
    {
        return Inertia::render('Publico/Terms');
    }

    public function privacy()
    {
        return Inertia::render('Publico/PrivacyPolicy');
    }

    public function complaint()
    {
        return Inertia::render('Publico/Complaint');
    }

    public function help()
    {
        return Inertia::render('Publico/Help');
    }

    public function refund()
    {
        return Inertia::render('Publico/Refund');
    }
}
