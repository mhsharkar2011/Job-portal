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
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Technology and IT related companies and jobs',
                'icon' => 'fa-solid fa-laptop-code',
                'color' => '#3B82F6',
                'sort_order' => 1,
            ],
            [
                'name' => 'Garment & Textile',
                'slug' => 'garment-textile',
                'description' => 'Garment, textile and fashion industry companies',
                'icon' => 'fa-solid fa-tshirt',
                'color' => '#EF4444',
                'sort_order' => 2,
            ],
            [
                'name' => 'Software Development',
                'description' => 'Jobs related to software engineering, programming, and development',
                'icon' => 'fa-solid fa-code',
                'color' => '#10B981',
                'sort_order' => 3,
            ],
            [
                'name' => 'Design & Creative',
                'description' => 'Graphic design, UI/UX, and creative roles',
                'icon' => 'fa-solid fa-palette',
                'color' => '#F59E0B',
                'sort_order' => 4,
            ],
            [
                'name' => 'Marketing',
                'description' => 'Digital marketing, SEO, and advertising positions',
                'icon' => 'fa-solid fa-bullhorn',
                'color' => '#8B5CF6',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
