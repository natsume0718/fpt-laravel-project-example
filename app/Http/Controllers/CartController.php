<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Http\Request\CartAddItemRequest;
use App\Models\Cart;

class CartController extends AbstractController
{
    /**
     * @param CartAddItemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function addItem(CartAddItemRequest $request)
    {
        $cart = Cart::where('user_id', auth()->user()->id)
            ->where('product_id', $request->get('product_id'))
            ->first();

        if (empty($cart)) {
            Cart::create($request->merge(['user_id' => auth()->user()->id])->all());
        } else {
            $cart->quantity += $request->get('quantity');
            if ($cart->quantity == 0) {
                $cart->delete();
            } else {
                $cart->save();
            }
        }

        return redirect(route('carts.index'))->with('success', __('Saved!'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $models = Cart::where('user_id', auth()->user()->id)
            ->get();

        return view('carts', [
            'models' => $models,
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        $model = Cart::findOrFail($id);

        $isDeleted = $model->delete();

        if (!$isDeleted) {
            return redirect()->back()->with('error', __('Not Deleted!'));
        }

        return redirect()->back()->with('success', __('Deleted!'));
    }
}
