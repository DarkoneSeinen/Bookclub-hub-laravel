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
        // Get first 3 users as club owners
        $users = User::take(3)->get();

        if ($users->isEmpty()) {
            return;
        }

        // Get some books for readings
        $books = Book::take(5)->get();

        $clubData = [
            [
                'name' => 'Club de Misterio',
                'description' => 'Amantes de las novelas de misterio y suspenso',
                'is_private' => false,
                'max_members' => 20,
            ],
            [
                'name' => 'Club de Fantasía Épica',
                'description' => 'Exploramos mundos de fantasía y aventura épica',
                'is_private' => false,
                'max_members' => 25,
            ],
            [
                'name' => 'Club Secreto de Clásicos',
                'description' => 'Para los que amamos la literatura clásica',
                'is_private' => true,
                'max_members' => 10,
            ],
        ];

        foreach ($clubData as $index => $data) {
            $club = Club::create([
                ...$data,
                'owner_id' => $users[$index]->id,
            ]);

            // Add other users as members
            foreach ($users as $key => $user) {
                if ($user->id !== $club->owner_id && $key !== $index) {
                    $club->members()->attach($user->id, [
                        'role' => rand(0, 1) ? 'member' : 'moderator',
                        'joined_at' => now()->subDays(rand(1, 30)),
                    ]);
                }
            }

            // Add some readings
            if ($books->count() > 0) {
                $book = $books[rand(0, $books->count() - 1)];
                Reading::create([
                    'club_id' => $club->id,
                    'book_id' => $book->id,
                    'status' => 'en_curso',
                    'start_date' => now()->subDays(10),
                    'end_date' => now()->addDays(20),
                ]);
            }
        }
    }
}
