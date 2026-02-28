<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function mypage(Request $request)
    {
        $userId = Auth::id();

        $userData = User::find($userId);

        $page = $request->query('page', 'sell');

        if ($page === 'sell') {
            $products = Product::where('user_id', $userId)->get();
        } else {
            $products = Purchase::with('product')->where('user_id', $userId)->get();
        }
        return view('mypage', compact('userData', 'page', 'products'));
    }


    public function profile(Request $request)
    {
        $userId = Auth::id();
        $userData = User::find($userId);

        return view('profile', compact('userData'));
    }

    public function store(ProfileRequest $request)
    {
        $imagePath = 'flea-market-image/default_icon.png';

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('avatar', 'public');
        }

        $userId = Auth::id();
        $user = User::find($userId);

        $profile = $request->only(['name', 'postal_code', 'address', 'building']);

        $userData = array_merge($profile, [
            'profile_image' => $imagePath,
        ]);


        $user->update($userData);

        $products = Product::get();

        return view('products', compact('products'));
    }
}
