<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $book = $review->book;
        $review->delete();

        // Actualizar rating del libro
        $avgRating = $book->reviews->avg('rating');
        $count = $book->reviews->count();

        $book->update([
            'rating_avg' => $avgRating,
            'review_count' => $count,
        ]);

        return back()->with('message', ' Reseña eliminada');
    }
}
