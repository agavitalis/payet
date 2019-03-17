<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Model\Organization;
use App\Model\User;
use App\Model\Withdraw;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index(){
        $users=DB::table('users')->where(['user_type'=>'user'])->get()->count();
        $organizations=DB::table('organizations')->get()->count();
        $transactions=DB::table('transactions')->get()->count();
        $withdraws=DB::table('withdraws')->where(['paid'=>'NO'])->get()->count();
      
        return view('admin.index',compact('users','organizations','transactions','withdraws'));
    }

    public function users(){
        //get all my users
            $users  =   DB::table('users')->where('user_type','user')->get();
            
        return view('admin.v_users',compact('users'));
    }

    public function admin_transactions(){
        //get all my transactions
            $transactions  =   DB::table('transactions')->get();
            
        return view('admin.admin_transactions',compact('transactions'));
    }

    public function approve_org( $id = null){
        if($id == null){
            //get all my organizations
            $organizations  =   DB::table('organizations')->where('approved',0)->get();    
            return view('admin.approve_org',compact('organizations'));
        }
        else{
            //approve organization

            $organization = Organization::find($id);
            $organization->approved = 1;
            $organization->save();

            return back()->with('success','Organization approved, successfully ');
        }
          
    }
     public function manage_org( $id = null){
        if($id == null){
            //get all my organizations
            $organizations  =   DB::table('organizations')->where('approved',1)->get();    
            return view('admin.manage_org',compact('organizations'));
        }
        else{
            //approve organization

            $organization = Organization::find($id);
            $organization->approved = 0;
            $organization->save();

            return back()->with('success','Organization suspended, successfully');
        }
          
    }

    public function profile()
    {
        return view('admin.admin_profile',compact(''));
    }


    public function edit_profile(Request $request)
    {
        if($request->isMethod('GET'))
        { 
            return view('admin.admin_edit_profile',compact(''));
        }
        elseif($request->isMethod('POST'))
        {
             //validate this input
            $validatedData = $request->validate([
                'first_name'=>'required',
                'last_name'=>'required',
                'email'=>'required'
            ]);
            //update organization details
            $user = User::find(Auth::user()->id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
           
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            $user->about = $request->about;
            $user->save();

            return back()->with('success','E-FEES Profile, successfully updated');
        }
    }

    public function admin_withdraws(Request $request){
         if($request->isMethod('GET'))
        { 
            $withdraws  =   DB::table('withdraws')->orderBy('id','desc')->get(); 
            return view('admin.withdraw_request',compact('withdraws'));
        }
        elseif($request->isMethod('POST'))
        {
           // dd($request);
            if($request->action == "honor"){

                //subtract his money
                $user_wallet  =   DB::table('users')->where('username',$request->wallet)->get(); 
                $org_wallet  =   DB::table('organizations')->where('wallet',$request->wallet)->get();  

                if($user_wallet->count() > 0){
                     //debit the account
                    $user_wallet  =  DB::table('users')->where('username',$request->wallet)->first(); 
                    $user = User::find($user_wallet->id);
                    $user->wallet_balance = $user->wallet_balance - $request->amount;
                    $user->save();

                    //update the withdraw table

                    $withdraw = Withdraw::find($request->honor_id);
                
                    $withdraw->paid = "HONORED";
                    $withdraw->date_paid = date('Y-m-d H:i:s');
                    $withdraw->save();


                    return back()->with('success','Withdraw request, successfully honored');
                }
                else if($org_wallet->count() > 0){
                    
                    //debit the account
                    $org_wallet  =  DB::table('organizations')->where('wallet',$request->wallet)->first(); 
                    $org = Organization::find($org_wallet->id);
                    $org->wallet_balance = $org->wallet_balance - $request->amount;
                    $org->save();

                    //update the withdraw table

                    $withdraw = Withdraw::find($request->honor_id);
                
                    $withdraw->paid = "HONORED";
                    $withdraw->date_paid = date('Y-m-d H:i:s');
                    $withdraw->save();


                     return back()->with('success','Withdraw request, successfully honored');
                }


            }elseif ($request->action == "reject") {
                $withdraw = Withdraw::find($request->reject_id);
                
                $withdraw->paid = "REJECTED";
                $withdraw->date_paid = date('Y-m-d H:i:s');
                $withdraw->save();

                return back()->with('success','Withdraw request, successfully rejected');
            }
            else{
                return back()->with('error','I dont know what you are talking about');
            }

        }
    }
}
