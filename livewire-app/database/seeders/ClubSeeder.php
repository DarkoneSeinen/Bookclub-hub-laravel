<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\User;
use App\Models\Book;
use App\Models\Reading;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $users = User::take(5)->get();

        if ($users->count() < 3) {
            return;
        }

        // Get books
        $books = Book::inRandomOrder()->take(10)->get();

        if ($books->isEmpty()) {
            return;
        }

        $clubsData = [
            [
                'name' => 'Club de Misterio y Suspenso',
                'description' => 'Un club dedicado a los amantes de las novelas de misterio, suspenso y crimen. Compartimos teorías, debatimos giros inesperados y recomendamos nuestros thrillers favoritos.',
                'is_private' => false,
                'max_members' => 20,
            ],
            [
                'name' => 'Club de Fantasía Épica',
                'description' => 'Exploramos mundos de fantasía, magia y aventura épica. Desde clásicos como Tolkien hasta nuevos autores, aquí celebramos la imaginación sin límites.',
                'is_private' => false,
                'max_members' => 25,
            ],
            [
                'name' => 'Club Secreto de Clásicos',
                'description' => 'Para los que amamos la literatura clásica. Discutimos obras de autores atemporales y su relevancia en la actualidad.',
                'is_private' => true,
                'max_members' => 10,
            ],
            [
                'name' => 'Club de Ciencia Ficción',
                'description' => 'Viajamos a través del tiempo y el espacio con historias de ciencia ficción. Distopías, viajes espaciales y tecnología futura.',
                'is_private' => false,
                'max_members' => 30,
            ],
            [
                'name' => 'Club de Romance y Novelas Contemporáneas',
                'description' => 'Celebramos historias de amor, relaciones y emociones. Romance, contemporáneo y drama reunidos en un solo lugar.',
                'is_private' => false,
                'max_members' => 35,
            ],
        ];

        foreach ($clubsData as $index => $data) {
            $owner = $users[$index % $users->count()];
            
            $club = Club::create([
                ...$data,
                'owner_id' => $owner->id,
            ]);

            // Add other users as members with random roles
            foreach ($users as $key => $user) {
                if ($user->id !== $club->owner_id) {
                    $roles = ['member', 'member', 'member', 'moderator'];
                    $role = $roles[array_rand($roles)];
                    
                    $club->members()->attach($user->id, [
                        'role' => $role,
                        'joined_at' => now()->subDays(rand(1, 60)),
                    ]);
                }
            }

            // Add 2-4 readings to each club
            $clubBooks = $books->random(min(4, $books->count()));
            $statuses = ['planeado', 'en_curso', 'completado'];
            
            foreach ($clubBooks->take(rand(2, 4)) as $book) {
                $status = $statuses[array_rand($statuses)];
                $startDate = now()->subDays(rand(5, 60));
                
                Reading::create([
                    'club_id' => $club->id,
                    'book_id' => $book->id,
                    'status' => $status,
                    'start_date' => $status === 'planeado' ? null : $startDate,
                    'end_date' => $status === 'completado' ? $startDate->addDays(rand(14, 30)) : ($status === 'en_curso' ? $startDate->addDays(rand(10, 20)) : null),
                ]);
            }
        }
    }
}
