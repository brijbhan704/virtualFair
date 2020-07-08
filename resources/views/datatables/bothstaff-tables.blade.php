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
                <h1>Counselor</h1>
                <ul>
                  <li>Details</li>
                </ul>

            </div>




            <div class="separator-breadcrumb border-top"></div>

          
            <!-- <div class="row mb-4">
                <div class="col-md-12">
                    <h4><i class="fa fa-filter"></i>Filter</h4>
                    <p>Filter Component will come here.</p>
                </div>
            </div> -->
            <!-- end of row -->

            <div class="row mb-4">

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
                    <th scope="col">In Event</th>
                    <th scope="col">Name</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Whatsapp No</th>
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
                       

                    <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>
                            <?php 
                                
                                //dump($list->ebsm_id);
                            ?>
                        @if($list->eewbm_status=='active')
                           
                            <label class="checkbox checkbox-outline-danger" onclick="checked('{{$list->ebsm_id}}','{{$list->eem_id}}');">
                            <input type="checkbox" checked="checked">
                             <span class="checkmark"></span>
                            </label>
                            
                            @else
                            
                            <label class="checkbox checkbox-outline-danger" onclick="checked('{{$list->ebsm_id}}','{{$list->eem_id}}');">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            </label>
                                
                        </td>
                            @endif
                        </td>
                        <td>{{$list->ebsm_name}}</td>
                        <td>{{$list->ebsm_mobile}}</td>
                        <td>{{$list->ebm_login_user}}</td>
                        <td>{{$list->eem_whatsapp_no}}</td>
                        <td>{{$list->staffStatus}}</td>
                        <td> <a href="javascript:void(0);" class="text-success mr-2" onclick="editCounselor('{{$list->ebsm_id}}');">
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

<div class="col-md-6  text-right">{{$leadList->onEachSide(2)->appends(request()->except('page'))->links()}}</div>
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
                            <h5 class="modal-title" id="exampleModalCenterTitle-2"><h4>Add New Counselor</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form  name="addnewuser" id="addnewuser" class="" action="#" method="post">
                              {{ csrf_field() }}
                        <div class="modal-body">
                              <input class="form-control" type="hidden" name="addcourse" id="addcourse" value="addcourse" />
                             <div class="card mb-4">
                        <div class="card-body">
                           
                                <div class="row">
                                    
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_duration">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                        value="">
                                        <span class="text-danger" id="err_msg_cn" name="err_msg_cn"  style="display:none;"></span>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_sem">E-mail</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="E-mail Address" 
                                         value="">
                                        <span class="text-danger" id="err_msg_cf" name="err_msg_cf"  style="display:none;"></span>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_year">Password</label>
                                        <input type="text" class="form-control" name="password" id="password"  placeholder="Password"  
                                            value="">
                                        <span class="text-danger" id="pass" name="pass"  style="display:none;"></span>

                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_year">Mobile No</label>
                                        <input type="number" class="form-control" name="phone" id="phone"  placeholder="Mobile"
                                         value="">
                                        <span class="text-danger" id="err" name="err"  style="display:none;"></span>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_year">WhatsApp No</label>
                                        <input type="number" class="form-control" name="whatsapp" id="whatsapp"  placeholder="WhatsApp No"  
                                            value="">
                                        <span class="text-danger" id="err_msg" name="err_msg"  style="display:none;"></span>
                                    </div>    
                                </div>
                        </div>
                    </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary ladda-button basic-ladda-button" data-style="expand-right" onclick="Adduser()">Add User</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
 <!--End Courses Offered modal -->



<!-- Edit User modal -->
        <div class="modal fade" id="EditUsermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
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
  
       function checked(ebsm_id, eem_id) {
        swal({
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                title: 'Are You Sure !',          
              }).then(function(result) {
                $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method:"POST",
                        url: "saveData",
                        data: {'ebsm_id':ebsm_id,'eem_id':eem_id},
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
        }


    function editCounselor(ebsmId){
            $('#edit').html('');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: 'edituser',
                data: 'ebsmId='+ebsmId,
                success: function (data) {
                       
                    $('#edit').html(data);
                    $('#EditUsermodal').modal('toggle')
                    }      
            });
        }


 
    function updateuser(){
        //alert('jhjhj');
        if($.trim($('#edit_usser_name').val())==''){
            $("#err_msg_cnn").html('Pleae Enter Name');
            $("#err_msg_cnn").fadeIn('fast');
            document.edituser.edit_usser_name.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg_cnn').offset().top);
                    return false;
          }
          if($.trim($('#edit_user_email').val())==''){
            $("#err_msg_eu").html('Pleae Enter Email Address');
            $("#err_msg_eu").fadeIn('fast');
            document.edituser.edit_user_email.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg_eu').offset().top);
                    return false;
          }

          if($.trim($('#edit_user_phone').val())==''){
            $("#err_msg_eup").html('Pleae Enter Mobile');
            $("#err_msg_eup").fadeIn('fast');
            document.edituser.edit_user_phone.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg_eup').offset().top);
                    return false;
          }

           var phone = document.getElementById('edit_user_phone');
            if (phone.value.length < 10) {
            $("#err_msg_eup").html('Please Enter 10 Digit Mobile No.');
            $("#err_msg_eup").fadeIn('fast');
            document.edituser.edit_user_phone.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg_eup').offset().top);
                    return false;
          }

           if($.trim($('#edit_user_whatsapp').val())==''){
            $("#err_msg_euw").html('Pleae Enter Whatsapp No');
            $("#err_msg_euw").fadeIn('fast');
            document.edituser.edit_user_whatsapp.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg_euw').offset().top);
                    return false;
            }

            var whatsapp = document.getElementById('edit_user_whatsapp');
            if (whatsapp.value.length < 10) {
            $("#err_msg_euw").html('Please Enter 10 Digit Mobile No.');
            $("#err_msg_euw").fadeIn('fast');
            document.edituser.edit_user_whatsapp.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg_euw').offset().top);
                    return false;
          }
       
        $.ajax({
                method:"POST",
                url:"adduser",
                data:$('#edituser').serialize(),
                success:function(data){
                  swal({
                      type: 'success',
                      title: 'Success!',
                      text: 'User Update Successfully',
                      buttonsStyling: false,
                      confirmButtonClass: 'btn btn-lg btn-success'
                  })
                  setTimeout(function(){ window.location.reload(); }, 3000);
                  return false;
                }
              });

    }

        function Adduser(){  
           // alert('jhjhj');
            if($.trim($('#name').val())==''){
            $("#err_msg_cn").html('Pleae Enter Name');
            $("#err_msg_cn").fadeIn('fast');
            document.
            addnewuser.name.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg_cn').offset().top);
                    return false;
          }
          if($.trim($('#email').val())==''){
            $("#err_msg_cf").html('Pleae Enter Email Address');
            $("#err_msg_cf").fadeIn('fast');
            document.addnewuser
            .email.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg_cf').offset().top);
                    return false;
          }

          if($.trim($('#password').val())==''){
            $("#pass").html('Pleae Enter Password');
            $("#pass").fadeIn('fast');
            document.
            addnewuser.password.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#pass').offset().top);
                    return false;
          }

          if($.trim($('#phone').val())==''){
            $("#err").html('Pleae Enter Mobile');
            $("#err").fadeIn('fast');
            document.
            addnewuser.phone.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err').offset().top);
                    return false;
          }

           var phone = document.getElementById('phone');
          if (phone.value.length < 10) {
            $("#err").html('Please Enter 10 Digit Mobile No.');
            $("#err").fadeIn('fast');
            document.
            addnewuser.phone.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err').offset().top);
                    return false;
          }


           if($.trim($('#whatsapp').val())==''){
            $("#err_msg").html('Pleae Enter Whatsapp No');
            $("#err_msg").fadeIn('fast');
            document.
            addnewuser.whatsapp.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg').offset().top);
                    return false;
            }

            var whatsapp = document.getElementById('whatsapp');
            if (whatsapp.value.length < 10) {
            $("#err_msg").html('Please Enter 10 Digit Whatsapp No.');
            $("#err_msg").fadeIn('fast');
            document.
            addnewuser.whatsapp.focus();
             //if is any error found. then do this
             $(window).scrollTop($('#err_msg').offset().top);
                    return false;
            }
            $.ajax({
                method:"POST",
                url:"adduser",
                data:$('#addnewuser').serialize(),
                success:function(data){

                    var obj=jQuery.parseJSON(data);

                console.log(obj.code);
                  swal({
                      type: 'success',
                      title: 'Success!',
                      text: obj.msg,//'Add New User Successfully',
                      buttonsStyling: false,
                      confirmButtonClass: 'btn btn-lg btn-success'
                  })
                  setTimeout(function(){ window.location.reload(); }, 3000);
                  return false;
                }
              });


        }
                    
                </script>
@endsection
