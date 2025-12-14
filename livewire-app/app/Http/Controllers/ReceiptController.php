<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use PDF;
use Illuminate\Support\Str;

class ReceiptController extends Controller
{
    /**
     * Generar PDF del recibo y guardar orden
     */
    public function generatePDF()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío');
        }

        // Calcular totales
        $items = [];
        $subtotal = 0;
        $orderItems = [];

        foreach ($cart as $bookId => $cartItem) {
            $book = \App\Models\Book::find($bookId);
            if ($book) {
                $quantity = (int) $cartItem['quantity'];
                $price = (float) $cartItem['price'];
                $itemTotal = $price * $quantity;
                
                $items[] = [
                    'title' => $book->title,
                    'author' => $book->author,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $itemTotal,
                ];
                
                $orderItems[$bookId] = [
                    'quantity' => $quantity,
                    'price' => $price,
                ];
                
                $subtotal += $itemTotal;
            }
        }

        $tax = round($subtotal * 0.08, 2);
        $shipping = $subtotal > 50 ? 0 : 10;
        $total = $subtotal + $tax + $shipping;
        $receiptNumber = 'RCP-' . strtoupper(substr(md5(time()), 0, 8));

        // Datos para el PDF
        $data = [
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
            'user' => auth()->user(),
            'date' => now()->format('d/m/Y H:i'),
            'receiptNumber' => $receiptNumber,
        ];

        // Crear orden en BD
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . Str::upper(Str::random(8)),
            'total_price' => $total,
            'status' => 'pending',
            'payment_method' => 'manual',
            'shipping_address' => 'A definir',
        ]);

        // Crear items de la orden
        foreach ($orderItems as $bookId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $bookId,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        // Limpiar carrito
        session()->forget('cart');

        // Generar PDF
        $pdf = PDF::loadView('receipts.pdf', $data);
        
        // Guardar PDF temporalmente y redirigir a confirmación
        session()->put('order_id', $order->id);
        session()->put('receipt_data', $data);
        
        return $pdf->download('recibo-' . date('Y-m-d-His') . '.pdf');
    }

    /**
     * Mostrar página de confirmación
     */
    public function confirmation()
    {
        $orderId = session()->get('order_id');
        
        if (!$orderId) {
            return redirect()->route('cart.index');
        }

        $order = Order::find($orderId);
        
        if (!$order || $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.confirmation', compact('order'));
    }
}
