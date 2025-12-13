<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookInventory;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            // Clásicos
            [
                'title' => 'El Quijote',
                'author' => 'Miguel de Cervantes',
                'isbn' => '978-8499056951',
                'description' => 'La novela del famoso hidalgo que se convierte en caballero andante.',
                'pages' => 1037,
                'published_year' => 1605,
                'genres' => ['Clásico', 'Aventura', 'Ficción'],
                'price' => 29.99,
                'quantity' => 15,
            ],
            [
                'title' => 'Orgullo y Prejuicio',
                'author' => 'Jane Austen',
                'isbn' => '978-8497592611',
                'description' => 'Una novela romántica sobre Elizabeth Bennet y Mr. Darcy.',
                'pages' => 432,
                'published_year' => 1813,
                'genres' => ['Romance', 'Clásico'],
                'price' => 18.99,
                'quantity' => 20,
            ],
            [
                'title' => 'Cien Años de Soledad',
                'author' => 'Gabriel García Márquez',
                'isbn' => '978-8401405389',
                'description' => 'La epopeya de la familia Buendía en el pueblo mágico de Macondo.',
                'pages' => 471,
                'published_year' => 1967,
                'genres' => ['Realismo Mágico', 'Ficción', 'Clásico Latinoamericano'],
                'price' => 22.50,
                'quantity' => 18,
            ],

            // Ciencia Ficción
            [
                'title' => 'Dune',
                'author' => 'Frank Herbert',
                'isbn' => '978-8499089720',
                'description' => 'Una epopeya espacial en el planeta desértico de Arrakis.',
                'pages' => 688,
                'published_year' => 1965,
                'genres' => ['Ciencia Ficción', 'Aventura'],
                'price' => 24.99,
                'quantity' => 25,
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'isbn' => '978-8483065044',
                'description' => 'Una distopía sobre un régimen totalitario omnisciente.',
                'pages' => 328,
                'published_year' => 1949,
                'genres' => ['Ciencia Ficción', 'Distopía'],
                'price' => 15.99,
                'quantity' => 22,
            ],

            // Misterio
            [
                'title' => 'El Asesinato de Roger Ackroyd',
                'author' => 'Agatha Christie',
                'isbn' => '978-8401401682',
                'description' => 'Un misterio detectivesco protagonizado por Hércules Poirot.',
                'pages' => 320,
                'published_year' => 1926,
                'genres' => ['Misterio', 'Thriller'],
                'price' => 16.50,
                'quantity' => 12,
            ],

            // Fantasía
            [
                'title' => 'El Señor de los Anillos',
                'author' => 'J.R.R. Tolkien',
                'isbn' => '978-8445074770',
                'description' => 'La epopeya de la Tierra Media y la búsqueda del Anillo Único.',
                'pages' => 1144,
                'published_year' => 1954,
                'genres' => ['Fantasía', 'Aventura', 'Clásico'],
                'price' => 35.99,
                'quantity' => 30,
            ],
            [
                'title' => 'Harry Potter y la Piedra Filosofal',
                'author' => 'J.K. Rowling',
                'isbn' => '978-8498382709',
                'description' => 'Un joven mago descubre su legado y la verdad sobre su pasado.',
                'pages' => 309,
                'published_year' => 1997,
                'genres' => ['Fantasía', 'Infantil', 'Aventura'],
                'price' => 18.99,
                'quantity' => 40,
            ],

            // Desarrollo Personal
            [
                'title' => 'Hábitos Atómicos',
                'author' => 'James Clear',
                'isbn' => '978-8401424266',
                'description' => 'Estrategias prácticas para mejorar tus hábitos diarios.',
                'pages' => 432,
                'published_year' => 2018,
                'genres' => ['Desarrollo Personal', 'No-ficción'],
                'price' => 19.99,
                'quantity' => 28,
            ],
            [
                'title' => 'El Poder del Ahora',
                'author' => 'Eckhart Tolle',
                'isbn' => '978-8497597777',
                'description' => 'Una guía para vivir en el presente y transformar tu vida.',
                'pages' => 288,
                'published_year' => 1997,
                'genres' => ['Espiritualidad', 'Desarrollo Personal'],
                'price' => 17.50,
                'quantity' => 16,
            ],

            // Novelas Contemporáneas
            [
                'title' => 'La Casa de los Espíritus',
                'author' => 'Isabel Allende',
                'isbn' => '978-8401402076',
                'description' => 'La saga de la familia Trueba a través de varias generaciones.',
                'pages' => 449,
                'published_year' => 1982,
                'genres' => ['Ficción', 'Realismo Mágico'],
                'price' => 20.99,
                'quantity' => 14,
            ],
            [
                'title' => 'La Chica del Tren',
                'author' => 'Paula Hawkins',
                'isbn' => '978-8401405369',
                'description' => 'Un thriller psicológico sobre una mujer que presencia un crimen.',
                'pages' => 424,
                'published_year' => 2015,
                'genres' => ['Thriller', 'Misterio'],
                'price' => 16.99,
                'quantity' => 26,
            ],
        ];

        foreach ($books as $bookData) {
            $price = $bookData['price'];
            unset($bookData['price']);
            $quantity = $bookData['quantity'];
            unset($bookData['quantity']);

            $book = Book::create($bookData);

            // Crear inventario
            BookInventory::create([
                'book_id' => $book->id,
                'quantity_available' => $quantity,
                'quantity_sold' => 0,
                'price' => $price,
                'discount_percentage' => 0,
                'format' => 'physical',
            ]);
        }

        $this->command->info('✅ 12 libros y sus inventarios creados exitosamente!');
    }
}
