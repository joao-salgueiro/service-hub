<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Cadastrar um novo serviço prestado
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $service = Service::create([
            'provider_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
        ]);

        return response()->json([
            'message' => 'Serviço cadastrado com sucesso',
            'service' => $service,
        ], 201);
    }

    /**
     * Atualizar um serviço prestado
     */
    public function update(Request $request, $id)
    {
        $service = Service::where('id', $id)->where('provider_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
        ]);

        $service->update($validated);

        return response()->json([
            'message' => 'Serviço atualizado com sucesso',
            'service' => $service,
        ]);
    }

    /**
     * Deletar um serviço prestado
     */
    public function destroy($id)
    {
        $service = Service::where('id', $id)->where('provider_id', Auth::id())->firstOrFail();
        $service->delete();

        return response()->json([
            'message' => 'Serviço deletado com sucesso',
        ]);
    }
}
