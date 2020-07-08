@extends('layouts.master')
@section('before-css')

@endsection

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/quill.bubble.css')}}">
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/quill.snow.css')}}">
@endsection

@section('main-content')




            <div class="row mb-4">


                <div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">

                          <h4>Highlights</h4>
                        <p>  <div class="mx-auto col-md-8">
                              <div id="full-editor" style="width:100%">

                              </div>
                          </div></p>
                          <hr>
                          <h4>Quick Facts</h4><br>
                          <div class="row">

                              <div class="col-md-4 col-6">
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i>Type of Institute</p>
                                      <span>State University</span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Edit-Map text-16 mr-1"></i>Ownership</p>
                                      <span>Private</span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Calendar text-16 mr-1"></i>Estd. Year</p>
                                      <span></span>
                                  </div>
                              </div>
                              <div class="col-md-4 col-6">
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i>Accreditation</p>
                                      <span></span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-MaleFemale text-16 mr-1"></i> Campus Size</p>
                                      <span></span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Cloud-Weather text-16 mr-1"></i> Approval</p>
                                      <span></span>
                                  </div>
                              </div>
                              <div class="col-md-4 col-6">
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Face-Style-4 text-16 mr-1"></i> Phone</p>
                                      <span></span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-email text-16 mr-1"></i> Email</p>
                                      <span></span>
                                  </div>
                                  <div class="mb-4">
                                      <p class="text-primary mb-1"><i class="i-Home1 text-16 mr-1"></i> Address</p>
                                      <span></span>
                                  </div>
                              </div>
                          </div>
                          <!-- end of row -->

                        </div>
                    </div>

                </div>
                <!-- end of col -->


            </div>


@endsection

@section('page-js')


 <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="{{asset('assets/js/vendor/quill.min.js')}}"></script>



@endsection

@section('bottom-js')

<script src="{{asset('assets/js/quill.script.js')}}"></script>


@endsection
