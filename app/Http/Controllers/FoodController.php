<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Dish_category;
use App\Models\Ingredient;
use App\Models\Ingredient_category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('food/Index', [
            'dishes' => Dish::with(['dish_categories', 'ingredients'])->take(6)->get(),
            'ingredient_categories' => Ingredient_category::all(),
            'dish_categories' => Dish_category::all(),
            'ingredients' => Ingredient::with(['providers', 'providers.cities'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function structure()
    {
        return Inertia::render('structure-menu/Index', [
            'categories' => Dish_category::all()
        ]);
    }
}
