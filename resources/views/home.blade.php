@extends('layouts.admin')

@section('main-content')

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

@if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success border-left-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            {{__('Payment have been paid')}}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$widget['transactionsPaid']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{__('Order not paid')}}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$widget['transactionsExpired']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">{{__('Order Payment')}}
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $widget['payment']}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">{{ __('Users') }}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $widget['users'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transactions Category </h6>
            </div>
            <div class="card-body">

                @php
                    // Mengambil total transaksi
                    $totalTransactions = $widget['payment'];

                    // Menghitung jumlah transaksi per status
                    $transactionsPaid = $widget['transactionsPaid'];
                    $transactionsExpired = $widget['transactionsExpired'];
                    $transactionsNotValid = $totalTransactions - ($transactionsPaid + $transactionsExpired); // Asumsi lainnya adalah not valid

                    // Menghitung persentase
                    $percentagePaid = $totalTransactions > 0 ? round(($transactionsPaid / $totalTransactions) * 100) : 0;
                    $percentageExpired = $totalTransactions > 0 ? round(($transactionsExpired / $totalTransactions) * 100) : 0;
                    $percentageNotValid = $totalTransactions > 0 ? round(($transactionsNotValid / $totalTransactions) * 100) : 0;
                @endphp

                <h4 class="small font-weight-bold">Transactions have been paid
                    <span class="float-right">{{ $percentagePaid }}%</span>
                </h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentagePaid }}%"
                        aria-valuenow="{{ $percentagePaid }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold">Transaction expired
                    <span class="float-right">{{ $percentageExpired }}%</span>
                </h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentageExpired }}%"
                        aria-valuenow="{{ $percentageExpired }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold">Transaction not valid
                    <span class="float-right">{{ $percentageNotValid }}%</span>
                </h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $percentageNotValid }}%"
                        aria-valuenow="{{ $percentageNotValid }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <h4 class="small font-weight-bold">Order Payment
                    <span class="float-right">Complete!</span>
                </h4>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-6 mb-4">

        <!-- Illustrations -->
        <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Payment List</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('home') }}">
            <div class="form-row">
                <!-- Filter Status -->
                <div class="form-group col-md-4">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">All</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="not_valid" {{ request('status') == 'not_valid' ? 'selected' : '' }}>Not Valid</option>
                    </select>
                </div>
                <!-- Filter Periode -->
                <div class="form-group col-md-4">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="end_date">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <!--  -->

    <div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Reff</th>
                <th>Code</th>

                <th>Customer Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->reff }}</td>
                    <td>{{ $payment->code }}</td>
                    <td>{{ $payment->name }}</td>
                    <td> {{  number_format($payment->amount, 2) }}</td>
                    <td>
                        @if ($payment->status == 'paid')
                            <span class="badge badge-success">Paid</span>
                        @elseif ($payment->status == 'expired')
                            <span class="badge badge-warning">Expired</span>
                        @else
                            <span class="badge badge-danger">Not Valid</span>
                        @endif
                    </td>
                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center">
    {{ $payments->links() }}
</div>

</div>



    </div>
</div>
@endsection