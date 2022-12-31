@extends('layouts.admin')
@section('title', 'Edit Account')

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Account</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">Edit Account</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <form action="{{route('account-setup.update',$account->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" disabled name="name" value="{{$account->name}}">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" disabled name="email" value="{{$account->email}}">
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>PhoneNumber</label>
                                    <input type="text" class="form-control" disabled name="text" value="{{$account->phone_number}}">
                                    @error('phone_number')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Selected Payment Gateway</label>
                                    <select name="payment_gateway" class="form-control">
                                      @if(isset($account->payment_gateway))
                                          @if($account->payment_gateway=="stripe")
                                              <option>Select Payment Gateway</option>
                                              <option value="stripe" selected>Stripe</option>
                                              <option value="razorpay" >Razorpay</option>
                                            @else
                                                <option>Select Payment Gateway</option>
                                                <option value="stripe">Stripe</option>
                                                <option value="razorpay" selected>Razorpay</option>
                                            @endif
                                        @else
                                            <option>Select Payment Gateway</option>
                                            <option value="stripe">Stripe</option>
                                            <option value="razorpay">Razorpay</option>
                                      @endif
                                    </select>
                                    @error('payment_gateway')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Stripe Account</label>
                                    <input type="text" class="form-control" name="stripe_account" value="{{$account->stripe_account}}" placeholder="Stripe Account Id">
                                    @error('stripe_account')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Stripe Verified</label>
                                    <select class="form-control" name="stripe_verified" >
                                        @if($account->stripe_verified)
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        @else
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        @endif
                                    </select>
                                    @error('stripe_verified')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Razorpay Account</label>
                                    <input type="text" class="form-control" name="razorpay_account" value="{{$account->razorpay_account}}" placeholder="Razorpay Account Id">
                                    @error('razorpay_account')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label>Razorpay Verified</label>
                                    <select class="form-control" name="razorpay_verified" >
                                        @if($account->razorpay_verified)
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        @else
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        @endif
                                    </select>
                                    @error('razorpay_verified')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



