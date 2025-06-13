<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminContactController extends Controller
{
    /**
     * Return the admin user contact info for guest chat.
     */
    public function index()
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return response()->json(['contacts' => []]);
        }

        return response()->json([
            'contacts' => [
                [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                ],
            ],
        ]);
    }
}
