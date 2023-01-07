@extends('layouts.admin')
@section('title', 'Verify Tutor')

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Verify Tutor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">Verify Tutor</li>
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
                <div class="col-md-10 offset-md-1">
                    <div class="card">
                        <form action="{{route('tutors.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">

                                <table class="table table-bordered">

                                    <tbody>
                                    <tr>
                                        <th scope="row">Name:</th>
                                        <td>{{isset($user->name)?$user->name:""}}</td>
                                        <th>Email:</th>
                                        <td>{{isset($user->email)?$user->email:""}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Brand Name:</th>
                                        <td>{{isset($user->brand_name)?$user->brand_name:""}}</td>
                                        <th><strong>Logo:</strong></th>
                                        <td>Logo</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tutor Verified:</th>
                                        <td>{{$user->tutor_verify==1?"Yes":"No"}}</td>
                                        <th><strong>TutorType:</strong></th>
                                        <td>
                                            @if($user->tutor_type==1)
                                                Coaching Center
                                            @elseif($user->tutor_type==2)
                                             School
                                            @elseif($user->tutor_type==3)
                                                Individual Tutor
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date Of Birth</th>
                                        <td>{{isset($user->date_of_birth)?Carbon\Carbon::parse($user->date_of_birth)->format('d M Y'):""}}</td>
                                        <th><strong>Address:</strong></th>
                                        <td>
                                            {{$user->address}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">City</th>
                                        <td>{{$user->city}}</td>
                                        <th><strong>Pincode:</strong></th>
                                        <td>
                                            {{$user->pincode}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Teaching Specialties</th>
                                        <td>{{$user->teaching_specialties}}</td>
                                        <th><strong>Teaching Style:</strong></th>
                                        <td>
                                            {{$user->teaching_style}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Country Name</th>
                                        <td>{{$user->country_name}}</td>
                                        <th><strong>Intro Video:</strong></th>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#video-intro">
                                                Play Video
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Introduction</th>
                                        <td>{{$user->intro_text}}</td>
                                        <th><strong>languages:</strong></th>
                                        <td>
                                           {{$user->languages}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Education</th>
                                        <td>{{$user->education}}</td>
                                        <th><strong>certification:</strong></th>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#check-certificate">
                                               Check Certificate
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Experience</th>
                                        <td>{{$user->experience}}</td>
                                        <th><strong>Payment Method:</strong></th>
                                        <td>
                                            {{$user->payment_gateway}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Stripe Account</th>
                                        <td>{{$user->stripe_account}}</td>
                                        <th><strong>Stripe Verified:</strong></th>
                                        <td>
                                            {{$user->stripe_verified==1?"yes":"no"}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Razorpay Account</th>
                                        <td>{{$user->razorpay_account}}</td>
                                        <th><strong>Razorpay Verified:</strong></th>
                                        <td>
                                            {{$user->razorpay_verified==1?"yes":"no"}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tutor Active</th>
                                        <td>{{$user->disable_user==1?"No":"Yes"}}</td>
                                        <th><strong>Phone Number</strong></th>
                                        <td>
                                            {{$user->phone_number}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Selected Plan</th>
                                        <td>{{$user->selected_plan}}</td>
                                        <th><strong>Purchased Date</strong></th>
                                        <td>
                                            {{isset($user->purchased_date)?Carbon\Carbon::parse($user->purchased_date)->format('d M Y'):""}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Timezone</th>
                                        <td>{{$user->timezone}}</td>
                                        <th><strong>Plan End On</strong></th>
                                        <td>
                                            {{isset($user->plan_end_on)?Carbon\Carbon::parse($user->plan_end_on)->format('d M Y'):""}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="form-group mt-4">
                                    <label for="">Add Status</label>
                                    <select name="tutor_verify" class="form-control">
                                        @if($user->tutor_verify==0)
                                            <option value="1">Verified</option>
                                            <option value="2">Reject</option>
                                            <option value="0" selected>UnVerify</option>
                                        @elseif($user->tutor_verify==1)
                                            <option value="1" selected>Verified</option>
                                            <option value="2">Reject</option>
                                            <option value="0">UnVerify</option>
                                        @else
                                            <option value="1">Verified</option>
                                            <option value="2" selected>Reject</option>
                                            <option value="0">UnVerify</option>
                                        @endif
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                   Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="video-intro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Intro Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video width="320" height="240" controls>
                        <source src="{{$user->intro_video}}" type="video/mp4">

                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="check-certificate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Certificate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(pathinfo($user->certificate_file, PATHINFO_EXTENSION)=="pdf")
                        <a href="{{$user->certificate_file}}">check Pdf</a>
                    @else
                        <img src="{{$user->certificate_file}}" class="img-fluid" alt="certificate File">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection



