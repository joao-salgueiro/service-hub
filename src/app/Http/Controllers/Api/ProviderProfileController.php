<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Provider;
use Illuminate\Support\Facades\Storage;

class ProviderProfileController extends Controller
{
    // Buscar perfil do prestador autenticado
    public function show(Request $request)
    {
        $provider = $request->user()->provider;
        if (!$provider) {
            return response()->json(['error' => 'Provider not found'], 404);
        }
        return response()->json($provider->load('user'));
    }
    //atualizar perfil do prestador
    public function update(Request $request)
    {
        $provider = $request->user()->provider;
        if (!$provider) {
            return response()->json(['error' => 'Provider not found'], 404);
        }

        $data = $request->validate([
            'bio' => 'nullable|string',
            'location' => 'nullable|string',
            'phone' => 'nullable|string',
            'name' => 'nullable|string',
            'cpf' => 'nullable|string',
            'data_nascimento' => 'nullable|date',
            'email' => 'nullable|email',
            'photo' => 'nullable|image|max:2048',
        ]);

        if (isset($data['name'])) {
            $provider->user->name = $data['name'];
            $provider->user->save();
        }
        if (isset($data['bio'])) {
            $provider->bio = $data['bio'];
        }
        if (isset($data['location'])) {
            $provider->location = $data['location'];
        }
        if (isset($data['phone'])) {
            $provider->phone = $data['phone'];
        }
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/providers');
            $provider->photo = basename($path);
        }
        if (isset($data['cpf'])) {
            $provider->cpf = $data['cpf'];
        }
        if (isset($data['data_nascimento'])) {
            $provider->data_nascimento = $data['data_nascimento'];
        }
        if (isset($data['email'])) {
            $provider->user->email = $data['email'];
            $provider->user->save();
        }
        $provider->save();
        return response()->json($provider->load('user'));
    }
    //deletar conta do prestador
    public function destroy(Request $request)
    {
        $provider = $request->user()->provider;
        if (!$provider) {
            return response()->json(['error' => 'Provider not found'], 404);
        }

        $user = $provider->user;
        $provider->delete();
        $user->delete();

        return response()->json(['message' => 'Conta deletada com sucesso']);
    }
}