				<div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle"><h4>Show Counselor</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form  name="" id="" class="" action="#" method="post">
                              {{ csrf_field() }}
                        <div class="modal-body">
                        <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
	                            <th scope="col">#</th>
	                            <th scope="col">Name</th>
	                            <th scope="col">E-mail</th>
	                            <th scope="col">Password</th>
	                            <th scope="col">Contact No</th>
	                            <th scope="col">Status</th>
                        	</tr>
                        </thead>
                        <tbody>
                        	@php
                        	 $i=1
                        	  @endphp
                            @if(isset($counselor) && !empty($counselor))
                             @foreach($counselor as $counselors)
                            <tr>
                           
                                <th scope="row">{{$i++}}</th>
                                <td>{{$counselors->ebsm_name}}</td> 
                                <td>{{$counselors->ebm_login_user}}</td>
                                <td>{{$counselors->ebm_login_pwd}}</td>
                                <td>{{$counselors->ebsm_mobile}}</td>                      
                                <td>{{$counselors->ebsm_statu}}</td>
                              
                            </tr>
                          @endforeach
                           @else
                        	<tr><th scope="row" >Empty record!</th></tr>
                   			@endif
                        </tbody>
                     </table>            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary ladda-button basic-ladda-button" data-style="expand-right">Add User</button> -->
                </div>
              </form>