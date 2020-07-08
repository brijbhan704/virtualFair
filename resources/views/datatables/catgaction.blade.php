<!----------------------------------->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card mb-5">
                                    
            <div class="card-body">
                <div class="row row-xs">

                  
                        <div class="col-md-6">
                        <div class="card-body">

                            <div class="row">
                                <div class=" col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="SelectMonth">Lead Status</label>
                                        <select class="custDropdown form-control" name="clsstage" id="clsstage">
                                               {!! $htmlAppend !!}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <label class="mr-sm-2" for="Comment">Comment</label>
                                    <textarea id="clscomment" name="clscomment" rows="8" class="form-control form-control-sm"  placeholder="Text only"  required></textarea>
                                    
                                    <input type="hidden" id="leemId" name="leemId" value="{{$leemId}}">

                                </div>
                            </div>

                        </div>
                        </div>




                        <div class="col-md-6 mt-3 mt-md-0">
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