<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Software Development',
                'description' => 'Jobs related to software engineering, programming, and development',
                'icon' => 'fa-solid fa-code',
                'color' => '#3B82F6',
                'sort_order' => 1,
            ],
            [
                'name' => 'Design & Creative',
                'description' => 'Graphic design, UI/UX, and creative roles',
                'icon' => 'fa-solid fa-palette',
                'color' => '#EF4444',
                'sort_order' => 2,
            ],
            [
                'name' => 'Marketing',
                'description' => 'Digital marketing, SEO, and advertising positions',
                'icon' => 'fa-solid fa-bullhorn',
                'color' => '#10B981',
                'sort_order' => 3,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
