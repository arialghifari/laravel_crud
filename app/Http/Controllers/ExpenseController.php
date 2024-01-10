<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function createExpense(Request $request)
    {
        $incomingRequest = $request->validate([
            'title' => ['required', 'max:255'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'category' => ['required', 'max:255'],
            'description' => ['nullable'],
        ]);
        $incomingRequest['date'] = date('Y-m-d', strtotime($incomingRequest['date']));
        $incomingRequest['user_id'] = auth()->user()->id;

        Expense::create($incomingRequest);

        return redirect('/');
    }

    public function editExpense(Expense $expense)
    {
        if (!auth()->check()) {
            return redirect('/');
        }

        // if (auth()->user()->id === $expense->user_id) {
        // }
        return view('editExpense', ['expense' => $expense]);

        return redirect('/');
    }

    public function updateExpense(Request $request, Expense $expense)
    {
        if (auth()->user()->id !== $expense->user_id) {
            return redirect('/');
        }

        $incomingRequest = $request->validate([
            'title' => ['required', 'max:255'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'category' => ['required', 'max:255'],
            'description' => ['nullable'],
        ]);
        $incomingRequest['date'] = date('Y-m-d', strtotime($incomingRequest['date']));

        $expense->update($incomingRequest);

        return redirect('/');
    }

    public function deleteExpense(Expense $expense)
    {
        if (auth()->user()->id === $expense->user_id) {
            $expense->delete();
        }

        return redirect('/');
    }
}
