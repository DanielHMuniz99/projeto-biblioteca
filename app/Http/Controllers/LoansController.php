<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LibraryUser;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Services\LoanService;

class LoansController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['libraryUser', 'book'])->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $users = LibraryUser::all();
        $books = Book::where('status', 'available')->get();
        return view('loans.form', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'library_user_id' => 'required|exists:library_users,id',
            'book_id' => 'required|exists:books,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        Loan::create([
            'library_user_id' => $request->library_user_id,
            'book_id' => $request->book_id,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'status' => 'pending',
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

    public function renew($id, LoanService $loanService)
    {
        $loan = Loan::with('user')->findOrFail($id);

        try {
            $loanService->renewLoan($loan);
            return redirect()->route('emprestimos.index')
                ->with('success', 'Empréstimo renovado com sucesso por mais 7 dias.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('emprestimos.index')
                ->with('error', $e->getMessage());
        }
    }
}
