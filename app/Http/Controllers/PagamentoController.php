<?php

namespace App\Http\Controllers;

use App\Models\BemLocavel;
use App\Models\Caracteristica;
use App\Models\Localizacao;
use App\Models\Marca;
use App\Models\Pagamento;
use App\Models\Reserva;
use App\Models\TipoBem;
use App\Models\User;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index() {
        return Pagamento::with('reserva')->get();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'valor' => 'required|numeric',
            'metodo_pagamento' => 'required|string',
            'estado' => 'required|string'
        ]);
        return Pagamento::create($data);
    }

    public function show(Pagamento $pagamento) {
        return $pagamento->load('reserva');
    }

    public function update(Request $request, Pagamento $pagamento) {
        $pagamento->update($request->all());
        return $pagamento->load('reserva');
    }

    public function destroy(Pagamento $pagamento) {
        $pagamento->delete();
        return response()->noContent();
    }
}
