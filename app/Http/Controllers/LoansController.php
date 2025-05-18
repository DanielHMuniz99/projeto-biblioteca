<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LibraryUser;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\LoanService;

class LoansController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $loans = Loan::with(['libraryUser', 'book'])->get();
        return view('loans.index', compact('loans'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $users = LibraryUser::all();
        $books = Book::where('status', 'available')->get();
        return view('loans.form', compact('users', 'books'));
    }

    /**
     * @param Request $request
     * @param LoanService $loanService
     * 
     * @return RedirectResponse
     */
    public function store(Request $request, LoanService $loanService): RedirectResponse
    {
        $validated = $request->validate([
            'library_user_id' => 'required|exists:library_users,id',
            'book_id' => 'required|exists:books,id',
            'start_date' => 'required|date|before_or_equal:today',
            'due_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            $loanService->createLoan($validated);
        } catch (\Exception $e) {
            return redirect()
                ->route('emprestimos.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('emprestimos.index')->with('success', 'Empréstimo registrado com sucesso.');
    }

    /**
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function markAsReturned(int $id): RedirectResponse
    {
        $loan = Loan::findOrFail($id);
        $loan->update(['status' => 'returned']);
        $loan->book->update(['status' => 'available']);

        return redirect()->route('emprestimos.index')->with('success', 'Livro marcado como devolvido.');
    }

    /**
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function markAsLate(int $id): RedirectResponse
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

    /**
     * @param int $id
     * @param LoanService $loanService
     * 
     * @return RedirectResponse
     */
    public function renew(int $id, LoanService $loanService): RedirectResponse
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
