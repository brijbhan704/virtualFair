@extends('layouts.master')
@section('page-css')
<link rel="stylesheet" href="{{asset('assets/styles/vendor/ladda-themeless.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/styles/vendor/quill.bubble.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/quill.snow.css')}}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/sweetalert2.min.css')}}">
<style>
.avatar-lg {
    width: 150px;
    height: 150px;
}
</style>
@endsection

@section('main-content')

<?php  
    $profile_pic=""; 
    $profile_pic=$profileDetail->exhim_logo; 
?>

<div class="breadcrumb">
    <h1>User Profile</h1>
    <ul>
        <li><a href="">Pages</a></li>
        <li>User Profile</li>
    </ul>
</div>

<div id="spinner" style="display:none;z-index: 99999;position: fixed;width: 100%;height: 100%;">
		<div class="loader spinner-bubble spinner-bubble-primary" style="margin-top: 20%;margin-left: 44%;"></div>
</div>




            <div class="separator-breadcrumb border-top"></div>
            
            @php

            if(!empty($profileDetail->exhim_banner)){
                $imgUel='public/assets/images/'.$bmid.'/'.$profileDetail->exhim_id.'/'.$profileDetail->exhim_banner;
                
                if(!file_exists($imgUel)){
                    $imgUel="";
                }
            }
                
            @endphp

            

            <div class="card user-profile o-hidden mb-4">
                <div class="header-cover" style="background-image: url({{$imgUel}})">
                       
                        <div class="card-img-overlay">
                            <div class="p-1 text-right card-header font-weight-light d-flex">
                                <a href="#" class="btn btn-primary" onclick="bannerUpload('{{$profileDetail->exhim_id}}', '{{$profileDetail->exhim_banner}}', 'update');" data-toggle="modal" data-target="#photosmodal"> <span class="d-flex align-items-center"><i class="i-Edit mr-2"></i>Change</span></a>
                            </div>
                        </div>
              

                       

                </div>
                <div class="user-info">

                    
                        <div class="avatar-lg mb-1">
                            <div class="p-1 text-left card-header font-weight-light d-flex">
                                <a href="#" class="btn btn-primary" onclick="logoUpload('{{$profileDetail->exhim_id}}', '{{$profileDetail->exhim_logo}}', 'update');" data-toggle="modal" data-target="#photosmodal"> 
                                    <img  class="mb-1" src="{{asset('assets/images/'.$bmid.'/'.$profileDetail->exhim_id.'/'.$profileDetail->exhim_logo)}}" alt="" >
                                    
                                    <span class="d-flex align-items-center" ><i class="i-Edit mr-2"></i>Change</span>
                                </a>
                            </div>
                        </div>
                    
                    
                   
                    

                       

                    <!--
                        <?php if (!empty($profile_pic)){  ?>
                            <img class="profile-picture avatar-lg mb-2" src="{{asset('assets/images/'.$bmid.'/'.$profileDetail->exhim_id.'/'.$profileDetail->exhim_logo)}}" alt="">
                        <?php } else { ?>
                            <img class="profile-picture avatar-lg mb-2" src="{{asset('assets/images/faces/avatar.jpg')}}" alt="">
                        <?php } ?>
                    -->
                    <p class="m-0 text-24">{{$profileDetail->exhim_organization_name}}</p>
                    <p class="text-muted m-0"><!--Digital Marketer--></p>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs profile-nav mb-4" id="profileTab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="timeline-tab" data-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="false">Brochure</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="friends-tab" data-toggle="tab" href="#friends" role="tab" aria-controls="friends" aria-selected="false">Courses Offered</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="photos-tab" data-toggle="tab" href="#photos" role="tab" aria-controls="photos" aria-selected="false">Photos</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="profileTabContent">

                      <div class="tab-pane fade active show" id="about" role="tabpanel" aria-labelledby="about-tab">
                          
                          
                        <h4>Highlights</h4>
                        <a class=" float-right" href="#" data-toggle="modal" data-target="#highlightmodal"><i class="i-Edit text-primary">Edit</i></a>
                        <div class="row" style="border: 1px solid #e5e5e5;padding-top: 10px;border-radius: 27px;">
                            <p>{!! html_entity_decode($profileDetail->exhim_detail) !!}</p>
                        </div>

                        <hr>


                          <h4>Quick Facts</h4>
                          <br>  <span class="float-right" href="#" data-toggle="modal" data-target="#quickfactsmodal"><i class="i-Edit text-primary">Edit</i></span>

                          <div class="row" style="border: 1px solid #e5e5e5;padding-top: 10px;border-radius: 27px;">
                              <div class="col-md-4 col-6">
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i>Type of Institute</p>
                                      <span>{{$profileDetail->exhim_type_of_institute}}</span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Edit-Map text-16 mr-1"></i>Ownership</p>
                                      <span>{{$profileDetail->exhim_ownership}}</span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i>Estd. Year</p>
                                      <span>{{$profileDetail->exhim_estd_year}}</span>
                                  </div>

                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Email text-16 mr-1"></i> State</p>
                                      <span>{{$profileDetail->sm_name}}</span>
                                  </div>


                              </div>
                              <div class="col-md-4 col-6">
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Edit text-16 mr-1"></i>Accreditation</p>
                                      <span>{{$profileDetail->exhim_accreditation}}</span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i> Campus Size</p>
                                      <span>{{$profileDetail->exhim_campus_area}}</span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Cloud-Weather text-16 mr-1"></i> Approval</p>
                                      <span>{{$profileDetail->exhim_approval}}</span>
                                  </div>
                                
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Email text-16 mr-1"></i> City</p>
                                      <span>{{$profileDetail->cm_name}}</span>
                                  </div>
                              </div>


                              <div class="col-md-4 col-6">
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Face-Style-4 text-16 mr-1"></i> Phone</p>
                                      <span>{{$profileDetail->exhim_contact_us}}</span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Email text-16 mr-1"></i> Email</p>
                                      <span>{{$profileDetail->exhim_contact_email}}</span>
                                  </div>


                                 
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Email text-16 mr-1"></i> Whatsapp Number </p>
                                      <span>{{$profileDetail->exhim_whatsapp}}</span>
                                  </div>

                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i> Address</p>
                                      <span>{{$profileDetail->exhim_address}}</span>
                                  </div>






                              </div>
                          </div>
                          <!-- <hr>
                          <h4>Other Info</h4>
                          <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum dolore labore reiciendis ab quo ducimus reprehenderit natus debitis, provident ad iure sed aut animi dolor incidunt voluptatem. Blanditiis, nobis aut.</p>
                          <div class="row">
                              <div class="col-md-2 col-sm-4 col-6 text-center">
                                  <i class="i-Plane text-32 text-primary"></i>
                                  <p class="text-16 mt-1">Travelling</p>
                              </div>
                              <div class="col-md-2 col-sm-4 col-6 text-center">
                                  <i class="i-Camera text-32 text-primary"></i>
                                  <p class="text-16 mt-1">Photography</p>
                              </div>
                              <div class="col-md-2 col-sm-4 col-6 text-center">
                                  <i class="i-Car-3 text-32 text-primary"></i>
                                  <p class="text-16 mt-1">Driving</p>
                              </div>
                              <div class="col-md-2 col-sm-4 col-6 text-center">
                                  <i class="i-Gamepad-2 text-32 text-primary"></i>
                                  <p class="text-16 mt-1">Gaming</p>
                              </div>
                              <div class="col-md-2 col-sm-4 col-6 text-center">
                                  <i class="i-Music-Note-2 text-32 text-primary"></i>
                                  <p class="text-16 mt-1">Music</p>
                              </div>
                              <div class="col-md-2 col-sm-4 col-6 text-center">
                                  <i class="i-Shopping-Bag text-32 text-primary"></i>
                                  <p class="text-16 mt-1">Shopping</p>
                              </div>
                          </div> -->
                      </div>

                        <div class="tab-pane fade " id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                            <ul class="timeline clearfix">
                                <li class="timeline-line"></li>
                                    <div class="timeline-card card">
                                        <div class="card-body">
                                          <form class="" name="brochureform" action="saveuserprofile" method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                          <div class="input-group mb-2">
                                            <input type="hidden" name="brochure" id="brochure" value="brochure">
                                              <input type="file" class="form-control" name="upload_brochure" placeholder="Change/Upload Brochure" aria-label="Brochure" >
                                              <div class="input-group-append">
                                                  <button class="btn btn-primary" type="submit" id="button-comment1">Change/Upload</button>
                                              </div>
                                          </div>
                                          </form>
                                            <div class="mb-2">
                                                <h4>Brochure</h4>
                                            </div>
                                            <!-- <img class="rounded mb-2" src="" alt=""> -->
                                            <iframe class="rounded mb-2" src="{{asset('assets/images/'.$bmid.'/'.$profileDetail->exhim_id.'/brochure/'.$profileDetail->exhim_brochure)}}"
                                              width="100%" height="700" frameborder="0" align="center" >

                                            </iframe>

                                        </div>
                                    </div>

                            </ul>

                        </div>


                        <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                            <div class="row">

                              <div class="col-md-12 mb-3">
                                <h4>  <a href="javascript:void(0);" class="float-right"   onclick="addeditcoursedetails('');" ><i class="i-Add">Add Course</i></a><h4>
                              </div>

                             
                              <div class="col-md-12 mb-1">
                                <div class="row">
                                        <div class="col-md-3 col-6"><p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i>Course</p></div>
                                        <div class="col-md-3 col-6"><p class="text-primary mb-1"><i class="i-Edit-Map text-16 mr-1"></i>Stream</p></div>
                                        <div class="col-md-3 col-6"><p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i>Course Duration</p></div>
                                        <div class="col-md-3 col-6"><p class="text-primary mb-1"><i class="i-Money-2 text-16 mr-1"></i>Fee </p></div>
                                </div>
                            </div>
                        


                          @foreach($AddedCourse as $course)

                           
                            <div class="col-md-12 mb-1">

                              <div class="card card-profile-1 mb-1">
                             
                                <div class="card-body ">
                                    <a href="javascript:void(0);"  class="float-right mt-0" onclick="addeditcoursedetails('{{$course->epm_id}}');"><i class="i-Pen-2 font-weight-bold"> {{-- $course->epm_id --}}</i></a>
                                    <div class="row">
            
                                        <div class="col-md-3 col-6"><span>{{$course->epm_text}}</span></div>
                                        <div class="col-md-3 col-6"><span>{{$course->ppm_text}}</span></div>
                                        <div class="col-md-3 col-6"><span> @if(!empty($course->epm_duration_in_year)) {{$course->epm_duration_in_year}} Year @endif </span></div>
                                        <div class="col-md-3 col-6"><span>{{$course->epm_total_fee_charged}}</span></div>
<!--

                                              <div class="col-md-4 col-6">
                                                  <div class="mb-4">
                                                      <p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i>Stream</p>
                                                      <span>{{$course->ppm_text}}</span>
                                                  </div>
                                                  <div class="mb-4">
                                                      <p class="text-primary mb-1"><i class="i-Edit-Map text-16 mr-1"></i>Course</p>
                                                      <span>{{$course->epm_text}}</span>
                                                  </div>
                                                  <div class="mb-4">
                                                      <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i>Course Duration</p>
                                                      <span>{{$course->epm_duration_in_year}}</span>
                                                  </div>
                                              </div>

                                              <div class="col-md-4 col-6">
                                                  <div class="mb-4">
                                                      <p class="text-primary mb-1"><i class="i-Money-2 text-16 mr-1"></i>Fee Per Semester</p>
                                                      <span>{{$course->epm_fee_charged_per_sem}}</span>
                                                  </div>
                                                  <div class="mb-4">
                                                      <p class="text-primary mb-1"><i class="i-Money-2 text-16 mr-1"></i>Fee Yearly</p>
                                                      <span>{{$course->epm_total_fee_charged}}</span>
                                                  </div>
                                              </div>

-->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach




                            </div>
                        </div>
                        <div class="tab-pane fade" id="photos" role="tabpanel" aria-labelledby="photos-tab">

                            <div class="row">
                              <div class="col-md-12 mb-3">
                                <h4>  <a href="#" class="float-right" onclick="uploadphotoEvnt();" data-toggle="modal" data-target="#photosmodal" ><i class="i-Add">Add Photo</i></a><h4>
                              </div>
                              @foreach($galleryDetail as $gallery)
                                <div class="col-md-4">
                                    <div class="card text-white o-hidden mb-3">
                                        <img class="card-img" src="{{asset('assets/images/'.$bmid.'/'.$profileDetail->exhim_id.'/gallery/'.$gallery->eg_name)}}" alt="">
                                        <div class="card-img-overlay">
                                            <div class="p-1 text-left card-header font-weight-light d-flex">
                                                <a href="#" class="btn btn-primary" onclick="updatephotoEvnt('{{$gallery->eg_id}}','{{$gallery->eg_name}}');" data-toggle="modal" data-target="#photosmodal"> <span class="d-flex align-items-center"><i class="i-Edit mr-2"></i>Change</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- highlight modal -->
            <div class="modal fade" id="highlightmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle-2">  <h4>Highlights</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="highlightform" id="highlightform" class="" action="saveuserprofile" method="post">
                              {{ csrf_field() }}
                          <textarea class="ckeditor form-control form-control-lg"  name="exhim_detail" autocomplete="off" id="exhim_detail" >{{ $profileDetail->exhim_detail }}</textarea>
                              <input class="form-control" type="hidden" name="highlights" id="highlights" value="highlights" />
                            <!-- <textarea class="d-none" name="exhim_detail" id="exhim_detail"></textarea> -->


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Quickfaccts modal -->
            <div class="modal fade" id="quickfactsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle-2"><h4>Quick Facts</h4></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                
                
                        <form  name="quickfactform" id="quickfactform" class="" action="saveuserprofile" method="post">
                        {{ csrf_field() }}
                                
                          <div class="modal-body">
                            <input class="form-control" type="hidden" name="quickfact" id="quickfact" value="quickfact" />
                          
                            <div class="row">
                                <div class="col-md-4 col-6">
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i>Type of Institute</p>
                                        <span><input class="form-control" type="text" name="institute_type" id="institute_type" value="{{$profileDetail->exhim_type_of_institute}}" /></span>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Edit-Map text-16 mr-1"></i>Ownership</p>
                                        <span><input type="text" class="form-control"  name="ownership" id="ownership" value="{{$profileDetail->exhim_ownership}}" /></span>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i>Estd. Year</p>
                                        <span><input type="text" class="form-control"  name="estd_year" id="estd_year" value="{{$profileDetail->exhim_estd_year}}" /></span>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i>State</p>
                                        <span>
                                            <select id="state" name="state"   data-id="state" class="form-control custom-select target" onchange="fillCityList(this.value);">
                                                <option value="">Select Please</option>
                                                @if(!empty($stateList))
                                                        @foreach($stateList as $key => $stateData)
                                                                <option value="{{$stateData->sm_id}}" @if(isset($profileDetail->sm_id) && $profileDetail->sm_id==$stateData->sm_id) selected @endif > {{$stateData->sm_name}} </option>
                                                        @endforeach
                                                @endif
                                            </select>
                                        </span>
                                    </div>


                                </div>

                                <div class="col-md-4 col-6">
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i>Accreditation</p>
                                        <span><input type="text" class="form-control"  name="accreditation" id="accreditation" value="{{$profileDetail->exhim_accreditation}}" /></span>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Campus Size</p>
                                        <span><input type="text" class="form-control"  name="campus_area" id="campus_area" value="{{$profileDetail->exhim_campus_area}}" /></span>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Cloud-Weather text-16 mr-1"></i> Approval</p>
                                        <span><input type="text" class="form-control"  name="approval" id="approval" value="{{$profileDetail->exhim_approval}}" /></span>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i>City</p>
                                        <span>
                                            <select id="cityList" name="city"  data-id="city" class="form-control custom-select target">
                                                <option value="">Select Please</option>
                                                @if(!empty($cityList))
                                                        @foreach($cityList as $key => $cityData)
                                                                <option value="{{$cityData->cm_id}}" @if(isset($profileDetail->cm_id) && $profileDetail->cm_id==$cityData->cm_id) selected @endif > {{$cityData->cm_name}} </option>
                                                        @endforeach
                                                @endif
                                            </select>
                                        </span>
                                    </div>

                                </div>

                                <div class="col-md-4 col-6">
                                   
                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Face-Style-4 text-16 mr-1"></i> Phone</p>
                                        <span><input type="text" class="form-control"  name="phone" id="phone" value="{{$profileDetail->exhim_contact_us}}" /></span>
                                    </div>


                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-email text-16 mr-1"></i> Email</p>
                                        <span><input type="text" class="form-control"  name="email" id="email" value="{{$profileDetail->exhim_contact_email}}" /></span>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-email text-16 mr-1"></i> Whatsapp Number </p>
                                        <span><input type="text" class="form-control"  name="whatsapp_id" id="whatsapp_id" value="{{$profileDetail->exhim_whatsapp}}" /></span>
                                    </div>



                                    <div class="mb-4">
                                        <p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i> Address</p>
                                        <span><input type="text" class="form-control"  name="address" id="address" value="{{$profileDetail->exhim_address}}" /></span>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>

                      </form>



                    </div>
                </div>
            </div>



            <!-- photos modal -->
            <div class="modal fade" id="photosmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form name="photouploadform" id="photouploadform" class="" action="saveuserprofile" method="post"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title " id="exampleModalCenterTitle-2">  <h4 id="up-photo">Upload Photo</h4></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  
                                    <input class="form-control" type="file" name="upload_photo" id="upload_photo" />

                                    <input type="hidden" name="photoupload" id="photoupload" value="photoupload">
                                    <input type="hidden" name="eg_id" id="eg_id" value="">
                                    <input type="hidden" name="eg_name" id="eg_name" value="">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Courses Offered modal -->
            <div class="modal fade" id="courseofferedmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content" id="addeditDiv">


                    </div>
                </div>
            </div>
@endsection



@section('page-js')


    <script src="{{asset('assets/js/vendor/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/vendor/ladda.js')}}"></script>
    <script src="{{asset('assets/js/ladda.script.js')}}"></script>
    <script src="{{asset('assets/js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/js/vendor/sweetalert2.min.js')}}"></script>
    <script>

    $(document).on({
        ajaxStart: function() { $('#spinner').show(); },
        ajaxStop: function() { $('#spinner').hide(); }
    });
    </script>

    
<script type="text/javascript">
// var form = document.getElementById("highlightform"); // get form by ID
//
// form.onsubmit = function() {  var hvalue = $('#full-editor').text();
//         $('#exhim_detail').val(hvalue);
//                            }

function bannerUpload(id,name,action){
    if(action=='update'){
        $('#up-photo').html('Change Banner');
        $('#photoupload').val('UpdateBanner');
        $('#eg_id').val(id);
        $('#eg_name').val(name);
    }else{
        $('#up-photo').html('Add Banner');
        $('#photoupload').val('AddBanner');
        $('#eg_id').val(id);
        $('#eg_name').val(name);
    }
 
}

function logoUpload(id,name,action){
    if(action=='update'){
        $('#up-photo').html('Change Logo');
        $('#photoupload').val('UpdateLogo');
        $('#eg_id').val(id);
        $('#eg_name').val(name);
    }else{
        $('#up-photo').html('Add Logo');
        $('#photoupload').val('AddLogo');
        $('#eg_id').val(id);
        $('#eg_name').val(name);
    }
}



function updatephotoEvnt(id,name){
  $('#up-photo').html('Change Photo');
  $('#photoupload').val('photoupdate');
  $('#eg_id').val(id);
  $('#eg_name').val(name);
}


function uploadphotoEvnt(){
    $('#up-photo').html('Upload Photo');
    $('#photoupload').val('photoupload');
    $('#eg_id').val();
    $('#eg_name').val();
}

function getcourses(ppm_id){
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method:"POST",
    url:"getcourses",
    data:{ppm_id:ppm_id},
    success:function(data){
      $('#courses_div').html("");
        $('#courses_div').html(data);
      //console.log(data);
    }
  });
}
function Showotherinput(val){
  if(val=='other'){
      $('#new_course').removeClass('d-none');
  }else{
      $('#new_course').addClass('d-none');
      $('#new_course').val('');
  }

}

function AddCourseOffered(){
  if(!$("input[name='stream']:checked").val()){
    $("#err_msg_s").html('Pleae Select Stream');
	  $("#err_msg_s").fadeIn('fast');
	  document.courseaddform.stream.focus();
		 $(window).scrollTop($('#err_msg_s').offset().top);
            return false;
  }
  if(!$("input[name='Course']:checked").val()){
    $("#err_msg_c").html('Pleae Select Course');
	  $("#err_msg_c").fadeIn('fast');
	  document.courseaddform.Course.focus(); 
		 $(window).scrollTop($('#err_msg_c').offset().top);
            return false;
  }

  if(!$("input[name='Education[]']:checked").val()){
    $("#err_msg_ch").html('Pleae Select Qualification');
    $("#err_msg_ch").fadeIn('fast');
    document.courseaddform.Education.focus();    
     $(window).scrollTop($('#err_msg_ch').offset().top);
            return false;
  }

  if($('input[name=Course]:checked').val()=='other' && $.trim($('#new_course').val())==''){
    $("#err_msg_nc").html('Pleae Enter Course Name');
	  $("#err_msg_nc").fadeIn('fast');
	  document.courseaddform.new_course.focus();  
		 $(window).scrollTop($('#err_msg_nc').offset().top);
            return false;
  }
  if($.trim($('#course_duration').val())==''){
    $("#err_msg_cd").html('Pleae Enter Course Duration in years');
    $("#err_msg_cd").fadeIn('fast');
    document.courseaddform.course_duration.focus();    
     $(window).scrollTop($('#err_msg_cd').offset().top);
            return false;
  }
 
  if($.trim($('#course_fee_year').val())==''){
    $("#err_msg_cfy").html('Pleae Enter Course Fee Yearly');
    $("#err_msg_cfy").fadeIn('fast');
    document.courseaddform.course_fee_year.focus();    
     $(window).scrollTop($('#err_msg_cfy').offset().top);
            return false;
  }

  
if($('#upload_brochure').val() != '') {            
      $.each($('#upload_brochure').prop("files"), function(k,v){
          var filename = v['name'];    
          var ext = filename.split('.').pop().toLowerCase();
          if($.inArray(ext, ['pdf']) == -1) {
              swal({
                    type: 'alert',
                    title: 'Incoorect!',
                    text: 'Accept Only PDF file',
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-lg btn-danger'
                })
               /* setTimeout(function(){ window.location.reload(); }, 3000);
                return false;*/
          }else{
            $("#courseaddform").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'AddCourseOffered',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response){
                    swal({
                          type: 'success',
                          title: 'Success!',
                          text: ' Added Successfully',
                          buttonsStyling: false,
                          confirmButtonClass: 'btn btn-lg btn-success'
                      })
                      /*setTimeout(function(){ window.location.reload(); }, 3000);
                      return false;*/
                       
                    }
                });
            });
          }
      });        
}



  
   
    /*$.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method:"POST",
    url:"AddCourseOffered",
    data:$('#courseaddform').serialize(),
    success:function(data){
      swal({
          type: 'success',
          title: 'Success!',
          text: 'Course Added Successfully',
          buttonsStyling: false,
          confirmButtonClass: 'btn btn-lg btn-success'
      })
      setTimeout(function(){ window.location.reload(); }, 3000);
      return false;
    }
  });*/
}


function fillCityList(stateId){

   $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: 'citylist',
        data: 'state='+stateId,
        success: function (data) {
            var obj=jQuery.parseJSON(data);
            if(obj.code==='200'){
                $('#cityList').html(obj.htmlAppend);

            }
                
        }   
    });
}

function addeditcoursedetails(epmId){
    //$('#addeditDiv').html('');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: 'addeditcourse',
        data: 'epmId='+epmId,
        success: function (data) {
                $('#addeditDiv').html(data);
                $('#courseofferedmodal').modal('toggle')

            }      
    });
}


  function downloadpdf(epmId){
    //alert(epmId);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: 'downloadpdf',
        data: {'epmId':epmId},
        success: function (data) {
               

            }      
    });


    }


</script>

@endsection


               