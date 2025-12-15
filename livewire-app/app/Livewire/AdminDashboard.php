<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $totalOrders = 0;
    public $totalRevenue = 0;
    public $totalUsers = 0;
    public $totalBooks = 0;
    public $recentOrders = [];
    public $topBooks = [];

    public function mount()
    {
        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        // Estadísticas generales
        $this->totalOrders = Order::count();
        $this->totalRevenue = Order::sum('total_price');
        $this->totalUsers = User::where('role', '!=', 'admin')->count();
        $this->totalBooks = Book::count();

        // Últimas 5 órdenes
        $this->recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($order) => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'customer' => $order->user->name,
                'total' => $order->total_price,
                'status' => $order->status,
                'created_at' => $order->created_at->format('d/m/Y H:i'),
            ])
            ->toArray();

        // Top 5 libros más vendidos
        $this->topBooks = Book::with('orderItems')
            ->get()
            ->map(fn($book) => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'sold' => $book->orderItems->count(),
                'revenue' => $book->orderItems->sum(fn($item) => $item->subtotal),
            ])
            ->sortByDesc('sold')
            ->take(5)
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin-dashboard')->layout('layouts.app');
    }
}
