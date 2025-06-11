<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{

    public function downloadArquivoPdf()
    {
        // Consideramos que 'reserva_id' foi armazenado na sessão anteriormente, por exemplo:
        // session(['reserva_id' => $reserva->id]);
        if (!session()->has('reserva_id')) {
            return redirect()->route('dashboard');
        }

        $reservaId = session('reserva_id');
        
        //Verifica se $reservaId contém um objeto. 
        //Se for um objeto, ela acessa sua propriedade id; caso contrário, mantém $reservaId como está.
        $reservaId = is_object($reservaId) ? $reservaId->id : $reservaId;

        $reserva = Reserva::with(['user', 'bemLocavel'])->find($reservaId);

        if (!$reserva) {
            return redirect()->route('dashboard')->with('error', 'Reserva não encontrada.');
        }

        $pdf = Pdf::loadView('reserva.print', compact('reserva'));

        return $pdf->download('reserva-' . env('APP_NAME') . '-' . date('Ymd') . '.pdf');
    }

    public function downloadArquivoTxt()
    {
       // Consideramos que 'reserva_id' foi armazenado na sessão anteriormente em um array, por exemplo:
       // session(['reserva_id' => $reserva->id]);

        if (!session()->has('reserva_id')) {
            return redirect()->route('dashboard');
        }
        
        $reservaData = session('reserva_id');
        $reservaId = is_object($reservaData) ? $reservaData->id : $reservaData;

        $reserva = Reserva::with(['user', 'bemLocavel'])->find($reservaId);

        $content = "Dados da Reserva:\n";
        $content .= "ID: {$reserva->id}\n";
        $content .= "Usuário: {$reserva->user->name}\n";
        $content .= "Email: {$reserva->user->email}\n";
        $content .= "Bem Locável: {$reserva->bemLocavel->modelo}\n";
        $content .= "Data de Início: {$reserva->data_inicio}\n";
        $content .= "Data de Fim: {$reserva->data_fim}\n";

        $filename = 'reserva-' . env('APP_NAME') . '-' . date('Ymd') . '.txt';

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
