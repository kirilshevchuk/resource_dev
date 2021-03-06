<?php
	Class User extends CI_Model
	{
		function __construct(){
			parent::__construct();
			$this->load->library('email');
		}
		
		public function send_signup_mail($email){		 
			$this->email->from(ADMIN_EMAIL,ADMIN_NAME);
			$this->email->to($email);
			$firstname = $this->input->post('login_firstname');
			$lastname = $this->input->post('login_lastname');
			$username = $this->input->post('login_username');
			$loginphone = $this->input->post('login_phone');
			$password = $this->input->post('login_password');
                $login_link = base_url()."login";
                $message = "
                    <p>Dear $firstname $lastname.</p>
                    <p>Thanks for signup&nbsp;and w<span style='font-family:arial,tahoma,verdana,sans-serif'><span style='font-size:small'>elcome to our system! We</span>&nbsp;<span style='font-size:small'>will be here to support you every step of</span>&nbsp;<span style='font-size:small'>the way on your journey to success online.</span><br />
                    <span style='font-size:small'>The first thing you need to do is login:</span><br />
                    <a href='http://'".$login_link."><span style='font-size:small'>$login_link</span></a><br />
                        Login:&nbsp;</span>$username</p>
                    <p><span style='font-family:arial,tahoma,verdana,sans-serif'>Password:&nbsp;</span>$password<br />
                    <span style='font-family:arial,tahoma,verdana,sans-serif'><span style='font-size:small'>Once you&#39;re inside the system, all you</span><br />
                    <span style='font-size:small'>need to do is watch the welcome video</span><br />
                    <span style='font-size:small'>and follow the steps on the left.</span></span></p>
                    <p><span style='font-family:arial,tahoma,verdana,sans-serif; font-size:small'>Best regards</span><br />
                    <span style='font-family:arial,tahoma,verdana,sans-serif'>Login:&nbsp;</span>&quot;Teame name&quot;</p>
                        ";
                $message1 = "
Dear $firstname $lastname.

Thanks for signup and welcome to our system! We will be here to support you every step of the way on your journey to success online.
The first thing you need to do is login:
$login_link
Login: $username

Password: $password
Once you're inside the system, all you
need to do is watch the welcome video
and follow the steps on the left.

Best Regards
Easy Access Profits
                        ";
			$this->email->subject('Welcome to Easy Access Profits');
			$this->email->message($message1);
			$this->email->send();
			//$this->email->print_debugger();
		}
		public function send_mail($to, $fromname, $fromemail, $msg,$subject){
				$config['protocol'] = 'mail';
				$config['wordwrap'] = FALSE;
				$config['mailtype'] = 'html';
				$config['charset'] = 'utf-8';
				$config['crlf'] = "\r\n";
				$config['newline'] = "\r\n";
				$this->email->initialize($config);
				
				$this->email->from($fromemail,$fromname);
				//$this->email->to(TESTING_EMAIL);
				$to='vipinwebguru@gmail.com';
				$this->email->to($to);			
				$this->email->subject($subject);
				$this->email->message($msg);
				$this->email->send();
				//$this->email->print_debugger();
		}		
		function login($username, $password)
		{
			$this -> db -> select('*');
			$this -> db -> from('users');
			$this -> db -> where('user_name', $username);
			$this -> db -> where('password', md5($password));
			$this -> db -> where('role','admin');
			$this -> db -> limit(1);
			$query = $this->db->get();
			// echo $this->db->last_query();
			if($query->num_rows == 1) {
				return $query->result();			

			}else{
				return false;
			}
		}
	 
		function check_for_valid_affliate_id($id){
			$this -> db -> select('*');
			$this -> db -> from('users');
			$this -> db -> where('user_track_id', $id);
			$query = $this->db->get();
			return $query->num_rows;
		}

		function check_for_allready_signup($info=array()){
			// echo '<pre>';
			// print_r($info);
			// echo '</pre>';

			$this -> db -> select('*');
			$this -> db -> from('users');
			$this -> db -> where('affiliate_user_id', $info['affiliate_user_id']);
			$this -> db -> where('user_email', $info['user_email']);
			$this -> db -> where('role', 'user');
			$query = $this->db->get();
			// echo $query->num_rows;
			// die();
			return $query->num_rows;
		}
		
		function signup($wholedata=array())
		{	
			$is_refer=0;
			$is_valid_affliate_id=1;
			if (array_key_exists('affiliate_user_id', $wholedata)){
				$is_refer=1;
				$aff_res=$this->check_for_valid_affliate_id($wholedata['affiliate_user_id']);
				if($aff_res!=0){
					// echo 'Valid_affliate_id';
					// die("valid");
					$is_valid_affliate_id=1;
				}else{
					$is_valid_affliate_id=0;
					// echo 'invalid_affliate_id';
					return 'invalid_affliate_id';
					die(' Die due to invalid_affliate_id');
				}	
				// echo "The 'first' element is in the array-{$wholedata[affiliate_user_id]}";
			}
			if($is_valid_affliate_id==1){
				//check whether user allready signup using same link
				if($is_refer==1){
					$is_first_signup=$this->check_for_allready_signup($wholedata);
					if($is_first_signup!=0){
						return 'allready_signup';
						die('die due to allready_signup');
					}	
				}
				
				//execute the insert operation 
				// echo '<pre>';
				// print_r($wholedata);
				// echo '</pre>';

				$result = $this->db->insert('users',$wholedata);
				if($result)
				{
					$lastuserid = $this->db->insert_id();
					// $t= substr($wholedata['first_name'],0,1);
					// $first_char= strtolower($t);
					// $track_id = $first_char.$lastuserid.$this->create_track_id($length=4,$use_upper=0,$use_lower=0,$use_number=1,$use_custom="");
					$track_id = $wholedata['user_name'];
					$datatoupdate = array(
										'user_track_id'=>$track_id,
									);
					$this->db->where('id', $lastuserid);
					$this->db->where('user_name', $wholedata['user_name']);
					$this->db->trans_start();
					$status = $this->db->update('users', $datatoupdate);
					if($status){
						$this->send_signup_mail($wholedata['user_email']);
					}		
					$this->db->trans_complete();
					
					$userarray = array(
						'id' => $lastuserid,
						'user_name'	=> $wholedata['user_name'],
						'full_name' =>$wholedata['first_name'],
						'role'  => $wholedata['role'],
						'user_track_id'  => $track_id
					);
					return $userarray;
				}
			}else{
				return false;
			}
		}
			 
		 /*******=======---------------- Create Custom/Random String ---------- =========************/

    /*---Let??? see the  Function parameters Specificateion-------------------
        lenght: is the password length (default = 8)
        use_upper: set to 0 if you do not want to use uppercase chars (ABCD???), any other value otherwise. Default = 1
        use_lower: set to 0 if you do not want to use lowercase chars (abcd???), any other value otherwise. Default = 1
        use_number: set to 0 if you do not want to use number chars (0123???), any other value otherwise. Default = 1
		
		
	 	
        use_custom: a string representing any extra char you want (such as ?*_ ???). Default = empy string
     */
		function create_track_id($length=8,$use_upper=1,$use_lower=1,$use_number=1,$use_custom=""){
			$upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$lower = "abcdefghijklmnopqrstuvwxyz";
			$number = "0123456789";
			$seed_length='';
			$seed='';
			$password='';
			if($use_upper){
					$seed_length += 26;
					$seed .= $upper;
			}
			if($use_lower){
					$seed_length += 26;
					$seed .= $lower;
			}
			if($use_number){
					$seed_length += 10;
					$seed .= $number;
			}
			if($use_custom){
					$seed_length +=strlen($use_custom);
					$seed .= $use_custom;
			}
			for($x=1;$x<=$length;$x++){
					$password .= $seed{rand(0,$seed_length-1)};
			}
			return($password);
		}
		/*******=======-------------End of  Create Custom/Random String ---------- =========**********/
		
		function check_username_exists($username)
		{
			$this -> db -> select('user_name');
			$this -> db -> from('users');
			$this -> db -> where('user_name', $username);
			$query = $this->db->get();
			return $query->num_rows;
			// die(">>>>");
			// return $query->num_rows;
		}
		
		function get_admin_login_detail(){
			$t=$this->session->userdata('logged_in');
			// echo '<pre>';
			// print_r($t);
			// echo '</pre>';die();

			$this -> db -> select('*');
			$this -> db -> from('users');
			$this -> db -> where('user_name',$t['username']);
			$this -> db -> where('id', $t['id']);
			$this -> db -> where('user_track_id', '0');
			$this -> db -> where('role','admin');
			$query = $this->db->get();
			// echo $this ->db->last_query();
			if($query->num_rows == 1) {
				return $query->row_array();			
			}else{
				return false;
			}
		}
				
		function set_admin_password(){
			$login_admin_detail=$this->get_admin_login_detail();
			$old_pwd=$login_admin_detail['password'];
			$current_pwd = $this->input->post('txtCurrent');
			$new_pwd = $this->input->post('txtNewpwd');
			$confirm_pwd = $this->input->post('txtConfirmpwd');
			
			if($old_pwd==md5($current_pwd)){
				// echo 'pss mat';
				if($new_pwd==$confirm_pwd){
					$my_password=md5($confirm_pwd);
					$datatoupdate = array(
											'password'=>$my_password,
											'real_password'=>$new_pwd
										);
					$this->db->where('id', $login_admin_detail['id']);
					$this->db->where('role', 'admin');
					$this->db->trans_start();
					$status = $this->db->update('users', $datatoupdate);
					$this->db->trans_complete();
					if($status){
						return 'success';
					};
				}else{
					return 'notconfirm';
					// die();
				}
			}else{
				// echo '<h1>Opps!! Your current password does not match.</h1>';
				return 'notmatch';
			}
			return false;
		}
		
		
		function update_account_detail(){
			$session_admin=$this->session->userdata('logged_in');
			$fname = $this->input->post('txtFname');
			$lname = $this->input->post('txtLname');
			$phone = $this->input->post('txtPhone');
			$email = $this->input->post('txtEmail');

			$datatoupdate = array(
								'first_name'=>$fname,
								'last_name'=>$lname,
								'phone_number'=>$phone,
								'user_email'=>$email
							);
			
			$this->db->where('id', $session_admin['id']);
			$this->db->where('role', 'admin');
			$this->db->trans_start();
			$status = $this->db->update('users', $datatoupdate); 
			$this->db->trans_complete();
			// echo $this->db->last_query();
			return $status;
		}
/*----Function make by kiril------*/
		function get_pure_leverage_data($trackid){
                    $this->db->select('pl.*');
                    $this->db->from('users as u');
                    $this->db->join('purelev_setup as pl', "u.id = pl.user_id");
                    $this->db->where('u.user_track_id',$trackid);
                    $query = $this->db->get();
                    if($query->num_rows>0){
                        return $query->first_row();
                    }
                    return FALSE;
		}
/*----Function make by kiril------*/
	
	 //here the login functions ends now the user management functions on the admin end as well as user's front end
	 
	 
	/*  function GetUserData($userid = false)
	 {
		$this->db->select('*');
		$this->db->from('users');
		if($userid != false)
		{
			$this->db->where('id',$userid);
			$this->db->limit('1');
		}
		$query = $this->db->get();
		return $query;
	 } */

	/*  function InsertUserData()
		{
			
					$first_name = $this->input->post('txt_fname');
					$last_name = $this->input->post('txt_lname');
					$user_name 	 = $this->input->post('txt_username');
					$real_password = $this->input->post('txt_password');
					$password = md5($real_password);
					$role = 'user';
					$user_email = $this->input->post('txt_emailid');
					$organisation = $this->input->post('txt_organisation');
					$assingedvideosarray = $this->input->post('chk_assignedvideos');
					
					
                    $data = array(
                        'first_name'=>$first_name,
                        'last_name'=>$last_name,
                        'user_name'=>$user_name,
                        'password'=>$password,
                        'real_password'=>$real_password ,
                        'role'=>$role, 
                        'user_email'=>$user_email, 
                        'organisation'=>$organisation 
                    );
					//start of the transaction 
					$this->db->trans_start();
					$this->db->insert('users',$data);
					$lastuserid=$this->db->insert_id();
					if(is_array($assingedvideosarray))
					{
					foreach($assingedvideosarray as $videoid):
					$assignvdata = array(
                        'user_id'=>$lastuserid,
                        'video_id'=>$videoid
                    );
					$this->db->insert('assigned_videos',$assignvdata);
					endforeach;
					}
					$this->db->trans_complete();
					//showing completion of the transaction 
				return $this->db->trans_status();//giving the status of the transaction 
		
		} */
	 public function setCookie($username,$password){
             setcookie("username",$username, time()+3600*24*7);
             setcookie("password",$password, time()+3600*24*7);
             setcookie("remeber_me",$this->input->post("remeber_me"), time()+3600*24*7);
         }
	 public function unsetCookie($username,$password){
             setcookie("username",$username, time()-3);
             setcookie("password",$password, time()-3);
             setcookie("remeber_me",$this->input->post("remeber_me"), time()-3);
         }
	}
	?>