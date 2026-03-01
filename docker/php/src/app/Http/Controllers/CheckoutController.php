<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;

class CheckoutController extends Controller
{
    public function checkout(PurchaseRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $paymentMethod = $request->get('payment_method');

        if ($product->is_sold) {
            abort(403, '売り切れです');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => [$paymentMethod],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'customer_email' => auth()->user()->email,
            'success_url' => url('/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/cancel'),
            'metadata' => ['product_id' => $product->id],
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $session_id = $request->query('session_id');

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::retrieve($session_id);

        if (!Purchase::where('stripe_session_id', $session->id)->exists()) {
            Purchase::create([
                'user_id' => auth()->id(),
                'product_id' => $session->metadata->product_id,
                'stripe_session_id' => $session->id,
                'amount' => $session->amount_total,
            ]);

            Product::where('id', $session->metadata->product_id)->update(['is_sold' => true]);
        }

        return redirect()->route('products.list');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
