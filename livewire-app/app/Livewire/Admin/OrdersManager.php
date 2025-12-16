<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersManager extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $showDetailModal = false;
    public $selectedOrder = null;
    public $selectedOrderItems = [];

    protected $statuses = [
        'pending' => ['label' => 'Pendiente', 'color' => 'yellow'],
        'processing' => ['label' => 'Procesando', 'color' => 'blue'],
        'completed' => ['label' => 'Completado', 'color' => 'green'],
        'cancelled' => ['label' => 'Cancelado', 'color' => 'red'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function viewOrder($id)
    {
        $this->selectedOrder = Order::with(['user', 'items.book'])->findOrFail($id);
        $this->selectedOrderItems = $this->selectedOrder->items->map(fn($item) => [
            'book_title' => $item->book->title ?? 'Libro eliminado',
            'book_author' => $item->book->author ?? '-',
            'quantity' => $item->quantity,
            'unit_price' => $item->unit_price,
            'subtotal' => $item->subtotal,
        ])->toArray();
        $this->showDetailModal = true;
    }

    public function updateStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);
        session()->flash('message', 'Estado de la orden actualizado correctamente.');
    }

    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->selectedOrder = null;
        $this->selectedOrderItems = [];
    }

    public function render()
    {
        $orders = Order::with('user')
            ->when($this->search, function ($query) {
                $query->where('order_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.orders-manager', [
            'orders' => $orders,
            'statuses' => $this->statuses,
        ])->layout('layouts.app');
    }
}
