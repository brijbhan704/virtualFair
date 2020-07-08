
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle-2"><h4>{{empty($epmId) ? 'Add Courses' : 'Edit Courses'}}</h4></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form name="courseaddform" id="courseaddform" class="uploadlogo" action="" method="post"  enctype="multipart/form-data">
{{ csrf_field() }}

    <div class="modal-body">
        
            <input class="form-control" type="hidden" name="addcourse" id="addcourse" value="addcourse" />

            <div class="card mb-4">
                <div class="card-body" [formGroup]="radioGroup">
                <span class="text-danger" id="err_msg_s" name="err_msg_s"  style="display:none;"></span>
                    <div class="card-title">Select Stream</div>
                    <div class="row">
                        @foreach($coursesDetails['stream'] as $key => $value)

                        <?php 
                            $ischecked="";
                            if(isset($applyedDetails->ppm_id) && $applyedDetails->ppm_id==$value->ppm_id){
                                $ischecked= 'checked';
                            }else if($key==0){
                                $ischecked="checked";
                            }   
                        ?>
                            <div class="col-md-4 col-6">
                            <label class="radio radio-outline-danger">
                                <input type="radio" name="stream" value="{{$value->ppm_id}}"  {{$ischecked}} formControlName="radio"  onchange="getcourses('{{$value->ppm_id}}')" >
                                <span>{{$value->ppm_text}}</span>
                                <span class="checkmark"></span>
                            </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-4">
              <div class="card-body" [formGroup]="radioGroup">
                <span class="text-danger" id="err_msg_c" name="err_msg_c"  style="display:none;"></span>
                <div class="card-title">Select Course</div>
                    <div class="row" id="courses_div">

                        @foreach($coursesDetails['courses'] as $key => $value)
                            <div class="col-md-4 col-6">
                                <label class="radio radio-outline-danger">
                                    <input type="radio" name="Course" value="{{$value->exhipm_id}}" <?php if(isset($applyedDetails->exhipm_id) && $applyedDetails->exhipm_id==$value->exhipm_id) echo 'checked'; ?> formControlName="radio" onclick="Showotherinput(this.value)" >
                                    <span>{{$value->epm_text}}</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        @endforeach

                        <div class="col-md-4 col-6">
                            <label class="radio radio-outline-danger">
                                <input type="radio" name="Course" value="other"  formControlName="radio" onclick="Showotherinput(this.value)" >
                                <span>Other</span>
                                <span class="checkmark"></span>
                            </label>
                            <input class="d-none form-control" type="text" name="new_course" id="new_course" value=""  placeholder="Enter Course Name" >
                            <span class="text-danger" id="err_msg_nc" name="err_msg_nc"  style="display:none;"></span>
                        </div>

                    </div>
            </div>
        </div>
<!-- start qualification -->
        <div class="card mb-4">
              <div class="card-body">
                <span class="text-danger" id="err_msg_ch" name="err_msg_ch"  style="display:none;"></span>
                <div class="card-title">Select Qualification</div>
                    <div class="row" id="courses_div">
                        @foreach($coursesDetails['qualification'] as $key => $value)
                            <div class="col-md-4 col-6">                  
                                <label class="checkbox checkbox-outline-danger">
                                <input type="checkbox" name="Education[]" value="{{$value->qm_id}}"  
                                <?php                                
                            if(isset($applyedDetails->qm_id)){
                                $checked=[];
                                $checked =  explode(',',$applyedDetails->qm_id);
                                if(in_array($value->qm_id, $checked))
                                {
                                echo "checked";
                               }
                           }?> formControlName="checkbox" >
                                    <span>{{$value->qm_text}}</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        @endforeach
                </div>
            </div>
        </div>
        <!-- end qualification -->

        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">More detail on Course</div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label for="course_duration">Course Duration <small>(in years)</small></label>
                            <input type="text" class="form-control" value="{{(isset($applyedDetails->epm_duration_in_year) ? $applyedDetails->epm_duration_in_year : '')}}" name="course_duration" id="course_duration" placeholder="Course Duration (in years)">
                            <span class="text-danger" id="err_msg_cd" name="err_msg_cd"  style="display:none;"></span>
                        </div>


                        <div class="col-md-6 form-group mb-3">
                            <label for="course_fee_year">Course Fee <small><!--(Yearly)--></small></label>
                            <input type="text" class="form-control" value="{{(isset($applyedDetails->epm_total_fee_charged) ? $applyedDetails->epm_total_fee_charged : '')}}" name="course_fee_year" id="course_fee_year"  placeholder="Course Fee">
                            <span class="text-danger" id="err_msg_cfy" name="err_msg_cfy"  style="display:none;"></span>

                        </div>
                    </div>
            </div>
        </div>
                   

                    <div class="col-md-10 form-group ">
                        <label for="course_fee_year">Upload Brochure</label>
                        <input class="form-control" name="upload_brochure" id="upload_brochure" type="file" accept="application/pdf">
                        <embed src="{{(isset($applyedDetails->brochure) ? $applyedDetails->brochure : '')}}" style="width:600px; height:70px;" frameborder="0">
                        <span class="text-danger" id="err_brochure" name="err_brochure"  style="display:none;"></span>
                        <?php 

                            if(isset($applyedDetails->brochure)){
                                ?><a href="javascript:void(0)" onclick="downloadpdf('{{$epmId}}');"><button type="button" class="btn btn-secondary">Download PDF</button></a><?php
                            }
                        ?>
                    </div>


    </div>

    <div class="modal-footer">

        <input type="hidden" class="form-control" value="{{$epmId}}" name="epmId" id="epmId">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary ladda-button basic-ladda-button submitBtn" data-style="expand-right" onclick="AddCourseOffered()">
        {{empty($epmId) ? 'Add Courses' : 'Edit Courses'}}</button>
    </div>
    
</form>
