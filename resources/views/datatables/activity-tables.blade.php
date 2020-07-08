@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')
  <div class="breadcrumb">
                <h1>Visitors</h1>
                <ul>
                  <li>Activity</li>
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
                                                                                    <th scope="col">City</th>
                                                                                    <th scope="col">Qualification</th>
                                                                                    <th scope="col">Course Interested In</th>
                                                                                    <th scope="col">Pages / Time spent</th>
                                                                                    <th scope="col">Brochure Downloaded</th>
                                                                                    <th scope="col">Enquery Sent</th>
                                                                                    <th scope="col">Video Call Time</th>
                                                                                    <th scope="col">WhatsApp Message Sent</th>

                                                                                  </tr>
                                                                              </thead>
                                                                              <tbody>
                                                      @include('datatables.activity_content')
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                          <th scope="col">#</th>
                                                          <th scope="col">Name</th>
                                                          <th scope="col">City</th>
                                                          <th scope="col">Qualification</th>
                                                          <th scope="col">Course Interested In</th>
                                                          <th scope="col">Pages / Time spent</th>
                                                          <th scope="col">Brochure Downloaded</th>
                                                          <th scope="col">Enquery Sent</th>
                                                          <th scope="col">Video Call Time</th>
                                                          <th scope="col">WhatsApp Message Sent</th>

                                                        </tr>
                                                    </tfoot>
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



            </div>
            <!-- end of row -->



@endsection

@section('page-js')

 <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>

@endsection
