<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\VotingPeriod;
use App\Models\VotingCandidate;
use App\Models\Vote;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VotingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos clubs y libros
        $clubs = Club::limit(3)->get();
        $books = Book::inRandomOrder()->limit(20)->get();
        $users = User::limit(10)->get();

        if ($clubs->isEmpty() || $books->count() < 5 || $users->isEmpty()) {
            $this->command->warn('No hay suficientes clubs, libros o usuarios para crear votaciones');
            return;
        }

        $clubs->each(function ($club) use ($books, $users) {
            // Votación activa
            $activePeriod = VotingPeriod::create([
                'club_id' => $club->id,
                'title' => 'Próximo Libro: Abril',
                'description' => 'Elige el libro que queremos leer el próximo mes.',
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(10),
                'status' => 'activa',
            ]);

            // Agregar candidatos (5 libros aleatorios)
            $candidateBooks = $books->random(min(5, $books->count()));

            foreach ($candidateBooks as $book) {
                // Crear el candidato
                VotingCandidate::create([
                    'voting_period_id' => $activePeriod->id,
                    'book_id' => $book->id,
                ]);

                // 1-10 votos por libro
                $voteCount = rand(1, min(10, $users->count()));
                $voters = $users->random($voteCount);

                foreach ($voters as $voter) {
                    // Evitar duplicados
                    if (!Vote::where('voting_period_id', $activePeriod->id)
                        ->where('user_id', $voter->id)
                        ->exists()) {
                        Vote::create([
                            'voting_period_id' => $activePeriod->id,
                            'user_id' => $voter->id,
                            'book_id' => $book->id,
                        ]);
                    }
                }
            }

            // Votación cerrada (completada con ganador)
            $completedPeriod = VotingPeriod::create([
                'club_id' => $club->id,
                'title' => 'Ganador: Marzo',
                'description' => 'Se completó la votación del mes pasado.',
                'start_date' => Carbon::now()->subDays(45),
                'end_date' => Carbon::now()->subDays(30),
                'status' => 'completada',
            ]);

            // Agregar candidatos y votos (completado)
            $completedBooks = $books->random(min(5, $books->count()));

            $winnerBook = null;
            $maxVotes = 0;

            foreach ($completedBooks as $book) {
                // Crear candidato
                VotingCandidate::create([
                    'voting_period_id' => $completedPeriod->id,
                    'book_id' => $book->id,
                ]);

                $voteCount = rand(3, min(15, $users->count()));
                $voters = $users->random($voteCount);

                foreach ($voters as $voter) {
                    if (!Vote::where('voting_period_id', $completedPeriod->id)
                        ->where('user_id', $voter->id)
                        ->exists()) {
                        Vote::create([
                            'voting_period_id' => $completedPeriod->id,
                            'user_id' => $voter->id,
                            'book_id' => $book->id,
                        ]);

                        if ($voteCount > $maxVotes) {
                            $maxVotes = $voteCount;
                            $winnerBook = $book;
                        }
                    }
                }
            }

            // Marcar ganador
            if ($winnerBook) {
                $completedPeriod->update(['winner_book_id' => $winnerBook->id]);
            }
        });

        $this->command->info('✓ Votaciones creadas exitosamente');
    }
}
