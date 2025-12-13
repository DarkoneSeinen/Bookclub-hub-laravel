<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Ver wishlist
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $wishlistItems = auth()->user()->wishlists()->with('book')->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Remover de wishlist
     */
    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->delete();

        return back()->with('message', 'Libro removido de favoritos');
    }
}
