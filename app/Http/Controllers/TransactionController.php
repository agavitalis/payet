<?php

namespace App\Http\Controllers;

Use Illuminate\Http\Request;
Use Validator;
Use Response;
Use Auth;
Use DB;
Use Illuminate\Support\Facades\Input;
Use App\Model\Transaction;
Use App\Model\Organization;
Use App\Model\User;
Use App\Model\Withdraw;


class TransactionController extends Controller
{
     //function to generate random string
    public function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function payments(Request $request){
        if($request->isMethod('GET'))
        {    
            //select all my organizations     
            $organizations  =   DB::table('organizations')->where('owned_by', Auth::user()->username)->get();
            return view('user.make_payment',compact('organizations')); 
        }
        elseif($request->isMethod('POST'))
        {
            if($request->action =="with_atm"){

                $transaction = new Transaction;

                
                $transaction->first_name = $request->fname;
                $transaction->last_name = $request->lname;
                $transaction->username = Auth::user()->username;
                $transaction->email = $request->email;
                $transaction->phone = $request->phone;

                $transaction->transaction_id = $request->trans_id;
                $transaction->transaction_by = Auth::user()->username;
                $transaction->transaction_benefit = $request->receiver_wallet;
                $transaction->benefit_type = 'CREDIT';
                $transaction->transaction_type = 'DEBIT';
                $transaction->transaction_details =  $request->summary;
                $transaction->transaction_mode = 'Debit_Card';
                $transaction->transaction_status = 'successfull';
                $transaction->amount = $request->amount;

                $transaction->save();

                
                 //check to make sure the receiver wallet is functional
                $org_wallet = DB::table('organizations')->where(['wallet'=> $request->receiver_wallet,'approved'=>1])->get()->count();
                $per_wallet = DB::table('users')->where(['username'=> $request->receiver_wallet])->get()->count();
                

                //credit  the receiver wallet
                if($per_wallet > 0){

                    $user_wallet = DB::table('users')->where(['username'=> $request->receiver_wallet])->first();
                    
                    $user = User::find( $user_wallet->id);
                    $user->wallet_balance = $user->wallet_balance + $request->amount;
                    $user->update(); 

                }
                else {
                    $org_wallet = DB::table('organizations')->where(['wallet'=> $request->receiver_wallet])->first();
                    
                    $org = Organization::find( $org_wallet->id);
                    $org->wallet_balance = $org->wallet_balance + $request->amount;
                    $org->update();
                }


             return Response::json($request);
            }
            elseif($request->w_action =="with_wallet"){

                //check to make sure the receiver wallet is functional
                $org_wallet = DB::table('organizations')->where(['wallet'=> $request->w_receiver,'approved'=>1])->get()->count();
                $per_wallet = DB::table('users')->where(['username'=> $request->w_receiver,])->get()->count();
                
                if($org_wallet == 0 && $per_wallet == 0){
                    return back()->with('error','Selected receiver wallet not found, contact the admin for correct wallet address(Wallet IDs must match exactly)');
                }

                //check if it is a person wallent or an organizational wallet before logging payment
                if($request->w_wallet == Auth::user()->username){
                    //it is a personal wallet then check his account balance
                    if(Auth::user()->wallet_balance < $request->w_amount){
                        return back()->with('error','Insufficient balance in the selected wallet, the transaction could not be completed');
                    }
                    else{

                        //debit the wallet given
                        $user = User::find(Auth::user()->id);
                        $user->wallet_balance = $user->wallet_balance - $request->w_amount;
                        $user->update();

                        //generate a transaction ID
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < 8; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }

                        //then create a new transaction
                        
                        $transaction = new Transaction;
                    
                        $transaction->first_name = $request->w_fname;
                        $transaction->last_name = $request->w_lname;
                        $transaction->username = Auth::user()->username;
                        $transaction->email = $request->w_email;
                        $transaction->phone = $request->w_phone;

                        $transaction->transaction_id = $randomString;
                        $transaction->transaction_by = $request->w_wallet;
                        $transaction->transaction_type = 'DEBIT';
                        $transaction->transaction_benefit = $request->w_receiver;
                        $transaction->benefit_type = 'CREDIT';
                        $transaction->transaction_details =  $request->w_summary;
                        $transaction->transaction_mode = ' Personal Wallet';
                        $transaction->transaction_status = 'successful';
                        $transaction->amount = $request->w_amount;

                        $transaction->save();

                        //credit  the receiver wallet
                        if($per_wallet > 0){
                            
                            $user_wallet = DB::table('users')->where(['username'=> $request->w_receiver])->first();
                            
                            $user = User::find( $user_wallet->id);
                            $user->wallet_balance = $user->wallet_balance + $request->w_amount;
                            $user->update(); 

                        }
                        else {
                            $org_wallet = DB::table('organizations')->where(['wallet'=> $request->w_receiver])->first();
                            
                            $org = Organization::find( $org_wallet->id);
                            $org->wallet_balance = $org->wallet_balance + $request->w_amount;
                            $org->update();
                        }

                        return back()->with('success','Transaction successful,receiver credited');

                    }
                    
                }
                else{
                    //it is organizational wallet. log the transactions
                    $org_wallet = DB::table('organizations')->where(['wallet'=> $request->w_wallet])->first();
                    
                    if( $org_wallet->wallet_balance < $request->w_amount){
                        return back()->with('error','Insufficient balance in the selected organizational  wallet, the transaction could not be completed');
                    }
                    else{
                         
                         //debit the wallet given
                        $org_wallet = DB::table('organizations')->where(['wallet'=> $request->w_wallet])->first();
                            
                            $org = Organization::find( $org_wallet->id);
                            $org->wallet_balance = $org->wallet_balance - $request->w_amount;
                            $org->update();

                        //generate a transaction ID
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $charactersLength = strlen($characters);
                        $randomString = '';
                        for ($i = 0; $i < 8; $i++) {
                            $randomString .= $characters[rand(0, $charactersLength - 1)];
                        }

                        //then create a new transaction
                        
                        $transaction = new Transaction;
                    
                        $transaction->first_name = $request->w_fname;
                        $transaction->last_name = $request->w_lname;
                        $transaction->username = Auth::user()->username;
                        $transaction->email = $request->w_email;
                        $transaction->phone = $request->w_phone;

                        $transaction->transaction_id = $randomString;
                        $transaction->transaction_by = $request->w_wallet;
                        $transaction->transaction_type = 'DEBIT';
                        $transaction->transaction_benefit = $request->w_receiver;
                        $transaction->benefit_type = 'CREDIT';
                        $transaction->transaction_details =  $request->w_summary;
                        $transaction->transaction_mode = ' Personal Wallet';
                        $transaction->transaction_status = 'successful';
                        $transaction->amount = $request->w_amount;

                        $transaction->save();

                        //credit  the receiver wallet
                        if($per_wallet > 0){

                            $user_wallet = DB::table('users')->where(['username'=> $request->w_receiver])->first();
                            
                            $user = User::find( $user_wallet->id);
                            $user->wallet_balance = $user->wallet_balance + $request->w_amount;
                            $user->update(); 

                        }
                        else {
                            $org_wallet = DB::table('organizations')->where(['wallet'=> $request->w_receiver])->first();
                            
                            $org = Organization::find( $org_wallet->id);
                            $org->wallet_balance = $org->wallet_balance + $request->w_amount;
                            $org->update();
                        }

                        return back()->with('success','Transaction successful,receiver credited');
               
                    }
                }
                

            }
           else{
                    //dd($request);
                    return back()->with('error',' Unrecognized Command');
          
            }
        }
    }

    public function receipt($id = null) {
       if($id != null){
        $transaction = Transaction::find($id);
        return view('user.receipt',compact('transaction'));

       }else {
           return back()->with('error','Opps, Your  request is not recognized');
       }
    }

    public function transactions($id = null){
        //show based on selection
        if($id != null){
            $transactions  =   DB::table('transactions')->where('transaction_by',$id )->orWhere('transaction_benefit',$id)->get();
            return view('user.transactions',compact('transactions'));
        }else {
            $transactions  =   DB::table('transactions')->where('username',Auth::user()->username)->get();
          return view('user.transactions',compact('transactions'));
        }
          
    }

    public function print_receipts(){
          $transactions  =   DB::table('transactions')->where('username',Auth::user()->username)->get();
        return view('user.print_receipts',compact('transactions'));
    }

    public function log_cash(Request $request){
        if($request->isMethod('GET'))
        {    
            //select all my organizations     
            $organizations  =   DB::table('organizations')->where('owned_by', Auth::user()->username)->get();
            return view('user.log_cash',compact('organizations')); 
        }
        elseif($request->isMethod('POST'))
        {

                //generate a transaction ID
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < 8; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }

                 //then create a new transaction
                        
                $transaction = new Transaction;
            
                $transaction->first_name = $request->w_fname;
                $transaction->last_name = $request->w_lname;
                $transaction->username = Auth::user()->username;
                $transaction->email = $request->w_email;
                $transaction->phone = $request->w_phone;

                $transaction->transaction_id = $randomString;
                $transaction->transaction_by =  Auth::user()->username;
                $transaction->transaction_type = 'CASH';
                $transaction->transaction_benefit = $request->w_wallet;
                $transaction->benefit_type = 'CASH';
                $transaction->transaction_details =  $request->w_summary;
                $transaction->transaction_mode = ' Cash by hand';
                $transaction->transaction_status = 'successful';
                $transaction->amount = $request->w_amount;

                $transaction->save();

                 return back()->with('success','Transaction successful,Cash successfully logged');
        }
    }   
    
   public function request_withdrawal(Request $request){
       if($request->isMethod("GET")){

            //select all my organizations     
            $organizations  =   DB::table('organizations')->where('owned_by', Auth::user()->username)->get();
            
            return view('user.request_withdrawal',compact('organizations'));
       }
       else{
             
            //check how much the guy have in his wallet
            if( Auth::user()->username == $request->wallet_id )
            {
               
                if($request->amount > Auth::user()->wallet_balance){

                    return back()->with('error','Insufficient balance in the wallet selected5678');
                }
                else{
                        
                        //then create a withdraw
                        $withdraw = new Withdraw;
                        $withdraw->done_by =  Auth::user()->username;
                        $withdraw->wallet_id = $request->wallet_id;
                        $withdraw->amount = $request->amount;
                        $withdraw->paid ="NO";
                        $withdraw->date_requested = $request->withdraw_date;
                        $withdraw->date_paid ="NOT YET";
                        $withdraw->details = $request->about;

                        $withdraw->save();
                    
                        return back()->with('success','Your withdrawal request have successfully been recorded');
                        // $user = User::find( Auth::user()->id);
                        // $user->wallet_balance = $user->wallet_balance + $request->amount;
                        // $user->update(); 
                    }

            }
            else
            {
                
                $organizations  =   DB::table('organizations')->where('owned_by', Auth::user()->username)->first();   
                $org = Organization::find( $organizations->id);

                if($request->wallet >  $org->wallet_balance){

                    return back()->with('error','Insufficient balance in the wallet selected');
                }
                else{

                    //then create a withdraw
                    $withdraw = new Withdraw;
                    $withdraw->done_by =  Auth::user()->username;
                    $withdraw->wallet_id = $request->wallet_id;
                    $withdraw->amount = $request->amount;
                    $withdraw->paid ="NO";
                    $withdraw->date_requested = $request->withdraw_date;
                    $withdraw->date_paid ="NOT YET";
                    $withdraw->details = $request->about;

                    $withdraw->save();
                
                    return back()->with('success','Your withdrawal request have successfully been recorded');
                    
                }
                           
            }

            
       }
   } 
   public function view_withdrawal(){
        //select all my withdraw requests     
        $withdraws  =   DB::table('withdraws')->where('done_by', Auth::user()->username)->get();
        
        return view('user.view_withdrawals',compact('withdraws'));
   }

}
