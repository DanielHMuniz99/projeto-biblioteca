<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class LoansController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $users = User::all();
        $books = Book::where('status', 'available')->get();
        return view('loans.form', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'due_date' => 'required|date|after:today'
        ]);

        Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'due_date' => $request->due_date,
            'status' => 'pending'
        ]);

        Book::findOrFail($request->book_id)->update(['status' => 'loaned']);
        return redirect()->route('emprestimos.index')->with('success', 'Empréstimo registrado com sucesso.');
    }

    public function markAsReturned($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->update(['status' => 'returned']);
        $loan->book->update(['status' => 'available']);

        return redirect()->route('emprestimos.index')->with('success', 'Livro marcado como devolvido.');
    }

    public function markAsLate($id)
    {
        $loan = Loan::with('book')->findOrFail($id);
    
        if (now()->lt($loan->due_date)) {
            return redirect()
                ->route('emprestimos.index')
                ->with('error', 'Este empréstimo ainda não está atrasado.');
        }
    
        $loan->update(['status' => 'late']);
    
        return redirect()
            ->route('emprestimos.index')
            ->with('success', 'Empréstimo marcado como atrasado.');
    }    
}
