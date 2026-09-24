<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = ['Laravel', 'Vue.js', 'Tailwind CSS', 'React', 'PHP'];
        foreach ($channels as $channel) {
            Channel::create([
            'name' => $channel,
            'slug' => Str::slug($channel),
        ]);
        }
    }
}
