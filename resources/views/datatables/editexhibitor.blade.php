		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
		<div class="modal-header">
		            <h5 class="modal-title" id="exampleModalCenterTitle-2"><h4>Edit Exhibitor Detail</h4></h5>
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">&times;</span>
		            </button>
		        </div>
		        <form  name="editexhibitor" id="editexhibitor" class="" action="" method="post">
		              {{ csrf_field() }}

		              <input class="form-control" type="hidden" name="editexhibitors" id="editexhibitors" value="adduser" />
		        <div class="modal-body">
		            

		    <div class="card mb-4">
		        <div class="card-body">
		           
		                <div class="row">
		                    
		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_duration">Organization Name</label>
		                        <input type="text" class="form-control" name="ex_name" id="ex_name" placeholder="Name"
		                        value="{{$dataList->exhim_organization_name}}">
		                        <span class="text-danger" id="msg_name" name="msg_name"  style="display:none;"></span>
		                    </div>

		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_sem">Contact E-mail</label>
		                        <input type="email" class="form-control" name="ex_email" id="ex_email" placeholder="E-mail Address" 
		                         value="{{$dataList->exhim_contact_email}}">
		                        <span class="text-danger" id="msg_email" name="msg_email"  style="display:none;"></span>
		                    </div>

		                    

		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_year">Contact No</label>
		                        <input type="number" class="form-control" name="ex_phone" id="ex_phone"  placeholder="Mobile"
		                         value="{{$dataList->exhim_contact_us}}">
		                        <span class="text-danger" id="msg_contact" name="msg_contact"  style="display:none;"></span>
		                    </div>
		                    
		                    <!-- <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_year">Address</label>
		                        <input type="text" class="form-control" name="ex_address" id="ex_address"  placeholder="Address"
		                         value="{{$dataList->exhim_address}}">
		                        <span class="text-danger" id="msg_address" name="msg_address"  style="display:none;"></span>
		                    </div> -->
		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_sem">Select State</label>
		                        
		                         <select class="form-control" id="ex_category" name="ex_sm_ids">	
									
								@foreach($categories as $category)
		                            <option value="{{ $category->sm_id }}" {{$id->sm_id == $category->sm_id  ? 'selected' : ''}}>{{ $category->sm_name }}</option>
		                        @endforeach
									</select>
		                        <span class="text-danger" id="msg_state" name="msg_state"  style="display:none;"></span>
		                    </div> 
		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_sem">Select City</label>
		                        <select class="form-control" id="ex_subcategory" name="ex_cm_ids">
									 @foreach($subcategories as $subcategory)
		                            <option value="{{ $subcategory->cm_id }}" {{$id->cm_id == $subcategory->cm_id  ? 'selected' : ''}}>{{ $subcategory->cm_name }}</option>
		                        @endforeach
		                    </select>
		                        <span class="text-danger" id="msg_city" name="msg_city"  style="display:none;"></span>
		                    </div>
		                    
		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_year">WhatsApp No</label>
		                        <input type="number" class="form-control" name="ex_whatsApp" id="ex_whatsApp"  placeholder="WhatsApp No"  
		                            value="{{$dataList->exhim_whatsapp}}">
		                        <span class="text-danger" id="msg_whatsapp" name="msg_whatsapp"  style="display:none;"></span>
		                    </div> 
		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_sem">Select State</label>
		                        
		                         <select class="form-control" id="plan" name="plan">	
									
								@foreach($plans as $plan)
		                            <option value="{{ $plan->ppm_id }}" {{$dataList->ppm_id == $plan->ppm_id  ? 'selected' : ''}}>{{ $plan->ppm_text }}</option>
		                        @endforeach
									</select>
		                        <span class="text-danger" id="msg_plan" name="msg_plan"  style="display:none;"></span>
		                    </div> 
		                       
		                </div>
		        </div>
		    </div>


		        </div>
		        <div class="modal-footer">
		             <input type="hidden" class="form-control" value="{{$dataList->exhim_id}}" name="exhim_id" id="exhim_id">
		            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		            <button type="button" class="btn btn-primary ladda-button basic-ladda-button" data-style="expand-right" onclick="updateExhibitor()">Update Exhibitor</button>
		        </div>
		      </form>



		      <script type="text/javascript">
		      	$('#ex_category').change(function(){
		      		//consol.log('jhgjhgj');
					    var categoryID = $(this).val();
					    if(categoryID){
					        $.ajax({
					        	headers: {
					                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					                },
					           type:"POST",
					           url:"{{url('ex_subcategorylist')}}/"+categoryID,
					           success:function(res){               
					            if(res){
					                $("#ex_subcategory").empty();
					                $("#ex_subcategory").append('<option>Select City</option>');
					                $.each(res,function(key,value){
					                    $("#ex_subcategory").append('<option value="'+key+'">'+value+'</option>');
					                });
					           
					            }else{
					               $("#ex_subcategory").empty();
					            }
					           }
					        });
					    }else{
					        $("#ex_subcategory").empty();
					    }      
					   });
		      </script>
              