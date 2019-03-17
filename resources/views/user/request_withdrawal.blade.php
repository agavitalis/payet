
@extends('layouts.app')

@section('header')
@include('partials.user.header')
@endsection

@section('body')

 <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
                <div class="page-title">
                <div class="title_left">
                    <h3>Withdraw Request</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                    </div>
                </div>
                </div>
             <div class="clearfix"></div>
              @include('partials.user.alert')

            
           <div class="register_wrapper">

            <section class="login_content"> 
            <div class="col-md-12 "><h1>Withdrawal Request Form</h1></div>
            <form class="form-horizontal" method="POST" action="{{ route('request_withdrawal') }}">
                <div class="animate col-md-6">

                    {{ csrf_field() }}
                    <div>
                        <input id="amount" type="number" class="form-control" name="amount"  placeholder="Enter Amount" required autofocus>

                           
                    </div>
                    <div>
                         <span>I want to be payed on</span>
                        <input id="withdraw_date" type="date" class="form-control" name="withdraw_date" placeholder="I want to be payed on?" required autofocus>
                       
                           
                    </div>
                    <div>
                        <select class="form-control" name="wallet_id">
                            <option>Select Wallet</option>
                            <option value="{{Auth::user()->username}}">Wallet ID: {{Auth::user()->username}}</option>
                            @foreach($organizations as $organization)
                            <option value="{{$organization->wallet}}" >Wallet ID: {{$organization->wallet}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                   
                    
                </div>

                <div class="animate col-md-6">

                   
                   
                    <div>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"placeholder="Confirm Password" required>
                
                    </div>

                    <div>
                       
                            <textarea class="form-control" rows="3" name="about" placeholder='Withdrawal Details'></textarea>
                        
                    </div>
                    <div class="ln_solid"></div>

                    <div>
                        
                                        
                        <button type="submit" class="btn btn-primary">
                            Process My Request
                        </button>
                        <a class="reset_pass" href="#">
                            payments are made on weekends only
                        </a>
                    </div>
                    
                </div>
                <div class="clearfix"></div>

            </form>  
            
            </section>
        
        </div>
            
           

          </div>
        </div>
    <!-- /page content -->
      

     

@endsection


@section('footer')
  @include('partials.user.footer')
@endsection



@section('scripts')
     <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script src="../js/custom.js"></script>
@endsection