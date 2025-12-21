<?php

namespace App\Livewire\Profile;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ExportData extends Component
{
    public function exportAllData()
    {
        // Get all expenses for the authenticated user
        $expenses = Expense::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('expense_date', 'desc')
            ->get();

        // Generate filename with current date
        $filename = 'expense_flow_data_' . now()->format('Y-m-d_His') . '.csv';

        // Create a streamed response
        return response()->streamDownload(function () use ($expenses) {
            $handle = fopen('php://output', 'w');

            // Add file header with export info
            fputcsv($handle, ['Expense Flow - Full Data Export']);
            fputcsv($handle, ['Exported on: ' . now()->format('F d, Y at h:i A')]);
            fputcsv($handle, ['User: ' . Auth::user()->name]);
            fputcsv($handle, []);

            // Add CSV headers
            fputcsv($handle, [
                'Date',
                'Description',
                'Category',
                'Payment Method',
                'Amount (₦)',
                'Notes'
            ]);

            // Add expense data
            foreach ($expenses as $expense) {
                fputcsv($handle, [
                    $expense->expense_date->format('Y-m-d'),
                    $expense->description,
                    $expense->category->name ?? 'N/A',
                    ucwords(str_replace('_', ' ', $expense->payment_method)),
                    number_format($expense->amount, 2, '.', ''),
                    $expense->notes ?? ''
                ]);
            }

            // Add summary section
            fputcsv($handle, []);
            fputcsv($handle, ['=== SUMMARY ===']);
            fputcsv($handle, [
                'Total Expenses:',
                $expenses->count(),
                '',
                '',
                '',
                ''
            ]);
            fputcsv($handle, [
                'Total Amount:',
                '',
                '',
                '',
                number_format($expenses->sum('amount'), 2, '.', ''),
                ''
            ]);

            // Add category breakdown
            if ($expenses->count() > 0) {
                fputcsv($handle, []);
                fputcsv($handle, ['=== CATEGORY BREAKDOWN ===']);
                fputcsv($handle, ['Category', 'Count', 'Total Amount (₦)']);

                $categoryStats = $expenses->groupBy('category.name')->map(function ($group) {
                    return [
                        'count' => $group->count(),
                        'total' => $group->sum('amount')
                    ];
                });

                foreach ($categoryStats as $categoryName => $stats) {
                    fputcsv($handle, [
                        $categoryName ?? 'Uncategorized',
                        $stats['count'],
                        number_format($stats['total'], 2, '.', '')
                    ]);
                }
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function render()
    {
        return view('livewire.profile.export-data');
    }
}
