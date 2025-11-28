<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Food & Dining', 'icon' => 'utensils', 'color' => '#EF4444'],
            ['name' => 'Transportation', 'icon' => 'car', 'color' => '#3B82F6'],
            ['name' => 'Entertainment', 'icon' => 'film', 'color' => '#8B5CF6'],
            ['name' => 'Bills & Utilities', 'icon' => 'bolt', 'color' => '#F59E0B'],
            ['name' => 'Shopping', 'icon' => 'shopping-bag', 'color' => '#EC4899'],
            ['name' => 'Health & Fitness', 'icon' => 'heart', 'color' => '#10B981'],
            ['name' => 'Other', 'icon' => 'tag', 'color' => '#6B7280'],
        ];

        // Add default categories for each user
        User::all()->each(function ($user) use ($categories) {
            foreach ($categories as $category) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $category['name'],
                    'icon' => $category['icon'],
                    'color' => $category['color'],
                    'is_default' => true,
                ]);
            }
        });
    }
}
