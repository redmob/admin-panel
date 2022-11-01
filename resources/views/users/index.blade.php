@extends('layouts.admin')
@section('title', 'Sub Admins')

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <section class="content">
        <div class="row">

            <div class="col-10 offset-1">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        {{ Session::get('success') }}
                    </div>
                @endif
            </div>
            <div class="col-10 offset-1 clearfix">
                <a class="btn btn-info float-right" href="/users/create">Add User</a>
            </div>
            <div class="col-12">
                <div class="card card-primary" style="overflow-x:auto;">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered" >
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>

                                <th style="width: 40px">Edit</th>
{{--                                <th style="width: 40px">Delete</th>--}}
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <a class="btn btn-success" href="users/{{$user->id}}/edit">Edit</a>
                                    </td>
{{--                                    <td>--}}
{{--                                        <form action="{{ route('users.destroy', $user->id)}}" method="post">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button class="btn btn-danger" type="submit">Delete</button>--}}
{{--                                        </form>--}}
{{--                                    </td>--}}
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{$users->links()}}

                </div>
            </div>
        </div>


    </section>

@endsection

