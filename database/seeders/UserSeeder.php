<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'lola.dillo@bulletin.test'],
            [
                'name' => 'Lola Dillo',
                'password' => Hash::make('bulletin2026'),
                'email_verified_at' => now(),
            ]
        );

        User::query()->firstOrCreate(
            ['email' => 'kagawad.dillo@bulletin.test'],
            [
                'name' => 'Kagawad Henri James Dillo',
                'password' => Hash::make('bulletin2026'),
                'email_verified_at' => now(),
            ]
        );

        User::factory()->count(8)->create();

        $kagawad = User::query()->where('email', 'kagawad.dillo@bulletin.test')->firstOrFail();
        $kagawadAuthor = Author::query()->where('email', $kagawad->email)->firstOrFail();
        $kagawadAuthor->user()->associate($kagawad);
        $kagawadAuthor->save();
    }
}
