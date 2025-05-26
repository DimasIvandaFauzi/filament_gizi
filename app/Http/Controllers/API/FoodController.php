<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $foods = Food::all();
        \Log::info('Food Data: ', $foods->toArray());
        return response()->json([
            'status' => 'success',
            'data' => $foods,
        ], 200);
    }
}