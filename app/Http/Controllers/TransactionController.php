<?php

namespace App\Http\Controllers;

use App\Enums\LaptopStatus;
use App\Enums\PaymentMethod;
use App\Exceptions\TransactionException;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UploadProofRequest;
use App\Models\Laptop;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $transactions)
    {
    }

    /** Riwayat transaksi for customer with login */
    public function index(Request $request): View
    {
        $transactions = Transaction::query()
            ->ownedBy($request->user())
            ->with('laptop.brand')
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /** Form booking untuk only satu laptop. */
    public function create(Laptop $laptop): View|RedirectResponse
    {
        Gate::authorize('create', Transaction::class);

        if ($laptop->status !== LaptopStatus::Tersedia) {
            return redirect()
                ->route('catalog.show', $laptop)
                ->with('error', TransactionException::laptopUnavailable()->getMessage());
        }

        return view('transactions.create', [
            'laptop' => $laptop->load('brand'),
            'paymentMethods' => PaymentMethod::cases(),
        ]);
    }

    public function store(StoreBookingRequest $request, Laptop $laptop): RedirectResponse
    {
        try {
            $transaction = $this->transactions->book($request->user(), $laptop, $request->paymentMethod());
        } catch (TransactionException $e) {
            return redirect()->route('catalog.show', $laptop)->with('error', $e->getMessage());
        }

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Booking berhasil dibuat. Laptop ditahan untuk Anda.');
    }

    public function show(Transaction $transaction): View
    {
        Gate::authorize('view', $transaction);

        return view('transactions.show', [
            'transaction' => $transaction->load('laptop.brand', 'user'),
        ]);
    }

    public function uploadProof(UploadProofRequest $request, Transaction $transaction): RedirectResponse
    {
        try {
            $this->transactions->uploadProof($transaction, $request->file('proof'));
        } catch (TransactionException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Bukti transfer berhasil diunggah. Menunggu verifikasi admin.');
    }

    public function proof(Transaction $transaction): StreamedResponse
    {
        Gate::authorize('view', $transaction);

        abort_unless($transaction->hasProof(), 404);

        return Storage::disk(Transaction::PROOF_DISK)->response($transaction->proof_of_payment);
    }
}
