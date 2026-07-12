<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::where('client_id', Auth::user()->client_id);
        
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('expense_date', $request->bulan);
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('expense_date', $request->tahun);
        }

        $expenses = $query->orderBy('expense_date', 'desc')->get();
        $totalPengeluaran = $expenses->sum('amount');

        return view('bendahara.expenses.index', compact('expenses', 'totalPengeluaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:Keamanan,Kebersihan,Infrastruktur,Sosial,Administrasi,Lain-lain',
            'amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
            'receipt' => 'nullable|image|max:5120',
            'notes' => 'nullable|string'
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('expenses', 'public');
        }

        Expense::create([
            'client_id' => Auth::user()->client_id,
            'title' => $request->title,
            'category' => $request->category,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'receipt_path' => $receiptPath,
            'notes' => $request->notes,
        ]);

        return redirect()->route('bendahara.expenses.index')->with('success', 'Data pengeluaran kas berhasil dicatat.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->client_id !== Auth::user()->client_id) abort(403);

        if ($expense->receipt_path && Storage::disk('public')->exists($expense->receipt_path)) {
            Storage::disk('public')->delete($expense->receipt_path);
        }

        $expense->delete();

        return redirect()->route('bendahara.expenses.index')->with('success', 'Data pengeluaran kas berhasil dihapus.');
    }
}
