<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionStatus;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\TransactionService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Dashboard transaksi untuk admin
 */
class TransactionController extends Controller
{
    public function __construct(private TransactionService $transactions)
    {
    }

    public function index(Request $request): View
    {
        $transactions = Transaction::query()
            ->with(['user', 'laptop.brand'])
            ->ofStatus($request->query('status'))
            ->search($request->query('q'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'statuses' => TransactionStatus::cases(),
            'statusCounts' => Transaction::countByStatus(),
        ]);
    }

    public function show(Transaction $transaction): View
    {
        return view('admin.transactions.show', [
            'transaction' => $transaction->load('laptop.brand', 'user'),
        ]);
    }

    public function verify(Transaction $transaction): RedirectResponse
    {
        return $this->perform(
            fn () => $this->transactions->verifyPayment($transaction),
            'Pembayaran terverifikasi. Laptop ditandai Terjual.',
        );
    }

    public function complete(Transaction $transaction): RedirectResponse
    {
        return $this->perform(
            fn () => $this->transactions->completeCod($transaction),
            'Transaksi COD selesai. Laptop ditandai Terjual.',
        );
    }

    public function cancel(Transaction $transaction): RedirectResponse
    {
        return $this->perform(
            fn () => $this->transactions->cancel($transaction),
            'Booking dibatalkan. Laptop kembali Tersedia.',
        );
    }

    private function perform(Closure $action, string $successMessage): RedirectResponse
    {
        try {
            $action();
        } catch (TransactionException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', $successMessage);
    }
}
