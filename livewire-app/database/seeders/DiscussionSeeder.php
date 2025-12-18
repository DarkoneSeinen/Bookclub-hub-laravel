<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Comment;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $clubs = Club::all();

        foreach ($clubs as $club) {
            $discussionCount = random_int(3, 8);
            
            for ($i = 0; $i < $discussionCount; $i++) {
                $discussion = Discussion::create([
                    'club_id' => $club->id,
                    'book_id' => $club->books()->inRandomOrder()->first()?->id,
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraph(),
                    'created_by' => $users->random()->id,
                    'status' => fake()->randomElement(['activa', 'cerrada']),
                ]);

                // Agregar comentarios anidados
                $commentCount = random_int(2, 6);
                for ($j = 0; $j < $commentCount; $j++) {
                    $rootComment = Comment::create([
                        'discussion_id' => $discussion->id,
                        'user_id' => $users->random()->id,
                        'content' => fake()->paragraph(),
                        'parent_comment_id' => null,
                    ]);

                    // Agregar algunas respuestas a comentarios
                    if (fake()->boolean(70)) {
                        $replyCount = random_int(1, 3);
                        for ($k = 0; $k < $replyCount; $k++) {
                            Comment::create([
                                'discussion_id' => $discussion->id,
                                'user_id' => $users->random()->id,
                                'content' => fake()->paragraph(),
                                'parent_comment_id' => $rootComment->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
