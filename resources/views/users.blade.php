<html>
<head>
    <title>Datatables Filter With Dropdown</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>

</head>
<body>

<div class="container">
    <h1>users </h1>

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label><strong>Paid Status :</strong></label>
                <select id='selected_plan' class="form-control" style="width: 200px">
                    <option value="">Status</option>
                    <option value="FREE">FREE</option>
                    <option value="PAID">PAID</option>
                </select>
            </div>
        </div>
    </div>

    <table class="table table-bordered data-table">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Last Login</th>
            <th>Joining Date</th>
            <th>Fee Status</th>
            <th>Total Students</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

</body>

<script type="text/javascript">
    $(function () {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('users.index') }}",
                data: function (d) {
                    d.approved = $('#approved').val(),
                        d.search = $('input[type="search"]').val()
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'last_active_datetime', name: 'last_active_datetime'},
                {data: 'created_at', name: 'created_at'},
                {data: 'selected_plan', name: 'selected_plan'},
                {data: 'student', name: 'student'},
            ]
        });

        $('#selected_plan').change(function(){
            table.draw();
        });

    });
</script>
</html>
