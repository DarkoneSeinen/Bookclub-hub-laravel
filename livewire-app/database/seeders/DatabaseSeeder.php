<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario de prueba
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Crear artículos
        Article::factory(20)
            ->recycle($user)
            ->create();
        
        Article::factory(20)->create();

        // Ejecutar seeders del módulo de libros
        $this->call([
            BookSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
