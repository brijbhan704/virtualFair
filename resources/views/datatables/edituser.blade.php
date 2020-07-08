
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle-2"><h4>Edit Counselor Detail</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form  name="edituser" id="edituser" class="" action="" method="post">
                              {{ csrf_field() }}

                              <input class="form-control" type="hidden" name="edituser" id="edituser" value="adduser" />
                        <div class="modal-body">
                            

                    <div class="card mb-4">
                        <div class="card-body">
                            
                                <div class="row">
                                    
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_duration">Name</label>
                                        <input type="text" class="form-control" name="edit_usser_name" id="edit_usser_name" placeholder="Name"
                                        value="{{(isset($dataList->ebsm_name) ? $dataList->ebsm_name : '')}}">
                                        <span class="text-danger" id="err_msg_cnn" name="err_msg_cnn"  style="display:none;"></span>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_sem">E-mail</label>
                                        <input type="email" class="form-control" name="edit_user_email" id="edit_user_email" placeholder="E-mail Address" 
                                         value="{{(isset($dataList->ebm_login_user) ? $dataList->ebm_login_user : '')}}"
                                       
                                         >
                                        <span class="text-danger" id="err_msg_eu" name="err_msg_eu"  style="display:none;"></span>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_year">Mobile No</label>
                                        <input type="number" class="form-control" name="edit_user_phone" id="edit_user_phone"  placeholder="Mobile"
                                         value="{{(isset($dataList->ebsm_mobile) ? $dataList->ebsm_mobile : '')}}">
                                        <span class="text-danger" id="err_msg_eup" name="err_msg_eup"  style="display:none;"></span>

                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="course_fee_year">WhatsApp No</label>
                                        <input type="number" class="form-control" name="edit_user_whatsapp" id="edit_user_whatsapp"  placeholder="WhatsApp No"  
                                            value="{{(isset($dataList->eem_whatsapp_no) ? $dataList->eem_whatsapp_no : '')}}">
                                        <span class="text-danger" id="err_msg_euw" name="err_msg_euw"  style="display:none;"></span>

                                    </div>
                                    
                                </div>
                        </div>
                    </div>


                        </div>
                        <div class="modal-footer">
                            <input type="hidden" class="form-control" value="{{$ebsmId}}" name="ebsmId" id="ebsmId">
                            <input type="hidden" class="form-control" value="{{$dataList->eem_id}}" name="eem_id" id="eem_id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary ladda-button basic-ladda-button" data-style="expand-right" onclick="updateuser()">Update User</button>
                        </div>
                      </form>
                    