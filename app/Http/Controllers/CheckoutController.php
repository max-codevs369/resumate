<?php

namespace App\Http\Controllers;

use App\Models\{Transaction, Setting};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showPricing()
    {
        $settings = Setting::pluck('value', 'key');

        if (Auth::check()) {
            if (Auth::user()->is_premium == 1) {
                abort(404);
            }
        }

        $transaction = null;
        if (Auth::check()) {
            $transaction = Transaction::where('user_id', Auth::id())->latest()->first();
        }

        return view('pages.pricing', compact('transaction', 'settings'));
    }
    public function checkout()
    {
        if (Auth::user()->is_premium == 1) {
            abort(404);
        }

        $settings = Setting::pluck('value', 'key');

        $transaction = Transaction::where('user_id', Auth::id())->latest()->first();

        if ($transaction && $transaction->status === 'pending') {
            return redirect()->route('pricing'); 
        }

        return view('pages.pricing.checkout', compact('transaction', 'settings'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method'   => 'required|string|in:Transfer Bank,QRIS',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ], [
            'proof_of_payment.required' => 'Bukti pembayaran wajib diunggah.',
            'proof_of_payment.image'    => 'File harus berupa gambar.',
            'proof_of_payment.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        $proofPath = $request->file('proof_of_payment')->store('proofs', 'public');

        $transactionCode = 'TRX-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        $amountFromSetting = Setting::where('key', 'pricing_amount')->value('value') ?? 299;

        $totalAmount = (int) $amountFromSetting * 1000;

        Transaction::create([
            'transaction_code' => $transactionCode,
            'user_id'          => Auth::id(), 
            'amount'           => $totalAmount, 
            'payment_method'   => $request->payment_method,
            'proof_of_payment' => $proofPath,
        ]);

        return redirect()->route('pricing')->with('success', 'Bukti pembayaran berhasil dikirim! Mohon tunggu admin melakukan verifikasi.');
    }
}