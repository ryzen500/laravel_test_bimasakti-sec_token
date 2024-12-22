<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     /**
    //      * count user
    //      * @var mixed
    //      */
    //     $users = User::count();
    //     $count_Transaction = Payment::count();
    //     /**
    //      * Count transactions with status 'paid'
    //      */
    //     $transactionsPaid = Payment::where('status', 'paid')->count();

    //     /**
    //      * Count transactions with status 'expired'
    //      */
    //     $transactionsExpired = Payment::where('status', 'expired')->count();
    //     $widget = [
    //         'users' => $users,
    //         'payment' => $count_Transaction,
    //         'transactionsPaid'=>$transactionsPaid,
    //         'transactionsExpired'=>$transactionsExpired
    //         //...
    //     ];

    //     return view('home', compact('widget'));
    // }

    public function index(Request $request)
{
    /**
     * Widget Data
     */
    $users = User::count();
    $count_Transaction = Payment::count();
    $transactionsPaid = Payment::where('status', 'paid')->count();
    $transactionsExpired = Payment::where('status', 'expired')->count();

    $widget = [
        'users' => $users,
        'payment' => $count_Transaction,
        'transactionsPaid' => $transactionsPaid,
        'transactionsExpired' => $transactionsExpired,
    ];

    /**
     * Filter Data Payment
     */
    $status = $request->input('status'); // Filter status
    $startDate = $request->input('start_date'); // Filter start date
    $endDate = $request->input('end_date'); // Filter end date

    $query = Payment::query();

    // Apply status filter
    if (!empty($status)) {
        $query->where('status', $status);
    }

    // Apply date range filter
    if (!empty($startDate) && !empty($endDate)) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Fetch filtered data
    $payments = $query->latest()->paginate(10);

    return view('home', compact('widget', 'payments'));
}

}
