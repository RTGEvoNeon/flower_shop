<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $product->price * $details['quantity']
                ];
                $total += $product->price * $details['quantity'];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        $product = Product::findOrFail($productId);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Товар добавлен в корзину',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    public function update(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        $cart = session()->get('cart', []);
        
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $quantity;
        }
        
        session()->put('cart', $cart);
        
        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);
        
        unset($cart[$productId]);
        session()->put('cart', $cart);
        
        return response()->json(['success' => true]);
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $product->price * $details['quantity']
                ];
                $total += $product->price * $details['quantity'];
            }
        }

        if (empty($cartItems)) {
            return redirect('/')->with('error', 'Корзина пуста');
        }

        return view('cart.checkout', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'delivery_address' => 'required|string|max:500',
            'delivery_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:1000'
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect('/')->with('error', 'Корзина пуста');
        }

        try {
            DB::beginTransaction();

            // Создаем заказ
            $total = 0;
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    $total += $product->price * $details['quantity'];
                }
            }

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'delivery_address' => $request->delivery_address,
                'delivery_date' => $request->delivery_date,
                'notes' => $request->notes,
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            // Создаем позиции заказа
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $details['quantity'],
                        'price' => $product->price
                    ]);
                }
            }

            DB::commit();

            // Очищаем корзину
            session()->forget('cart');

            return redirect()->route('order.success', $order->id)
                ->with('success', 'Заказ успешно оформлен!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Произошла ошибка при оформлении заказа');
        }
    }

    public function orderSuccess($orderId)
    {
        $order = Order::with('orderItems.product')->findOrFail($orderId);
        return view('cart.success', compact('order'));
    }
}
