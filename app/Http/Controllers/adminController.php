<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use Validator;
use Session;
use Redirect;

class adminController extends Controller
{
    //
    public function index()
    {
        $data = array();
        return view('admin/index');
    }

    public function CheckLogin()
    {
        //ss$regex='/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $validator = Validator::make(Request::all(), [
            'email' => 'required',
            'password' => 'required'

        ]);

        if ($validator->fails() && empty(Session('session'))) {
            return redirect::back()->with(['errors' => $validator->errors()]);
        } else if (empty(Session('session'))) {

            $brandData = DB::table('access_mappings as am')
                ->join('brand_organizer_master as bm', 'bm.bm_id','am.bm_id')
                ->select('*')
                ->where('am.login_id', '=', request('email'))
                ->where('am.password', '=', request('password'))
                ->first();
           
            if (isset($brandData) && !empty($brandData->bm_id)) {
               
                $authData[0]=$brandData;
               //dd(Session::put('session', $authData));
               Session::put('session', $authData);
                $tablesName = collect([
                                ## Lead Part ##
                                'lead_master'=> $brandData->bm_id.'_'.'lead_master',
                                'event_master'=>$brandData->bm_id.'_'.'event_master',

                                ## Exhibitor ##
                                'exhibitor_master'=>$brandData->bm_id.'_'.'exhibitor_master',
                                'exhibitor_gallery'=>$brandData->bm_id.'_'.'exhibitor_gallery',

                                'exhibitor_product_mapping'=>$brandData->bm_id.'_'.'exhibitor_product_mapping',
                                'exhibitor_product_master'=>$brandData->bm_id.'_'.'exhibitor_product_master',
                                'exhibitor_boothstaff'=>$brandData->bm_id.'_'.'exhibitor_boothstaff',
                                'exhibitor_event_mapping'=>$brandData->bm_id.'_'.'exhibitor_event_mapping',
                                'exhibitor_city_master'=>$brandData->bm_id.'_'.'exhibitor_city_master',
                                'exhibitor_event_with_boothstaff_mapping'=>$brandData->bm_id.'_'.'exhibitor_event_with_boothstaff_mapping',
                                ## Masters ##
                                'master_lead_source'=>$brandData->bm_id.'_'.'master_lead_source',
                                'organization_type'=>$brandData->bm_id.'_'.'organization_type',
                                'parent_product_master'=>$brandData->bm_id.'_'.'parent_product_master',
                                'product_master'=>$brandData->bm_id.'_'.'product_master',
                                'qualification_master'=>$brandData->bm_id.'_'.'qualification_master',
                                'master_city'=>'master_city',
                                'master_state'=>'master_state',
                                'master_country'=>'master_country',

                                'lead_event_master_mapping'=>$brandData->bm_id.'_'.'lead_event_master_mapping',
                                'lead_event_exhibitor_mapping'=>$brandData->bm_id.'_'.'lead_event_exhibitor_mapping',
                                'lead_categorization'=>$brandData->bm_id.'_'.'lead_categorization',
                                'lead_event_exhibitor_mapping_remark'=>$brandData->bm_id.'_'.'lead_event_exhibitor_mapping_remark',
                                'lead_event_exhibitor_mapping_activity'=>$brandData->bm_id.'_'.'lead_event_exhibitor_mapping_activity',
                                'participation_plans_master'=>$brandData->bm_id.'_'.'participation_plans_master',
                                'live_career_counseling_sessions'=>$brandData->bm_id.'_'.'live_career_counseling_sessions',
                                'activity_master'=>$brandData->bm_id.'_'.'activity_master'
                                
                                

                            ]);

                Session::put('tdetail', $tablesName);
                $tdetail=Session('tdetail');
                $profileDetail=array();
                $evntDetail=array();
                ## Exhibitor Details ##
                if($brandData->at_id=='3'){
                    
                    $profileDetail = DB::table($tdetail['exhibitor_master'])
                    ->select('*')
                    ->where('exhim_login_id', '=', $brandData->map_id)
                    ->first();

                    if(isset($profileDetail->exhim_id)){
                        ## Current : Event Detail #
                        $evntDetail = DB::table($tablesName['event_master']. ' as em' )
                        ->leftjoin($tablesName['exhibitor_event_mapping']. ' as eem', 'eem.aem_id','em.aem_id')
                        ->select('em.*')
                        ->where('em.aem_status', '!=', 'inactivate')
                        ->where('eem.eem_status', '=', 'active')
                        ->where('eem.exhim_id', '=', $profileDetail->exhim_id)
                        ->orderBy('em.aem_id', 'DESC')
                        ->get();
                        //dd($evntDetail);
                    }

                   

                }else{

                     ## Current : Event Detail #
                     $evntDetail = DB::table($tablesName['event_master'])
                     ->where('aem_status', '!=', 'inactivate')
                     ->orderBy('aem_id', 'DESC')
                     ->get();


                }
                //dump($evntDetail);
                Session::put('profileDetail', $profileDetail);
                Session::put('evntDetail', $evntDetail);
                Session::put('selectedEvent', $evntDetail[0]);


               
            }

        }
            $tdetail=Session('tdetail');
            $infoTodaycity=DB::table($tdetail['lead_master'] .' as lm')
                    ->Join($tdetail['master_city'] .' as mc' ,'lm.city_id', 'mc.cm_id')
                    ->whereDay('lm.lm_create_date', now()->day)
                    ->select('mc.cm_name as Name',DB::raw("count(lm.city_id) as TotalCount"))
                    ->groupBy('lm.city_id')->get();

            $infoTodaycourse=DB::table($tdetail['lead_event_master_mapping'] .' as lemm')
                    ->Join($tdetail['product_master'] .' as pm' ,'lemm.pm_id', 'pm.pm_id')
                    ->whereDay('lemm.lemm_insert_date', now()->day)
                    ->select('pm.pm_text as Name','lemm.pm_id',DB::raw("count(lemm.pm_id) as TotalCount"))
                    ->groupBy('lemm.pm_id')->get();


            $infoTodayuniversity=DB::table($tdetail['lead_event_master_mapping'] .' as lemm')
                    ->Join($tdetail['lead_event_exhibitor_mapping'] .' as leem' ,'lemm.lemm_id', 'leem.lemm_id')
                    ->Join($tdetail['exhibitor_master'] .' as em' ,'em.exhim_id', 'leem.exhim_id')
                    ->whereDay('leem.leem_datetime', now()->day)
                    ->select('em.exhim_organization_name as Name',DB::raw("count(leem.lemm_id) as TotalCount"))
                    ->groupBy('leem.exhim_id')->get();

            $infoTotalcity=DB::table($tdetail['lead_master'] .' as lm')
                    ->Join($tdetail['master_city'] .' as mc' ,'lm.city_id', 'mc.cm_id')
                    ->select('mc.cm_name as Name',DB::raw("count(lm.city_id) as TotalCount"))
                    ->groupBy('lm.city_id')->get();

            $infoTotalcourse=DB::table($tdetail['lead_event_master_mapping'] .' as lemm')
                    ->Join($tdetail['product_master'] .' as pm' ,'lemm.pm_id', 'pm.pm_id')
                    ->select('pm.pm_text as Name','lemm.pm_id',DB::raw("count(lemm.pm_id) as TotalCount"))
                    ->groupBy('lemm.pm_id')->get();
                     //dump( $query->pm_id);
           
                  
       //dump($infoTotalcourse);


            $infoTotaluniversity=DB::table($tdetail['lead_event_master_mapping'] .' as lemm')
                    ->Join($tdetail['lead_event_exhibitor_mapping'] .' as leem' ,'lemm.lemm_id', 'leem.lemm_id')
                    ->Join($tdetail['exhibitor_master'] .' as em' ,'em.exhim_id', 'leem.exhim_id')
                    ->select('em.exhim_organization_name as Name',DB::raw("count(leem.lemm_id) as TotalCount"))
                    ->groupBy('leem.exhim_id')->get();

            $infoTotalactivity=DB::table($tdetail['activity_master'] .' as am')
                    ->Join($tdetail['lead_event_exhibitor_mapping_activity'] .' as leema' ,'leema.am_id', 'am.am_id')
                    ->select('am.am_text as Name',DB::raw("count(leema.am_id) as TotalCount"))
                    ->groupBy('leema.am_id')->get();

            $infoTodayactivity=DB::table($tdetail['activity_master'] .' as am')
                    ->Join($tdetail['lead_event_exhibitor_mapping_activity'] .' as leema' ,'leema.am_id', 'am.am_id')
                    ->whereDay('leema.leema_datetime', now()->day)
                    ->select('am.am_text as Name',DB::raw("count(leema.am_id) as TotalCount"))
                    ->groupBy('leema.am_id')->get();

                    /*$infoTotalactivity=DB::table($tdetail['lead_event_exhibitor_mapping_activity'] .' as leema')
                    ->Join($tdetail['lead_event_master_mapping'] .' as lemm' ,'leema.lemm_id', 'lemm.lemm_id')
                    ->select('leema.leema_text as Name',DB::raw("count(leema.lemm_id) as TotalCount"))
                    ->groupBy('leema.lemm_id')->get();*/

            $todays_total=DB::table($tdetail['lead_master'])->whereDay('lm_create_date', now()->day)->get()->count(); 
            $total=DB::table($tdetail['lead_master'])->count();
        // attempt to do the login


                
        if (!empty(Session('session'))) {

        //$data=  HomeController::GetDashboardData();
              return view('dashboard.dashboardv1',[
                            'info'=>$infoTodaycity,
                            'infoTodaycourse'=>$infoTodaycourse,
                            'infoTodayuniversity'=>$infoTodayuniversity,
                            'infoTotalcity'=>$infoTotalcity,
                            'infoTotalcourse'=>$infoTotalcourse,
                            'infoTotaluniversity'=>$infoTotaluniversity,
                            'todays_total'=>$todays_total,
                            'total'=>$total,
                            'infoTotalactivity'=>$infoTotalactivity,
                            'infoTodayactivity'=>$infoTodayactivity


              ]);
              //, ['getUserDetailsbyMapId' => $getUserDetailsbyMapId, 'leadList' => $leadList]

        } else {
            // validation not successful, send back to form
            Session::flash('error', "Username & Password do not match");
            return Redirect::to('/');
            //return redirect::back()->with(['wrong'=>"Userid & Password do not match"]);
        }

    }

    public function seteventasrequest()
    {
        $resp=Array();
        $resp['code']='404';

        $tdetail=Session('tdetail');
        $pdetail=Session('profileDetail');

       if(request('eventid')){
            $eventid=request('eventid');
            
            ## Current : Event Detail #
            $evntDetail = DB::table($tdetail['event_master'])
            ->where('aem_id', '=', request('eventid'))
            ->orderBy('aem_id', 'DESC')
            ->first();
            if(isset($evntDetail)){
                Session::put('selectedEvent', $evntDetail);
                $resp['code']='200'; 
                $resp['data']= $evntDetail;
            }
          
       }
       return Redirect::to('/'.request('targetpage')); 
    
    }

    public function doLogout()
    {
        session()->flush(); // log the user out of our application
        return Redirect::to('/'); // redirect the user to the login screen
    }




    ################
}
