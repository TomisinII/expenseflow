<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo user
        $user = User::firstOrCreate(
            ['email' => 'demo@expenseflow.app'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        // Create categories
        $categories = [
            ['name' => 'Food & Dining', 'icon' => 'utensils', 'color' => '#10B981'],
            ['name' => 'Transportation', 'icon' => 'car', 'color' => '#3B82F6'],
            ['name' => 'Entertainment', 'icon' => 'film', 'color' => '#8B5CF6'],
            ['name' => 'Shopping', 'icon' => 'shopping-bag', 'color' => '#F59E0B'],
            ['name' => 'Bills & Utilities', 'icon' => 'file-text', 'color' => '#EF4444'],
            ['name' => 'Healthcare', 'icon' => 'heart', 'color' => '#EC4899'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['user_id' => $user->id, 'name' => $cat['name']],
                [
                    'icon' => $cat['icon'],
                    'color' => $cat['color'],
                    'is_default' => false,
                ]
            );
        }

        // Create sample expenses
        $expenses = [
            ['amount' => 5000, 'category' => 'Food & Dining', 'description' => 'Lunch at The Place', 'days_ago' => 1],
            ['amount' => 2500, 'category' => 'Transportation', 'description' => 'Uber to work', 'days_ago' => 2],
            ['amount' => 15000, 'category' => 'Shopping', 'description' => 'Groceries', 'days_ago' => 3],
            ['amount' => 8000, 'category' => 'Entertainment', 'description' => 'Movie tickets', 'days_ago' => 5],
            ['amount' => 25000, 'category' => 'Bills & Utilities', 'description' => 'Electricity bill', 'days_ago' => 7],
        ];

        foreach ($expenses as $exp) {
            $category = Category::where('user_id', $user->id)
                ->where('name', $exp['category'])
                ->first();

            Expense::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'amount' => $exp['amount'],
                'description' => $exp['description'],
                'expense_date' => now()->subDays($exp['days_ago']),
                'payment_method' => 'card',
            ]);
        }
    }
}
