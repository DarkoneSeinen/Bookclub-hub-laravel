<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Mostrar carrito
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $bookId => $item) {
            $book = Book::find($bookId);
            if ($book) {
                $cartItems[] = [
                    'book' => $book,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ];
                $total += $item['price'] * $item['quantity'];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Remover item del carrito
     */
    public function destroy($bookId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$bookId]);
        session()->put('cart', $cart);

        return back()->with('message', ' Libro removido del carrito');
    }

    /**
     * Actualizar cantidad
     */
    public function update(Request $request, $bookId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('message', ' Carrito actualizado');
    }

    /**
     * Limpiar carrito
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('message', ' Carrito vaciado');
    }
}
