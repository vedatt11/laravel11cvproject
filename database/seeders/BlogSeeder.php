<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::create([
            'category_id'=>1,
            'name'=>'Merhaaba Dunya Blogu',
            'content'=>'Bu bir bloh yazısı'

        ]);

    }
}
