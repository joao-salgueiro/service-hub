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

    // Atualizar perfil do prestador
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
        $provider->save();
        return response()->json($provider->load('user'));
    }
}
