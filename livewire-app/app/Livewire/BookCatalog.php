<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class BookCatalog extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public array $selectedGenres = [];

    #[Url]
    public string $sortBy = 'latest';

    #[Url]
    public string $priceRange = 'all';

    public array $availableGenres = [];

    public function mount()
    {
        // Obtener todos los géneros disponibles
        $this->availableGenres = Book::all()
            ->pluck('genres')
            ->flatten()
            ->unique()
            ->values()
            ->toArray();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedGenres()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedPriceRange()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedGenres = [];
        $this->sortBy = 'latest';
        $this->priceRange = 'all';
        $this->resetPage();
    }

    public function render()
    {
        $query = Book::query();

        // Búsqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('author', 'like', "%{$this->search}%")
                  ->orWhere('isbn', 'like', "%{$this->search}%");
            });
        }

        // Filtro por géneros
        if (!empty($this->selectedGenres)) {
            $query->where(function ($q) {
                foreach ($this->selectedGenres as $genre) {
                    $q->orWhereJsonContains('genres', $genre);
                }
            });
        }

        // Filtro por precio
        if ($this->priceRange === 'cheap') {
            $query->whereHas('inventory', fn($q) => $q->where('price', '<=', 15));
        } elseif ($this->priceRange === 'medium') {
            $query->whereHas('inventory', fn($q) => $q->whereBetween('price', [15, 30]));
        } elseif ($this->priceRange === 'expensive') {
            $query->whereHas('inventory', fn($q) => $q->where('price', '>', 30));
        }

        // Ordenamiento
        match ($this->sortBy) {
            'price-asc' => $query->join('book_inventory', 'books.id', '=', 'book_inventory.book_id')
                                  ->orderBy('book_inventory.price', 'asc')
                                  ->select('books.*'),
            'price-desc' => $query->join('book_inventory', 'books.id', '=', 'book_inventory.book_id')
                                   ->orderBy('book_inventory.price', 'desc')
                                   ->select('books.*'),
            'rating' => $query->orderBy('rating_avg', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $books = $query->paginate(9);

        return view('livewire.book-catalog', [
            'books' => $books,
        ]);
    }
}
