<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class LikeController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();

        if ($product->isLikedBy($user)) {
            $product->likedUsers()->detach($user->id);
            $liked = false;
        } else {
            $product->likedUsers()->attach($user->id);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $product->likedUsers()->count(),
        ]);
    }
}
