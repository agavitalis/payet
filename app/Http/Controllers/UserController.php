<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Organization;
use Auth;
use DB;
use App\Model\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     

    
    public function index(){
       
        $organizations=DB::table('organizations')->where(['owned_by'=>Auth::user()->username])->get()->count();
        $payment_made=DB::table('transactions')->where(['username'=>Auth::user()->username,'transaction_type'=>'DEBIT'])->get()->count();
        $payment_received=DB::table('transactions')->where(['transaction_benefit'=>Auth::user()->username,'transaction_type'=>'CREDIT'])->get()->count();
      
        return view('user.index',compact('organizations','payment_made','payment_received')); 
              
    }

    public function create_org(Request $request){
        if($request->isMethod('GET'))
        {
            return view('user.create_org'); 
        }
        elseif($request->isMethod('POST')){
            //dd($request);

            //validate this input
           
            $validatedData = $request->validate([
            
                'wallet'=>'unique:organizations',
               
            ]);

            $check=DB::table('users')->where(['username'=>$request->wallet])->get()->count();

            if($check > 0){
                return back()->with('error','Organization Wallet already choosen');
  
            }else{

                 $organization = new Organization();
            
                $organization->name =$request->org_name;
                $organization->wallet =$request->wallet;
                $organization->description = $request->org_description;
                $organization->payment_from= $request->payment_from;
                $organization->payment_to= $request->payment_to;
                $organization->owned_by= Auth::user()->username;
                
                
                $organization->save();
                return back()->with('success','Organization successfully created, awaiting approval');
  
            }
           
        }
        
    }

    public function manage_org( $id = null){
        if($id == null)
        {
            //get all my organizations
            $organizations  =   DB::table('organizations')->where('owned_by',Auth::user()->username)->get();
            
            return view('user.manage_org',compact('organizations')); 
        }
        else
        {
            //delete an organization

             Organization::find($id)->delete();
             return back()->with('success','Organization deleted, successfully');

        }
    }

    public function edit_org( $id=null, Request $request){
        if($request->isMethod('GET'))
        {
            //get the organization detail
            $organization = Organization::find($id);       
            return view('user.edit_org',compact('organization')); 
        }
        elseif($request->isMethod('POST'))
        {
            
           //update organization details
            $organization = Organization::find($request->idd);
            $organization->name = $request->org_name;
            $organization->description = $request->org_description;
            $organization->payment_from = $request->payment_from;
            $organization->payment_to = $request->payment_to;

            $organization->save();

            return back()->with('success','Organization details, successfully updated');

           
        }
    }



    public function my_wallet(Request $request){
        if($request->isMethod('GET'))
        {            
            return view('user.my_wallet',compact('')); 
        }
        elseif($request->isMethod('POST'))
        {

        }
    }

    public function other_wallets(Request $request){
        if($request->isMethod('GET'))
        {            
            $wallets  =   DB::table('organizations')->where('owned_by',Auth::user()->username)->get();
            return view('user.other_wallets',compact('wallets')); 
        }
        elseif($request->isMethod('POST'))
        {

        }
    }


    public function profile()
    {
        return view('user.profile',compact(''));
    }


    public function edit_profile(Request $request)
    {
        if($request->isMethod('GET'))
        { 
            return view('user.edit_profile',compact(''));
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
    
}
