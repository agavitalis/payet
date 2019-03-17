
@extends('layouts.app')

@section('header')
@include('partials.admin.header')
@endsection

@section('body')

 <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
                <div class="page-title">
                <div class="title_left">
                    <h3>My Profile</h3>
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
            <div class="col-md-12 "><h1>Update your E-FEES Platform Profile</h1></div>
            <form class="form-horizontal" method="POST" action="{{ route('admin_edit_profile') }}">
                <div class="animate col-md-6">

                    {{ csrf_field() }}
                    <div>
                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{Auth::user()->first_name}}" placeholder="First Name" required autofocus>

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div>
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{Auth::user()->last_name}}" placeholder="Last Name" required autofocus>

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div>
                        <input id="username" type="text" disabled class="form-control" name="username" value="{{Auth::user()->username}}" placeholder="Username" required autofocus>

                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div>
                        <input id="phone" type="phone" class="form-control" name="phone" value="{{Auth::user()->phone}}" placeholder="Phone Number" required autofocus>

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                    </div>
                    
                </div>

                <div class="animate col-md-6">

                    {{ csrf_field() }}
                    <div>
                        <input id="email" type="text" class="form-control" name="email" value="{{Auth::user()->email}}" placeholder="Email Address" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                    </div>
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
                       
                            <textarea class="form-control" rows="3" name="about" placeholder='Tell us about yourself'></textarea>
                        
                    </div>
                    <div class="ln_solid"></div>

                    <div>
                        
                                        
                        <button type="submit" class="btn btn-primary">
                            Update Profile
                        </button>
                        <a class="reset_pass" href="#">
                            Usernames cannot be changed
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
  @include('partials.admin.footer')
@endsection



@section('scripts')
     <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script src="../js/custom.js"></script>
@endsection