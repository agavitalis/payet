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
                    <h3>Log Cash</h3>
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

            
            <div class="row">
              <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-bars"></i>Fill to log cash <small>( cash can only be logged for organizations and logged cash are not added to your wallets)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">Log Cash Here!</a>
                        </li>
                        
                      </ul>
                      <div id="myTabContent" class="tab-content">
                         <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                             <div class="x_content">
                                <br/>
                                <form class="form-horizontal form-label-left input_mask" method="POST" action="{{ route('log_cash')}}">

                                     {{ csrf_field() }}
                                    <input type="hidden" name="w_action" value="with_wallet">

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" name="w_fname" placeholder="First Name"  value="{{Auth::user()->first_name}}">
                                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control" name="w_lname" placeholder="Last Name"  value="{{Auth::user()->last_name}}">
                                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" name="w_email" placeholder="Email"  value="{{Auth::user()->email}}">
                                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control" name="w_phone" placeholder="Phone" value="{{Auth::user()->phone}}">
                                        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <select class="form-control" name="w_wallet">
                                            <option>Select Wallet</option>
                                            @foreach($organizations as $organization)
                                            <option value="{{$organization->wallet}}" >Wallet ID: {{$organization->wallet}}</option>
                                            @endforeach
                                            
                                        </select>
                                        <span class="fa fa-credit-card form-control-feedback right" aria-hidden="true"></span>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="number" class="form-control"required  name="w_amount" placeholder="Amount">
                                        <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                                    </div>

                                
                                  
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <textarea class="form-control" required rows="3" name="w_summary" placeholder='Transaction Summary'></textarea>
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                            <button class="btn btn-primary  pull-right" type="reset">Reset</button>
                                            <button type="submit" class="btn btn-success  pull-right">Log Cash</button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                         </div>

                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="clearfix"></div>

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