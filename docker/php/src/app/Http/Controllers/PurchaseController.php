<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
    public function purchase($item_id)
    {
        $product = Product::find($item_id);
        $userId = Auth::id();
        $user = User::find($userId);

        return view('purchase', compact('product', 'user'));
    }

    public function edit($user_id, $product_id)
    {
        $user = User::find($user_id);

        $productId = $product_id;

        return view('edit', compact('user', 'productId'));
    }

    public function update(AddressRequest $request, $item_id)
    {
        $userId = Auth::id();

        $address_data = $request->only(['postal_code', 'address', 'building']);
        User::find($userId)->update($address_data);

        $product = Product::find($item_id);
        $userId = Auth::id();
        $user = User::find($userId);

        return view('purchase', compact('product', 'user'));
    }
}