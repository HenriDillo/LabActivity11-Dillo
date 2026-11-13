<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::query()->create([
            'name' => 'Kagawad Henri James Dillo',
            'position' => 'Kagawad',
            'email' => 'kagawad.dillo@bulletin.test',
        ]);

        Author::factory()->count(4)->create();
    }
}
