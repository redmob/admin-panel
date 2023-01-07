<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DataTables;


class TutorController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = User::select('id', 'name', 'email', 'phone_number', 'last_active_datetime', 'created_at', DB::raw('(select count(id) from users where tutor_id=users.id && user_role="student") as student'), 'selected_plan', 'purchased_date', 'tutor_verify')->where('user_role', 'tutor')->latest();
            foreach ($data as $datum) {
                dd($datum->tutor_verify);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('selected_plan', function ($row) {
                    if ($row->selected_plan == "FREE") {
                        return 'FREE';
                    } else {
                        return $row->selected_plan;
                    }
                })
                ->addColumn('last_active_datetime', function ($row) {
                    if (isset($row->last_active_datetime) && !empty($row->last_active_datetime)) {
                        return Carbon::parse($row->last_active_datetime)->format('d M Y H:i:s');
                    }
                    return "";
                })
                ->addColumn('purchased_date', function ($row) {
                    if (isset($row->purchased_date) && !empty($row->purchased_date)) {
                        return Carbon::parse($row->purchased_date)->format('d M Y');
                    }
                    return "";
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d M Y');

                })
                ->addColumn('student', function ($row) {
//                    return DB::select('select count(*) as count from users where (tutor_id = ? && user_role= ?)', array($row->id,"student"))[0]->count;
                    return User::where([['tutor_id', '=', $row->id], ['user_role', '=', 'student']])->count();
                })
                ->addColumn('status', function ($row) {
                    if (isset($row->tutor_verify)) {
                        if ($row->tutor_verify == 1) {
                            return 'Verified';
                        } else if ($row->tutor_verify == 2) {
                            return 'Rejected';
                        } else {
                            return 'UnVerified';
                        }
                    } else {

                        return "-";
                    }

                })
                ->addColumn('action', function ($row) {
                    if (isset($row->tutor_verify)) {
                        if ($row->tutor_verify == 1) {
                            return '<a href="/tutors/' . $row->id . '/edit">UnVerify</a>';
                        } else if ($row->tutor_verify == 2) {
                            return '<a href="/tutors/' . $row->id . '/edit">Rejected</a>';
                        } else {
                            return '<a href="/tutors/' . $row->id . '/edit">Verify</a>';
                        }
                    } else {
                        return '-';
                    }
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('approved') == '1') {
                        $instance->where('selected_plan', 'FREE');
                    }
                    if ($request->get('approved') == '0') {
                        $instance->whereNotIn('selected_plan', ['FREE']);
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['disable', 'action'])
                ->make(true);
        }

        return view('tutors.index');
    }

    public function edit($id)
    {
        $langArray = ["Doctorate or higher", "Master's degree", "Bachelor's degree", "Vocational qualification", "GED", "Secondary education or high school", "Primary education"];
//        teaching_specialties

        $user = User::find($id);


        $newLang = array();
        if (isset($user->teaching_specialties) && !empty($user->teaching_specialties)) {
            $selected_teaching_specialties = explode(',', $user->teaching_specialties);
            foreach ($selected_teaching_specialties as $specialty) {
                $newLang[] = $langArray[$specialty];
            }

            $newLang=implode(',',$newLang);
            $user->teaching_specialties=$newLang;
        }

        if (isset($user->education) &&!empty($user->education)){
            $user->education=$langArray[$user->education];
        }
        if (isset($user->logo) && !empty($user->logo)) {
            $user->logo = App::environment(['staging', 'local']) ? "http://tutorapi.test/public/assets/$id/logo/$user->logo" : Storage::url('public/assets/' . $id . '/' . 'logo/' . $user->logo);
        }

        if (isset($user->intro_video) && !empty($user->intro_video)) {
            $user->intro_video = App::environment(['staging', 'local']) ? "http://tutorapi.test/public/assets/$id/profile/$user->intro_video" : Storage::url('public/assets/' . $id . '/' . 'profile/' . $user->intro_video);
        }

        if (isset($user->certificate_file) && !empty($user->certificate_file)) {
            $user->certificate_file = App::environment(['staging', 'local']) ? "http://tutorapi.test/public/assets/$id/profile/$user->certificate_file" : Storage::url('public/assets/' . $id . '/' . 'profile/' . $user->certificate_file);
        }


        return view('tutors.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->tutor_verify = intval($request->tutor_verify);
        $user->save();
        $message = $request->tutor_verify == 1 ? "Successfully Verified" : "SuccessFully Unverified";
        return redirect()->route('tutors.index')->with('success', $message);
    }
}

