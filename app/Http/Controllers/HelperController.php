<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
//use Requests;

use Validator;
Use Session;
Use Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Route;

use App\ComModel;

class HelperController extends Controller
{
        static function callSmsApi($phone, $templateId, $dynamicFieldArray){ 
                     
            $resarray =array();
            $smsTemplateBasedApiUrl=config('constants.smsTemplateBasedApiUrl');
            $live_url ="";
            ## SMS API URL ##
            if(!empty($smsTemplateBasedApiUrl)){
                    ## SMS ALI URL ##
                    $apiUrl     = $smsTemplateBasedApiUrl;
                    $searchArray    = array('#?mobileNumber?#','#?smsTempId?#');
                    $replaceArray  = array($phone,$templateId);
                    $live_url = HelperController::stro_replace($searchArray, $replaceArray, $apiUrl);
            }
            ## URL ##
            if(!empty($live_url) && !empty($dynamicFieldArray)){
                foreach($dynamicFieldArray as $fieldName => $fieldValue){
                    $live_url .="&".$fieldName."=".$fieldValue;
                }
    
                $live_url .="&response=Y";

                if($_SERVER['REMOTE_ADDR'] == '203.145.168.201'){
                    $resarray['url']=$live_url;
                }
                
                $parse_url=file($live_url);
                $resarray['status']=$parse_url;
            }
            return $resarray;
            //echo  json_encode($resarray);*/
        }
        static function stro_replace($search, $replace, $subject)
        {

            return strtr($subject, array_combine($search, $replace));
            /*
                    calling  process
                    $search  = array(
                            '#ClientName#',
                            '#ClientNumber#',
                            '#EventDate#'
                        );
                        $replace = array(
                            ucfirst($selectenqhistory[$lastDataId]['f_name']),
                            $selectenqhistory[$lastDataId]['mobile'],
                            $selectenqhistory[$lastDataId]['event_date']
                        );
                        
                        $msgtext = $this->stro_replace($search, $replace, $msgtext);

            */
        }
        ## current IP ##
        static function realIp(){
            if (!empty($_SERVER["HTTP_CLIENT_IP"]))
            {
                //check for ip from share internet
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            }
            elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
            {
                // Check for the Proxy User
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            }
            else
            {
                $ip = $_SERVER["REMOTE_ADDR"];
            }

            return $ip;
        }

        static function generate_otp($num=4,$alpha=0,$numNonAlpha=0)
        {
           
            $listAlpha  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $listNumber = '0123456789';
            $listNonAlpha = '@:!.$';
            //$listNonAlpha = '@:!.$';//',$;@:!.$/*-@_+;./*$-!,';
            $uniqueCreateCode= substr(str_shuffle($listAlpha),0,$alpha).
            substr(str_shuffle($listNumber),0,$num).
            substr(str_shuffle($listNonAlpha),0,$numNonAlpha);

            $uniqueCode=$uniqueCreateCode;
            return $uniqueCode;
        }

        static function set_base_url($request)
        {
            $url="";
            $baseroot=config('constants.baseroot');
            $url .=$baseroot;
            $url .="/vf/"; 
            if(isset($request->brand)){
                $url.=$request->brand;
            }
            if(isset($request->curevent)){
                $url.='/'.$request->curevent;
            }
            return $url;
        }
        static function setBaseUrlFromRoot($request)
        {
            $url="";
            $url .="/vf/"; 
            if(isset($request->brand)){
                $url.=$request->brand;
            }
            if(isset($request->curevent)){
                $url.='/'.$request->curevent;
            }
            return $url;
        }

    
}
?>
