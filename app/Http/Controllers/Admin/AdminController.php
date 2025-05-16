<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

class AdminController
{
    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard');
    }
}
