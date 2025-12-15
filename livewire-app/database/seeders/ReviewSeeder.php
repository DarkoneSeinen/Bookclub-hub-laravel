<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $books = Book::all();

        $reviews = [
            ['rating' => 5, 'title' => 'Una obra maestra absoluta', 'content' => 'El Quijote es simplemente magistral. Una novela que todo el mundo debería leer.'],
            ['rating' => 5, 'title' => 'Perfecto', 'content' => 'Una de las mejores historias de amor jamás escritas. Austen es genial.'],
            ['rating' => 5, 'title' => 'Increíble', 'content' => 'Cien años de soledad es una obra de arte. Mágico y profundo.'],
            ['rating' => 4, 'title' => 'Muy bueno', 'content' => 'Dune es épico, aunque es un poco largo. Recomendado para fans de ciencia ficción.'],
            ['rating' => 5, 'title' => 'Distopía aterradora', 'content' => '1984 es perturbador y fascinante. Orwell fue un genio visionario.'],
            ['rating' => 4, 'title' => 'Excelente misterio', 'content' => 'El Asesinato de Roger Ackroyd me tuvo enganchado de principio a fin.'],
            ['rating' => 5, 'title' => 'Epopeya de fantasía', 'content' => 'El Señor de los Anillos es simplemente extraordinario. Tolkien creó un mundo completo.'],
            ['rating' => 5, 'title' => 'Magia desde el primer momento', 'content' => 'Harry Potter te atrapa desde la primera página. Perfecto para todas las edades.'],
            ['rating' => 4, 'title' => 'Práctico y motivador', 'content' => 'Hábitos Atómicos me ha ayudado a cambiar mi vida. Muy recomendado.'],
            ['rating' => 4, 'title' => 'Transformador', 'content' => 'El Poder del Ahora cambió mi perspectiva sobre la vida. Profundo y accesible.'],
            ['rating' => 5, 'title' => 'Saga familiar épica', 'content' => 'La Casa de los Espíritus es una novela hermosa que abarca generaciones.'],
            ['rating' => 4, 'title' => 'Thriller psicológico fascinante', 'content' => 'La Chica del Tren es adictiva. Un giro final que no esperas.'],
        ];

        if ($users->isEmpty() || $books->isEmpty()) {
            $this->command->warn('⚠️  No hay usuarios o libros para crear reseñas. Ejecuta los seeders correspondientes primero.');
            return;
        }

        $usersArray = $users->toArray();
        $booksArray = $books->toArray();
        
        // Crear reseñas sin repetir combinación user-book
        foreach ($reviews as $index => $review) {
            $userId = $usersArray[$index % count($usersArray)]['id'];
            $bookId = $booksArray[$index % count($booksArray)]['id'];
            
            // Verificar que no exista ya esta reseña
            if (!\App\Models\Review::where('user_id', $userId)->where('book_id', $bookId)->exists()) {
                Review::create([
                    'user_id' => $userId,
                    'book_id' => $bookId,
                    'rating' => $review['rating'],
                    'title' => $review['title'],
                    'content' => $review['content'],
                    'helpful_count' => rand(0, 50),
                ]);
            }
        }

        $this->command->info('✅ ' . count($reviews) . ' reseñas creadas exitosamente!');
    }
}
