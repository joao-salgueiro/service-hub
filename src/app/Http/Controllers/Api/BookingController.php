<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    // Método privado para obter e validar o provider autenticado
    private function getAuthenticatedProvider()
    {
        $provider = Auth::user()->provider;
        if (!$provider) {
            response()->json(['message' => 'Usuário não é um prestador'], 403)->send();
            exit;
        }
        return $provider;
    }

    // Lista solicitações de serviço para o provider autenticado
    public function index()
    {
        $provider = $this->getAuthenticatedProvider();

        $bookings = Booking::whereHas('service', function ($query) use ($provider) {
            $query->where('provider_id', $provider->id);
        })->with(['customer', 'service'])->orderBy('scheduled_at', 'desc')->get();

        return response()->json($bookings);
    }

    // Aceitar uma solicitação de serviço
    public function accept($id)
    {
        $provider = $this->getAuthenticatedProvider();

        $booking = Booking::where('id', $id)
            ->whereHas('service', function ($query) use ($provider) {
                $query->where('provider_id', $provider->id);
            })->firstOrFail();

        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Solicitação já foi processada'], 400);
        }

        $booking->status = 'confirmed';
        $booking->save();

        return response()->json(['message' => 'Solicitação aceita com sucesso', 'booking' => $booking]);
    }

    // Rejeitar uma solicitação de serviço
    public function reject($id)
    {
        $provider = $this->getAuthenticatedProvider();

        $booking = Booking::where('id', $id)
            ->whereHas('service', function ($query) use ($provider) {
                $query->where('provider_id', $provider->id);
            })->firstOrFail();

        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Solicitação já foi processada'], 400);
        }

        $booking->status = 'cancelled';
        $booking->save();

        return response()->json(['message' => 'Solicitação rejeitada com sucesso', 'booking' => $booking]);
    }
}
