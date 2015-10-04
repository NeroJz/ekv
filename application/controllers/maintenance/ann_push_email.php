<?php
/**************************************************************************************************
 * File Name        : Result.php
 * Description      : This File contain Result module.
 * Author           : sukor
 * Date             : 26 januari 2014
 * Version          : -
 * Modification Log : -
 * Function List       : __construct(),
 **************************************************************************************************/
class Ann_push_email extends CI_Controller {
    
    function __construct() 
    {
        parent::__construct();

        $this->load->model('m_result');
        $this -> load -> model('m_announcement');
    }



  function email_send(){
      
        $open_date=date('Y-m-d');
        $emailuser='';
        $result=$this->m_announcement->get_announcement_byopen($open_date);
       if($result){

       foreach ($result as $value) {
           
  
    $colIds='';
        if(!empty($value->col_ids) && $value->col_ids != null){
        $aarycol=explode(',', $value->col_ids);
        
       
        foreach ($aarycol as $colrow) {
                
            $colIds[].=$colrow;
   
        }
        
        }
     
        $email=$this->m_announcement->get_user_email($colIds);
        
        foreach ($email as $val) {
                    if(!empty($val->user_email)){
                   $emailuser.=$val->user_email.",";       
                    }
              
            
        }
       $annCount= $value->ann_content;
       $anntitle= $value->ann_title;
        $dt = array(
        array(
            "from" => $value->user_email, 
            "from_name" => $value->user_email, 
            "to" => $emailuser, 
            "subject" =>$anntitle, 
            "message" => $annCount
            )
        );
        
    
        $r=sendMail($dt);
        
        if($r){
            
            $value->ann_title;
            $data = array(
               'ann_status_push' => 2
              
            );

$this->db->where('ann_id', $value->ann_id);
$this->db->update('announcement', $data); 
        }
           }
 
  }
    }

}