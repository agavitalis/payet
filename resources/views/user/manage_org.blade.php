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
                    <h3>Manage My Organizations</h3>
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
                    <div class="col-md-12">
                        <div class="x_panel">
                        <div class="x_title">
                            <h2>Your organizations and their wallet IDs</h2>
                            <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <!-- start project list -->
                            <table class="table table-striped projects">
                            <thead>
                                <tr>
                                <th style="width: 1%">#</th>
                                <th style="width: 20%">Organization Name</th>
                                <th>Wallat  ID</th>
                        
                                <th>Status</th>
                                <th style="width: 40%">#Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($organizations as $organization)    
                                <tr>
                                <td>#</td>
                                <td>
                                    <a>{{$organization->name}}</a>
                                    <br/>
                                    <small>Created  {{ Carbon\Carbon::parse($organization->created_at)->diffForHumans() }}</small>
                                </td>
                                <td>
                                   {{$organization->wallet}} 
                                </td>
                               
                                <td>
                                    @if($organization->approved == 1)
                                    <button type="button" class="btn btn-success btn-flat">Verified</button>
                                    @else
                                    <button title="Only Verified Organizations Can Be Managed" type="button" class="btn btn-danger btn-flat">Not Verified</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="/transactions/{{$organization->wallet}}" class="btn btn-primary btn-flat"><i class="fa fa-folder"></i> View Transactions</a>
                                    <a href="/edit_org/{{$organization->id}}" class="btn btn-info btn-flat"><i class="fa fa-pencil"></i> Edit </a>
                                    <a href="/manage_org/{{$organization->id}}" title="This will delete the organization and cannot be undone" class="btn btn-danger btn-flat"><i class="fa fa-trash-o"></i> Delete </a>
                                </td>
                                </tr>
                            @endforeach   
                            </tbody>
                            </table>
                            <!-- end project list -->

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