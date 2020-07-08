<!----------------------------------->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card mb-5">
                                    
            <div class="card-body">
                <div class="row row-xs">


                        <div class="col-md-12 mt-3 mt-md-0">
                        <!--h4 class="modal-title text-blue" id="modelTile"> # Akhilesh Yadav ( 9891787418 )</h4-->
                        <div class="card-body">

                            <h6 class="yelloworder text-white px-2 py-1 rounded d-inline-block">History</h6>
                            <div class="row" style="max-height: 225px;overflow: auto;">
                            <div class="col-md-12">

                                @if(!empty($remarkList))
                                    @foreach($remarkList as $key => $remarkData)

                                        <div class=" text-grey bg-light p-2 mb-2 rounded border">
                                            <span class=""> {{date('d-M-Y h:i A', strtotime($remarkData->leem_insert_date))}} : <strong> {{$remarkData->lc_text}}  </strong></span>
                                            <div class="media-body pl-1" style="border-top: 1px solid #ced4db;">
                                                <span> {{ucfirst($remarkData->leer_remark)}}</span> 
                                                <div><strong> ( By {{ucwords($remarkData->user_name)}} )</strong></div>
                                            </div>
                                        </div>

                                    @endforeach
                                @endif

                            </div>
                            </div>

                        </div>
                        </div>


                                
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            
<!----------------------------------->