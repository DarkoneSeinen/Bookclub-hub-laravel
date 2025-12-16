<?php

namespace App\Livewire\Admin;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class BooksManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $bookId = null;
    
    // Form fields
    public $title = '';
    public $author = '';
    public $isbn = '';
    public $description = '';
    public $price = 0;
    public $pages = 0;
    public $published_year = '';
    public $genres = '';
    public $cover_image = '';
    public $newCoverImage;
    
    protected $rules = [
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'isbn' => 'required|string|max:20',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'pages' => 'nullable|integer|min:0',
        'published_year' => 'nullable|integer|min:1800|max:2030',
        'genres' => 'nullable|string',
        'newCoverImage' => 'nullable|image|max:2048',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $book = Book::findOrFail($id);
        $this->bookId = $book->id;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->isbn = $book->isbn;
        $this->description = $book->description;
        $this->price = $book->price;
        $this->pages = $book->pages;
        $this->published_year = $book->published_year;
        $this->genres = is_array($book->genres) ? implode(', ', $book->genres) : $book->genres;
        $this->cover_image = $book->cover_image;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'description' => $this->description,
            'price' => $this->price,
            'pages' => $this->pages,
            'published_year' => $this->published_year,
            'genres' => array_map('trim', explode(',', $this->genres)),
        ];

        // Handle cover image
        if ($this->newCoverImage) {
            $data['cover_image'] = $this->newCoverImage->store('covers', 'public');
        } elseif (!$this->editMode) {
            $data['cover_image'] = 'https://placehold.co/300x450?text=' . urlencode($this->title);
        }

        if ($this->editMode) {
            $book = Book::findOrFail($this->bookId);
            $book->update($data);
            session()->flash('message', 'Libro actualizado correctamente.');
        } else {
            Book::create($data);
            session()->flash('message', 'Libro creado correctamente.');
        }

        $this->closeModal();
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        session()->flash('message', 'Libro eliminado correctamente.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->bookId = null;
        $this->title = '';
        $this->author = '';
        $this->isbn = '';
        $this->description = '';
        $this->price = 0;
        $this->pages = 0;
        $this->published_year = date('Y');
        $this->genres = '';
        $this->cover_image = '';
        $this->newCoverImage = null;
        $this->resetValidation();
    }

    public function render()
    {
        $books = Book::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('author', 'like', '%' . $this->search . '%')
                    ->orWhere('isbn', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.books-manager', compact('books'))
            ->layout('layouts.app');
    }
}
