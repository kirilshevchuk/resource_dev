<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
	Class Plspagesetup_Model extends CI_Model
	{
		function __construct()
		{
			// Call the Model constructor
			parent::__construct();
			
		}
                public function getCampaignCode(){
                    return "2b533a401b27";
                }
		public function getFormID(){
                    return "2716777";
                }
                public function getAffiliateName(){
                    return "elishahong2";
                }
	}
	?>