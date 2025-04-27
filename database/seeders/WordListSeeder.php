<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\support\Facades\File;
use App\Models\Word;


class WordListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        // Path to Json file
        $json = File::get(database_path("seeders/data/newJPWordList.json"));

        // Decode into associative array
        $words = json_decode($json, true);

        foreach ($words as $entry) {
            Word::create([
                'unit'     => $entry['Unit'],                 // Unit identifier
                'japanese' => $entry['JP']['Japanese'],       // Japanese text
                'romaji'   => $entry['JP']['Romaji'],         // Romaji reading
                'english'  => $entry['English'],              // English translation
            ]);
        }
    }
}
