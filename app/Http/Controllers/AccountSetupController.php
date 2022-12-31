<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\DB;

class AccountSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::select('id','name','email','phone_number' ,'payment_gateway', 'stripe_account', 'stripe_verified', 'razorpay_account', 'razorpay_verified')->where('user_role', 'tutor')->latest();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('payment_gateway', function ($row) {
                    if (isset($row->payment_gateway) && !empty($row->payment_gateway)) {
//                        if ($row->payment_gateway =='stripe') {
//                            return '<span class="badge badge-primary">Stripe</span>';
//                        } elseif ($row->payment_gateway == 'razorpay') {
//                            return '<span class="badge badge-primary">Razorpay</span>';
//                        }
                        return $row->payment_gateway;
                    } else {
                        return  "not selected";
                    }
                    return "payment";
                })
                ->addColumn('action', function ($row) {
                    return '<a href="/account-setup/'.$row->id.'/edit">Edit</a>';
                })
                ->addColumn('razorpay_verified', function ($row) {
                    if ($row->razorpay_verified){
                        return "Yes";
                    } else {
                            return 'No';
                    }
                })->addColumn('stripe_verified', function ($row) {
                    if ($row->stripe_verified){
                        return "Yes";
                    } else {
                            return 'No';
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

                ->make(true);
        }

        return view('account.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account=User::find($id);
        return view('account.edit',compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $account = User::find($id);
        $account->payment_gateway = $request->payment_gateway;
        $account->stripe_account = $request->stripe_account;
        $account->stripe_verified = $request->stripe_verified;
        $account->razorpay_account = $request->razorpay_account;
        $account->razorpay_verified = $request->razorpay_verified;
        $account->save();

        return redirect()->route('account-setup.index')->with('success', "Account successfully updated");

    }


}
