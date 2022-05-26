<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channelNames = [
            'Рецепты',
            'Форум php',
            'Книжный клуб',
            'Блог путешествий',
            'Инди-музыка',
            'Философия',
            'Психология',
            'Клуб общения на английском языке',
            'Открытки',
            'Классическая музыка',
            'Продажа музыкальных инструментов',
        ];

        foreach($channelNames as $channelName)
        {
            if (!Channel::query()->where('title', '=', $channelName)->exists()) {
                Channel::create([
                    'title' => $channelName
                ]);
            }
        }
    }
}
