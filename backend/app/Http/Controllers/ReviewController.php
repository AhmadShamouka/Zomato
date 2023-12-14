<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    public function show_review()
    { 
         if (Auth::check()){
        $review = Review::find(Auth::user()->id);
        if (!$review) {
            return response()->json([
                'status' => 'error',
                'message' => 'Review not found',
            ]);
        }
        return response()->json([
            'status' => 'success',
            'review' => $review,
        ]);
    }
    }
    public function create_review(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->owner == 0) {
            $user = Auth::user();
    
            $request->validate([
                'rate' => 'required|integer|min:1|max:5',
            ]);
    
            $review = Review::create([
                'users_id' => $user->id,
                'rate' => $request->rate,
                'restaurants_id' => $id,
            ]);
    
            return response()->json([
                'status' => 'success',
                'review' => $review,
            ], 201);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Permission denied or invalid user type.',
            ]);
        }
    }
    
    
}