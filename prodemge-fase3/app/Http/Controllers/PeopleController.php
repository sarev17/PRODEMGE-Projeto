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
            return response()->json(['response'=>'Usuário cadastrdo'],201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
