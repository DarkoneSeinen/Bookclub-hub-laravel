<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Wishlist;
use Livewire\Component;

class WishlistButton extends Component
{
    public Book $book;
    public bool $isInWishlist = false;

    public function mount()
    {
        if (auth()->check()) {
            $this->isInWishlist = Wishlist::where([
                'user_id' => auth()->id(),
                'book_id' => $this->book->id,
            ])->exists();
        }
    }

    public function toggleWishlist()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($this->isInWishlist) {
            Wishlist::where([
                'user_id' => auth()->id(),
                'book_id' => $this->book->id,
            ])->delete();
            $this->isInWishlist = false;
            session()->flash('message', ' Libro removido de favoritos');
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'book_id' => $this->book->id,
            ]);
            $this->isInWishlist = true;
            session()->flash('message', ' Libro agregado a favoritos');
        }
    }

    public function render()
    {
        return view('livewire.wishlist-button');
    }
}
