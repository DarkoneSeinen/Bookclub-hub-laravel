<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class CartManager extends Component
{
    public Book $book;
    public int $quantity = 1;

    protected $rules = [
        'quantity' => 'required|integer|min:1|max:10',
    ];

    public function addToCart()
    {
        $this->validate();

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!$this->book->isAvailable()) {
            session()->flash('error', 'Este libro no está disponible');
            return;
        }

        // Obtener o crear carrito en sesión
        $cart = session()->get('cart', []);

        if (isset($cart[$this->book->id])) {
            $cart[$this->book->id]['quantity'] += $this->quantity;
        } else {
            $cart[$this->book->id] = [
                'book_id' => $this->book->id,
                'quantity' => $this->quantity,
                'price' => $this->book->getDiscountedPrice(),
            ];
        }

        session()->put('cart', $cart);
        session()->flash('message', ' Libro agregado al carrito!');
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart-manager');
    }
}
