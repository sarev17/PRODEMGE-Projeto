<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Contact;
use App\Models\People;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PeopleController extends Controller
{
    public function search(String $term)
    {
        $user = collect();
        $user = User::whereHas('people', function ($query) use ($term) {
            $query->where('name', 'like', "%$term%");
        })->get();
        if ($user->isEmpty()) {
            $user = People::where('document', $term)->get();
            $user->transform(function ($person) {
                return $person->user;
            });
        }
        if ($user->isEmpty()) {
            $user = User::where('id', $term)->get();
        }
        if ($user->isEmpty()) {
            return response()->json((object)[], 400);
        }

        $peopleData = $user->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'document' => $user->people->document,
                'register' => $user->people->created_at->format('d/m/Y')
            ];
        });

        return response()->json((object)['response' => $peopleData], 200);
    }
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = User::create([
                'name' => $request->name,
                'social_name' => $request->social_name,
                'password' => Hash::make($request->document),
                'email' => $request->email
            ]);
            $people = People::create([
                'user_id' => $user->id,
                'document' => $request->document,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
            ]);
            Contact::create([
                'people_id' => $people->id,
                'phone_number' => $request->contact,
                'type' => 'whatsapp'
            ]);
            return response()->json(['response' => 'Usuário cadastrdo'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function edit(Request $request, User $user)
    {
        // Atualizar os dados do usuário
        $user->update([
            'name' => $request->input('name'),
            'social_name' => $request->input('social_name'),
            'email' => $request->input('email'),
        ]);

        $people = $user->people;
        $people->update([
            'document' => $request->input('document'),
            'father_name' => $request->input('father_name'),
            'mother_name' => $request->input('mother_name'),
        ]);

        // Atualizar o endereço residencial
        $residenceAddress = $people->address()->where('business', 'residential')->first();
        $residenceAddress->update([
            'postal_code' => $request->input('postalCodeResidence'),
            'number' => $request->input('numberResidence'),
            'complement' => $request->input('complementResidence'),
            'neighborhood' => $request->input('neighborhoodResidence'),
            'uf' => $request->input('ufResidence'),
            'city' => $request->input('cityResidence'),
        ]);

        // Atualizar o endereço comercial
        $commercialAddress = $people->address()->where('business', 'commercial')->first();
        $commercialAddress->update([
            'postal_code' => $request->input('postalCodeComercial'),
            'number' => $request->input('numberComercial'),
            'complement' => $request->input('complementComercial'),
            'neighborhood' => $request->input('neighborhoodComercial'),
            'uf' => $request->input('ufComercial'),
            'city' => $request->input('cityComercial'),
        ]);

        return response()->json(['message' => 'Dados atualizados com sucesso'], 200);
    }
}
