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
                    <h3>My Personal Wallet</h3>
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
                @include('partials.user.alert')

                <div class="clearfix"></div>
                <div class="row">
                   
                    <div class="col-md-12">
                            <div class="x_panel">
                            <div class="x_content">
                                <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                    <ul class="pagination pagination-split">
                                    <li><a href="#">M</a></li>
                                    <li><a href="#">Y</a></li>
                                    <li>...</li>
                                    <li><a href="#">P</a></li>
                                    <li><a href="#">E</a></li>
                                    <li><a href="#">R</a></li>
                                    <li><a href="#">S</a></li>
                                    <li><a href="#">O</a></li>
                                    <li><a href="#">N</a></li>
                                    <li><a href="#">L</a></li>

                                    <li>...</li>
                                    <li><a href="#">W</a></li>
                                    <li><a href="#">A</a></li>
                                    <li><a href="#">L</a></li>
                                    <li><a href="#">L</a></li>
                                    <li><a href="#">E</a></li>
                                    <li><a href="#">T</a></li>
                                    
                                    </ul>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-md-6 col-md-offset-3  col-xs-12 profile_details">
                                    <div class="well profile_view">
                                    <div class="col-sm-12">
                                        <h4 class="brief"><i>Wallet ID: {{Auth::user()->username}}</i></h4>
                                        <div class="left col-xs-7">
                                        <h2>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h2>
                                        <p><strong>Email: </strong>{{Auth::user()->email}}</p>
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-user"></i> Username:{{Auth::user()->username}} </li>
                                            <li><i class="fa fa-phone"></i> Phone #:{{Auth::user()->phone}} </li>
                                            <li><i class="fa fa-credit-card"></i> Account Balance:</li>
                               
                                        </ul>
                                            <div class="tile-stats">
                                                <div class="count"><i class="fa fa-money"></i>  N{{Auth::user()->wallet_balance}}</div>
                                            </div>
                                        </div>
                                        <div class="right col-xs-5 text-center">
                                        <img src="../images/wallet.jpg" alt="" class="img-circle img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 bottom text-center">
                                        
                                        <div class="col-xs-12 col-sm-12 emphasis">
                                        
                                            <a class="btn btn-success btn-flat" href="/make_payment"> <i class="fa fa-heart"> </i> Make Payment</a>
                    
                                            <a class="btn btn-primary btn-flat" href="/make_payment"><i class="fa fa-credit-card"> </i> Fund Wallet</a>
                                       
                                            <a class="btn btn-info btn-flat" href="/transactions/{{Auth::user()->username}}"><i class="fa fa-eye"> </i> View Transactions</a>
                                        
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                
                               

                                
                                </div>
                            </div>
                            </div>
                        </div>






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
    
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
   
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../vendors/starrr/dist/starrr.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
	
    <script src="../js/custom.js"></script>
 
</body>
</html>
    
@endsection