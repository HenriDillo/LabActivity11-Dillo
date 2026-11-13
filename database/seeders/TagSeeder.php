<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Purok Dillo', 'Urgent', 'Libre', 'Schedule', 'Health'] as $name) {
            Tag::query()->firstOrCreate(['name' => $name]);
        }

        $tags = Tag::query()->get();

        foreach (Post::query()->get() as $post) {
            if ($post->is_pinned) {
                $post->tags()->sync($tags->whereIn('name', ['Purok Dillo', 'Urgent'])->modelKeys());

                continue;
            }

            $post->tags()->sync($tags->random(rand(1, 3))->modelKeys());
        }
    }
}
