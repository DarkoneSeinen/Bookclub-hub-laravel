<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReceiptController extends Controller
{
    /**
     * Generar PDF del recibo
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
                $subtotal += $itemTotal;
            }
        }

        $tax = round($subtotal * 0.08, 2);
        $shipping = $subtotal > 50 ? 0 : 10;
        $total = $subtotal + $tax + $shipping;

        // Datos para el PDF
        $data = [
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
            'user' => auth()->user(),
            'date' => now()->format('d/m/Y H:i'),
            'receiptNumber' => 'RCP-' . strtoupper(substr(md5(time()), 0, 8)),
        ];

        // Generar PDF
        $pdf = PDF::loadView('receipts.pdf', $data);
        return $pdf->download('recibo-' . date('Y-m-d-His') . '.pdf');
    }
}
