<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Thời trang nam',
                'slug' => 'thoi-trang-nam',
                'parent_id' => 0,
            ],
            [
                'name' => 'Thời trang nữ',
                'slug' => 'thoi-trang-nu',
                'parent_id' => 0,
            ],
            [
                'name' => 'Thời trang trẻ em',
                'slug' => 'thoi-trang-tre-em',
                'parent_id' => 0,
            ]
        ]);
    }
}
