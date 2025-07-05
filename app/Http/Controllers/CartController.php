<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $cart = $this->getUserCart();
            $userId = Auth::id();

            // تنظيف السلة من المنتجات التي تم شراؤها سابقًا
            foreach ($cart->items as $item) {
                $hasPurchased = Order::where('user_id', $userId)
                    ->where('product_id', $item->product_id)
                    ->exists();

                if ($hasPurchased) {
                    $item->delete();
                }
            }

            // تحديث الإجمالي
            $cart->total = $cart->items->sum(function ($item) {
                return $item->quantity * $item->price;
            });
            $cart->save();

        } else {
            // مستخدم غير مسجل: استرجاع السلة من السيشن
            $sessionCartItems = session('cart.items', []);
            $cartItems = collect($sessionCartItems)->map(function ($item) {
                $product = Product::find($item['product_id']);
                return (object)[
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ];
            });

            $cart = (object)[
                'items' => $cartItems,
                'total' => session('cart.total', 0)
            ];
        }

        return view('cart.index', ['cart' => $cart]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if (Auth::check()) {
            $cart = $this->getUserCart();

            $existingOrder = Order::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();

            if ($existingOrder) {
                return redirect()->route('cart.index')->with('error', 'تم شراء المنتج مسبقاً.');
            }

            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                return redirect()->route('cart.index')->with('error', 'المنتج موجود بالفعل في السلة!');
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price
                ]);
            }

            $cart->total = $cart->items->sum(function ($item) {
                return $item->quantity * $item->price;
            });
            $cart->save();

        } else {
            $cartItems = session('cart.items', []);

            foreach ($cartItems as $item) {
                if ($item['product_id'] == $product->id) {
                    return redirect()->route('cart.index')->with('error', 'المنتج موجود بالفعل في السلة!');
                }
            }

            $cartItems[] = [
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ];

            $total = array_sum(array_map(function ($item) {
                return $item['quantity'] * $item['price'];
            }, $cartItems));

            session(['cart.items' => $cartItems, 'cart.total' => $total]);
        }

        return redirect()->route('cart.index')->with('success', 'تمت إضافة المنتج إلى السلة بنجاح!');
    }

    public function remove($itemId)
    {
        if (Auth::check()) {
            $cart = $this->getUserCart();

            $cartItem = $cart->items()->where('id', $itemId)->first();

            if ($cartItem) {
                $cartItem->delete();
            }

            $cart->total = $cart->items->sum(function ($item) {
                return $item->quantity * $item->price;
            });
            $cart->save();

        } else {
            $cartItems = session('cart.items', []);

            // لاحظ هنا: $itemId يمثل product_id عند الضيف
            $cartItems = array_filter($cartItems, function ($item) use ($itemId) {
                return $item['product_id'] != $itemId;
            });

            $total = array_sum(array_map(function ($item) {
                return $item['quantity'] * $item['price'];
            }, $cartItems));

            session(['cart.items' => $cartItems, 'cart.total' => $total]);
        }

        return redirect()->route('cart.index')->with('success', 'تمت إزالة المنتج من السلة بنجاح!');
    }

    private function getUserCart()
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }
}
