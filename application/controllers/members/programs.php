<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	//session_start(); //we need to call PHP's session object to access it through CI
class Programs extends CI_Controller {
	 
	 function __construct()
	 {
	  	 parent::__construct();
		$this->load->model('menu_model','',TRUE);
		// check for validate user login
		$session_login_client=$this->session->userdata('client_login');
		if (!($session_login_client['login_state'] == 'active' && $session_login_client['role'] == 'user')) {
			redirect('/', 'refresh');
		}else{
			$strMenus=$this->menu_model->getMenuData_array();
			$this->session->set_userdata('menu_data_in_session', $strMenus);
		}
		
		$this->load->model('programs_model','',TRUE);
		$this->load->model('client','',TRUE);
		$this->load->model('video','',TRUE);
	 
	 }
	 
	
	
	 function index()
	 {
		if($this->session->userdata('client_login'))
		{
			$this->data['client_full_data']=$this->client->get_current_login_client_detail();
			$this->data['metatitle'] = 'Programs Sign-Up ';
			$this->data['scriptlist'][]='jwplayer/jwplayer.js';
			$this->data['stylelist'][]='css/members/program.css';
			$this->data['query'] = $this->programs_model->getProgram_for_clentdashboard();
			$this->data['video_query'] = $this->video->GetAllVideoData();
			// echo $this->db->last_query(); 
			// $this->data['query'] = $this->video->GetAllVideoData();
			$this->data['subview']=  'members/programs/programs_view';
			$this->data['tab_menu_id'] =1 ;
			$this->load->view('members/_layout_main.php', $this->data);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}

	 function save($id){
			// $this->data['client_full_data']=$this->client->get_current_login_client_detail();
			// $d=$this->client->get_current_login_client_detail();
			$statusupdate = $this->client->save_program_user_name($id);  
			if($statusupdate){
				echo 1;
			}else{
				echo 0;
			}	
			// echo '<pre>';
			// print_r($d);
			// echo '</pre>';
			// die();
			// echo $id;
	 }
         function checkurl(){
             $url = $this->input->post("url");
             if(empty($url)){
                 $url = "dhfhsdfhsjsjfejifejfiehfdha";
             }
             $ch = curl_init();
             curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt ($ch, CURLOPT_URL, $url);
             curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
             curl_setopt ($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
             curl_setopt($ch, CURLOPT_HEADER, true);
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
             curl_setopt($ch, CURLOPT_NOBODY, true);
             $content = curl_exec ($ch);
             curl_close ($ch);
             $result = (preg_match("/404 Not Found/",$content))?0:1;
             echo $result;
             //var_dump($content);
             //$this->load->view('test');
         }
	 function show_next_step($menu_id){
		echo $next_step_html=$this->programs_model->get_next_step_by_menu_id($menu_id);
	 }
	 
	 
}
	 
?>