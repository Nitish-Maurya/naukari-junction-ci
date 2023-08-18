<?php
class Home extends CI_Controller
{
	public $language_data_a=10;
	public $default_languag=1;
	public $user_header1=1;
	public $diff_language=0;
	public $diff_language_menu=0;
	public $language_data_a_v=10;
	public $default_languag_v=1;
	public $user_header1_v=1;
	function __construct()
	{
		parent::__construct();
		$this->email=$this->session->userdata('seeker');
		$this->load->model('Common_model');
		$this->load->library('google');
		
	}
	function config_variable_pagenation($total_rows,$per_page,$num_links)
	{
		  $this->load->library("pagination");
		  $config = array();
		  $config["base_url"] = "#";
		  $config["total_rows"] = $total_rows;
		  $config["per_page"] = $per_page;
		  $config["uri_segment"] = 3;
		  $config["use_page_numbers"] = TRUE;
		  $config["full_tag_open"] = '<ul style="background:white" class="pagination">';
		  $config["full_tag_close"] = '</ul>';
		  $config["first_tag_open"] = '<li>';
		  $config["first_tag_close"] = '</li>';
		  $config["last_tag_open"] = '<li>';
		  $config["last_tag_close"] = '</li>';
		  $config['next_link'] = '&gt;';
		  $config["next_tag_open"] = '<li>';
		  $config["next_tag_close"] = '</li>';
		  $config["prev_link"] = "&lt;";
		  $config["prev_tag_open"] = "<li>";
		  $config["prev_tag_close"] = "</li>";
		  $config["cur_tag_open"] = "<li class='active'><a href='#'>";
		  $config["cur_tag_close"] = "</a></li>";
		  $config["num_tag_open"] = "<li>";
		  $config["num_tag_close"] = "</li>";
		  $config['first_link'] = false;
          $config['last_link'] = false;
		  $config["num_links"] = $num_links;
		  $this->pagination->initialize($config);
		  $page = $this->uri->segment(3);
		  return $start = ($page - 1) * $config["per_page"];
	}
	

	//User Home Open
	function index()
	{
		
		$job_count=$this->Common_model->count_num('job_types','Active','status');
		$location_count=$this->Common_model->count_num('location','Active','status');
		$qualification_count=$this->Common_model->count_num('qualification','Active','status');
		$exp_count=$this->Common_model->count_num('experience','Active','status');
		$desi_count=$this->Common_model->count_num('designation','Active','status');
		$job_post=$this->Common_model->select('job_post');     							 //Left Menu Value	
		// echo "<pre>";
		// print_r($job_post);
		// die();
		$location=array();
		$job_type=array();
		$qualification=array();
		$exp=array();
		$desi=array();
		$custom_ads=array();
		if($location_count>0)
		{
				$location=$this->Common_model->select('location','Active','status');	 //Left Menu Value
		} 
		if($job_count>0)
		{
			    $job_type=$this->Common_model->select('job_types','Active','status'); 	 //Left Menu Value
		} 
		if($qualification_count>0)
		{
               $qualification=$this->Common_model->select('qualification','Active','status');   //Left Menu Value
		} 
		if($exp_count>0)
		{
			    $exp=$this->Common_model->select('experience','Active','status');   			 //Left Menu Value
		}  
		if($desi_count>0)
		{https://alphawizztest.tk/JustOut/admin/home
			   $desi=$this->Common_model->select('designation','Active','status');   			 //Left Menu Value
		}   
		$custom_adds_count=$this->Common_model->count_num('jp_custom_ads','Active','status');
		if($custom_adds_count>0)
		{
			$custom_ads=$this->Common_model->select('jp_custom_ads','Active','status');
		}
		$this->language_fatch('home_page');
		$data['controller']=$this;
		$data['sres']=$job_post;
		$data['location']=$location;
		$data['job_type']=$job_type;
		$data['qua']=$qualification;
		$data['exp']=$exp;
		$data['desi']=$desi;
		$data['custom_ads']=$custom_ads;
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('user_home',$data);	
	    $this->language_fatch('home_page');
	}
	function pagination()   ///HOME PAGE PAGENATION
	{
		  $this->load->model("Common_model");
		  $ofset = '6';
		  $total_rows=$this->Common_model->row_count('recruiter_jobs');
		  $start= $this->config_variable_pagenation($total_rows,$ofset,'2');
		  $res=$this->Common_model->fetch_details('recruiter_jobs',$ofset, $start);
		  $link = $this->pagination->create_links();
          $this->language_fatch('home_page');
		  
		  $data['controller']=$this;
          $data['sres']=$res;
		  $data['link']=$link;
		  $data['profile_match'] = $this->jobMatchPercent($data['sres']);
		//   echo "<pre>";
		//   print_r($data);
		
		 $this->load->view('module/search_res',$data);
	}

	function jobMatchPercent($job) {
		$job_index = ['job_type','designation','qualification','specialization'];
		$user_id = $this->session->userdata('user_id');
		$user_detail =$this->Common_model->select_data('*', 'seeker', ['id'=>$user_id]);

		// print_r($user_detail);
		// echo "<br>";
		// echo "<pre>";
		// print_r($job);
		// die();
		$per_arr=[];
		$match = 0;
		$i=0;
		if(!empty($user_detail)){
		foreach($job as $key => $value){
			if(strtolower($value->job_type) == strtolower($user_detail[0]['exp'])){
				$match++;
			}
			if(strtolower($value->job_role) == strtolower($user_detail[0]['job_role'])){
				$match++;
			}
			if(strtolower($value->designation) == strtolower($user_detail[0]['designation'])){
				$match++;
			}
			if(strtolower($value->specialization) == strtolower($user_detail[0]['specialization'])){
				$match++;
			}
			
			$percent = round($match*100/count($job_index));
			$per_arr[$i]['job_id']= $value->id;
			$per_arr[$i]['percent']= $percent;
			$i++;
			
		}
	}
		return $per_arr;
	
	}

	

	//Job Full Detail View
	function user_jobSingle($id='')
	{
		$this->session->unset_userdata('job_applay');
		$custom_ads=array();
		if($id!='')
		{
			$job_info = $this->Common_model->select('recruiter_jobs', $id, 'id');  	// Job Detail
			$r_id = $job_info->user_id;
			$id = $job_info->id;
			$rec_info = $this->Common_model->select('recruiter', $r_id, 'id');    	// ORG detail
			$check_status=$this->Common_model->job_applay_status_check('jp_applay_job', $id, $this->email, 'job_id', 's_email');   //Job Applay Status Check
				$custom_adds_count=$this->Common_model->count_num('jp_custom_ads','Active','status');
			if($custom_adds_count>0)
			{
				$custom_ads=$this->Common_model->select('jp_custom_ads','Active','status');
			}
			   $this->language_fatch('single_job');
		        $data['controller']=$this;
				$data['r1']=$job_info;
				$data['res0']=$rec_info;
				$data['r1']=$job_info;
				$data['custom_ads']=$custom_ads;
			if($check_status>0)
			{
				$data['status']='yes';
				$this->load->view('user_jobSingle',$data);
			}
			else
			{
				$data['status']='no';
				$this->load->view('user_jobSingle',$data);
			}
		}
	}	
	function ch()
	{
		echo date("Y-m-d");
	}
	//Job Applay
	function job_applay($id='',$r_id='')
	{
			if($id==0 || $id=='')
			{
				
			}
			else 
			{
				$session_data=$this->email;
				$this->session->set_userdata('job_applay',$id);
				if(!$session_data)
				{
					redirect('home/login');
				}
				else
				{
					$rec_info=$this->Common_model->select('recruiter',$r_id,'id');
					$seeker_info=$this->Common_model->select('seeker',$session_data,'email');
					$email=$rec_info->email;
					$seeker_name=$seeker_info->name;
					$seeker_location=$seeker_info->p_locaion;
					
					/*$this->load->library('email');
					$this->email->from('deependrabaghel455@gmail.com');
					$this->email->to('engineersworld8@gmail.com');
					$this->email->subject('Email Test');
					$this->email->message('Testing the email class.');
					$this->email->send();*/
					$check_counter=$this->Common_model->select('seeker',$this->email,'email');
					if($check_counter->counter)
					{
							$applay_job_info=array('job_id'=>$id,
									  's_email'=>$session_data,
									  'r_id'=>$r_id,
							);
							//Fetch All Data form job_post
							$job_post_info=$this->Common_model->select('job_post',$id,'id');
							$job_post_id=$job_post_info->application;
							$job_post_id++;
							$application_counter=array('application'=>$job_post_id);
							$job_application_update=$this->Common_model->updateData('job_post',$application_counter,$id,'id');
							 $job_applay_res1=$this->Common_model->insert('jp_applay_job',$applay_job_info);
							if($job_applay_res1)
							{
								$link=base_url('recruiter/applied_user/'.$id);
								$to = $email;
								$subject = "New Seeker Applay Your Posted Job";
								$txt = "	Click This Link To See Seeker Information :".$link;
								$headers = "From: deependrabaghel455@gmail.com" . "\r\n";
								mail($to,$subject,$txt,$headers);
								$this->session->set_flashdata('applay', 'yes');
								redirect('home/my_applied_jobs');
							}
							else
							{
								echo "Not Applied";
							}
					}
					else
					{
							$qualification=$this->Common_model->select('qualification');
							$location=$this->Common_model->select('location');
							$area_of_sectors=$this->Common_model->select('area_of_sectors');
							$job_types=$this->Common_model->select('job_types');
							$seeker_info=$this->Common_model->select('seeker',$this->email,'email');
							//check First Time Update or Not
							$profile_update_status=$seeker_info->counter;
							//check First Time Update or Not close
							$this->session->set_flashdata('pupdate','yes');
							//$this->load->view('user_profile',$data);
							redirect('home/user_profile');
					}
				}
			}
	}
	//Page Open
	public function login()
	{
		$this->language_fatch('login_page');
		$this->language_fatch_v('validation');
		$data['controller']=$this;
		$this->load->view('login',$data);
	}
	function email_send()
	{
					/*$this->load->library('email');
					$this->email->from('deependrabaghel455@gmail.com');
					$this->email->to('engineersworld8@gmail.com');
					$this->email->subject('Email Test');
					$this->email->message('Testing the email class.');
					$this->email->send();*/
					
					/*$to = "engineersworld8@gmail.com";
					$subject = "My subject";
					$txt = "Hello world!";
					$headers = "From: deependrabaghel455@gmail.com" . "\r\n" .
					"CC: deependrabaghel455@gmail.com";
					mail($to,$subject,$txt,$headers);*/
	}
function search1(){}
	function register()
	{
		$this->language_fatch('register_page');
		$this->language_fatch_v('validation');
		$data['controller']=$this;
		$this->load->view('register',$data);
	}
	function user_profile()
	{
		if(!isset($this->email))
		{
			redirect('home/login');
		}
		$qualification=$this->Common_model->select('qualification');
		$location=$this->Common_model->select('location');
		$area_of_sectors=$this->Common_model->select('area_of_sectors');
		$job_role=$this->Common_model->select('job_role');
		$job_type=$this->Common_model->select('job_types');
		$area_of_sectors1=$this->Common_model->select('area_of_sectors');
		$currentctc=$this->Common_model->select('currentctc_tbl');
		$expectedctc=$this->Common_model->select('expectedctc_tbl');
		$designation=$this->Common_model->select('designation');
		$specialization=$this->Common_model->select('specialization');
		// $seeker_info=$this->Common_model->select('seeker',$this->email,'email');
		$seeker_info=$this->db->query("SELECT * FROM seeker WHERE email = '".$this->email."'")->row();

		//check First Time Update or Not
		$profile_update_status=$seeker_info->counter;
		//check First Time Update or Not close
	   	$this->language_fatch('user_profile_page');
		$this->language_fatch_v('validation');
	    $data['controller']=$this;
		$data['res1']=$seeker_info;
		// print_r($data);die;
		$data['location1']=$location;
		$data['qualification']=$qualification;
		$data['area_of_sectors1']=$area_of_sectors;
		$data['job_type']=$job_type;
		$data['job_role']=$job_role;
		$data['currentctc']=$currentctc;
		$data['expectedctc']=$expectedctc;
		$data['designation']=$designation;
		$data['area_of_sectors1']=$area_of_sectors1;
		$data['specialization']=$specialization;
		$data['profile_update_status']=$profile_update_status;
		$data['complete_profile'] = $this->profileCompletePercent($seeker_info);
		
		$this->load->view('user_profile',$data);
		 
		
	}

	//profile percent complete

	function profileCompletePercent($user_detail,$user_type = 'seekar'){
		// if($user_detail->name)
		$complete = 0;
		if($user_type == 'seekar'):
		$profile_field = ['name','surname','email','city','mno','gender','excepted','current_address','location','job_type','job_role','designation','qua','keyskills','resume','specialization','age','notice_period','p_year'];
		else :
			$profile_field = ['name','email','mno','org_type','location','address','website','company'];
		endif;
		foreach($profile_field as $value){
			$complete = (!empty($user_detail->$value) and $user_detail->$value != '' and !is_null($user_detail->$value)) ?$complete+1:$complete;
			
		}

		$all_field = count($profile_field);
		$percent = round(($complete*100)/$all_field);
		return $percent;
	}
	
	//User Profile Update
	function profile_update()
	{   //counter ps_reserve email all fileld for required seeker
		$data=$this->input->post();
		$ps=$this->input->post('ps');
		$ps_reserve=$this->input->post('ps_reserve');
		
		$ps2='';
		if(!empty($ps))
		{
			if(preg_match('/^[a-f0-9]{32}$/', $ps))
			{
				$ps2=$ps;
			}
			else
			{
				$ps2=md5($ps);
			}
		}
		else
		{
			$ps2=$ps_reserve;
		}
		$data['ps']=$ps2;
		unset($data['ps_reserve']);
		$resume_file1=$_FILES['resume']['name'];
		//echo"<pre>";print_r($resume_file1);die;
		if(empty($resume_file1))
		{
			unset($data['rps']);	
					$res=$this->Common_model->updateData('seeker',$data,$this->email,'email');
					if($res)
					{
						echo "Update";
					}
					else
					{
						echo "Not Update";
					}
		}
		else
		{
				$seeker_info=$this->Common_model->select('seeker',$this->email,'email');
				$img=$seeker_info->resume;
				$config['upload_path']="./uploads/resume";
				$config['allowed_types']="pdf|docx";
				$this->load->library('upload',$config);
				if($this->upload->do_upload('resume'))
				{
					if(!empty($img))
					{
					unlink('./'.$img);
					}
					
					$d1=$this->upload->data();
					$d2= $d1['file_name'];
					$d3='uploads/resume/'.$d2;
					$data['resume']=$d3;
					
					unset($data['rps']);	
					$res=$this->Common_model->updateData('seeker',$data,$this->email,'email');
					// echo"<pre>";print_r($this->db->last_query());die;
					if($res)
					{
						echo "Update";
					}
					else
					{
						echo "Not Update";
					}
				}
				else
				{
					echo "Uploaded file is not a valid resume file. Only PDF and DOC files are allowed";
				}
		}
	}
	function pro_pic_upload($name='')
	{
		//email email
		if(!isset($this->email))
		{
			echo $this->email;
		}
		$seeker_info=$this->Common_model->select('seeker',$this->email,'email');
		$img=$seeker_info->img;
		$config['upload_path']="./uploads/user_pro_pic";
		$config['allowed_types']="jpg|jpeg|png";
		$this->load->library('upload',$config);
		if($this->upload->do_upload('img'))
		{
			if(!empty($img))
			{
				if($img!="assets/images/user.svg")
				{
					unlink('./'.$img);
				}	
			}
			$d1=$this->upload->data();
		    $d=$d1['file_name'];
			$d2='uploads/user_pro_pic/'.$d;
			$data=array('img'=>$d2);
			$res=$this->Common_model->updateData($name,$data,$this->email,'email');
			
			$qualification=$this->Common_model->select('qualification');
			$location=$this->Common_model->select('location');
			$area_of_sectors=$this->Common_model->select('area_of_sectors');
			$job_types=$this->Common_model->select('job_types');
			if($res)
			{
				echo "ok";
			}
			else
			{
				
				echo "not";
		    }
		}
		else
		{
				echo "Uploaded file is not a valid image. Only JPG and PNG  files are allowed";
		}
	}
	
	//Sign  Up Seeker And Recruiter
	function signUp($name='')
	{
		$res=$this->Common_model->select('jp_setting','2','id');
		if($name!='')
		{
			if($name=='recruiter')
			{
					$plan=$this->Common_model->select('jp_revenue');
					foreach($plan as $p1)
					{
						if($p1->show_on_reg=='yes')
						{
							//echo "Pay";
								$data=$this->input->post();
								$ps=$this->input->post('ps');
								$mno=$this->input->post('mno');
								
								$ps1=md5($ps);
								$data['ps']=$ps1;
								$email=$this->input->post('email');
								$mno=$this->input->post('mno');
								unset($data['rps']);
								$d1=$this->Common_model->signUp($data,$mno,$email,$name);
								
								if($d1==1)
								{
									$this->session->set_userdata('pay_sessiion',$email);
									$this->session->set_userdata('pay_sessiion2',$ps);
									$this->session->set_userdata('pay_sessiion3',$mno);
										$email_info=$this->Common_model->select('jp_setting_email','1','id');
										$link=base_url('home/v/').$mno."/".$name;
										$this->load->library('email');
										$config['mailtype'] = 'html';
										$this->email->initialize($config);
										$this->email->to($email);
										$this->email->from($email_info->recruiter_email);	
									    $this->email->subject($email_info->recruiter_subject);
									    $this->email->message("<div style='width:100%;height:100px;background:#5176E3'><br><center><img src='".base_url().$res->logo_img."' alt='logo'></center></div><p><font size='2' color='#74787E'>".$email_info->recruiter_veri_msg."</font></p><br><br><a href='".$link."' style='color:red;'>Click Here</a><br><br><br><p><font size='4' color='#74787E'>Thank you</font></p><font color='#74787E'><p>Regards,</p><p>".$res->title."</p></font>");
									    $this->email->send();
									echo "pay";
								}
								else if($d1=='eyes')
								{
									$q=$this->db->select('*')->from('recruiter')->where('email',$email)->get();
									$res=$q->row();
									if($res->pay=='no')
									{
										echo 'pay';
									}
									else
									{
										echo "eyes";
									}
								}
								else if($d1=='myes')
								{
									$q=$this->db->select('*')->from('recruiter')->where('email',$email)->where('mno',$mno)->get();
									$res=$q->row();
									if($res->pay=='no')
									{
										echo 'pay';
									}
									else
									{
										echo "myes";
									}
								}
								else
								{
									$q=$this->db->select('*')->from('recruiter')->where('email',$email)->where('mno',$mno)->get();
									$res=$q->row();
									// print_r($res);
								}
							
						}
						else
						{
								$data=$this->input->post();
								$ps=$this->input->post('ps');
								$ps1=md5($ps);
								$data['ps']=$ps1;
								$email=$this->input->post('email');
								$mno=$this->input->post('mno');
								unset($data['rps']);
								$d1=$this->Common_model->signUp($data,$mno,$email,$name);
								$p_info=$this->Common_model->select('jp_plans');
								$p_infi_plane='';
								foreach($p_info as $p1)
								{
									$p_infi_plane=$p1->name;
								}
								if($d1==1)
								{
									$d1=date('Y/m/d');
									$arr=array('pay'=>'no',
											   'plan'=>$p_infi_plane,
											   'pay_date'=>'',
											   'show_on_reg'=>'no',
									);
									$res=$this->Common_model->updateData('recruiter',$arr,$email,'email');
										$email_info=$this->Common_model->select('jp_setting_email','1','id');

										$link=base_url('home/v/').$mno."/".$name;
										$this->load->library('email');
										$config['mailtype'] = 'html';
										$this->email->initialize($config);
										$this->email->to($email);
										$this->email->from($email_info->recruiter_email);	
									    $this->email->subject($email_info->recruiter_subject);
									    $this->email->message("<div style='width:100%;height:100px;background:#5176E3'><br><center><img src='".base_url().$res->logo_img."' alt='logo'></center></div><p><font size='2' color='#74787E'>".$email_info->recruiter_veri_msg."</font></p><br><br><a href='".$link."' style='color:red;'>Click Here</a><br><br><br><p><font size='4' color='#74787E'>Thank you</font></p><font color='#74787E'><p>Regards,</p><p>".$res->title."</p></font>");
									    $this->email->send();
									$this->session->set_flashdata('msg','vmsg');
									echo "Ok";
								}
								else
								{
									echo $d1;
								}
							
						}
					}
			}
			else 
			{
				
				$data=$this->input->post();
				$ps=$this->input->post('ps');
				$ps1=md5($ps);
				$data['ps']=$ps1;
				$email=$this->input->post('email');
				$mno=$this->input->post('mno');
				unset($data['rps']);
				$d1=$this->Common_model->signUp($data,$mno,$email,$name);
				if($d1==1)
				{
						$email_info=$this->Common_model->select('jp_setting_email','1','id');
						$message=$email_info->seeker_veri_msg." click this link".base_url('home/v/').$mno."/".$name;
						mail($to_email_address,$subject,$message,$headers);

						$link=base_url('home/v/').$mno."/".$name;
						$this->load->library('email');
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$this->email->to($email);
						$this->email->from($email_info->seeker_email);	
					    $this->email->subject($email_info->seeker_subject);
					    $this->email->message("<div style='width:100%;height:100px;background:#5176E3'><br><center><img src='".base_url().$res->logo_img."' alt='logo'></center></div><p><font size='2' color='#74787E'>".$email_info->seeker_veri_msg."</font></p><br><br><a href='".$link."' style='color:red;'>Click Here</a><br><br><br><p><font size='4' color='#74787E'>Thank you</font></p><font color='#74787E'><p>Regards,</p><p>".$res->title."</p></font>");
					    $this->email->send();

						$this->session->set_flashdata('msg','vmsg');
					echo "Ok";
				}
				else
				{
					echo $d1;
				}
			}
		}
	}
	function paypal()
	{	
		$plane_id=$this->input->post('id');
		if(isset($plane_id))
		{
			$plane_id=$this->input->post('id');
			$this->session->set_userdata('p_id',$plane_id);
			$plane_data=$this->Common_model->select('jp_plans',$plane_id,'id');
			$paypal_info=$this->Common_model->select('jp_setting','2','id');
			$price=$plane_data->amount_usd;
			$id=$plane_data->name;
			$c= base_url('home/paypal_cancel');
			$s= base_url('home/paypal_success');
			$n= base_url('home/paypal_notify');
			echo $form='<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="payuForm" name="pay_form_name">
										<input type="hidden" name="business" value="'.$paypal_info->paypal_email.'">
										<input type="hidden" name="item_name" value="'.$id.'">
										<input type="hidden" name="amount" value="'.$price.'">
										<input type="hidden" name="item_number" value="'.$this->email.'">
										<input type="hidden" name="no_shipping" value="1">
										<input type="hidden" name="currency_code" value="USD">
										<input type="hidden" name="cmd" value="_xclick">
										<input type="hidden" name="handling" value="0">
										<input type="hidden" name="no_note" value="1">
										<input type="hidden" name="custom" value="1">
										<input type="hidden" name="cancel_return" value="'.$c.'">
										<input type="hidden" name="return" value="'.$s.'">
										<input type="hidden" name="notify_url" value="'.$n.'">
		</form>';
		}
		else
		{
			echo "<script>window.location.href='".base_url()."'</script>";
		}
	}
	function paypal_cancel()
	{
		$this->language_fatch('user_profile_page');
		$this->language_fatch_v('validation');
	    $data['controller']=$this;
		$this->load->view('cancel',$data);
	}
	function paypal_success()
	{
		   $email= $this->session->userdata('pay_sessiion');
		   if(isset($email))
		   {
			$ps= $this->session->userdata('pay_sessiion2');
			$p_id= $this->session->userdata('p_id');
			$p_info=$this->Common_model->select('jp_plans',$p_id,'id');
				$p_infi_plane=$p_info->name;
				$p_infi_month=$p_info->duration;
			$d1=date('Y/m/d');
			$arr=array('pay'=>'yes',
			'pay_date'=>$d1,
			'plan'=>$p_infi_plane,
			'month'=>$p_infi_month,
			'show_on_reg'=>'yes',
			);
			$res=$this->Common_model->updateData('recruiter',$arr,$email,'email');
			if($res)
			{
				$this->session->set_flashdata('msg', 'Update');
				if($this->session->userdata('recruiter'))
				{
					redirect('/recruiter');
				}
				else
				{
					redirect('home/login');
			    }
			}
			else
			{
				echo "Fail";
			}
		  }
		  else
		  {
			  redirect('home/login');
		  }
		
	}
	function paypal_notify()
	{
		if(isset($_POST['payer_id']))
		{
		$d1=date('Y/m/d');
		$pd=$_POST['item_name'];
		$uname=$_POST['item_number'];
		$custom=$_POST['custom'];
		$payment_type=$_POST['payment_type'];
		$status=$_POST['payment_status'];
		$pay_amount=$_POST['mc_gross'];
		$arr=array('p_id'=>$pd,
		'payment_type'=>$payment_type,
		'status'=>$status,
		'pay_amount'=>$pay_amount,
		'source'=>'Paypal',
		'pay_date'=>$d1,
		'email'=>$uname,
		);
		$this->Common_model->insert('jp_payment',$arr);
		}
		else
		{
				redirect('/');
		}
	}
	//Login Seeker And Recruiter
	function login1($name='')
	{


		$email=$this->input->post('email');
		$remember=$this->input->post('remember');

		if(isset($email))
		{
			$email=$this->input->post('email');
			$ps1=$this->input->post('ps');
			$ps=md5($ps1);
			if(!empty($remember))
			{
				$em= array(
				   'name'   => 'email_user',
				   'value'  => $email,
				   'expire' => '604800',
			   );
				$this->input->set_cookie($em);
				$p= array(
				   'name'   => 'password_user',
				   'value'  => $ps1,
				   'expire' => '604800',
			   );
				$this->input->set_cookie($p);
			}
			 // echo "<pre>";print_r($name);die;
			$q=$this->Common_model->login($email,$ps,$name);
			// print_r($q);die;
			if($q)
			{			  
				if($name=='recruiter')
				{ 
					$rec_info=$this->Common_model->select('recruiter',$email,'email');
					//echo "<pre>";print_r($rec_info);die;
					$plan=$rec_info->show_on_reg;
					
					if($plan=='no')
					{
						// if($q->veri!="yes")
						// {
						// 	echo "ve";
						// }
						// else
						if($q->status!='Active')
						{
							echo "y_ac_dis";
						}
						else
						{
							$this->session->set_userdata($name,$email);
							// $chat_setting=$this->Common_model->select_data('chat_system','jp_setting');

							// if(!empty($chat_setting))
								$this->session->set_userdata('chat_system',$chat_setting[0]['chat_system']);
							$full_name=$rec_info->name;
							$user_id=$rec_info->id;
							$this->session->set_userdata('full_name',$full_name);
							$this->session->set_userdata('user_id',$user_id);
							// echo "<pre>";print_r('ok');die;
							echo "right";
						}	
					}
					else
					{
						$pay=$rec_info->pay;

								// if($q->veri!="yes")
								// {
								// 	echo "ve";
								// }
								// else if($q->status!='Active')
								// {
								// 	echo "y_ac_dis";
								// }
								// else
								// {
									$this->session->set_userdata($name,$email);
									$chat_setting=$this->Common_model->select_data('chat_system','jp_setting');

									if(!empty($chat_setting))
										$this->session->set_userdata('chat_system',$chat_setting[0]['chat_system']);
									$full_name=$rec_info->name;
									$user_id=$rec_info->id;
									$this->session->set_userdata('full_name',$full_name);
									$this->session->set_userdata('user_id',$user_id);
									echo "right";
								// }	
						
					}
				}
				else
				{
					$rec_info=$this->Common_model->select('seeker',$email,'email');
						//  if($q->veri!="yes")
						// {
						// 	echo "ve";
						// }
						// else 
						if($q->status!='Active')
						{
							echo "y_ac_dis";
						}else{

							$this->session->set_userdata($name,$email);
							
							// $chat_setting=$this->Common_model->select_data('chat_system','jp_setting');
							// // if(!empty($chat_setting))
							$this->session->set_userdata('chat_system',$chat_setting[0]['chat_system']);
							$full_name=$rec_info->name;
							$user_id=$rec_info->id;
							$this->session->set_userdata('full_name',$full_name);
							$this->session->set_userdata('user_id',$user_id);


							echo "right";
						}	
				}
				
					
			}else if($pay=='no')
						{
							$mno=$rec_info->mno;
							$user_id=$rec_info->id;
							$full_name=$rec_info->name;
							$chat_setting=$this->Common_model->select_data('chat_system','jp_setting');
							if(!empty($chat_setting))
								$this->session->set_userdata('chat_system',$chat_setting[0]['chat_system']);
							$this->session->set_userdata('pay_sessiion',$email);
							$this->session->set_userdata('pay_sessiion2',$ps);
							$this->session->set_userdata('pay_sessiion3',$mno);
							$this->session->set_userdata('full_name',$full_name);
							$this->session->set_userdata('user_id',$user_id);
							$this->session->set_flashdata('pay_msg', 'yes');
							echo "pay";
						}
			else
			{
				echo "The email address or password doesn't match any account";
			}
		}
	}
	
	//E-Mail verify
	function v($email='',$name='')
	{
		if($email!='')
		{
			$arr=['veri'=>'yes'];
			$res=$this->Common_model->v($email,$arr,$name);
			if($res)
			{
				redirect('home/login');
			}
			else
			{
				echo "Varifai Email";
			}
		}
	}
	
	//left Filter 
	function search_left_f()
	{
		$data = $this->input->get();
		//print_r(json_decode($data));
		if(!empty($data))
		{
			$size=0;
			$job_jt_q='';
			$job_loc_q='';
			$job_desi_q='';
			$job_qua_q='';
			$job_exp_q='';
			$job_data='';
			
			$arr=array();
			foreach($data as $d1)
			{
				$size=sizeof($d1);
				foreach($d1 as $d2)
				{
					$exp=explode('_',$d2);
					$e1=$exp[1];
					$data=$exp[0];
					if($e1=='jt')
					{
						if($job_jt_q=='')
						{
							$job_jt_q.=" job_type  = '$data'";
						}
						else
						{
							$job_jt_q.="OR job_type = '$data'";
							$job_jt_q='('.$job_jt_q.')';
						}
				
					}
					
					if($e1=='loc')
					{
						if($job_loc_q=='')
						{
							$job_loc_q.=" location = '$data'";
						}
						else
						{
							$job_loc_q.="OR location  = '$data'";
							$job_loc_q='('.$job_loc_q.')';
						}
						
					}
					if($e1=='desi')
					{
						if($job_desi_q=='')
						{
							$job_desi_q.="designation  = '$data'";
						}
						else
						{
							$job_desi_q.=" OR designation  = '$data'";
							$job_desi_q='('.$job_desi_q.')';
						}
						
					}
					
					if($e1=='qua')
					{
						if($job_qua_q=='')
						{
								$job_qua_q.="qualification  = '$data'";
						}
						else
						{
							$job_qua_q.="OR qualification = '$data'";
							$job_qua_q='('.$job_qua_q.')';
						}
						
					}
					if($e1=='exp')
					{
						if($job_exp_q=='')
						{
							$job_exp_q.="experience  = '$data'";
						}
						else
						{
							$job_exp_q.=" OR experience  = '$data'";
							$job_exp_q='('.$job_exp_q.')';
						}
						
						
					}
				}
			}
			if($job_jt_q!='')
			{
				$job_data=$job_jt_q;
			}
			if($job_loc_q!='')
			{
				$job_data=$job_loc_q;
			}
			if($job_desi_q!='')
			{
				$job_data=$job_desi_q;
			}
			if($job_qua_q!='')
			{
				$job_data=$job_qua_q;
			}
			if($job_exp_q!='')
			{
				$job_data=$job_exp_q;
			}
			if($job_jt_q!='' && $job_loc_q!='')
			{
				$job_data=$job_jt_q.' AND '.$job_loc_q;
			}
			if($job_jt_q!='' && $job_desi_q!='')
			{
				$job_data=$job_jt_q.' AND '.$job_desi_q;
			}
			if($job_jt_q!='' && $job_qua_q!='')
			{
				$job_data=$job_jt_q.' AND '.$job_qua_q;
			}
			if($job_jt_q!='' && $job_exp_q!='')
			{
				$job_data=$job_jt_q.' AND '.$job_exp_q;
			}
			if($job_loc_q!='' && $job_desi_q!='')
			{
				$job_data=$job_loc_q.' AND '.$job_desi_q;
			}
			if($job_loc_q!='' && $job_qua_q!='')
			{
					$job_data=$job_loc_q.' AND '.$job_qua_q;
			}
			if($job_loc_q!='' && $job_exp_q!='')
			{
				$job_data=$job_loc_q.' AND '.$job_exp_q;
			}
			if($job_desi_q!='' && $job_qua_q!='')
			{
				$job_data=$job_desi_q.' AND '.$job_qua_q;
			}
			if($job_desi_q!='' && $job_exp_q!='')
			{
				$job_data=$job_desi_q.' AND '.$job_exp_q;
			}
			if($job_jt_q!='' && $job_loc_q!='' && $job_desi_q!='')
			{
				$job_data=$job_jt_q.' AND '.$job_loc_q." AND ".$job_desi_q;
			}
			if($job_desi_q!='' && $job_qua_q!='' && $job_exp_q!='')
			{
				$job_data=$job_desi_q.' AND '.$job_qua_q." AND ".$job_exp_q;
			}
			if($job_jt_q!='' && $job_loc_q!='' && $job_qua_q!='')
			{
				$job_data=$job_jt_q.' AND '.$job_loc_q." AND ".$job_qua_q;
			}
			if($job_jt_q!='' && $job_loc_q!='' && $job_exp_q!='')
			{
				$job_data=$job_jt_q.' AND '.$job_loc_q." AND ".$job_exp_q;
			}
			if($job_jt_q!='' && $job_loc_q!='' && $job_exp_q!='' && $job_desi_q!='')
			{
				$job_data=$job_jt_q.' AND '.$job_loc_q." AND ".$job_exp_q." AND ".$job_desi_q;
			}
			if($job_jt_q!='' && $job_loc_q!='' && $job_desi_q!='' && $job_exp_q!='')
			{
				$job_data=$job_jt_q.' AND '.$job_loc_q." AND ".$job_desi_q." AND ".$job_exp_q;
			}
			if($job_loc_q!='' && $job_desi_q!='' && $job_qua_q!='' && $job_exp_q!='')
			{
				$job_data=$job_loc_q.' AND '.$job_desi_q." AND ".$job_qua_q." AND ".$job_exp_q;
			}
			if($job_jt_q!='' && $job_loc_q!=' ' && $job_desi_q!='' && $job_qua_q!='' && $job_exp_q!='')
			{
					$job_data=$job_jt_q.' AND '.$job_loc_q." AND ".$job_exp_q." AND ".$job_desi_q." AND ".$job_qua_q;
			}
			
		  
		  $ofset = '6';
		  $total_rows = $this->Common_model->num_r($job_data);
		  $start= $this->config_variable_pagenation($total_rows,$ofset,'2');
		  $res=$this->Common_model->l_f($job_data,$ofset, $start);
		  //l_f($job_data);
		  $link = $this->pagination->create_links();
          $this->language_fatch('home_page');
		  $d1['controller']=$this;
          $d1['sres']=$res;
		  $d1['link']=$link;
		 $this->load->view('module/search_res',$d1);
		}
		else
		{
		}
	}
	
	function filter($tbl_name='')
	{
		$data=$this->input->post('search_txt');
		if(isset($data))
		{
			$res=$this->Common_model->rec_select($tbl_name,$data,'name');
			if($res)
			{
				$this->load->view('module/filter_data_view',['res'=>$res]);
			}
			else
			{
				echo "Location Not Found";
			}
		}
	}
	
	//Password change
	function forgot_password($name='')
	{
	    $email=$this->input->post('email');
	    if(isset($email))
		{
			$this->db->where('email',$email);
			$res=$this->db->get($name);
			if($res->num_rows()>0)
			{
				$ps=rand(50000,100000);
				$ps1=md5($ps);
				$to_email_address=$email;
				$subject="";
				$message="";
				$headers="";
				$email_info=$this->Common_model->select('jp_setting_email','1','id');
					$this->load->library('email');
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
					$this->email->to($to_email_address);
					if($name=='seeker')
					{
						$this->email->from($email_info->seeker_email);	
					    $this->email->subject($email_info->seeker_subject);
					    $this->email->message($email_info->seeker_forgot_msg." <b>".$ps."</b>");
					 }
					else if($name=='recruiter')
					{
						$this->email->from($email_info->recruiter_email);	
					    $this->email->subject($email_info->recruiter_subject);
					    $this->email->message($email_info->recruiter_forgot_msg." <b>".$ps."</b>");
					}
					
					
				if($this->email->send())
				{
				$data2=array('ps'=>$ps1);
				$r1=$this->Common_model->updateData($name,$data2,$email,'email');
				if($r1)
				{
					echo "Pssword_Change";
				}
				else
				{
					echo "Password Not Change";
				}
				}
				else
				{
					echo "E-Mail Not Send";
				}
			}
			else
			{
				echo "The email address doesn't match any account";
			}
	    }
	}
	
	
	//My Applied job
	function my_applied_jobs()
	{
		$email=$this->session->userdata('seeker');
		if(!isset($email))
		{
			redirect('home/login');
		}
		$this->language_fatch('my_applied_job_page');
		$data['controller']=$this;
		$this->load->view('my_applied_jobs',$data);
		
	}
	function my_applied_jobs_pagination()
	{
		 $email=$this->session->userdata('seeker');
		if(!isset($email))
		{
			redirect('home/login');
		}
		
	  $q1=$this->db->select('*')->from('jp_applay_job')->where('s_email',$email)->get();	
	  $this->load->model("Common_model");
	  $ofset='5';
	  $total_rows=$q1->num_rows();
	  $start= $this->config_variable_pagenation($total_rows,$ofset,'2');
	  $seeker_data=$this->Common_model->fetch_details('jp_applay_job',$ofset, $start,$email,'s_email');
	  $link = $this->pagination->create_links();
	  $this->language_fatch('my_applied_job_page');
	  $data['controller']=$this;
	  $data['seeker_data']=$seeker_data;
	  $data['link']=$link;
	  $this->load->view('module/my_applied_jobs',$data);
	}

	
	
	//Logout Button Seeker And Recruiter
	function logout()
	{
		//$this->session->unset_userdata('seeker');sess_destroy
		$this->session->sess_destroy();
		redirect('/');
	}
	
	//Filters
    function search_text()
	{
		$data=$this->input->get('search_txt');	 
		if(isset($data))
		{
			  $ofset='10';
	          $total_rows=$this->Common_model->row_count('jp_applay_job',$this->email,'s_email');
	          $start= $this->config_variable_pagenation($total_rows,$ofset,'2');
			  $res=$this->Common_model->search_text($ofset, $start,'job_post',$data,'job_location','qualification','technology');
			  $link = $this->pagination->create_links();
			  $this->language_fatch('home_page');
		      $d1['controller']=$this;
			  $d1['sres']=$res;
			  $d1['link']=$link;
			  $this->load->view('module/search_res',$d1);
	    }
	}
	function search_text2()
	{
		 $data=$this->input->post('search_txt');
		 if(isset($data))
		 {
			 $res=$this->Common_model->search_text2('job_post',$data,'job_location','qualification','technology');
			 $this->language_fatch('home_page');
			 $d1['controller']=$this;
			 $d1['jobs']=$res;
			 $this->load->view('module/key_press_filter_res',$d1);
		 }
	}
	function payum()
	{
	     $plane_id=$this->input->post('id');
		 if(isset($plane_id))
		 {
			  $plane_data=$this->Common_model->select('jp_plans',$plane_id,'id');
			  $payu_info=$this->Common_model->select('jp_setting','2','id');
			  $price=$plane_data->amount_inr;
			  $id=$plane_data->name;
			  $MERCHANT_KEY =$payu_info->merchant_key;
			  $SALT = $payu_info->merchant_salt;
			  $txnid = '10';
			  $ts_uname='Job Portel';
			  $user_email=$this->session->userdata('pay_sessiion');
			  $user_mobile=$this->session->userdata('pay_sessiion3');
			  $finalItemAmount=$price;
			  $finalItemName=$id;
			  $hash_string = $MERCHANT_KEY.'|'.$txnid.'|'.$finalItemAmount.'|'.$finalItemName.'|'.$ts_uname.'|'.$user_email.'|||||||||||'.$SALT;
			  $hash = strtolower(hash('sha512', $hash_string));
			  echo $formData =
							 '<form action="https://sandboxsecure.payu.in/_payment" method="post" id="payuForm1" name="payuForm1">
							  <input type="hidden" name="key" value="'.$MERCHANT_KEY.'" />
							  <input type="hidden" name="hash" value="'.$hash.'"/>
							  <input type="hidden" name="txnid" value="'.$txnid.'" />
							  <input type="hidden" name="amount" value="'.$finalItemAmount.'" />
							  <input type="hidden" name="firstname" id="firstname" value="'.$ts_uname.'" />
							  <input type="hidden" name="email" id="email" value="'.$user_email.'" />
							  <input type="hidden" name="phone" value="'.$user_mobile.'" />
							  <input type="hidden" name="productinfo" value="'.$finalItemName.'" />
							  <input type="hidden" name="surl" value="'.base_url().'home/payu_success/'.$plane_id.'">
							  <input type="hidden" name="furl" value="'.base_url().'home/payu_cancel">
							  <input type="hidden" name="curl" value="'.base_url().'home/payu_cancel">
							  <input type="hidden" name="service_provider" value="payu_paisa">
				
							 </form>';
			 }
	}
	function payu_success($p_id='')
	{
		
		if(isset($_POST['mihpayid']))
		{
			$email= $this->session->userdata('pay_sessiion');

			$ps= $this->session->userdata('pay_sessiion2');
			$p_info=$this->Common_model->select('jp_plans',$p_id,'id');
			
				$p_infi_plane=$p_info->name;
				$p_infi_month=$p_info->duration;
			$d1=date('Y/m/d');
			$arr=array('pay'=>'yes',
			'pay_date'=>$d1,
			'plan'=>$p_infi_plane,
			'month'=>$p_infi_month,
			'show_on_reg'=>'yes',
			);
			$res=$this->Common_model->updateData('recruiter',$arr,$email,'email');
			
		
			$mihpayid=$_POST['productinfo'];
			$mode=$_POST['mode'];
			$status=$_POST['status'];
			$amount=$_POST['amount'];
			$arr=array('p_id'=>$mihpayid,
					 '	payment_type'=>$mode,
					 'status'=>$status,
					 'pay_amount'=>$amount,
					 'source'=>'Payumoney',
					 'pay_date'=>$d1,
					 'email'=>$email,
			);
			$res=$this->Common_model->insert('jp_payment',$arr);
			if($res)
			{
				$this->session->set_flashdata('msg', 'Update');
				redirect('home/login');
			}
			else 
			{
				echo "Fail";
			}
	   }
	   else 
	   {
		   ?><script>window.location.href="paypal"</script><?php 
	   }
	}
	function payu_cancel()
	{
		$this->language_fatch('user_profile_page');
		$this->language_fatch_v('validation');
	    $data['controller']=$this;
		$this->load->view('cancel');
	}
	    function language_fatch_v($page_name)
	{
		$res=$this->Common_model->select('jp_setting','2','id');
		$language=$res->language;
	    $data=$this->Common_model->language_change('jp_language',$language,'language_key',$page_name,'language_type');
		$data1=$this->Common_model->language_change('jp_language',$language,'language_key','menu_header','language_type');
		$this->default_languag_v=$language;
		$this->language_data_a_v=$data;
		$this->user_header1_v=$data1;
	}
	function set_language_v($key_word)
	{
		if($key_word=='login' || $key_word=='jobs' || $key_word=='applied_job' || $key_word=='profile_setting' || $key_word=='logout')
		{ 
			$data=$this->user_header1_v;
			$language=$this->default_languag_v;
			$arr_data='';
			foreach($data as $d1)
			{
				if($d1->language_key==$key_word)
				{
						echo $d1->$language;
				}
				
			}
		}
		else
		{
			$data=$this->language_data_a_v;
			$language=$this->default_languag_v;
			$arr_data='';
			foreach($data as $d1)
			{
				if($d1->language_key==$key_word)
				{
						echo $d1->$language;
				}
				
			}
		}
	}
	function revenue_plans()
	{


		$email= $this->session->userdata('pay_sessiion');
		$this->language_fatch('revenue_plans');
		$d1['controller']=$this;
		// echo"<pre>";print_r($d1);die;
		if(isset($email))
		{
			$plans_count=$this->Common_model->row_count('jp_plans');

			if($plans_count>0)
			{
				// echo"<pre>";print_r('ok');
				$plans_info=$this->db->select('*')->from('jp_plans')->where('status',1)->get();
									// $res=$q->result_array();
				//print_r($this->db->last_query());die;
				
				if($plans_info)
				{
					$d1['plans_info']=$plans_info;
					// echo"<pre>";print_r($plans_info);die;
					$this->load->view('revenue_plans',$d1);
				}
				else
				{
					$this->load->view('revenue_plans',$d1);
				}
		    }
			else
			{
				// echo"<pre>";print_r('osdfk');die;
				$this->load->view('revenue_plans',$d1);
			}
		}
		else
		{
				$this->load->view('revenue_plans',$d1);
		}
	}
	function payment($id='')
	{
		$email= $this->session->userdata('pay_sessiion');
		if(isset($email))
		{
			$this->language_fatch('payment');
		    $d1['controller']=$this;
			$d1['id']=$id;
			$this->load->view('pay_pal',$d1);
	    }
	}
	function language_fatch($page_name)
	{
		//$req_data=$this->input->post('req_data');
		$res=$this->Common_model->select('jp_setting','2','id');
		$language=$res->language;
	    $data=$this->Common_model->language_change('jp_language',$language,'language_key',$page_name,'language_type');
		$data1=$this->Common_model->language_change('jp_language',$language,'language_key','menu_header','language_type');
		;
	    $this->diff_language=$this->Common_model->language_change('jp_language','english','language_key',$page_name,'language_type');
		$this->diff_language_menu=$this->Common_model->language_change('jp_language','english','language_key','menu_header','language_type');
		$this->default_languag=$language;
		$this->language_data_a=$data;
		$this->user_header1=$data1;
	}
	
	function set_language($key_word)
	{		
		if($key_word=='login' || $key_word=='jobs' || $key_word=='applied_job' || $key_word=='profile_setting' || $key_word=='logout' || $key_word=='trem_keyword' || $key_word=='ptivcy_keyword' || $key_word=='about_keyword' || $key_word=='contect_keyword' || $key_word=='chat_text')
		{
			$data=$this->user_header1;
			$language=$this->default_languag;
			$arr_data='';
			$d=$this->diff_language;
			$d2=$this->diff_language_menu;
			foreach($data as $d1)
			{
				if($d1->language_key==$key_word)
				{
						$backup=$d1->$language;
						if(empty($backup))
						{
							foreach($d2 as $dd2)
							{
								if($dd2->language_key==$key_word)
								{
									return $dd2->english;
								}
							}
						}
						else
						{
							return  $backup;
						}
				}
				
			}
		}
		else
		{
			$data=$this->language_data_a;
			
			$language=$this->default_languag;
			$d=$this->diff_language;
			$arr_data='';
			foreach($data as $d1)
			{
				if($d1->language_key==$key_word)
				{
						$backup=$d1->$language;
						if(empty($backup))
						{
							foreach($d as $dd)
							{
								if($dd->language_key==$key_word)
								{
									return  $dd->english;
								}
							}
						}
						else
						{
							return  $backup;
						}
				}
				
			}
		}
	}
	function send_notification ($tokens, $message)
	{
			$url = 'https://fcm.googleapis.com/fcm/send';
			$fields = array(
				 'registration_ids' => $tokens,
				 'notification' => $message,
				);

			$headers = array(
				'Authorization:key =AIzaSyBO6mT5A6E21y7524xYmypmbAgOwVhJkG0',
				'Content-Type: application/json'
				);

		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_URL, $url);
		   curl_setopt($ch, CURLOPT_POST, true);
		   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		   $result = curl_exec($ch);           
		   if ($result === FALSE) {
			   die('Curl failed: ' . curl_error($ch));
		   }
		   curl_close($ch);
		   return $result;
	}
	function push($name,$desi)
	{
		$res=$this->Common_model->select('seeker');
		$tokens=array();
		foreach($res as $r1)
		{
			$backup=$r1->token;
			if(!empty($backup))
			{
				$tokens[]=$backup;
			}
			
		}
		/*$tokens="dDrGVz_m4-g:APA91bG7H2oIHnMiIlcF_C5qc9vtrqkZBxLCcMh2PsvkviUun9iTV_bTYgSmC62MwMQehmv6U3PrA79ZdHbT54Te_Oq3HKXYcoWv7bHUOTQqHOV49M7FaHu1lfkIBVtVpVuQsKuWQAt9";*/
		$message = array("body" => $desi,
					"title"=>$name,
		);
		$message_status = $this->send_notification($tokens, $message);
	}
	
	
	function terms($id='')
	{
		$this->language_fatch('compliamce');
		$this->language_fatch_v('validation');
		$data['controller']=$this;
		$this->load->view('term_and_condition',$data);
	}
	
	function policy($id='')
	{
		$this->language_fatch('compliamce');
		$this->language_fatch_v('validation');
		$data['controller']=$this;
		$this->load->view('privacy_policy',$data);
	}
	function about($id='')
	{
		$this->language_fatch('compliamce');
		$this->language_fatch_v('validation');
		$data['controller']=$this;
		$this->load->view('about',$data);
	}
	function contact($id='')
	{
		$this->language_fatch('compliamce');
		$this->language_fatch_v('validation');
		$data['controller']=$this;
		$this->load->view('contact',$data);
	}
	function contect_us_update()
	{
		$data=$this->input->post();
		$res=$this->Common_model->insert('jp_contect_us',$data);
		if($res)
		{
			echo "Update";
		}
		else
		{
			echo "Not Update";
		}
	}

	public function oauth2callback(){
		$google_data=$this->google->validate();
		$ps=md5(rand(50000,100000));
		$session_data=array(
				'name'=>$google_data['name'],
				'email'=>$google_data['email'],
				'img'=>$google_data['profile_pic'],
				'ps'=>$ps,
				'veri'=>'yes',
				'google_id'=>$google_data['id'],
				);
		$email=$google_data['email'];
		$type=$this->session->flashdata('type');
		if($type=='seeker')
		{
			$this->db->where(array('email'=>$email));
			$q=$this->db->get('seeker');
			$seeker_info=$q->row();
			 $this->session->set_userdata('seeker',$email);
			if($seeker_info)
			{
				     redirect('/');
			}
			else
			{
				$sres=$this->Common_model->insert('seeker',$session_data);
				if($sres)
				{
					 redirect('/');
				}
		    }
		}

		else if($type=='recruiter')
		{
			$recruiter_info=$this->db->where(array('email'=>$email));
			$q=$this->db->get('recruiter');
			$recruiter_info=$q->row();
			$this->session->set_userdata('pay_sessiion',$email);
			if($recruiter_info)
			{
				$pay_status=$recruiter_info->pay;
				if($pay_status=='yes')
				{
					$this->session->set_userdata('recruiter',$email);
					redirect('/recruiter');
				}
				else
				{
					$this->session->set_userdata('recruiter',$email);
					redirect('/home/revenue_plans');
				}
			}
			else
			{
				$sres=$this->Common_model->insert('recruiter',$session_data);
				if($sres)
				{
					$this->session->set_userdata('recruiter',$email);
					  redirect('/home/revenue_plans');
				} 
		    }
		}
		/*$this->load->model('My_model');
		$arr=array('email'=>$google_data['email'],'google_id'=>$google_data['id']);
		$match=$this->My_model->matchexists($arr);
		if($match>0)
		{
			print_r($session_data);
		}
		else
		{
			$res=$this->My_model->google_signup($session_data);
			if($res)
			{
				echo "Insert";
			}
			else
			{
				echo "Not Insert";
			}
		}*/
			/*$this->session->set_userdata($session_data);
		}
		}
redirect(base_url());*/
	}
	function set_session()
	{
	    $type=$this->input->post('type');
		$url=$this->input->post('url');
		$this->session->set_flashdata('type', $type);
	}

	function user_chats(){
		$this->language_fatch('home_page');
		$data['controller']=$this;
		if(isset($_SESSION['seeker'])){
			$data['chat_info'] = $this->Common_model->select_data('user_from','jp_chat_message use index (id)',array('user_to' => 'seeker-'.$_SESSION['user_id']),'','','','','user_from');			
		}else{
			$data['chat_info'] = array();
		}
		$this->load->view('user_chats',$data);
	}


	function mypost($id='')   ///HOME PAGE PAGENATION
	{
		
		$data['res']=$this->Common_model->select('job_post',$id,'id');


		 $this->load->view('mypost',$data);
	}



	
}
?>
