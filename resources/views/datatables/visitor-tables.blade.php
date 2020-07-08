@extends('layouts.master')
@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
<style>
.divide{
    border-top: 1px solid #dee2e6;
}
.modal-header .close {
    font-weight: 200;
    font-size: 40px;
    padding: 5px 15px 0 0;
    outline: none;
}
.yelloworder {
    background-color: #ffd300;
}

</style>
@endsection

@section('main-content')

  <div class="breadcrumb">
                <h1>Lead Management </h1>
            </div>
            <div class="separator-breadcrumb border-top"></div>

            <div id="spinner" style="display:none;z-index: 99999;position: fixed;width: 100%;height: 100%;">
                    <div class="loader spinner-bubble spinner-bubble-primary" style="margin-top: 9%;margin-left: 44%;"></div>
            </div>
           

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
                                                        <th scope="col">Name
                                                            <div class="divide"> City </div></th>

                                                        <th scope="col">Current Qualification
                                                            <div class="divide"> Course Interested In </div></th>
                                                            
                                                        <th scope="col">Email
                                                            <div class="divide"> Mobile </div></th>

                                                        <th scope="col">Activity</th>
                                                       

                                                        <th scope="col">Lead Date
                                                                <div class="divide"> Lead Time </div></th>
                                                        
                                                        <th scope="col">Lead Stage
                                                            <div class="divide"> Conversation </div></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @include('datatables.visitor_content')
                                                    </tbody>
                                                    <!--tfoot>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Name
                                                                <div class="divide"> City </div></th>

                                                            <th scope="col">Current Qualification
                                                                <div class="divide"> Course Interested In </div></th>
                                                                
                                                            <th scope="col">Email
                                                                <div class="divide"> Mobile </div></th>

                                                            <th scope="col">Activity</th>
                                                            <th scope="col">Lead Stage</th>

                                                            <th scope="col">Lead Date
                                                                <div class="divide"> Lead Time </div></th>

                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </tfoot-->
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
                <!-- end of col modal-lg-->

                <div aria-hidden="true" aria-labelledby="ChangeLeadStage" role="dialog" tabindex="-1" id="ChangeLeadStage" data-backdrop="static" data-keyboard="false"  class="modal fade bg-white show">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0">
                            <form name="changeLeadStatusform" id="changeLeadStatusform" method="post">
                           
                                <div class="modal-header">
                                    <h4 class="modal-title text-blue" id="modelTile">Lead Status</h4>
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                </div>

                                <div class="col-md-12 alert alert-danger" id="errMsgShowleadcSF" style="display:none;"></div>
                                <div class="modal-body" id="modelDiv">




                                </div>

                                <div class="modal-footer justify-content-center" id="footerDiv">

                                   
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="changeLeadStatus();">Submit</button>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                </div>

            </div>
        <!-- end of row -->
@endsection

@section('page-js')

 <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
 <script src="{{asset('assets/js/datatables.script.js')}}"></script>
 
 <script>
    $(document).on({
        ajaxStart: function() { $('#spinner').show(); },
        ajaxStop: function() { $('#spinner').hide(); }
    });

 function addcate(leemId){
    
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: "post",
        url: 'addcategory',
        data: 'leemId='+leemId,
        success: function (data) {
                $('#modelDiv').html(data);
                $('#modelTile').html('Lead Status');
                $('#footerDiv').show();
                $('#ChangeLeadStage').modal('toggle')
            }      
    });
}

function showhistory(leemId){
    
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: "post",
        url: 'showhistory',
        data: 'leemId='+leemId,
        success: function (data) {
                $('#modelDiv').html(data);
                
                $('#modelTile').html('Conversation History');
                $('#footerDiv').hide();
                $('#ChangeLeadStage').modal('toggle')
            }      
    });
}


function changeLeadStatus(){
    var selectedMsg = $("#clsstage option:selected").text(); 
    var leemId = $("#leemId").val(); 

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: 'changeleadstatus',
        data: $('#changeLeadStatusform').serialize(),
        success: function (data) {
                var obj=jQuery.parseJSON(data);
                if(obj.code==='200'){
                    $('#status'+leemId).html(selectedMsg);
                }
                $('#ChangeLeadStage').modal('toggle')
            }      
    });
}


</script>
@endsection
