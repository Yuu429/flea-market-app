<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\ExhibitionRequest;

class SellController extends Controller
{
    public function sell()
    {
        $categories = Category::select('id', 'name')->get();

        return view('sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $userId = Auth::id();
        $imagePath = $request->file('img_url')->store('img_url', 'public');
        $productData = $request->only(['condition', 'name', 'brand', 'description', 'price']);

        $store = Product::create([
            'user_id' => $userId,
            'name' => $productData['name'],
            'price' => $productData['price'],
            'brand' => $productData['brand'],
            'description' => $productData['description'],
            'img_url' => $imagePath,
            'condition' => $productData['condition'],
        ]);

        $categories = $request->only('categories');
        foreach($categories as $category) {
            $store->categories()->attach($category);
        }

        return redirect('/');
    }
}
