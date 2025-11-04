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
            [
                'name' => 'Sales',
                'description' => 'Sales representatives and business development roles',
                'icon' => 'fa-solid fa-chart-line',
                'color' => '#F59E0B',
                'sort_order' => 4,
            ],
            [
                'name' => 'Customer Support',
                'description' => 'Customer service and support positions',
                'icon' => 'fa-solid fa-headset',
                'color' => '#8B5CF6',
                'sort_order' => 5,
            ],
            [
                'name' => 'Finance & Accounting',
                'description' => 'Financial analysis, accounting, and bookkeeping roles',
                'icon' => 'fa-solid fa-calculator',
                'color' => '#06B6D4',
                'sort_order' => 6,
            ],
            [
                'name' => 'Human Resources',
                'description' => 'HR, recruitment, and talent management positions',
                'icon' => 'fa-solid fa-users',
                'color' => '#EC4899',
                'sort_order' => 7,
            ],
            [
                'name' => 'Healthcare',
                'description' => 'Medical, nursing, and healthcare professional roles',
                'icon' => 'fa-solid fa-heart-pulse',
                'color' => '#DC2626',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
