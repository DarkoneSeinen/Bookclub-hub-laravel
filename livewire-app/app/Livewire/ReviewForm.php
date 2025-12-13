<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Review;
use Livewire\Component;

class ReviewForm extends Component
{
    public Book $book;
    public int $rating = 5;
    public string $title = '';
    public string $content = '';
    public bool $showForm = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'title' => 'required|string|max:255',
        'content' => 'required|string|max:1000',
    ];

    public function submitReview()
    {
        $this->validate();

        Review::create([
            'user_id' => auth()->id(),
            'book_id' => $this->book->id,
            'rating' => $this->rating,
            'title' => $this->title,
            'content' => $this->content,
        ]);

        // Actualizar rating del libro
        $this->updateBookRating();

        session()->flash('message', ' Reseña publicada exitosamente!');
        $this->resetForm();
        $this->dispatch('reviewAdded');
    }

    private function updateBookRating()
    {
        $reviews = $this->book->reviews;
        $avgRating = $reviews->avg('rating');
        $count = $reviews->count();

        $this->book->update([
            'rating_avg' => $avgRating,
            'review_count' => $count,
        ]);
    }

    private function resetForm()
    {
        $this->rating = 5;
        $this->title = '';
        $this->content = '';
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
