<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;


class TutorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id', 'name', 'email', 'phone_number', 'last_active_datetime', 'created_at', DB::raw('(select count(id) from users where tutor_id=users.id && user_role="student") as student'), 'selected_plan', 'purchased_date')->where('user_role', 'tutor')->latest();

            return Datatables::of($data)
                ->addIndexColumn()
//                ->orderColumns(['name', 'email','last_active_datetime'], '-:column $1')
                ->orderColumn('selected_plan', function ($query, $order) {
                    $query->orderBy('selected_plan', $order);
                })
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
                    return DB::select('select count(*) as count from users where tutor_id = ?', array($row->id))[0]->count;
                })
                ->orderColumn('purchased_date', function ($query) {
                    $query->orderBy('purchased_date');
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
                ->rawColumns(['disable'])
                ->make(true);
        }

        return view('tutors');
    }
}

