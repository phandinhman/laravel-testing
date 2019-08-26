<?php

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++)
        {
            Article::create([
                'title' => 'Title ' . $i,
                'body' => 'Body ' . $i,
            ]);
        }
    }
}
