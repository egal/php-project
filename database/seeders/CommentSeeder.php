<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channels = Channel::query()->inRandomOrder()->limit(5)->get();
        $posts = Post::query()->inRandomOrder()->limit(5)->get();
        $faker = Factory::create();

        foreach($channels as $channel)
        {
            Comment::create([
                'content' => $faker->text,
                'commentable_type' => 'channel',
                'commentable_id' => $channel->id
            ]);
        }

        foreach($posts as $post)
        {
            Comment::create([
                'content' => $faker->text,
                'commentable_type' => 'post',
                'commentable_id' => $post->id
            ]);
        }
    }
}
