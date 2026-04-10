<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProviderRegion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderRegionController extends Controller
{
    // Cadastrar regiões de atendimento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'regions' => 'required|array',
            'regions.*' => 'required|string',
        ]);

        $provider = Auth::user()->provider;
        if (!$provider) {
            return response()->json(['message' => 'Usuário não é um prestador'], 403);
        }

        // Remove regiões antigas
        $provider->regions()->delete();

        // Cria as novas regiões
        foreach ($validated['regions'] as $region) {
            $provider->regions()->create(['region' => $region]);
        }

        return response()->json(['message' => 'Regiões cadastradas com sucesso']);
    }

    // Listar regiões de atendimento do provider autenticado
    public function index()
    {
        $provider = Auth::user()->provider;
        if (!$provider) {
            return response()->json(['message' => 'Usuário não é um prestador'], 403);
        }
        return response()->json($provider->regions);
    }
}
