@extends('layouts.master')
<?php 
//dump($search);
?>
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/quill.bubble.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/quill.snow.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')
            <div class="breadcrumb">
                <h1>Career Session</h1>
                <ul>
                  <li>Details</li>
                </ul>

            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row mb-4">
	<form method="POST" action="CareerSession">
		 {{ csrf_field() }}
	             <div class="form-group" style="margin-left: 20px;">
                    <select class="form-control input-sm" name="search" id="search" >
                        <option value="">{{empty($search) ? 'All Status'  : $search}}</option>
                        <option value="Active"  ><?php if(isset($search) && $search=='Inactive') echo 'Active'; else echo 'Active' ?></option>
                        <option value="Inactive"><?php if(isset($search) && $search=='Active') echo 'Inactive'; else echo "Inactive"; ?></option>
                        <option value="">{{empty($search) ? ''  : 'All Status'}}</option> 
                    </select> 
                     <button class="btn btn-primary" style=" margin-top: -54px; margin-left: 96px;" >Check</button>
                </div>                                   
                
			 
		 </form> 	    	
<script type="text/javascript">
		
</script>
            <div class="col-md-12 mb-3">

                    <h4>  <a href="#" class="float-right"  data-toggle="modal" data-target="#CounselorModel" ><i class="i-Add">Add </i></a><h4>
            </div>
                <div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">
                            <div class="table-responsive">
                              <div class="row ">
                                  <div class="col-md-12">

    <form method="post" action="{{$_SERVER['REQUEST_URI']}}" id="pageInput">
        <div class="row pagination-bar">
            <div class="col-12 col-md-7">
                <div class="form-group mt-3">
                    @csrf
                    <div class="d-flex flex-row">
                        <div class="mr-2">
                        <select class="custom-select" name="pagination" id="pagination"
                                    onchange="this.form.submit();">
                                    <option value="10" @if($leadList->perPage() == 10) selected @endif>
                                        10
                                    </option>
                                <option value="25" @if($leadList->perPage() == 25) selected @endif>
                                    25
                                </option>
                                <option value="50" @if($leadList->perPage() == 50) selected @endif >
                                    50
                                </option>
                                <option value="75" @if($leadList->perPage() == 75) selected @endif >
                                    75
                                </option>
                                <option value="100"
                                        @if($leadList->perPage() == 100) selected @endif >100
                                </option>
                                <option value="200"
                                        @if($leadList->perPage() == 200) selected @endif >200
                                </option>
                                <option value="500"
                                        @if($leadList->perPage() == 500) selected @endif >500
                                </option>
                            </select>
                        </div>
                      <!-- code goes here -->

                    </div>

                </div>
            </div>
        <div class="col-md-3">
        &nbsp;
        </div>
            <div class="col-md-2 mt-3">
          <div class="form-group ">
              <i class="seacrh-icon"></i>
              <input type="text" class="form-control seacrh-field pl-4" name="search_text" placeholder="Search"  autocomplete="off" value="<?php if(isset($_REQUEST['search_text']) && !empty($_REQUEST['search_text'])){ echo$_REQUEST['search_text']; } ?>" onchange="this.form.submit();">

          </div>
      </div>

        </div>
    </form>

  <div class="table-responsive">
      <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Start DateTime</th>
                    <th scope="col">End DateTime</th>
                    <th scope="col">Zoom Id</th>
                    <th scope="col">Zoom Password</th>
                    <th scope="col">Status</th>          
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
				 @php
                    $i=1
                    @endphp
                    @if(isset($leadList) && !empty($leadList))
                        @foreach($leadList as $list)
                        <?php ?>
                    <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>{{$list->lccs_name}}</td>
                        <td>{{$list->lccs_start_datewtime}}</td>
                        <td>{{$list->lccs_end_datewtime}}</td>
                        <td>{{$list->lccs_zoom_id}}</td> 
                        <td>{{$list->lccs_zoom_pwd}}</td>
                        <td>
						@if($list->lccs_status=='active')
                        
                        <label class="switch switch-success mr-3" onclick="active('{{$list->lccs_id}}');">
                        	<input type="checkbox" checked="">
                            <span class="slider"></span>
                        </label>
                        @else
                        <label class="switch switch-success mr-3" onclick="active('{{$list->lccs_id}}');"> 
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                        </td>
                        @endif
                        <td><a href="javascript:void(0);" class="text-success mr-2" onclick="
						editCounselor('{{$list->lccs_id}}');">
                        <i class="nav-icon i-Pen-2 font-weight-bold"></i></a></td>
                    </tr>
                    @endforeach
                    @else
                        <tr><th scope="row" >Empty record!</th></tr>
                   @endif
                </tbody>
             </table>
             
  </div>
</div>
<div class="col-md-12">

<div class="col-md-6  text-right"></div>
</div>


</div>
</div>

</div>
</div>
</div>
                <!-- end of col -->

 <!-- Courses Offered modal -->
 <div class="modal fade" id="CounselorModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle-2"><h4>Add New Career Session</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form name="addcounselorSession" id="addcounselorSession" class="" action="saveuserprofile" method="post"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                              <input class="form-control" type="hidden" name="addcourse" id="addcourse" value="addcourse" />
                             <div class="card mb-4">
                             	<div class="card-body">                
                                <div class="row">
		                    
		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_duration"> Name</label>
		                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
		                        value="">
		                        <span class="text-danger" id="lcc_name" name="lcc_name"  style="display:none;"></span>
		                    </div>

		                    
							<div class="col-md-6 form-group mb-3">
	                            <label for="picker3">Start Date Time</label>             
	                                <input id="picker3" type="text" step=1 class="form-control" name="picker3" placeholder="Start Date Time">
	                                <div class="input-group-append">
	                                        
	                            </div>
	                            <span class="text-danger" id="lcc_start" name="lcc_start"  style="display:none;"></span>
                        	</div>

							<div class="col-md-6 form-group mb-3">
                            <label for="picker3">End Date Time</label>
                                <input id="enddate" class="form-control" type="text" step=1 name="enddate" placeholder="End Date Time">
                                <div class="input-group-append">                                       
                            	</div>
                            	<span class="text-danger" id="lcc_end" name="lcc_end"  style="display:none;"></span>
                    		</div>

		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_year">Zoom Id</label>
		                        <input type="text" class="form-control" name="zoomid" id="zoomid"  placeholder="Zoom Id"
		                         value="">
		                        <span class="text-danger" id="lcc_zoom" name="lcc_zoom"  style="display:none;"></span>
		                    </div>


		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_year">Zoom Password</label>
		                        <input type="text" class="form-control" name="zoompass" id="zoompass"  placeholder="Zoom Password"  
		                            value="">
		                        <span class="text-danger" id="lccs_zoom_pwd" name="lccs_zoom_pwd"  style="display:none;"></span>
		                    </div> 
		                       
		                </div>
                        </div>
                        
                    		</div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary ladda-button basic-ladda-button" data-style="expand-right" onclick="AddCounselorSession()">Add CareerSession</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
 <!--End Courses Offered modal -->

<!-- start Edit User modal -->
        <div class="modal fade" id="editCounselorSession" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                   <div class="modal-content" id="editsession">
                       
                       
                       
                   </div>
               </div>
           </div>
 <!--End Edit User modal -->
            </div>
            <!-- end of row -->



@endsection

@section('page-js')

<script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.script.js')}}"></script>
 <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
 
 <script type="text/javascript">

 	$(document).ready(function(){
    $("#picker3").focus( function() {
	    $(this).attr({type: 'datetime-local'});
      });
		});

 	$(document).ready(function(){
    $("#enddate").focus( function() {
	    $(this).attr({type: 'datetime-local'});
      });
		});
 	
 			function editCounselor(lccs_id)
            {
                //alert(lccs_id);return false;
                $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method:"POST",
                        url: "editCounselorSession",
                        data: {'lccs_id':lccs_id},
                        success: function (data) {
                            $('#editsession').html(data);
                            $('#editCounselorSession').modal('toggle')  
                                
                            }
                        });
            }

            function AddCounselorSession()
            {
            	if($.trim($('#name').val())==''){
            $("#lcc_name").html('Pleae Enter Name');
            $("#lcc_name").fadeIn('fast');
            document.
            addcounselorSession.name.focus();
             $(window).scrollTop($('#lcc_name').offset().top);
                    return false;
	          }
	          if($.trim($('#picker3').val())==''){
            $("#lcc_start").html('Pleae Enter Start Date Time');
            $("#lcc_start").fadeIn('fast');
            document.addcounselorSession
            .picker3.focus();
             $(window).scrollTop($('#lcc_start').offset().top);
                    return false;
	          }
	          if($.trim($('#enddate').val())==''){
            $("#lcc_end").html('Pleae Enter End Date Time');
            $("#lcc_end").fadeIn('fast');
            document.
            addcounselorSession.enddate.focus();
             $(window).scrollTop($('#lcc_end').offset().top);
                    return false;
	          }

	           if($.trim($('#zoomid').val())==''){
            $("#lcc_zoom").html('Pleae Enter Zoom ID');
            $("#lcc_zoom").fadeIn('fast');
            document.
            addcounselorSession.zoomid.focus();            
             $(window).scrollTop($('#lcc_zoom').offset().top);
                    return false;
	            }

	            
	            if($.trim($('#zoompass').val())==''){
            $("#lccs_zoom_pwd").html('Pleae Enter Zoom Password');
            $("#lccs_zoom_pwd").fadeIn('fast');
            document.
            addcounselorSession.zoompass.focus();
             $(window).scrollTop($('#lccs_zoom_pwd').offset().top);
                    return false;
            	}

            	$.ajax({
				    method:"POST",
				    url:"AddecounselorSession",
				    data:$('#addcounselorSession').serialize(),
				    success:function(data){
				      swal({
				          type: 'success',
				          title: 'Success!',
				          text: 'Counselor Added Successfully',
				          buttonsStyling: false,
				          confirmButtonClass: 'btn btn-lg btn-success'
				      })
				      setTimeout(function(){ window.location.reload(); }, 3000);
				      return false;
				    }
				  });
            }

            function updateCounselorSession()
            {
            	if($.trim($('#e_name').val())==''){
            $("#lccc_name").html('Pleae Enter Name');
            $("#lccc_name").fadeIn('fast');
            document.
            editcounselorsession.e_name.focus();
             $(window).scrollTop($('#lccc_name').offset().top);
                    return false;
	          }
	          if($.trim($('#e_startdates').val())==''){
            $("#lccc_start").html('Pleae Enter Start Date Time');
            $("#lccc_start").fadeIn('fast');
            document.editcounselorsession
            .e_startdates.focus();
             $(window).scrollTop($('#lccc_start').offset().top);
                    return false;
	          }
	          if($.trim($('#e_enddate').val())==''){
            $("#lccc_end").html('Pleae Enter End Date Time');
            $("#lccc_end").fadeIn('fast');
            document.
            editcounselorsession.e_enddate.focus();
             $(window).scrollTop($('#lccc_end').offset().top);
                    return false;
	          }

	           if($.trim($('#e_zoomid').val())==''){
            $("#lccc_zoom").html('Pleae Enter Zoom ID');
            $("#lccc_zoom").fadeIn('fast');
            document.
            editcounselorsession.e_zoomid.focus();            
             $(window).scrollTop($('#lccc_zoom').offset().top);
                    return false;
	            }

	            
	            if($.trim($('#e_zoompass').val())==''){
            $("#lccc_zoom_pwd").html('Pleae Enter Zoom Password');
            $("#lccc_zoom_pwd").fadeIn('fast');
            document.
            editcounselorsession.e_zoompass.focus();
             $(window).scrollTop($('#lccc_zoom_pwd').offset().top);
                    return false;
            	}
            	$.ajax({
        		 	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                	},
				    method:"POST",
				    url:"updateCounselorSession",
				    data:$('#editcounselorsession').serialize(),
				    success:function(data){
				      swal({
				          type: 'success',
				          title: 'Success!',
				          text: 'Counselor Session Update Successfully',
				          buttonsStyling: false,
				          confirmButtonClass: 'btn btn-lg btn-success'
				      })
				      setTimeout(function(){ window.location.reload(); }, 3000);
				      return false;
				    }
				  });
            }

            function active(lccs_id)
            {
            	$.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method:"POST",
                        url: "counselorchangeStatus",
                        data: {'lccs_id':lccs_id},
                        success: function (data) {
                              swal({
                                  type: 'success',
                                  title: 'Success!',
                                  text: 'Changed Successfully',
                                  buttonsStyling: false,
                                  confirmButtonClass: 'btn btn-lg btn-success'
                                 })
                                /*setTimeout(function(){ window.location.reload(); }, 1000);
                                return false;*/
                            }
                        });
            }


			   function Search() {			        
			        var SearchId = $( "#search_text" ).val();
				alert(SearchId);
					$.ajax({
        		 	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                	},
				    method:"POST",
				    url:"active",
				    data:{'SearchId':SearchId},
				    success:function(data){
				      console.log(data);
				    }
				  });
			        
			    }
					
 	
 </script>

  
@endsection
