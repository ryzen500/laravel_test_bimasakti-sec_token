@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Order Payment') }}</h1>

@if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger border-left-danger" role="alert">
        <ul class="pl-4 my-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

    <div class="col-lg-4 order-lg-2">
        <div class="card shadow mb-4">
            <div class="card-profile-image mt-4">
                <figure class="rounded-circle avatar avatar font-weight-bold"
                    style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}">
                </figure>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h5 class="font-weight-bold">{{ Auth::user()->fullName }}</h5>
                    <p>Administrator</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Payment Form</h6>
            </div>

            <div class="card-body">
                <form id="payment-form" method="POST" action="{{ route('order-payment.simpan') }}" autocomplete="off">
                    @csrf
                    <h6 class="heading-small text-muted mb-4">Payment Information</h6>

                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Customer Name<span
                                            class="small text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name"
                                        placeholder="Name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="code">Code</label>
                                    <input type="text" id="code" class="form-control" name="code"
                                        placeholder="Code" value="{{ old('code') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="reff">Reff<span
                                            class="small text-danger">*</span></label>
                                    <input type="text" id="reff" class="form-control" name="reff"
                                        placeholder="Reference" value="{{ old('reff') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="expired_at">Expired At</label>
                                    <input type="date" id="expired_at" class="form-control" name="expired_at"
                                        value="{{ old('expired_at') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="total">Total Amount<span
                                            class="small text-danger">*</span></label>
                                    <input type="number" id="amount" class="form-control" name="amount"
                                        placeholder="Enter amount" value="{{ old('amount') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary">Submit Payment</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
