@extends('layouts.admin')
@section('title')
    Tutor Account
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container" style="overflow-x: auto">
        <h1>Account List</h1>

{{--        <div class="card">--}}
{{--            <div class="card-body">--}}
{{--                <div class="form-group">--}}
{{--                    <label><strong>PAYMENT STATUS :</strong></label>--}}
{{--                    <select id='approved' class="form-control" style="width: 200px">--}}
{{--                        <option value="">PAYMENT STATUS</option>--}}
{{--                        <option value="1">FREE</option>--}}
{{--                        <option value="0">PAID</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div>
            @if(session()->has('success'))
                <div class="success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>

        <table class="table table-bordered data-table">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Payment Gateway</th>
                <th>Stripe Account</th>
                <th>Stripe Verified</th>
                <th>RazorPay Account</th>
                <th>Razorpay Verified</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                order: [[0, "desc" ]],
                ajax: {
                    url: "{{ route('account-setup.index') }}",
                    data: function (d) {
                        d.approved = $('#approved').val(),
                            d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email', name: 'email'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'payment_gateway', name: 'payment_gateway'},
                    {data: 'stripe_account', name: 'stripe_account'},
                    {data: 'stripe_verified', name: 'stripe_verified'},
                    {data: 'razorpay_account', name: 'razorpay_account'},
                    {data: 'razorpay_verified', name: 'razorpay_verified'},
                    {data: 'action', name: 'action'},
                ]
            });
            // 'name','email' ,'payment_gateway', 'stripe_account', 'stripe_verified', 'razorpay_account', 'razorpay_verified'

            $('#approved').change(function(){
                table.draw();
            });

        });
    </script>

@endsection
