<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Http\Request\OrderStoreRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends AbstractController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(OrderStoreRequest $request)
    {
        $order = Order::create($request->merge(['user_id' => auth()->user()->id])->all());

        $carts = Cart::where('user_id', auth()->user()->id)
            ->get();

        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'product_unit_price' => $cart->product->price,
                'quantity' => $cart->quantity
            ]);
        }

        Cart::where('user_id', auth()->user()->id)->delete();

        if (!$order) {
            return redirect(route('home'))->with('error', __('Not Saved!'));
        }

        return redirect(route('home'))->with('success', __('Saved!'));
    }
}
