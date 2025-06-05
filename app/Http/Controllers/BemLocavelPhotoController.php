<?php

namespace App\Http\Controllers;

use App\Models\BemLocavelPhoto;
use Illuminate\Http\Request;

class BemLocavelPhotoController extends Controller
{
    public function index()
    {
        $photos = BemLocavelPhoto::all();
        return response()->json($photos);
    }

    public function show($id)
    {
        $photo = BemLocavelPhoto::findOrFail($id);
        return response()->json($photo);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bem_locavel_id' => 'required|integer|exists:bens_locaveis,id',
            'photo_path' => 'required|string|max:255',
        ]);

        $photo = BemLocavelPhoto::create($validated);
        return response()->json($photo, 201);
    }

    public function update(Request $request, $id)
    {
        $photo = BemLocavelPhoto::findOrFail($id);

        $validated = $request->validate([
            'bem_locavel_id' => 'sometimes|required|integer|exists:bens_locaveis,id',
            'photo_path' => 'sometimes|required|string|max:255',
        ]);

        $photo->update($validated);
        return response()->json($photo);
    }

    public function destroy($id)
    {
        $photo = BemLocavelPhoto::findOrFail($id);
        $photo->delete();
        return response()->json(null, 204);
    }
}
