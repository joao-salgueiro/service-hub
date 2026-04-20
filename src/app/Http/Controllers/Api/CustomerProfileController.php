<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class CustomerProfileController extends Controller
{
    // Buscar perfil do cliente autenticado
    public function show(Request $request)
    {
        $customer = $request->user()->customer;
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        return response()->json($customer->load('user'));
    }
    // atualizar perfil do cliente
    public function update(Request $request)
    {
        $customer = $request->user()->customer;
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $data = $request->validate([
            'name'=>'nullable|string|max:255',
            'phone'=>'nullable|string',
            'address'=>'nullable|string|max:255',
            'photo'   => 'nullable|image|max:2048'
        ]);

        if (isset($data['name'])) {
            $customer->user->name = $data['name'];
            $customer->user->save();
        }
        if (isset($data['phone'])) {
            $customer->phone = $data['phone'];
        }
        if (isset($data['address'])) {
            $customer->address = $data['address'];
        }
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/customers');
            $customer->photo = basename($path);
        }
        $customer->save();
        return response()->json($customer->load('user'));
    }
    //deletar conta do cliente
    public function destroy(Request $request)
    {
        $customer = $request->user()->customer;
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $user = $customer->user;
        $customer->delete();
        $user->delete();

        return response()->json(['message' => 'Conta deletada com sucesso']);
    }
}