<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Redirect;
use App\ComModel;
use Illuminate\Http\Request;
use Response;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function ViewProfile(){

            $stateId=null;
            $countryId=null;
            $tdetail=Session('tdetail');

            $profileDetail = DB::table($tdetail['exhibitor_master'].' as em')
            ->leftJoin('master_city as mc', 'mc.cm_id', 'em.cm_id')
            ->leftJoin('master_state as ms', 'ms.sm_id', 'em.sm_id')
            ->select('em.*','ms.sm_name','mc.cm_name')
            ->where('exhim_login_id', '=', Session('session')[0]->map_id)
            ->first();

            $galleryDetail = DB::table($tdetail['exhibitor_gallery'])
            ->select('*')
            ->where('exhim_id', '=', $profileDetail->exhim_id)
            ->get();

           $getStateList =ComModel::getStateMaster($countryId);
           $getCityList =ComModel::getCityMaster($stateId);

           
            $AddedCourse=DB::table($tdetail['exhibitor_product_master'])
            ->join($tdetail['parent_product_master'],$tdetail['exhibitor_product_master'].'.ppm_id',$tdetail['parent_product_master'].'.ppm_id')
            ->join($tdetail['exhibitor_product_mapping'],$tdetail['exhibitor_product_master'].'.exhipm_id',$tdetail['exhibitor_product_mapping'].'.exhipm_id')
            ->where($tdetail['exhibitor_product_mapping'].'.exhim_id',$profileDetail->exhim_id)
            ->get();

            

            $coursesDetails=HomeController::getcourses();
           
/*echo '<pre>';
print_r($EducationName);die;*/
            return view('others.user-profile', [
              'profileDetail' => $profileDetail,
              'galleryDetail'=>$galleryDetail,
              'coursesDetails'=>$coursesDetails,
              'AddedCourse'=>$AddedCourse,
              'bmid'=>Session('session')[0]->bm_id,
              'stateList' => $getStateList,
              'cityList' => $getCityList
             
            ]);
    }


    /*public function downloadpdf()
    { 
       $tdetail=Session('tdetail');
       $pdfpath=DB::table($tdetail['exhibitor_product_mapping'])
       ->where('epm_id',request('epmId'))
       ->first();
        $pathToFile=public_path()."/".$pdfpath->brochure;
        $headers = array(
                    'Content-Type: application/pdf',
                );
          //dd($pathToFile);
        return response()->download($pathToFile, $headers);
     

    }*/


      public static function getcourses($ppmId=null){
          $tdetail=Session('tdetail');
          $coursesDetails=array();

          $stream = DB::table($tdetail['parent_product_master'])
              ->select('*')
              ->get();

            $ppm_id="";
            if(!null==request('ppm_id')){
              $ppm_id=request('ppm_id');
            }else if(!empty($ppmId)){
              $ppm_id=$ppmId;
            }else{
              $ppm_id=$stream[0]->ppm_id;
            }

           $courses = DB::table($tdetail['exhibitor_product_master'])
           ->select('*')
           ->where('ppm_id', '=', $ppm_id)
           ->get();

           $qualification = DB::table($tdetail['qualification_master'])
              ->select('*')
              ->get();

           $coursesDetails['stream']=$stream;
           $coursesDetails['courses']=$courses;
           $coursesDetails['qualification']=$qualification;

           if(!null==request('ppm_id')){
                  $content="";
                  foreach ($courses as  $value) {
                    $content .='<div class="col-md-4 col-6">
                      <label class="radio radio-outline-danger">
                          <input type="radio" name="Course" value="';
                        $content .=$value->exhipm_id.'"';
                        if($courses[0]->exhipm_id==$value->exhipm_id){
                          $content .=" checked";
                        }
                        $content .=' formControlName="radio" onclick="Showotherinput(this.value)" ><span>';
                        $content .=   $value->epm_text;
                        $content .= '</span>
                          <span class="checkmark"></span>
                      </label>
                    </div>';
                  }
                  $content .='<div class="col-md-4 col-6">
                    <label class="radio radio-outline-danger">
                        <input type="radio" name="Course" value="other"  formControlName="radio" onclick="Showotherinput(this.value)" >
                        <span>Other</span>
                        <span class="checkmark"></span>
                    </label>
                    <input class="d-none form-control" type="text" name="new_course" id="new_course" value=""  placeholder="Enter Course Name" >
                    <span class="text-danger" id="err_msg_nc" name="err_msg_nc"  style="display:none;"><
                  </div>';

            return $content;

           }else{
             return $coursesDetails;
           }


      }

    public static function GetDashboardData(){
      return view('dashboard.dashboardv1');
    }

    public function GetDataList(){

      $tdetail=Session('tdetail');
      $pdetail=Session('profileDetail');
      $eventDetail=Session('evntDetail');
      $selectedEvent=Session('selectedEvent');
     
      
      if(Session::has('paginate')){
          $paginate = Session::get('paginate');
      } else{
        $paginate = 10;
      }

      if (null !==(request('pagination'))){
          $paginate = request('pagination');
          Session::put('paginate', $paginate);
      }
      $searchText="";
      if (null !==(request('search_text'))){
          $searchText = request('search_text');
          //Session::put('search_text', $search_text);
      }

//dd($selectedEvent);

      $leadList=DB::table($tdetail['lead_master'].' as lm')
      ->join($tdetail['lead_event_master_mapping'].' as lemm', 'lemm.lm_id','lm.lm_id')
      ->join($tdetail['lead_event_exhibitor_mapping'].' as leem', 'leem.lemm_id','lemm.lemm_id')
      ->leftJoin(\DB::raw("(
        SELECT 
        `lemm_id`,
        GROUP_CONCAT(CONCAT('<li>',`leema_text`,'</a>') SEPARATOR ' ' ) as 'activity'
        FROM  `".$tdetail['lead_event_exhibitor_mapping_activity']."`  
        WHERE 1
        group by `lemm_id` ) as leema"),
                function ($join) {
                    $join->on('leema.lemm_id', '=', 'leem.lemm_id');
        })
      ->leftJoin($tdetail['master_city'].' as mc'  ,'lm.city_id','mc.cm_id')
      ->leftJoin($tdetail['qualification_master'].' as qm' ,'lm.qm_id','qm.qm_id')
      ->leftJoin($tdetail['product_master'].' as pm' ,'lm.pm_id','pm.pm_id')
      ->leftJoin($tdetail['lead_categorization'].' as lc' ,'lc.lc_id','leem.lc_id');

      $leadList->select('lm.*', 'lemm.*', 'lemm.*', 'leem.*','leema.activity','mc.*','qm.*','pm.*','lc.*');
      $leadList->where('lemm.aem_id', $selectedEvent->aem_id);
     
      if(!empty($searchText)){
            $leadList->where(function($query) use ($tdetail,$searchText) {
                $query->orwhere($tdetail['lead_master'].'.lm_email',$searchText)
                    ->orwhere($tdetail['lead_master'].'.lm_mobile',$searchText)
                    ->orwhere($tdetail['master_city'].'.cm_name',$searchText)
                    ->orwhere($tdetail['qualification_master'].'.qm_text','like','%'.$searchText.'%')
                    ->orwhere($tdetail['product_master'].'.pm_text','like','%'.$searchText.'%')
                    ->orwhere($tdetail['lead_master'].'.lm_fullname','like','%'.$searchText.'%');
            });
      }
      $res=$leadList->paginate($paginate);

      $leadcat=ComModel::getLeadCategorization();

      return view('datatables.visitor-tables',['leadList'=>$res, 'leadcat'=>$leadcat]);
    }
    public function VisitorActivity(){

            $tdetail=Session('tdetail');
            if(Session::has('paginate')){
                $paginate = Session::get('paginate');
            } else{
              $paginate = 10;
            }

            if (null !==(request('pagination'))){
                $paginate = request('pagination');
                Session::put('paginate', $paginate);
            }
            $searchText="";
            if (null !==(request('search_text'))){
                $searchText = request('search_text');
                //Session::put('search_text', $search_text);
            }

            $leadList=DB::table($tdetail['lead_master'] )
            ->join($tdetail['master_city'] ,$tdetail['lead_master'].'.city_id',$tdetail['master_city'].'.cm_id')
            ->join($tdetail['qualification_master'] ,$tdetail['lead_master'].'.qm_id',$tdetail['qualification_master'].'.qm_id')
            ->join($tdetail['product_master'] ,$tdetail['lead_master'].'.pm_id',$tdetail['product_master'].'.pm_id');
            if(!empty($searchText)){
                  $leadList->where(function($query) use ($tdetail,$searchText) {
                      $query->orwhere($tdetail['lead_master'].'.lm_email',$searchText)
                          ->orwhere($tdetail['lead_master'].'.lm_mobile',$searchText)
                            ->orwhere($tdetail['master_city'].'.cm_name',$searchText)
                          ->orwhere($tdetail['qualification_master'].'.qm_text','like','%'.$searchText.'%')
                          ->orwhere($tdetail['product_master'].'.pm_text','like','%'.$searchText.'%')
                          ->orwhere($tdetail['lead_master'].'.lm_fullname','like','%'.$searchText.'%');
                  });
            }
                        $res=$leadList  ->paginate($paginate);

            return view('datatables.activity-tables',['leadList'=>$res]);
    }


    public function Updateuserprofile(){


          $tdetail=Session('tdetail');
          $pdetail=Session('profileDetail');

          if(!null==request('upload_photo') && request('photoupload')=='photoupload'){
            $upload_image=request('upload_photo');
            $imageName = date('Y-m-d').time().'.'.$upload_image->getClientOriginalExtension();

            $imagePath='assets/images/'.Session('session')[0]->bm_id.'/'.$pdetail->exhim_id.'/gallery';
            $upload_image->move(public_path($imagePath), $imageName);
            $insert=DB:: table($tdetail['exhibitor_gallery'])
                        ->insert(array(
                                      'exhim_id'=> $pdetail->exhim_id,
                                      'eg_name'=>$imageName,
                                      'eg_type'=>'image'
                                      )
                        );
          }
          ## Upload Banner ##
          if(!null==request('upload_photo') && request('photoupload')=='UpdateBanner'){
            $upload_image=request('upload_photo');
            $imageName = date('Y-m-d').time().'.'.$upload_image->getClientOriginalExtension();

            $imagePath='assets/images/'.Session('session')[0]->bm_id.'/'.$pdetail->exhim_id.'/';
            $upload_image->move(public_path($imagePath), $imageName);
            $insert=DB:: table($tdetail['exhibitor_master'])
                        ->where('exhim_id', $pdetail->exhim_id)
                        ->update( array(
                                         'exhim_banner'=>$imageName
                                       )
                        );
          }
          ## Upload Logo ##
          if(!null==request('upload_photo') && request('photoupload')=='UpdateLogo'){
            $upload_image=request('upload_photo');
            $imageName = date('Y-m-d').time().'.'.$upload_image->getClientOriginalExtension();

            $imagePath='assets/images/'.Session('session')[0]->bm_id.'/'.$pdetail->exhim_id.'/';
            $upload_image->move(public_path($imagePath), $imageName);
            $insert=DB:: table($tdetail['exhibitor_master'])
                        ->where('exhim_id', $pdetail->exhim_id)
                        ->update( array(
                                         'exhim_logo'=>$imageName
                                       )
                        );
          }

          if(!null==request('upload_photo') && request('photoupload')=='photoupdate'){
            $upload_image=request('upload_photo');
            $imageName = date('Y-m-d').time().'.'.$upload_image->getClientOriginalExtension();
            $imagePath='assets/images/'.Session('session')[0]->bm_id.'/'.$pdetail->exhim_id.'/gallery';
            $upload_image->move(public_path($imagePath), $imageName);
                      $update=DB:: table($tdetail['exhibitor_gallery'])
                      ->where('eg_id', request('eg_id'))
                      ->update(array(
                                    'eg_name'=>$imageName
                                    )
                      );
            }

        if(!null==request('upload_brochure') && request('brochure')=='brochure'){
          $upload_image=request('upload_brochure');
          $imageName = 'brochure.'.$upload_image->getClientOriginalExtension();
          $imagePath='assets/images/'.Session('session')[0]->bm_id.'/'.$pdetail->exhim_id.'/brochure';
          $upload_image->move(public_path($imagePath), $imageName);
                        $update=DB:: table($tdetail['exhibitor_master'])
                        ->where('exhim_id', $pdetail->exhim_id)
                        ->update(array(
                                      'exhim_brochure'=>$imageName
                                      )
                        );
          }

            if(!null==request('quickfact')){
               
                $update=DB:: table($tdetail['exhibitor_master'])
                ->where('exhim_id', $pdetail->exhim_id)
                ->update(array(
                              'exhim_type_of_institute' => request('institute_type'),
                              'exhim_ownership'=>request('ownership'),
                              'exhim_estd_year'=>request('estd_year'),
                              'exhim_accreditation'=>request('accreditation'),
                              'exhim_campus_area'=>request('campus_area'),
                              'exhim_approval'=>request('approval'),
                              'exhim_contact_us'=>request('phone'),
                              'exhim_contact_email'=>request('email'),
                              'exhim_address'=>request('address'),
                              'sm_id'=>request('state'),
                              'cm_id'=>request('city'),
                              'exhim_whatsapp'=>request('whatsapp_id'),
                              )
                );
          }
          if(!null==request('highlights')){
                    
                    $update=DB:: table($tdetail['exhibitor_master'])
                    ->where('exhim_id', $pdetail->exhim_id)
                    ->update(array(
                                  'exhim_detail'=>request('exhim_detail')
                                  )
                    );
          }


                return redirect('profile');
    }

    function AddCourseOffered(Request $request){
        $tdetail=Session('tdetail');
        $pdetail=Session('profileDetail');
        $exhipm_id="";
        if(!null==request('Course') && request('Course')=='other') {
                $insertcourse= DB::table($tdetail['exhibitor_product_master'])
                      ->insert(
                        array(
                              'ppm_id'=>request('stream'),
                              'epm_text'=>request('new_course')
                            )
                        );
                $exhipm_id = DB::getPdo()->lastInsertId();
                
        }else{
          $exhipm_id=request('Course');
          $qm_id=$request->input('Education');
          $qm_ids = implode(',', $qm_id);
         // return($qm_id);die;
          
        }
        if(!empty(request('epmId'))){
            $datas  = array();
            $datas['exhipm_id']= $exhipm_id;
            $datas['qm_id']= $qm_ids;
            $datas['exhim_id']= $pdetail->exhim_id;
            $datas['epm_duration_in_year']= $request->course_duration;
            $datas['epm_fee_charged_per_sem']= $request->course_fee_sem;
            $datas['epm_total_fee_charged']= $request->course_fee_year;  
            $image=request('upload_brochure');
            $destinationPath = 'assets/images/1/1/brochure/'; // upload path
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image_url = $destinationPath.$profileImage;
            $success = $image->move($destinationPath, $profileImage);
            $datas['brochure']=$image_url;
            $Getexhim_Id = DB::table($tdetail['exhibitor_product_mapping'])
                            ->where('epm_id',request('epmId'))
                            ->update($datas);
         }else {
            $datas  = array();
            $datas['exhipm_id']= $exhipm_id;
            $datas['qm_id']= $qm_ids;
            $datas['exhim_id']= $pdetail->exhim_id;
            $datas['epm_duration_in_year']= $request->course_duration;
            $datas['epm_fee_charged_per_sem']= $request->course_fee_sem;
            $datas['epm_total_fee_charged']= $request->course_fee_year;  
            $image=request('upload_brochure');
            $destinationPath = 'assets/images/1/1/brochure/'; // upload path
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image_url = $destinationPath.$profileImage;
            $success = $image->move($destinationPath, $profileImage);
            $datas['brochure']=$image_url;
            $Getexhim_Id = DB::table($tdetail['exhibitor_product_mapping'])->insert($datas);
          
          }
         
          
       return redirect('profile');
    }

#######END CLASS ###


    public function bothstaff(){

        $tdetail=Session('tdetail');
        $profileDetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');
       //dump($profileDetail->exhim_id);
        if(Session::has('paginate')){
            $paginate = Session::get('paginate');
        } else{
          $paginate = 10;
        }
        if (null !==(request('pagination'))){
            $paginate = request('pagination');
            Session::put('paginate', $paginate);
        }
        $searchText="";
        if (null !==(request('search_text'))){
            $searchText = request('search_text');
            //Session::put('search_text', $search_text);
        }
       
        $leadList=DB::table($tdetail['exhibitor_boothstaff'] .' as ebs')
        ->leftJoin($tdetail['exhibitor_event_with_boothstaff_mapping'] .' as eewbm' ,'ebs.ebsm_id', 'eewbm.ebsm_id' )
        ->leftJoin($tdetail['exhibitor_event_mapping'] .' as eem','eewbm.eem_id', 'eem.eem_id');
        if(!empty($searchText)){
              $leadList->where(function($query) use ($searchText) {
                  $query->orwhere('eem.eem_whatsapp_no','%'.$searchText.'%')
                      ->orwhere('ebs.ebsm_name','like','%'.$searchText.'%')
                      ->orwhere('ebs.ebm_login_user','like','%'.$searchText.'%')
                      ->orwhere('ebs.ebsm_mobile','like','%'.$searchText.'%');
              });
        }
        $leadList->select('eem.aem_id','eem.eem_whatsapp_no','ebs.*','eewbm.*', DB::raw(" (CASE WHEN eewbm.eewbm_status = 'active' && ebs.ebsm_statu='active' THEN 'Active' ELSE 'Inactive' END) AS staffStatus ") );
        //$leadList->where('eewbm.eewbm_status', 'active');
      // $leadList->where('ebs.ebsm_statu', 'active');
        $leadList->where('ebs.exhim_id', $profileDetail->exhim_id);
        //$leadList->where('eem.aem_id', $eventDetails->aem_id);
        $res=$leadList->paginate($paginate);
        //dump($res);
        return view('datatables.bothstaff-tables',['leadList'=>$res]);
    }

    public function getbothstaff(){

        $tdetail=Session('tdetail');
        $profileDetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');

        $leadList=DB::table($tdetail['exhibitor_boothstaff']);
        $leadList->where('ebs_statu', 'active');
        $leadList->where('exhim_id', $profileDetail->exhim_id);
        $res=$leadList->get();
        return $res;

     }

     public function callcitylist(Request $request) {
      $respReq=array();
      $respReq['code']='404';
      $respReq['msg']='The records not found!';

        
        $state="";
        if(!empty(request('state'))){
          $state=request('state');
        }
        $cityMaster=ComModel::getCityMaster($state);
        if(!empty($cityMaster)){
          $respReq['code']='200';
            $htmlAppend='<option value="">Select Please</option>';
            $htmlMobAppend="";
            if(!empty($cityMaster)){
              foreach($cityMaster as $key => $cityData){
                $htmlAppend .=' <option value="'.$cityData->cm_id.'" > '.$cityData->cm_name.' </option>';
              }
            }

          $respReq['htmlAppend']=$htmlAppend;
        }
    return json_encode($respReq);
  }
  

    public function addeditcourse(){

        $stateId=null;
        $countryId=null;
        $ppmId=null;
        $applyedDetails=array();
        $tdetail=Session('tdetail');
        $profileDetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');     
        $epmId="";
        if(!empty(request('epmId'))){          
            $epmId=request('epmId');
            //return $epmId;die;   
            $profileSql = DB::table($tdetail['exhibitor_product_mapping']. ' as epmap')
                      ->Join($tdetail['exhibitor_product_master'].' as epm', 'epm.exhipm_id', 'epmap.exhipm_id')                 
                      ->Join($tdetail['parent_product_master'].' as ppm', 'ppm.ppm_id', 'epm.ppm_id')
                      ->select('epmap.*','epm.*','ppm.*');
                      if(!empty(request('epmId'))){
                        $profileSql->where('epmap.epm_id', request('epmId'));
                      }
                      $profileSql->where('epmap.exhim_id', $profileDetail->exhim_id);
            $applyedDetails= $profileSql->first();    
            $ppmId = $applyedDetails->ppm_id;
            /*$qm_id =  $applyedDetails->qm_id;
            $checked = explode(',', $qm_id);*/
//dump($applyedDetails);
        }
            

      $coursesDetails=HomeController::getcourses($ppmId);
//return $coursesDetails;die;
      return view('others.addeditcourse', [
        'coursesDetails'=>$coursesDetails,
        'applyedDetails'=>$applyedDetails,
        'epmId' => $epmId      
      ]);
    }

   
    public function addcategory(Request $request) {
       
        $tdetail=Session('tdetail');
        $profileDetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');
      
      
        $leemId = empty(request('leemId')) ? '' : request('leemId') ;
        
        if(!empty($leemId)){

              $dataList=DB::table($tdetail['lead_event_exhibitor_mapping'])
                        ->where('leem_id', request('leemId'))->first();

              # Remark History#
              $remarkList=ComModel::getExhibitorRemark(request('leemId'));

              $leadcat=ComModel::getLeadCategorization();
              $htmlAppend='<option value="">Select Please</option>';

              if(!empty($leadcat)){
                  foreach($leadcat as $key => $catData){
                    $htmlAppend .=' <option value="'.$catData->lc_id.'" ';
                  
                    if($dataList->lc_id==$catData->lc_id)
                      $htmlAppend .=' selected ';

                    $htmlAppend .='> '.$catData->lc_text.' </option>';
                  }
              }
          }
       
        return view('datatables.catgaction',['htmlAppend'=>$htmlAppend, 'leemId'=>$leemId, 'remarkList'=>$remarkList ]);
    }

    public function showhistory(Request $request) {
       
      $tdetail=Session('tdetail');
      $profileDetail=Session('profileDetail');
      $eventDetails=Session('selectedEvent');
    
      $leemId = empty(request('leemId')) ? '' : request('leemId') ;
    
      # Remark History#
      $remarkList=ComModel::getExhibitorRemark($leemId);
      
      return view('datatables.showhistory',['remarkList'=>$remarkList ]);
  }

    
    public function changeleadstatus(){

      $respReq['code']='404';
      $respReq['msg']='The records not found!';

      $tdetail=Session('tdetail');
      $pdetail=Session('profileDetail');
      $loginSess=Session::get('session')[0];
      $ip=Request::ip();

      if(!null==request('leemId')) {

           
             $respReq['code']='200';

              ## Last Remark Update ##
              DB::table($tdetail['lead_event_exhibitor_mapping'])
              ->where('leem_id',request('leemId'))
              ->update(
                      array(
                            'leem_updateby'=>$loginSess->map_id,
                            'leem_updateby_ip'=>$ip,
                            'lc_id'=>request('clsstage'),
                            'leem_last_remark_update_date'=> now(),
                            'leem_comment'=>request('clscomment')
                    )
              );

              ## ADD Remark ##
              DB::table($tdetail['lead_event_exhibitor_mapping_remark'])
              ->insert(
                      array(
                            'leem_id'=> request('leemId'),
                            'leer_updateby'=> $loginSess->map_id,
                            'leer_updateby_ip'=> $ip,
                            'lc_id'=> request('clsstage'),
                            'leer_remark'=> request('clscomment')
                    )
              );

      }

       return json_encode($respReq);
  }

 public  function saveData(Request $request)
  {
    $tdetail=Session('tdetail');
    $eem_id =request('eem_id');
    $ebsm_id =request('ebsm_id');
  //dd($ebsm_id);
    $check = DB::table($tdetail['exhibitor_event_with_boothstaff_mapping'])
            ->where('eem_id',$eem_id)
            ->where('ebsm_id',$ebsm_id)->pluck('eewbm_status');
      if ($check[0] == 'active') {
            DB::table($tdetail['exhibitor_event_with_boothstaff_mapping'])
            ->where('eem_id',$eem_id)
            ->where('ebsm_id',$ebsm_id)
            ->update([
              'eewbm_status'=>'Inactive'
            ]);
       
      }else{
      DB::table($tdetail['exhibitor_event_with_boothstaff_mapping'])
            ->where('eem_id',$eem_id)
            ->where('ebsm_id',$ebsm_id)
            ->update([
              'eewbm_status'=>'active'
            ]);
    }
    
  return "inserted";
  }



   //edit user

    public function edituser(){
        $tdetail=Session('tdetail');
        $profileDetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');     
        $ebsmId="";
        if(!empty(request('ebsmId'))){          
            $ebsmId=request('ebsmId');
            $dataList =  DB::table($tdetail['exhibitor_boothstaff'] .' as ebs')
                      ->leftJoin($tdetail['exhibitor_event_with_boothstaff_mapping'] .' as eewbm' ,'ebs.ebsm_id', 'eewbm.ebsm_id' )
                       ->leftJoin($tdetail['exhibitor_event_mapping'] .' as eem','eewbm.eem_id', 'eem.eem_id')->where('ebs.ebsm_id',$ebsmId)
                        ->select('ebs.*','eem.*')->first();
                        //dd($dataList);
            return view('datatables.edituser',[
                        'dataList'=>$dataList,
                        'ebsmId'=>$ebsmId
            ]);

          }
    }

    public function adduser()
    {
        $tdetail=Session('tdetail');
        $pdetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');
        $profileDetail=Session('profileDetail');
        //dd(request('eem_id'));
        if(!empty(request('ebsmId'))){
        $updateuser = DB::table($tdetail['exhibitor_boothstaff'])
                  ->where('ebsm_id',request('ebsmId'))
                  ->update(
                        array(                       
                              'exhim_id'=>$pdetail->exhim_id,
                              'ebsm_name'=>request('edit_usser_name'),
                              'ebsm_mobile'=>request('edit_user_phone'),
                              'ebm_login_user'=>request('edit_user_email')
                            )
                );
        $update = DB::table($tdetail['exhibitor_event_mapping'])
                  ->where('eem_id',request('eem_id'))
                  ->update(
                        array(          
                              'eem_whatsapp_no'=>request('edit_user_whatsapp')
                          )
                    );         


        }else {

          $respReq=array();
          $respReq['code']='200';
          $respReq['msg']='Your Counselor Seat is Full !';

          $get_ppm_id = DB::table($tdetail['exhibitor_event_mapping'])
                        ->where('aem_id',$eventDetails->aem_id)
                        ->where('exhim_id',$pdetail->exhim_id)
                        ->first();
          //dd ($get_ppm_id->ppm_id);die;
          $info=DB::table($tdetail['exhibitor_boothstaff'] .' as ebs')  
                      ->Join($tdetail['exhibitor_event_mapping'] .' as eem','ebs.exhim_id', 'eem.exhim_id')->where('ebs.exhim_id', $profileDetail->exhim_id)
                        ->select('eem.*','ebs.*',DB::raw("count(ebs.exhim_id) as totalcounselor"))
                        ->groupBy('ebs.exhim_id')->first();
                        //dd($info->totalcounselor);

                if ($get_ppm_id->ppm_id == 3 && $info->totalcounselor < 1) {
                    $Getebsm_Id= DB::table($tdetail['exhibitor_boothstaff'])
                    ->insertGetId(
                      array( 
                            'exhim_id'=>$pdetail->exhim_id,
                            'ebsm_name'=>request('name'),
                            'ebsm_mobile'=>request('phone'),
                            'ebm_login_user'=>request('email'),
                            'ebm_login_pwd'=>request('password')
                            )
                        );
                    $Geteem_Id = DB::table($tdetail['exhibitor_event_mapping'])
                          ->insertGetId(
                                array(          
                                      'eem_whatsapp_no'=>request('whatsapp')
                                      )
                                 ); 
                    $insertData = DB::table($tdetail['exhibitor_event_with_boothstaff_mapping'])
                          ->insert(
                                array(          
                                      'eem_id'=>$Geteem_Id,             
                                      'ebsm_id'=>$Getebsm_Id
                                      )
                                  );
                }elseif ($get_ppm_id->ppm_id == 2 && $info->totalcounselor < 3) {
                  $Getebsm_Id= DB::table($tdetail['exhibitor_boothstaff'])
                    ->insertGetId(
                      array( 
                            'exhim_id'=>$pdetail->exhim_id,
                            'ebsm_name'=>request('name'),
                            'ebsm_mobile'=>request('phone'),
                            'ebm_login_user'=>request('email'),
                            'ebm_login_pwd'=>request('password')
                            )
                        );
                  $Geteem_Id = DB::table($tdetail['exhibitor_event_mapping'])
                          ->insertGetId(
                                array(          
                                      'eem_whatsapp_no'=>request('whatsapp')
                                      )
                                 ); 
                  $insertData = DB::table($tdetail['exhibitor_event_with_boothstaff_mapping'])
                          ->insert(
                                array(          
                                      'eem_id'=>$Geteem_Id,             
                                      'ebsm_id'=>$Getebsm_Id
                                      )
                                  );
                 
                }elseif ($get_ppm_id->ppm_id == 5 && $info->totalcounselor < 5) {
                  $Getebsm_Id= DB::table($tdetail['exhibitor_boothstaff'])
                    ->insertGetId(
                      array( 
                            'exhim_id'=>$pdetail->exhim_id,
                            'ebsm_name'=>request('name'),
                            'ebsm_mobile'=>request('phone'),
                            'ebm_login_user'=>request('email'),
                            'ebm_login_pwd'=>request('password')
                            )
                        );
                  $Geteem_Id = DB::table($tdetail['exhibitor_event_mapping'])
                          ->insertGetId(
                                array(          
                                      'eem_whatsapp_no'=>request('whatsapp')
                                      )
                                 ); 
                  $insertData = DB::table($tdetail['exhibitor_event_with_boothstaff_mapping'])
                          ->insert(
                                array(          
                                      'eem_id'=>$Geteem_Id,             
                                      'ebsm_id'=>$Getebsm_Id
                                      )
                                  );
                }else{

                return json_encode($respReq);

                }
              } 
           //return 'inserted';
    }

    public function exhibitor_master(Request $request)
    {
        $search = $request->search;
        $tdetail=Session('tdetail');
        //dd( $tdetail);
        $profileDetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');
         //dump( $eventDetails);
        if(Session::has('paginate')){
            $paginate = Session::get('paginate');
        } else{
          $paginate = 10;
        }
        if (null !==(request('pagination'))){
            $paginate = request('pagination');
            Session::put('paginate', $paginate);
        }
        $searchText="";
        if (null !==(request('search_text'))){
            $searchText = request('search_text');
        }

         
        $leadList=DB::table($tdetail['exhibitor_master'] .' as em')
        ->Join($tdetail['exhibitor_event_mapping'] .' as eem' ,'em.exhim_id', 'eem.exhim_id')

        ->leftJoin(\DB::raw("(

             SELECT 
             eewbm.eem_id,
             eems.aem_id,
             eems.exhim_id,
             
             count(*) as 'counselor'
            FROM 
                    
                 ".$tdetail['exhibitor_event_with_boothstaff_mapping']."  as eewbm
             Join  ".$tdetail['exhibitor_event_mapping']." as eems ON eewbm.eem_id=eems.eem_id
            WHERE eems.aem_id=$eventDetails->aem_id
            group by eewbm.eem_id) as bsmm"),
                    function ($join) {
                        $join->on('bsmm.eem_id', '=', 'eem.eem_id');
            })

        ->leftJoin($tdetail['participation_plans_master'] .' as ppm' ,'ppm.ppm_id', 'eem.ppm_id');

        if(!empty($searchText)){
              $leadList->where(function($query) use ($searchText) {
                  $query->orwhere('em.exhim_whatsapp','like','%'.$searchText.'%')
                      ->orwhere('em.exhim_organization_name','like','%'.$searchText.'%')
                      ->orwhere('ppm.ppm_text','like','%'.$searchText.'%')
                      ->orwhere('em.exhim_contact_us','like','%'.$searchText.'%');
              });
        }
        $leadList->select('bsmm.*', 'eem.*','ppm.*','em.*');

        if (!empty($search)) {  

                    $leadList= $leadList->where('eem.eem_status',$search);

            }

        $res=$leadList->paginate($paginate);

        $category = DB::table($tdetail['master_state'])->get();
        $plans = DB::table($tdetail['participation_plans_master'])->get();


         //dump($res);
      return view('datatables.exhibitor-master',[
                'leadList'=>$res,
                'category'=>$category,
                'plans'=>$plans,
                'search'=>$search

          ]);
      
    }

    public function editexhibitor(){
        $tdetail=Session('tdetail');
        $profileDetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');     
        $exhim_id="";
        if(!empty(request('exhim_id'))){
          $exhim_id=request('exhim_id');
          $dataList =  DB::table($tdetail['exhibitor_master'] .' as em')
                      ->leftJoin($tdetail['exhibitor_event_mapping'] .' as eem' ,'em.exhim_id', 'eem.exhim_id' )
                      ->where('em.exhim_id',$exhim_id)
                        ->select('em.*','eem.*')->first();
          $id =  DB::table($tdetail['exhibitor_master'])->where('exhim_id',$exhim_id)->first();
          $categories = DB::table($tdetail['master_state'])->get();
          $subcategories = DB::table($tdetail['master_city'])
                    ->where("sm_id",$id->sm_id)
                    ->get();
          $plan = DB::table($tdetail['participation_plans_master'])->get();
          /*dump($subcategories);
          dump($categories);
          dump($id->sm_id);*/              
                        //dd($dataList);
          return view('datatables.editexhibitor',[
            'dataList'=>$dataList,
            'exhim_id'=>$exhim_id,
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'id'=>$id,
            'plans'=>$plan
          ]);
        }

    }
    public function Addexhibitor()
    {
          $tdetail=Session('tdetail');
          $pdetail=Session('profileDetail');
          $eventDetails=Session('selectedEvent');
          $sm_id = request('ex_sm_ids');
          $cm_id = request('ex_cm_ids');         
//dd ($cm_id);
            if(!empty(request('exhim_id'))){
            $Getexhim_Id = DB::table($tdetail['exhibitor_master'])
                            ->where('exhim_id',request('exhim_id'))
                            ->update(
                                  array( 
                                        'sm_id'=>$sm_id,
                                        'cm_id'=>$cm_id,              
                                        'exhim_organization_name'=>request('ex_name'),
                                        'exhim_contact_email'=>request('ex_email'),
                                        'exhim_contact_us'=>request('ex_phone'),
                                        'exhim_whatsapp'=>request('ex_whatsApp'),
                                        'exhim_address'=>request('ex_address')
                                      )
                                );
            $update_eem = DB::table($tdetail['exhibitor_event_mapping'])
            ->where('exhim_id',request('exhim_id'))
            ->update(
                  array( 
                        /*'aem_id'=>$eventDetails->aem_id,*/
                        'exhim_id'=>request('exhim_id'),
                        'ppm_id'=>request('plan')
                      )
                );
        
            }else {
              $sm_id = request('sm_id');
              $cm_id = request('cm_id');
              $check = DB::table($tdetail['exhibitor_master'])
                    ->where("sm_id",$sm_id)
                    ->where("cm_id",$cm_id)
                    ->first();
                   
                    if ($check==true) {
                        return "exists";
                      }else{
                     $Getexhim_Id = DB::table($tdetail['exhibitor_master'])
                            ->insertGetId(
                                  array( 
                                        'sm_id'=>$sm_id,
                                        'cm_id'=>$cm_id,              
                                        'exhim_organization_name'=>request('name'),
                                        'exhim_contact_email'=>request('email'),
                                        'exhim_contact_us'=>request('phone'),
                                        'exhim_whatsapp'=>request('whatsApp'),
                                        'exhim_address'=>request('address')
                                      )
                                );
                    $insertData = DB::table($tdetail['exhibitor_event_mapping'])
                    ->insert(
                          array( 
                                'aem_id'=>$eventDetails->aem_id,
                                'exhim_id'=>$Getexhim_Id             
                                
                              )
                        );
                    }
                    return 'Inserted';
                  }
      }

      public function subcategorylist($sm_id)
      {
        //dd($sm_id);
          $tdetail=Session('tdetail');
          $pdetail=Session('profileDetail');
          $city = DB::table($tdetail['master_city'])
                    ->where("sm_id",$sm_id)
                    ->pluck("cm_name","cm_id")->all();
                    //dd($city);
                    return response()->json($city);
      }

      public function ex_subcategorylist($id)
      {
         $tdetail=Session('tdetail');
          $pdetail=Session('profileDetail');
          $city = DB::table($tdetail['master_city'])
                    ->where("sm_id",$id)
                    ->pluck("cm_name","cm_id")->all();
                    //dd($city);
                    return response()->json($city);
       
      }

      public function changeStatus()
      {
          $pdetail=Session('profileDetail');
          $tdetail=Session('tdetail');
          $plan_id = request('result');
//dd (request('result'));
          $check = DB::table($tdetail['exhibitor_event_mapping'])
                  ->where('eem_id',request('eem_id'))
                  ->first();
                  //print_r($check);die;
                 /* ->pluck('eem_status','ppm_id');*/
            if ($check->eem_status == 'active') {
                  $active = DB::table($tdetail['exhibitor_event_mapping'])
                            ->where('eem_id',request('eem_id'))
                            ->update(
                                  array( 
                                        'eem_status'=>'Inactive',
                                        'ppm_id'=> $plan_id
                                      )
                                );
                  }else{
                  $inactive = DB::table($tdetail['exhibitor_event_mapping'])
                                ->where('eem_id',request('eem_id'))
                                ->update(
                                    array( 
                                          'eem_status'=>'Active',
                                          'ppm_id'=> $plan_id
                                          )
                                  );
                              }
           return "Inserted";
       }

         public function ShowCounselorDetail()
              {
                  $tdetail=Session('tdetail');
                  $counselor = DB::table($tdetail['exhibitor_boothstaff'])
                    ->where('exhim_id',request('exhim_id'))
                    ->get();
                    return view('datatables.showcounselor-detail',[
                    'counselor'=>$counselor
                    ]);
                    
              }


            //CounselorSession
          public function CounselorSession(Request $request)
            {
             $search = $request->search;
            // dump($search);
              $tdetail=Session('tdetail');
              $profileDetail=Session('profileDetail');
              $eventDetails=Session('selectedEvent');
              if(Session::has('paginate')){
                    $paginate = Session::get('paginate');
             } else{
                  $paginate = 10;
            }
            if (null !==(request('pagination'))){
            $paginate = request('pagination');
            Session::put('paginate', $paginate);
            }
            $searchText="";
            if (null !==(request('search_text'))){
            $searchText = request('search_text');
            }
            $leadList=DB::table($tdetail['live_career_counseling_sessions']);          
            if(!empty($searchText)){
                  $leadList->where(function($query) use ($searchText) {
                      $query->orwhere('lccs_name','like','%'.$searchText.'%')
                          ->orwhere('lccs_start_datewtime','like','%'.$searchText.'%')
                          ->orwhere('lccs_end_datewtime','like','%'.$searchText.'%')
                          ->orwhere('lccs_zoom_id','like','%'.$searchText.'%');
                  });
            }
            if (!empty($search)) {

                    $leadList= $leadList->where('lccs_status',$search);
            }             

            
            $res=$leadList->paginate($paginate);
            return view('datatables.CounselorSession',[
                    'leadList'=>$res,
                    'search'=>$search

                  ]);
            }

            public function editCounselorSession()
            {
              $tdetail=Session('tdetail');             
              $dataList=DB::table($tdetail['live_career_counseling_sessions'])
              ->where('lccs_id',request('lccs_id'))->first();
              return view('datatables.editCounselorSession',[
                'dataList'=>$dataList
                  ]);
              }

            public function AddecounselorSession()
            {
              //dd(request('enddate'));
              $tdetail=Session('tdetail');
              $selectedEvent=Session('selectedEvent');
              $insertData=DB::table($tdetail['live_career_counseling_sessions'])
                            ->insert(
                                  array( 
                                        'aem_id'=>$selectedEvent->aem_id,              
                                        'lccs_name'=>request('name'),
                                        'lccs_start_datewtime'=>request('picker3'),
                                        'lccs_end_datewtime'=>request('enddate'),
                                        'lccs_zoom_id'=>request('zoomid'),
                                        'lccs_zoom_pwd'=>request('zoompass')
                                      )
                                );
                            return "Inserted";
            }  


            public function updateCounselorSession()
            {
              //dd(request('startdate'));
              $tdetail=Session('tdetail');
              $selectedEvent=Session('selectedEvent');
              $insertData=DB::table($tdetail['live_career_counseling_sessions'])
                            ->where('lccs_id',request('lccs_id'))
                            ->update(
                                  array( 
                                        'aem_id'=>$selectedEvent->aem_id,              
                                        'lccs_name'=>request('e_name'),
                                        'lccs_start_datewtime'=>request('e_startdates'),
                                        'lccs_end_datewtime'=>request('e_enddate'),
                                        'lccs_zoom_id'=>request('e_zoomid'),
                                        'lccs_zoom_pwd'=>request('e_zoompass')
                                      )
                                );
                            return "Updated";
            }

            public function counselorchangeStatus()
            {

              $tdetail=Session('tdetail');
              $selectedEvent=Session('selectedEvent');

              $check = DB::table($tdetail['live_career_counseling_sessions'])
                  ->where('lccs_id',request('lccs_id'))
                  ->first();
              $lccs_id =request('lccs_id');
                  
            if ($check->lccs_status == 'active') {
                  $active = DB::table($tdetail['live_career_counseling_sessions'])
                            ->where('lccs_id',$lccs_id)
                            ->update([
                               'lccs_status'=>'inactive'
                            ]);
                  }else{
                   // dd(request('lccs_id'));
                  $inactive = DB::table($tdetail['live_career_counseling_sessions'])
                              ->where('lccs_id',$lccs_id)
                              ->update([
                               'lccs_status'=>'active'
                            ]);
                              }
          return "Inserted";
            }

            /**/

      
}
