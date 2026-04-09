<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Transaction, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{

    private function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('transaction_code', 'like', "%{$keyword}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$keyword}%")
                                              ->orWhere('email', 'like', "%{$keyword}%"));
            });
        }

        $filter = $request->get('filter', 'all');
        if (in_array($filter, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $filter);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = Transaction::with(['user'])->latest();
        $this->applyFilters($query, $request);

        $transactions = $query->paginate(10)->withQueryString();

        $stats = Transaction::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN status = 'approved' THEN amount ELSE 0 END) as revenue
        ")->first();

        $counts = [
            'all'      => (int) $stats->total,
            'pending'  => (int) $stats->pending,
            'approved' => (int) $stats->approved,
            'rejected' => (int) $stats->rejected,
        ];

        $totalRevenue = (float) $stats->revenue;
        $filter = $request->get('filter', 'all');

        return view('admin.transactions.index', compact(
            'transactions', 'counts', 'filter', 'totalRevenue'
        ));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function approve(Request $request, Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($transaction, $request) {
            $transaction->update([
                'status'      => 'approved',
                'verified_at' => now(),
                'admin_note'  => $request->admin_note ?? 'Pembayaran diverifikasi oleh Admin',
            ]);

            $transaction->user->activatePremium();
        });

        return back()->with('success', "Transaksi {$transaction->transaction_code} disetujui. User otomatis menjadi PRO selama 1 bulan.");
    }

    public function reject(Request $request, Transaction $transaction)
    {
        $request->validate([
            'admin_note' => ['required', 'string', 'max:500'],
        ], [
            'admin_note.required' => 'Wajib memberikan alasan penolakan agar user paham.',
        ]);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        $transaction->update([
            'status'      => 'rejected',
            'verified_at' => now(),
            'admin_note'  => $request->admin_note,
        ]);

        return back()->with('success', "Transaksi {$transaction->transaction_code} telah ditolak.");
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->status === 'approved') {
            return back()->with('error', 'Transaksi yang sudah disetujui tidak dapat dihapus untuk audit keuangan.');
        }

        if ($transaction->proof_of_payment) {
            Storage::disk('public')->delete($transaction->proof_of_payment);
        }

        $transaction->delete();

        return back()->with('success', 'Data transaksi berhasil dihapus.');
    }
}