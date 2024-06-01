<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\User;
use Illuminate\Http\Request;

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
        if($user->isEmpty()){
            $user = User::where('id',$term)->get();
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
}
