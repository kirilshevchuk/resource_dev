<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	//session_start(); //we need to call PHP's session object to access it through CI
	class Commisions extends CI_Controller {
	 
		function __construct()
		{
			parent::__construct();
			$this->load->model('menu_model','',TRUE);
			// check for validate user login
			$session_login_client=$this->session->userdata('client_login');
			if (!($session_login_client['login_state'] == 'active' && $session_login_client['role'] == 'user')) {
				redirect('login', 'refresh');
			}else{
				$strMenus=$this->menu_model->getMenuData_array();
				$this->session->set_userdata('menu_data_in_session', $strMenus);
			}
			$this->load->model('training_model','',TRUE);
			$this->load->model('client','',TRUE);
			$this->load->model('video','',TRUE);
			$this->load->library('form_validation');
		}
		 
		function tabs(){
			$this->data['subview']=  'members/site_dashboard';
			$this->load->view('members/_layout_main', $this->data);
		}

		function index()
		{
			$this->data['account_detail'] = $this->client->get_current_login_client_detail();
			$this->data['metatitle'] = 'Commision';
			$this->data['scriptlist'][]='jwplayer/jwplayer.js';
                        $this->data['stylelist'][]='css/training_display.css';
			$this->data['query']=$this->training_model->getCurrentCategories(2);
			$this->data['video_query'] = $this->video->GetAllVideoData();
			$this->data['tab_menu_id'] =2 ;
			$this->data['subview']=  'members/commision_view';
			$this->load->view('members/_layout_main', $this->data);
		}
		function showdata($category){
			// echo $category;
			echo $html=$this->training_model->get_traing_data_by_category($category,2);
			
		}
	}
	 
	?>