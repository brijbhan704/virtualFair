		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
		
		<div class="modal-header">
		            <h5 class="modal-title" id="exampleModalCenterTitle-2"><h4>Edit Career Session</h4></h5>
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">&times;</span>
		            </button>
		        </div>
		        <form  name="editcounselorsession" id="editcounselorsession" class="" action="" method="post">
		              {{ csrf_field() }}

		              <input class="form-control" type="hidden" name="editexhibitors" id="editexhibitors" value="adduser" />
		        <div class="modal-body">
		            

		    <div class="card mb-4">
		        <div class="card-body">
		           
		                <div class="row">
		                    
		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_duration"> Name</label>
		                        <input type="text" class="form-control" name="e_name" id="e_name" placeholder="Name"
		                        value="{{$dataList->lccs_name}}">
		                        <span class="text-danger" id="lccc_name" name="lccc_name"  style="display:none;"></span>
		                    </div>

		                    <div class="col-md-6 form-group mb-3">
	                            <label for="picker3">Start Date Time</label>                        
	                                <input id="e_startdates" type="datetime-local" step=1 class="form-control" name="e_startdates" placeholder="Start Date Time"  value="{{$dataList->lccs_start_datewtime}}">
	                               <div class="input-group-append">                                      
	                            </div>
	                            <span class="text-danger" id="lccc_start" name="lccc_start"  style="display:none;"></span>
                        	</div>

		                   
		                    <div class="col-md-6 form-group mb-3">
	                            <label for="picker3">End Date Time</label>                        
	                                <input id="e_enddate" type="datetime-local" step=1 class="form-control" name="e_enddate" placeholder="End Date Time"   value="{{$dataList->lccs_end_datewtime}}">
	                               <div class="input-group-append">                                      
	                            </div>
	                           <span class="text-danger" id="lccc_end" name="lccc_end"  style="display:none;"></span>
                        	</div>

		                   
		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_year">Zoom Id</label>
		                        <input type="text" class="form-control" name="e_zoomid" id="e_zoomid"  placeholder="Zoom Id"
		                         value="{{$dataList->lccs_zoom_id}}">
		                        <span class="text-danger" id="lccc_zoom" name="lccc_zoom"  style="display:none;"></span>
		                    </div>
		                    
		                    
		                    <div class="col-md-6 form-group mb-3">
		                        <label for="course_fee_year">Zoom Password</label>
		                        <input type="text" class="form-control" name="e_zoompass" id="e_zoompass"  placeholder="Zoom Password"  
		                            value="{{$dataList->lccs_zoom_pwd}}">
		                        <span class="text-danger" id="lccc_zoom_pwd" name="lccc_zoom_pwd"  style="display:none;"></span>
		                    </div> 
		                     

		                       
		                </div>
		        </div>
		    </div>


		        </div>
		        <div class="modal-footer">
		              <input type="hidden" class="form-control" value="{{$dataList->lccs_id}}" name="lccs_id" id="lccs_id">
		            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		            <button type="button" class="btn btn-primary ladda-button basic-ladda-button" data-style="expand-right" onclick="updateCounselorSession()">Update CareerSession</button>
		        </div>
		      </form>



		     
              