<?php

namespace App\Http\Controllers;

use App\Models\TransactionBackup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Payment;


class PaymentController extends Controller
{
    //
    public function index()
    {
        return view('payment');
    }


    //
    public function indexPayment()
    {
        return view('payments');
    }

    //
    public function indexStatus()
    {
        return view('status');
    }



    /**
     * Summary of orderPayment
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function orderPayment(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1', // Amount must be positive
            'reff' => 'required|string',
            'expired' => [
                'required',
                function ($attribute, $value, $fail) {
                    $expectedFormat = 'Y-m-d\TH:i:sP'; // Example: 2021-07-28T09:12:48+07:00
                    $date = Carbon::createFromFormat($expectedFormat, $value, null);
                    if (!$date || $date->format($expectedFormat) !== $value) {
                        $fail('The ' . $attribute . ' field must match the format: ' . $expectedFormat);
                    }
                    if ($date->isPast()) {
                        $fail('The ' . $attribute . ' field must be a future date.');
                    }
                },
            ],
            'name' => 'required|string|max:255',
            'hp' => 'required|string|max:20',
        ]);

        $fee = 2500;
        $resultedAmount = $validated['amount'] + $fee;
        $paymentCode = '8834' . $validated['hp'];

        $payment = Payment::create([
            'amount' => $resultedAmount,
            'reff' => $validated['reff'],
            'expired_at' => Carbon::parse($validated['expired']),
            'name' => $validated['name'],
            'hp' => $validated['hp'],
            'code' => $paymentCode,
        ]);

        return response()->json($payment, 201);
    }


    /**
     * Summary of payment
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function payment(Request $request)
    {
        $validated = $request->validate([
            'reff' => 'required|string',
        ]);

        $payment = Payment::where('reff', $validated['reff'])->first();

        if (!$payment) {
            return response()->json(['message' => 'Invalid reference'], 403);
        }

        if (now()->greaterThan($payment->expired_at)) {
            return response()->json(['status' => 'expired'], 200);
        }

        if ($payment->status === 'paid') {
            return response()->json(['message' => 'Payment already made'], 403);
        }

        $payment->update(['status' => 'paid']);

        TransactionBackup::create([
            'reff' => $payment->reff,
            'name' => $payment->name,
            'code' => $payment->code,
            'amount' => $payment->amount,
            'status' => $payment->status,
            'expired_at' => $payment->expired_at,

        ]);

        return response()->json([
            'amount' => $payment->amount,
            'reff' => $payment->reff,
            'name' => $payment->name,
            'code' => $payment->code,
            'status' => $payment->status,
        ]);
    }

    /**
     * Summary of checkStatus
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function checkStatus(Request $request)
    {
        $validated = $request->validate([
            'reff' => 'required|string',
        ]);

        $payment = Payment::where('reff', $validated['reff'])->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 403);
        }

        return response()->json($payment, 200);
    }


    /**
     * Summary of simpan ( This is Process backend for the web)
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function simpan(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'reff' => 'required|string|max:255',
            'expired_at' => 'nullable|date',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            // Simpan data ke database
            $orderPayment = Payment::create($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Payment has been successfully saved!');
            // return redirect()->route('payment')->with('success', 'Payment successfully submitted!');
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect()->back()->withErrors(['error' => 'Failed to save payment. ' . $e->getMessage()]);
        }
    }



    /**
     * Summary of simpan ( This is Process backend for the web)
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function simpanPembayaran(Request $request)
    {
        $validated = $request->validate([
            'reff' => 'required|string',
        ]);

        $payment = Payment::where('reff', $validated['reff'])->first();

        if (!$payment) {
            return redirect()->back()->withErrors(['error' => 'Invalid reference']);

        }

        if (now()->greaterThan($payment->expired_at)) {
            return redirect()->back()->withErrors(['error' => 'Expired']);
        }

        if ($payment->status === 'paid') {
            return redirect()->back()->withErrors(['error' => 'Payment already made ']);

        }

        $payment->update(['status' => 'paid']);


        try {
            // Simpan data ke database

            TransactionBackup::create([
                'reff' => $payment->reff,
                'name' => $payment->name,
                'code' => $payment->code,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'expired_at' => $payment->expired_at,

            ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Payment has been successfully saved!');
            // return redirect()->route('payment')->with('success', 'Payment successfully submitted!');
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect()->back()->withErrors(['error' => 'Failed to save payment. ' . $e->getMessage()]);
        }
    }


    public function submitStatus(Request $request)
    {
        $validated = $request->validate([
            'reff' => 'required|string',
        ]);
    
        $payment = Payment::where('reff', $validated['reff'])->first();
    
        if (!$payment) {
            return redirect()->back()->withErrors(['error' => 'Payment with the given reference not found.']);
        }
    
        return redirect()->back()
            ->with('success', 'Status Sebagai berikut')
            ->with('payment', $payment);
    }


}
