<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * function for construct datatables
 * Author: fakhruz, amtis solution, fakhruz@amtis.net, december 2013
 *
 *
 */

class Datatables_amtis extends Datatables
{
	/**
	 * Global container variables for chained argument results
	 *
	 */
	private $ci;
	private $tableName;
	private $loadImg;
	private $dtConfig = array();
	private $header = array();
	private $template = array();
	private $aoData = array();
	
	/**
    * Copies an instance of CI
    */
    public function __construct()
    {
    	parent::__construct();
		$this->ci =& get_instance();
		$this->ci->load->config("datatables_config");
		$this->ci->load->library('parser');
		$this->ci->load->library('table');
		
		$this->initConfig();
	}
	
	public function initConfig()
	{
		$this->dtConfig = $this->ci->config->item('dtConfig');
		$linkImg = base_url().$this->ci->config->item('loadImg');
		
		$this->loadImg = '<img src="'.$linkImg.'" width="24" height="24" align="center"/>';
	}
	
	public function setConfig($dtConfig)
	{
		$this->dtConfig = array_merge($this->dtConfig, $dtConfig);
	}
	
	public function setAoData($aoName, $aoValue,$bString = true){
		if($bString)
			$aoValue = "'$aoValue'";

		$aAoData = array("aoDataName"=>$aoName,"aoDataValue"=>$aoValue);
		array_push($this->aoData, $aAoData);
	}
	
	public function set_heading($header)
	{
		$this->header = $header;
	}
	
	public function set_template($template){
		$this->template = $template;
	}
	
	private function produceOutput($bAjax = false){
		$d['tableName'] = $this->tableName;
		$d['dtConfig'] = $this->dtConfig;
		$d['loadImg'] = $this->loadImg;
		$d['csrfName'] = $this->ci->security->get_csrf_token_name();
		$d['csrfValue'] = $this->ci->security->get_csrf_hash();
		$d['aoDataList'] = $this->aoData;
		
		if(sizeof($this->template) == 0)
			$this->template = array ('table_open' => '<table id="'.$this->tableName.'" width="100%">');
		
		$this->ci->table->set_template($this->template);
		$this->ci->table->set_heading($this->header);
		$d['table'] = $this->ci->table->generate();
		
		if(!$bAjax){
			return $this->ci->parser->parse("datatables/view",$d,true);
		}else{
			$aAjaxData = array();
			$aAjaxData['vScript'] = $this->ci->parser->parse("datatables/script",$d,true);
			$aAjaxData['vView'] = $this->ci->parser->parse("datatables/table",$d,true);

			return $aAjaxData;
		}
	}
	
	public function generateView($ajaxURL, $tableName="a", $bAjax = false){
		if(!empty($ajaxURL))
			$this->dtConfig["sAjaxSource"] = $ajaxURL;
		
		$this->tableName = $tableName;
			
		return $this->produceOutput($bAjax);
	}
}

?>