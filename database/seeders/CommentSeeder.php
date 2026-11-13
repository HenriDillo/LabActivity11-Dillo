<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::query()->get();

        foreach (Post::query()->where('is_published', true)->get() as $post) {
            $count = rand(0, 5);

            for ($i = 0; $i < $count; $i++) {
                $post->comments()->save(Comment::factory()->make([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]));
            }
        }

        $pinned = Post::query()->where('title', 'Purok Dillo Clean-up Drive')->firstOrFail();
        $lola = User::query()->where('email', 'lola.dillo@bulletin.test')->firstOrFail();

        $pinned->comments()->create([
            'user_id' => $lola->id,
            'body' => 'This is a great idea for our purok. Let us all join the clean-up drive.',
        ]);

        $pinned->comments()->create([
            'user_id' => $users->random()->id,
            'body' => 'Thank you to the barangay officials for organizing this activity.',
        ]);

        $pinned->comments()->create([
            'user_id' => $users->random()->id,
            'body' => 'I will bring my gloves and sacks to help out tomorrow.',
        ]);
    }
}
