@extends('layouts.master')
@section('page-css')
<?php


?>
<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/styles/vendor/quill.bubble.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/quill.snow.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')
            <div class="breadcrumb">
                <h1>Exhibitor</h1>
                <ul>
                  <li>Details</li>
                </ul>

            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row mb-4">
               <form method="POST" action="exhibitor">
         {{ csrf_field() }}
                 <div class="form-group" style="margin-left: 20px;">
                    <select class="form-control input-sm" name="search" id="search" >
                        <option value="" class="active"<?php if(isset($search) && $search==$search) ?>>{{empty($search) ? 'All Status'  : $search}}</option>
                        <option value="Active" >Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="">{{empty($search) ? ''  : 'All Status'}}</option>
                    </select> 
                     <button class="btn btn-primary" style=" margin-top: -54px; margin-left: 96px;" >Check</button>
                </div>                                   
                
             
            </form>
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
                    <th scope="col">Address</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Whatsapp No</th>
                    <th scope="col">Plan</th>
                    <th scope="col">Count Counselor</th>
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
                        <td>{{$list->exhim_organization_name}}</td>
                        <td>{{$list->exhim_address}}</td>
                        <td>{{$list->exhim_contact_email}}</td>
                        <td>{{$list->exhim_whatsapp}}</td> 
                        <td>{{$list->ppm_text}}</td>
                        <td><span class="badge btn-danger" onclick="showcounselor('{{$list->exhim_id}}');" style="cursor: pointer;">{{$list->counselor }}</span></td>                      
                        <td>
						@if($list->eem_status=='active')
                        
                        <label class="switch switch-success mr-3" onclick="checked('{{$list->eem_id}}','{{$list->ppm_id}}');">
                        	<input type="checkbox" checked="">
                            <span class="slider"></span>
                        </label>
                        @else
                        <label class="switch switch-success mr-3" onclick="checked('{{$list->eem_id}}','{{$list->ppm_id}}');"> 
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                        </td>
                        @endif
                        <td><a href="javascript:void(0);" class="text-success mr-2" onclick="addexhibitoruser('{{$list->exhim_id}}');">
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
                            <h5 class="modal-title" id="exampleModalCenterTitle-2"><h4>Add New Exhibitor</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form name="addneexhibitor" id="addneexhibitor" class="" action="saveuserprofile" method="post"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                              <input class="form-control" type="hidden" name="addcourse" id="addcourse" value="addcourse" />
                             <div class="card mb-4">
                             	<div class="card-body">                
                                <div class="row">
                                    
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_duration">Organization Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                        value="">
                                        <span class="text-danger" id="err_name" name="err_name"  style="display:none;"></span>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_sem">Contact E-mail</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="E-mail Address" 
                                         value="">
                                        <span class="text-danger" id="err_email" name="err_email"  style="display:none;"></span>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_year">Contact No</label>
                                        <input type="number" class="form-control" name="phone" id="phone"  placeholder="Mobile"
                                         value="">
                                        <span class="text-danger" id="err_contact" name="err_contact"  style="display:none;"></span>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_year">WhatsApp No</label>
                                        <input type="number" class="form-control" name="whatsApp" id="whatsApp"  placeholder="WhatsApp No"  
                                            value="">
                                        <span class="text-danger" id="err_whatsapp" name="err_whatsapp"  style="display:none;"></span>
                                    </div> 
                                    
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_sem">Select State</label>
                                        
                                         <select class="form-control" id="category" name="sm_id">

		  								 <option value="">Select State</option>
										 @foreach($category as $cut)
										 <option value="{{$cut->sm_id}}">{{$cut->sm_name}}</option>
		  								
		  								@endforeach
		  								</select>
                                        <span class="text-danger" id="err_state" name="err_state"  style="display:none;"></span>
                                    </div> 
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_sem">Select City</label>
                                        <select class="form-control" id="subcategory" name="cm_id">
		  								 
											
										
		  								</select>
                                        <span class="text-danger" id="err_city" name="err_city"  style="display:none;"></span>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_sem">Address</label>
                                        <input type="text" class="form-control" name="address" id="address" placeholder=" Address" 
                                         value="">
                                        <span class="text-danger" id="err_address" name="err_address"  style="display:none;"></span>
                                    </div> 
                                    <div class="col-md-6 form-group mb-3" id="modal-content">
                                        <label for="course_fee_sem">Select Plan</label>
                                        <select class="form-control chosen" id="plan" name="plan">
                                           
                                            @foreach($plans as $plan)
                                            <option value="{{$plan->ppm_id}}">{{$plan->ppm_text}}</option>
                                        
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="err_plan" name="err_plan"  style="display:none;"></span>
                                    </div>
                                </div>
                        </div>
                        
                    		</div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary ladda-button basic-ladda-button" data-style="expand-right" onclick="Addexhibitor()">Add Exhibitor</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
 <!--End Courses Offered modal -->

<!--start count counselor -->
<div class="modal fade" id="ex_showcounselor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="documents">
                    <div class="modal-content" id="showcounselor_ex">
                        
            </div>
        </div>
    </div>
<!--End count counselor -->

<!-- start Edit User modal -->
        <div class="modal fade" id="Editexhibitormodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content" id="edit">
                        
                        
                        
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
 	//category
 	$('#category').change(function(){
    var categoryID = $(this).val();    
    if(categoryID){
        $.ajax({
        	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
           type:"POST",
           url:"{{url('subcategorylist')}}/"+categoryID,
           success:function(res){               
            if(res){
                $("#subcategory").empty();
                $("#subcategory").append('<option>Select City</option>');
                $.each(res,function(key,value){
                    $("#subcategory").append('<option value="'+key+'">'+value+'</option>');
                });
           
            }else{
               $("#subcategory").empty();
            }
           }
        });
    }else{
        $("#subcategory").empty();
    }      
   });


 	function addexhibitoruser(exhim_id){
 		//alert('hhh');return false;
            $('#edit').html('');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: 'editexhibitor',
               	data: 'exhim_id='+exhim_id,
                success: function (data) {           
                    $('#edit').html(data);
                    $('#Editexhibitormodal').modal('toggle')
                    }      
            });
        }



        function Addexhibitor()
        {    	
        	if($.trim($('#name').val())==''){
            $("#err_name").html('Pleae Enter Name');
            $("#err_name").fadeIn('fast');
            document.
            addneexhibitor.name.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_name').offset().top);
                    return false;
          }
          if($.trim($('#email').val())==''){
            $("#err_email").html('Pleae Enter Email Address');
            $("#err_email").fadeIn('fast');
            document.addneexhibitor
            .email.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_email').offset().top);
                    return false;
          }
          if($.trim($('#phone').val())==''){
            $("#err_contact").html('Pleae Enter Mobile');
            $("#err_contact").fadeIn('fast');
            document.
            addneexhibitor.phone.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_contact').offset().top);
                    return false;
          }

           var phone = document.getElementById('phone');
          if (phone.value.length < 10) {
            $("#err_contact").html('Please Enter 10 Digit Mobile No.');
            $("#err_contact").fadeIn('fast');
            document.
            addneexhibitor.phone.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_contact').offset().top);
                    return false;
          }


           if($.trim($('#whatsApp').val())==''){
            $("#err_whatsapp").html('Pleae Enter Whatsapp No');
            $("#err_whatsapp").fadeIn('fast');
            document.
            addneexhibitor.whatsApp.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_whatsapp').offset().top);
                    return false;
            }

            var whatsapp = document.getElementById('whatsApp');
            if (whatsapp.value.length < 10) {
            $("#err_whatsapp").html('Please Enter 10 Digit Whatsapp No.');
            $("#err_whatsapp").fadeIn('fast');
            document.
            addneexhibitor.whatsApp.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_whatsapp').offset().top);
                    return false;
            }
            if($.trim($('#category').val())==''){
            $("#err_state").html('Pleae Select State');
            $("#err_state").fadeIn('fast');
            document.
            addneexhibitor.category.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_state').offset().top);
                    return false;
            }
            if($.trim($('#subcategory').val())==''){
            $("#err_city").html('Pleae Select City');
            $("#err_city").fadeIn('fast');
            document.
            addneexhibitor.subcategory.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_city').offset().top);
                    return false;
            }
            if($.trim($('#address').val())==''){
            $("#err_address").html('Pleae Enter Address');
            $("#err_address").fadeIn('fast');
            document.
            addneexhibitor.address.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_address').offset().top);
                    return false;
            }
            $.ajax({
				    method:"POST",
				    url:"Addexhibitor",
				    data:$('#addneexhibitor').serialize(),
				    success:function(data){
				      swal({
				          type: 'success',
				          title: 'Success!',
				          text: 'Exhibitor Added Successfully',
				          buttonsStyling: false,
				          confirmButtonClass: 'btn btn-lg btn-success'
				      })
				      setTimeout(function(){ window.location.reload(); }, 3000);
				      return false;
				    }
				  });
        	}

        function updateExhibitor(exhim_id){

        	if($.trim($('#ex_name').val())==''){
            $("#msg_name").html('Pleae Enter Name');
            $("#msg_name").fadeIn('fast');
            document.
            editexhibitor.ex_name.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#msg_name').offset().top);
                    return false;
          }
          if($.trim($('#ex_email').val())==''){
            $("#msg_email").html('Pleae Enter Email Address');
            $("#msg_email").fadeIn('fast');
            document.editexhibitor
            .ex_email.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#msg__email').offset().top);
                    return false;
          }
          if($.trim($('#ex_phone').val())==''){
            $("#msg_contact").html('Pleae Enter Mobile');
            $("#msg_contact").fadeIn('fast');
            document.
            editexhibitor.ex_phone.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#msg_contact').offset().top);
                    return false;
          }

           var phone = document.getElementById('ex_phone');
          if (phone.value.length < 10) {
            $("#msg_contact").html('Please Enter 10 Digit Mobile No.');
            $("#msg_contact").fadeIn('fast');
            document.
            editexhibitor.ex_phone.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#msg_contact').offset().top);
                    return false;
          }
          	/*if($.trim($('#ex_address').val())==''){
            $("#msg_address").html('Pleae Enter Address');
            $("#msg_address").fadeIn('fast');
            document.
            editexhibitor.ex_address.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#msg_address').offset().top);
                    return false;
            }*/
            if($.trim($('#ex_category').val())==''){
            $("#msg_state").html('Pleae Select State');
            $("#msg_state").fadeIn('fast');
            document.
            editexhibitor.ex_sm_ids.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#msg_state').offset().top);
                    return false;
            }
            if($.trim($('#ex_subcategory').val())==''){
            $("#msg_city").html('Pleae Select City');
            $("#msg_city").fadeIn('fast');
            document.
            editexhibitor.ex_cm_ids.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#msg_city').offset().top);
                    return false;
            }

           if($.trim($('#ex_whatsApp').val())==''){
            $("#msg_whatsapp").html('Pleae Enter Whatsapp No');
            $("#msg_whatsapp").fadeIn('fast');
            document.
            editexhibitor.ex_whatsApp.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#msg_whatsapp').offset().top);
                    return false;
            }

            var whatsapp = document.getElementById('ex_whatsApp');
            if (whatsapp.value.length < 10) {
            $("#msg_whatsapp").html('Please Enter 10 Digit Whatsapp No.');
            $("#msg_whatsapp").fadeIn('fast');
            document.
            editexhibitor.ex_whatsApp.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#msg_whatsapp').offset().top);
                    return false;
            }
        		 $.ajax({
        		 	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                	},
				    method:"POST",
				    url:"Addexhibitor",
				    data:$('#editexhibitor').serialize(),
				    success:function(data){
				      swal({
				          type: 'success',
				          title: 'Success!',
				          text: 'Exhibitor Update Successfully',
				          buttonsStyling: false,
				          confirmButtonClass: 'btn btn-lg btn-success'
				      })
				      setTimeout(function(){ window.location.reload(); }, 3000);
				      return false;
				    }
				  });
        	}

        function checked(eem_id,ppm_id)
            {
              //alert(ppm_id);return false;
              var s = $('#modal-content').clone();
              s.find('.chosen').addClass('swal');

              swal({
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                html: s.html(),
                title: 'Are You Sure !',
                preConfirm: function() {
                  return new Promise(function(resolve) {
                    resolve( $('.chosen.swal').val() );
                  });
                }
              }).then(function(result) {
                // reset modal overflow
                $('.swal2-modal').css('overflow', '');
                $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method:"POST",
                        url: "changeStatus",
                        data: {'eem_id':eem_id,'result':result},
                        success: function (data) {
                              swal({
                                  type: 'success',
                                  title: 'Success!',
                                  text: 'Changed Successfully',
                                  buttonsStyling: false,
                                  confirmButtonClass: 'btn btn-lg btn-success'
                                 })
                                setTimeout(function(){ window.location.reload(); }, 1000);
                                return false;
                            }
                        });
               // swal('Your choice is: ' + result);
              }).catch(function(reason){
                        swal({
                              type: 'error',
                              title: 'Cancel!',
                              text: 'Cancelled Successfully',
                              buttonsStyling: false,
                              confirmButtonClass: 'btn btn-lg btn-danger'
                             })
                            setTimeout(function(){ window.location.reload(); }, 1000);
                                return false;
                    });
              
             
              $('.chosen.swal').chosen({
                width: '35%',
                allow_single_deselect: true
              });
            }

            function showcounselor(exhim_id)
            {
                //alert(exhim_id);
                $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method:"POST",
                        url: "showcounselordetail",
                        data: {'exhim_id':exhim_id},
                        success: function (data) {
                            $('#showcounselor_ex').html(data);
                            $('#ex_showcounselor').modal('toggle')  
                                
                            }
                        });
            }
 </script>

  
@endsection
