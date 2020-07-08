@extends('layouts.master')
@section('page-css')

<link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
@endsection

@section('main-content')
 <div class="row mb-4">
                <div class="col-md-12 mb-4">
                    <div class="card text-left">

                        <div class="card-body">
                            <!--h1 class="card-title ">List of Feedback Report submitted by Exhibitor and Attendee</h1-->
							<div class="col-lg-12 col-md-12">
                    <!-- CARD ICON -->
                    <div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4">
                                <div class="card-body text-center">
                                    <i class="i-Data-Upload"></i>
                                    <p class="text-muted mt-2 mb-2">Total Number of Feedback Given by Exhibitor</p>
                                    <p class="text-primary text-24 line-height-1 m-0">3</p>
                                </div>
                            </div>
                        </div>
						<div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-icon mb-4">
                                <div class="card-body text-center">
                                    <i class="i-Data-Upload"></i>
                                    <p class="text-muted mt-2 mb-2">Total Number of Feedback Given by Attendee</p>
                                    <p class="text-primary text-24 line-height-1 m-0">2</p>
                                </div>
                            </div>
                        </div>
					</div>
					</div>
                            <div class="table-responsive">
                                <table id="zero_configuration_table" class="display table table-striped table-bordered" style="width:100%">
                                 @include('reports.feedback_table_content')
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
				 <!-- end of row -->



@endsection

@section('page-js')

 <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>

@endsection