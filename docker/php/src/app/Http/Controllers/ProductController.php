<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    public function products(Request $request)
    {
        $query = Product::query();

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        if ($request->filled('mylist')) {
            if (!auth()->check()) {
                return redirect('/login');
            }

            $userId = Auth::id();

            $query->whereHas('likes', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        $products = $query->get();

        return view('products', compact('products'));
    }

    public function detail($item_id)
    {
        $product = Product::with('categories')->find($item_id);

        $condition = [
            'good' => '良好',
            'excellent' => '目立った傷や汚れなし',
            'fair' => 'やや傷や汚れあり',
            'poor' => '状態が悪い',
        ];
        $displayCondition = $condition[$product->condition];

        $product->load([
            'comments.user',
        ])->loadCount('comments');

        return view('detail', compact('product', 'displayCondition'));
    }

}
