<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Session;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\HelperController;

class ComModel extends Model
{
    

    public static function getCityMaster($stateId=null)
    {
        $cityMasterData=array();
        $cityMasterSql= DB::table('master_city')
        ->where('cm_status','active');
        if(!empty($stateId)){
            $cityMasterSql->where('sm_id',$stateId);
        }
        $cityMasterSql->orderBy('cm_name','ASC');
        $cityMasterData=$cityMasterSql->get();
        return $cityMasterData;
    }
    public static function getStateMaster($countryId=null)
    {
        $stateMasterData=array();
        $stateMaster= DB::table('master_state')
        ->where('sm_status','active');
        if(!empty($countryId)){
            $stateMaster->where('counm_id',$countryId);
        }
        $stateMaster->orderBy('sm_name','ASC');
        $stateMasterData=$stateMaster->get();
        return $stateMasterData;
    }
    public static function getLeadCategorization()
    {
        $tdetail=Session('tdetail');
        $profileDetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');

        $getData=array();
        $sql= DB::table($tdetail['lead_categorization'])
        ->where('lc_status','active');
        $sql->orderBy('lc_orderby','ASC');
        $getData=$sql->get();
        return $getData;
    }

    public static function getExhibitorRemark($leemId)
    {
        $tdetail=Session('tdetail');
        $profileDetail=Session('profileDetail');
        $eventDetails=Session('selectedEvent');

        $remarkList=DB::table($tdetail['lead_event_exhibitor_mapping_remark'].' as leemr')
        ->leftJoin('access_mappings as am','am.map_id','leemr.leer_updateby')
        ->leftJoin($tdetail['lead_categorization'].' as lc','lc.lc_id','leemr.lc_id')
        ->select('leemr.*','lc.lc_text','am.user_name')
        ->where('leemr.leem_id', $leemId)
        ->orderBy('leemr.leer_id', 'DESC')->get();
    
        return $remarkList;
    }


   




   /*----------------------Start Masters--------------------------------*/
    public static function getQualificationMaster($basicData)
    {
        $qualiMData=array();
        $tdetail=$basicData['tdetail'];
        $eventdetail=$basicData['event'];

        $qualiMData= DB::table($tdetail['qualification_master'])
        ->where('qm_status','active')
        ->orderBy('qm_orderby','ASC')
        ->get();
        return $qualiMData;
    }
    public static function getCourseMaster($basicData)
    {
        $courseMasterData=array();
        $tdetail=$basicData['tdetail'];
        $eventdetail=$basicData['event'];

        $courseMasterData= DB::table($tdetail['product_master']. ' as pm')
        ->leftJoin($tdetail['parent_product_master_mapping'] .' as ppmm',  'ppmm.pm_id', '=', 'pm.pm_id')
        ->leftJoin($tdetail['parent_product_master'] .' as ppm' , 'ppm.ppm_id', '=', 'ppmm.ppm_id')
        ->select('pm.pm_id as key','pm.pm_text as value',DB::raw("(GROUP_CONCAT(ppm.ppm_id SEPARATOR ',')) as `ppm_id`"),DB::raw("(GROUP_CONCAT(ppm.ppm_text SEPARATOR ',')) as `ppm_text`") )
        ->where('pm.pm_status','active')
        ->groupBy('pm.pm_id')
        ->orderBy('pm.pm_orderby','ASC')
        ->get();
        return $courseMasterData;
    }
    public static function getParentProductMaster($basicData)
    {
        $parentProductMaster=array();
        $tdetail=$basicData['tdetail'];
        $eventdetail=$basicData['event'];

        $parentProductMaster= DB::table($tdetail['parent_product_master']. ' as ppm')
        ->leftJoin($tdetail['parent_product_master_mapping'] .' as ppmm',  'ppmm.ppm_id', '=', 'ppm.ppm_id')
        ->leftJoin($tdetail['product_master'] .' as pm' , 'pm.pm_id', '=', 'ppmm.pm_id')
        ->select('ppm.ppm_id as key','ppm.ppm_text as value',DB::raw("(GROUP_CONCAT(pm.pm_id SEPARATOR ',')) as 'pm_ids' "),DB::raw("(GROUP_CONCAT(pm.pm_text SEPARATOR ',')) as 'pm_texts'"))
        ->where('ppm.ppm_status','active')
        ->groupBy('ppm.ppm_id')
        ->orderBy('ppm.ppm_orderby','ASC')
        ->get();
        return $parentProductMaster;
    }

    public static function getCityMasterByCityId($cityId)
    {
        $cityMasterData=array();
        $cityMasterSql= DB::table('master_city')
        ->where('cm_status','active')
        ->where('cm_id',$cityId)
        ->orderBy('cm_name','ASC');
        $cityMasterData=$cityMasterSql->first();
        return $cityMasterData;
    }

   
    public static function isAboutuDataFilled($basicData, $lmId)
    {
        $isAbuFilled="N";
        $tdetail=$basicData['tdetail'];
        $eventdetail=$basicData['event'];
        $user = Session::get('user'); 
        if(!empty($lmId)){
            $datar = DB::table($tdetail['lead_master'])
            ->where('lm_id', $lmId)
            ->whereNotNull('pm_id')
            ->whereNotNull('qm_id')
            ->whereNotNull('city_id')
            ->first();
            if(!empty($datar)){
                $isAbuFilled="Y";
            }
        }

        return $isAbuFilled;
    }
   
   
   /*----------------------End Masters--------------------------------*/
   
   public static function updateadoutdata($allRequestData,$basicData)
   {
       $resArray=array();
       $tdetail=$basicData['tdetail'];
       $eventdetail=$basicData['event'];
       $user = Session::get('user'); 
       if(isset($user->lm_id) && !empty($user->lm_id)){
            $saveData=array();
            $saveData['qm_id']=$allRequestData['education'];
            $saveData['pm_id']=$allRequestData['course'];
            $saveData['city_id']=$allRequestData['city'];
            
            $update = DB::table($tdetail['lead_master'])->where('lm_id', $user->lm_id)->update(
                $saveData
            );

            $datar = DB::table($tdetail['lead_master'])
            ->where('lm_id', $user->lm_id)
            ->first();

            $resArray['code']="200";
            $resArray['data']= $datar;
        }else{
            $resArray['code']="400";
            $resArray['data']= '';
        }

       return $resArray;
   }

   public static function getExhibitorList($basicData,$allRequestData)
   {
        $exhibitorMaster=array();
        $tdetail=$basicData['tdetail'];
        $eventdetail=$basicData['event'];

        $exhibitorSql= DB::table($tdetail['exhibitor_master']. ' as em')
        ->Join($tdetail['exhibitor_event_mapping'] .' as eem',  'eem.exhim_id', '=', 'em.exhim_id')
        ->Join('master_city as mc',  'mc.cm_id', '=', 'em.cm_id')
        ->leftJoin($tdetail['product_exhibitor_master_mapping'] .' as pemm',  'pemm.exhim_id', '=', 'eem.exhim_id');
       

        $exhibitorSql->leftJoin(\DB::raw("(
            SELECT 
                 eewbm.`eem_id`,
                 eewbm.ebsm_id,
                GROUP_CONCAT(ebs.`ebsm_mobile` SEPARATOR ',') as 'ebsm_mobiles',
                GROUP_CONCAT(ebs.`ebsm_name` SEPARATOR ',') as 'ebsm_names',
                GROUP_CONCAT(eewbm.`eewbm_zoom_id` SEPARATOR ',') as 'eewbm_zoom_ids',
                GROUP_CONCAT(eewbm.`eewbm_zoom_pwd` SEPARATOR ',') as 'eewbm_zoom_pwds'
        
            FROM 
                        `".$tdetail['exhibitor_event_with_boothstaff_mapping']."` as eewbm
                JOIN `".$tdetail['exhibitor_boothstaff']."` AS ebs on ebs.ebsm_id=eewbm.ebsm_id
            WHERE 
                    eewbm.`eewbm_status`='active'
                AND ebs.ebsm_statu='active' 
            group by eewbm.`eem_id`) as ebstaff"),
                    function ($join) {
                        $join->on('ebstaff.eem_id', '=', 'eem.eem_id');
                });

        
        $exhibitorSql->select('em.*','ebstaff.*','eem.eem_whatsapp_no', DB::raw("(GROUP_CONCAT(pemm.pemm_id SEPARATOR ',')) as 'pemm_ids' ") );
        $exhibitorSql->where('eem.aem_id', $eventdetail->aem_id);


        if(isset($allRequestData['stream'])){
            $exhibitorSql->where('pemm.pm_id', $allRequestData['stream']);
        }

        if(isset($allRequestData['city'])){
            $exhibitorSql->whereIn('em.cm_id', $allRequestData['city']);
        }
        if(isset($allRequestData['state'])){
            $exhibitorSql->whereIn('mc.sm_id', $allRequestData['state']);
        }

       $exhibitorSql->where('eem.eem_status','active');
       $exhibitorSql->groupBy('em.exhim_id');
       $exhibitorSql->orderBy('eem.eem_orderby','ASC');
       $exhibitorMaster=$exhibitorSql->get();
       //dd($exhibitorMaster);
        return $exhibitorMaster;
    }

    public static function getExhibitorDetails($basicData,$allRequestData)
    {
            $exhibitorMaster=array();
            $tdetail=$basicData['tdetail'];
            $eventdetail=$basicData['event'];

            $exhibitorSql= DB::table($tdetail['exhibitor_master']. ' as em')
            ->Join($tdetail['exhibitor_event_mapping'] .' as eem',  'eem.exhim_id', '=', 'em.exhim_id');

            $exhibitorSql->leftJoin(\DB::raw("(
                SELECT 
                     eewbm.`eem_id`,
                     eewbm.ebsm_id,
                    GROUP_CONCAT(ebs.`ebsm_mobile` SEPARATOR ',') as 'ebsm_mobiles',
                    GROUP_CONCAT(ebs.`ebsm_name` SEPARATOR ',') as 'ebsm_names',
                    GROUP_CONCAT(eewbm.`eewbm_zoom_id` SEPARATOR ',') as 'eewbm_zoom_ids',
                    GROUP_CONCAT(eewbm.`eewbm_zoom_pwd` SEPARATOR ',') as 'eewbm_zoom_pwds'
            
                FROM 
                            `".$tdetail['exhibitor_event_with_boothstaff_mapping']."` as eewbm
                    JOIN `".$tdetail['exhibitor_boothstaff']."` AS ebs on ebs.ebsm_id=eewbm.ebsm_id
                WHERE 
                        eewbm.`eewbm_status`='active'
                    AND ebs.ebsm_statu='active' 
                group by eewbm.`eem_id`) as ebstaff"),
                        function ($join) {
                            $join->on('ebstaff.eem_id', '=', 'eem.eem_id');
                    });

            $exhibitorSql->select('em.*','ebstaff.*','eem.eem_whatsapp_no');
            $exhibitorSql->where('eem.aem_id', $eventdetail->aem_id);

            if(isset($allRequestData->exhiId) && !empty($allRequestData->exhiId)){
                $exhibitorSql->where('em.exhim_id', $allRequestData->exhiId);
            }

            $exhibitorSql->where('eem.eem_status','active');
            $exhibitorSql->orderBy('eem.eem_orderby','ASC');
            $exhibitorMaster=$exhibitorSql->first();
            //dd($exhibitorMaster);
            return $exhibitorMaster;
    }

    public static function getExhibitorGallery($basicData,$allRequestData)
    {
            $exhibitorGallery=array();
            $tdetail=$basicData['tdetail'];
            $eventdetail=$basicData['event'];

            $exhibitorSql= DB::table($tdetail['exhibitor_gallery']);
            if(isset($allRequestData->exhiId) && !empty($allRequestData->exhiId)){
                $exhibitorSql->where('exhim_id', $allRequestData->exhiId);
            }
            
            $exhibitorSql->where('eg_status','active');
            $exhibitorSql->orderBy('eg_orderby','ASC');
            $exhibitorGallery=$exhibitorSql->get();
            return $exhibitorGallery;
    }
    public static function getExhibitorProductMaster($basicData,$allRequestData)
    {
            $exhibitorProductM=array();
            $tdetail=$basicData['tdetail'];
            $eventdetail=$basicData['event'];

            $exhibitorSql= DB::table($tdetail['exhibitor_product_mapping']. ' as epm')
            ->Join($tdetail['exhibitor_product_master'] .' as epmas',  'epmas.exhipm_id', '=', 'epm.exhipm_id')
            ->select('epm.*','epmas.exhipm_id','epmas.epm_text');
           

            if(isset($allRequestData->exhiId) && !empty($allRequestData->exhiId)){
                $exhibitorSql->where('epm.exhim_id', $allRequestData->exhiId);
            }

            $exhibitorSql->where('epm.epm_status','active');
            $exhibitorSql->orderBy('epm.epm_orderby','ASC');
            $exhibitorProductM=$exhibitorSql->get();
           
            return $exhibitorProductM;
    }

   public static function reginquery($allRequestData,$basicData)
   {
            $resArray=array();
            $tdetail=$basicData['tdetail'];
            $eventdetail=$basicData['event'];
            $user = Session::get('user'); 
        
            if(!empty($allRequestData['mobile'])){

                $ind_mobile=trim($allRequestData['mobile']);
                $isInquiryData = DB::table($tdetail['inquiry_data'])
                ->where('ind_mobile', $ind_mobile)
                ->first();

            
                $saveData=array();
                $saveData['aem_id']=$eventdetail->aem_id;
                $saveData['exhim_id']=$allRequestData['exhimId'];
                $saveData['ind_fullname']=$allRequestData['fullname'];
                $saveData['ind_email']=$allRequestData['email'];
                $saveData['ind_mobile']=$allRequestData['mobile'];
                $saveData['ind_message']=$allRequestData['message_text'];
                $saveData['ind_ip']=HelperController::realIp();
                
                if(empty($isInquiryData)){

                    $id = DB::table($tdetail['inquiry_data'])->insertGetId(
                        $saveData
                    );
                    
                }else{

                    DB::table($tdetail['inquiry_data'])
                    ->where('ind_id', $isInquiryData->ind_id)
                    ->update(
                        $saveData
                    );
                    $id = $isInquiryData->ind_id;

                }
            }
            

            if(!empty($id)){
                $datar = DB::table($tdetail['lead_master'])
                ->where('lm_id', $user->lm_id)
                ->first();

                $resArray['code']="200";
                $resArray['data']= $datar;
            }else{
                $resArray['code']="400";
                $resArray['data']= '';
            }

       return $resArray;
   }


   ##====================================================##
    public static function getCityListWithInEvenExistingExhibitor($basicData, $stateId=null)
    {
       
        $resArray=array();
        $tdetail=$basicData['tdetail'];
        $eventdetail=$basicData['event'];
        $user = Session::get('user'); 

        $cityMasterData=array();
        
        $cityMasterSql= DB::table('master_city as mc')
        ->Join($tdetail['exhibitor_master'] .' as em',  'em.cm_id', '=', 'mc.cm_id')
        ->Join($tdetail['exhibitor_event_mapping'] .' as eem',  'eem.exhim_id', '=', 'em.exhim_id')
        ->select('mc.*');
            
        $cityMasterSql->where('eem.aem_id', $eventdetail->aem_id);
        $cityMasterSql->where('eem.eem_status','active');
        $cityMasterSql->where('em.exhim_status','active');
        
        if(!empty($stateId)){
            $cityMasterSql->whereIn('mc.sm_id',$stateId);
        }

        $cityMasterSql->groupBy('mc.cm_id');
        $cityMasterSql->orderBy('mc.cm_name','ASC');
        $cityMasterData=$cityMasterSql->get();

        return $cityMasterData;
    }


    public static function getStateListWithInEventExistingExhibitor($basicData, $countryId=null)
    {
        $resArray=array();
        $tdetail=$basicData['tdetail'];
        $eventdetail=$basicData['event'];
        $user = Session::get('user'); 

        $stateMasterData=array();

        $stateMaster= DB::table('master_state as ms')
        ->Join('master_city as mc',  'mc.sm_id', '=', 'ms.sm_id')
        ->Join($tdetail['exhibitor_master'] .' as em',  'em.cm_id', '=', 'mc.cm_id')
        ->Join($tdetail['exhibitor_event_mapping'] .' as eem',  'eem.exhim_id', '=', 'em.exhim_id')
        ->select('ms.*');
            
        $stateMaster->where('eem.aem_id', $eventdetail->aem_id);
        $stateMaster->where('eem.eem_status','active');
        $stateMaster->where('em.exhim_status','active');
        if(!empty($countryId)){
            $stateMaster->where('ms.counm_id',$countryId);
        }
        $stateMaster->groupBy('ms.sm_id');
        $stateMaster->orderBy('ms.sm_name','ASC');
        $stateMasterData=$stateMaster->get();

        return $stateMasterData;
    }
##====================================================##
    public static function getLiveCareerCounselingSessions($basicData,$forlist='live')
    {
        $reData=array();
        $tdetail=$basicData['tdetail'];
        $eventdetail=$basicData['event'];
        $user = Session::get('user'); 
       
        $sqlAppend="";
        if($forlist=='live'){
            $sqlAppend .= " and now() BETWEEN lccs.`lccs_start_datewtime` and lccs.`lccs_end_datewtime`  ";
            $sqlAppend .= " and lccs.`lccs_end_datewtime` >  now() ";
        }else if($forlist=='upcoming'){
            $sqlAppend .= " and now() NOT BETWEEN lccs.`lccs_start_datewtime` and lccs.`lccs_end_datewtime`  ";
            $sqlAppend .= " and lccs.`lccs_end_datewtime` >  now() ";
        }else {
            $sqlAppend .= " and lccs.`lccs_end_datewtime` <  now() ";
        }


       $sql="select lccs.*,case when lccsr.lccs_id IS NOT NULL then 'Registered' else 'Register' end 'isRegText'
        from
                  `".$tdetail['live_career_counseling_sessions']."` as lccs
        LEFT JOIN `".$tdetail['live_career_counseling_sessions_request']."` as lccsr ON lccsr.lccs_id=lccs.lccs_id and lccsr.lm_id='".$user->lm_id."'
        where lccs.`lccs_status` = 'active'
        and lccs.`aem_id` = '1'

       
        $sqlAppend
        order by lccs.`lccs_start_datewtime` asc, lccs.`lccs_orderby` asc";

        $reData= DB::select($sql);
      
        return $reData;
    }


    public static function regforlivesess($basicData,$allRequestData)
    {
                $resArray=array();
                $tdetail=$basicData['tdetail'];
                $eventdetail=$basicData['event'];
                $user = Session::get('user'); 
                $id=null;
            
                if(!empty($allRequestData['lccsId'])){

                    $lccsId=trim($allRequestData['lccsId']);
                    $lccsr = DB::table($tdetail['live_career_counseling_sessions_request'])
                    ->where('lccs_id', $lccsId)
                    ->where('lm_id', $user->lm_id)
                    ->first();

                
                    $saveData=array();
                    $saveData['lccs_id']=$lccsId;
                    $saveData['lm_id']=$user->lm_id;
                    $saveData['ruccs_ip']=HelperController::realIp();
                    
                    if(empty($lccsr)){
                        $id = DB::table($tdetail['live_career_counseling_sessions_request'])->insertGetId(
                            $saveData
                        ); 
                    }else{
                        $id =$lccsr->lccs_id;
                    }
                }
                


        return $id;
    }




    
}
?>
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
