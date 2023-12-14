<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    public function getall()
    {
        if (Auth::check()){
        $restaurants = Restaurant::all();

        return response()->json([
            'status' => 'success',
            'restaurants' => $restaurants,
        ]);
    }
    }
    public function show($id)
    {  if (Auth::check()){
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Restaurant not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'restaurant' => $restaurant,
        ]);
    }
}

    public function showfirst()
    { 
        if (Auth::check()){
        $restaurant = Restaurant::all()->first();
        if (!$restaurant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Restaurant not found',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'restaurant' => $restaurant,
        ]);
    }
}

    public function create_resto(Request $request){
        if (Auth::check()&& Auth::user()->owner==1) {
            $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required',
            'city' => 'required',
            'phone' => 'required',
        ]);

        $resto =Restaurant::create([
            'name' => $request->name,
            'owner'=>$user->id,
            'country' => $request->country,
            'city' => $request->city,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'status' => 'success',
            'restaurant' => $resto,
        ]);
    }
    }
    public function update_resto(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->owner == 1) {
            $user = Auth::user();
            $resto = Restaurant::find($id); // Use $id directly, not $request->$id
    
            if ($resto && $resto->owner == $user->id) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'country' => 'required',
                    'city' => 'required',
                    'phone' => 'required',
                ]);
    
                $resto->update([
                    'name' => $request->name,
                    'country' => $request->country,
                    'city' => $request->city,
                    'phone' => $request->phone,
                ]);
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Restaurant updated successfully',
                    'restaurant' => $resto,
                ]);
    }
    
}
    }
}