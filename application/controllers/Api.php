<?php
class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');

    }
    public function index()
    {
        $this->load->view('admin/api_details');
    }

    public function all_job()
    {
        $job = $this->Common_model->get_all_data1();
        if ($job) {
            $job2 = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => $job,
            );
            $json_job = json_encode($job2);
            echo $json_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'job not Found',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function allpage()
    {
        $type = $this->input->post('type');
        $setting_info = $this->Common_model->select('jp_setting', '2', 'id');
        if (!empty($type)) {
            

            if ($type == 'About Us') {
                $data = array(
                    'title' => 'About Us',
                    'body' => $setting_info->about_us,
                );

            } elseif ($type == 'Terms & Condition') {
                $data = array(
                    'title' => 'Terms & Condition',
                    'body' => $setting_info->terms_condition,
                );

            } elseif ($type == 'Support & Help') {
                $data = array(
                    'title' => 'Support & Help',
                    'body' => $setting_info->support_help,
                );

            } elseif ($type == 'Privacy Policy') {
                $data = array(
                    'title' => 'Privacy Policy',
                    'body' => $setting_info->privacy_policy,
                );

            } else {
                $data = [
                    'name' => $setting_info->title,
                    'contact' => $setting_info->app_mobile,
                    'whatsapp' => $setting_info->app_whatsapp,
                    'email' => $setting_info->app_email,
                    'facebook' => $setting_info->app_facebook,
                    'instagram' => $setting_info->app_instagram
                ];
            }

            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => $data,
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => [
                    'name' => $setting_info->title,
                    'contact' => $setting_info->app_mobile,
                    'whatsapp' => $setting_info->app_whatsapp,
                    'email' => $setting_info->app_email,
                    'facebook' => $setting_info->app_facebook,
                    'instagram' => $setting_info->app_instagram
                ]
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function password_change()
    {
        $type = $this->input->post('type');
        $email = $this->input->post('email');
        $old_ps = $this->input->post('old_ps');
        $ps = $this->input->post('ps');
        $data = $this->input->post();
        $info = $this->Common_model->select($type, $email, 'email');
        $o_ps = $info->ps;
        $old_ps1 = md5($old_ps);
        if ($o_ps == $old_ps1) {
            $new_ps1 = md5($ps);
            $to_email_address = $email;
            $subject = "";
            $message = "";
            $headers = "";
            $email_info = $this->Common_model->select('jp_setting_email', '1', 'id');
            $this->load->library('email');
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->to($to_email_address);
            $data2 = array('ps' => $new_ps1);
            $r1 = $this->Common_model->updateData($type, $data2, $email, 'email');
            if ($r1) {
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'password changed Success',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'password Not change',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'Enter right password',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }
    public function single_job()
    {
        $id = $this->input->post('job_id');
        $email = $this->input->post('email');

        // echo "<pre>",print_r($_POST);
        // die();
        if (!empty($id)) {
            $res = $this->Common_model->select('job_post', $id, 'id');

            $r_id = $res->r_id;

            // $org = $this->Common_model->select('recruiter',$email,'email');
            $org = $this->db->query("SELECT * FROM recruiter WHERE email = '" . $r_id . "' ")->result();

            if (empty($org)) {
                $org = [];
            }
            //org_detail
            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => $res,
                'recruiter' => $org,
            );

            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }
    public function signUp()
    {
        $name = $this->input->post('type');
        $data = $this->input->post();
        unset($data['type']);
        if (!empty($data)) {
            if ($name == 'recruiter') {
                $plan = $this->Common_model->select('jp_revenue');
                foreach ($plan as $p1) {
                    if ($p1->show_on_reg == 'yes') {
                        //echo "Pay";
                        $ps = $this->input->post('ps');
                        $mno = $this->input->post('mno');
                        $ps1 = md5($ps);
                        $data['ps'] = $ps1;
                        $data['ps2'] = $ps;
                        $email = $this->input->post('email');
                        $mno = $this->input->post('mno');
                        unset($data['rps']);
                        $d1 = $this->Common_model->signUp($data, $mno, $email, $name);
						$company = $this->input->post('company');
						$last_id = $this->db->insert_id();
						$this->db->where('id', $last_id)->update($name, ['company' => $company]);

                        //print_r($this->db->last_query());die;
                        if ($d1 == 1) {
                            $this->session->set_userdata('pay_sessiion', $email);
                            $this->session->set_userdata('pay_sessiion2', $ps);
                            $this->session->set_userdata('pay_sessiion3', $mno);
                            $email_info = $this->Common_model->select('jp_setting_email', '1', 'id');
                            $link = base_url('home/v/') . $mno . "/" . $name;
                            $this->load->library('email');
                            $config['mailtype'] = 'html';
                            $this->email->initialize($config);
                            $this->email->to($email);
                            $this->email->from($email_info->recruiter_email);
                            $this->email->subject($email_info->recruiter_subject);
                            $this->email->message("<div style='width:100%;height:100px;background:#5176E3'><br><c
									    	enter><img src='" . base_url('uploads/setting/logo_with_text.png') . "' alt='logo'></center></div><p><font size='2' color='#74787E'>" . $email_info->recruiter_veri_msg . "</font></p><br><br><a href='" . $link . "' style='color:red;'>Click Here</a><br><br><br><p><font size='4' color='#74787E'>Thank you</font></p><font color='#74787E'><p>Regards,</p><p>Job Portal</p></font>");
                            $this->email->send();
                            $q = $this->db->select('*')->from('recruiter')->where('email', $email)->get();
                            $res = $q->row();
                            $j_arr = array(
                                'staus' => 'true',
                                // 'message'=>'please pay',
								'type' => $name,
                                'message' => 'Account is Sucessfully Created',
                                'data' => $res,
                            );
                            $json_signup = json_encode($j_arr);
                            echo $json_signup;
							exit;
                        } else if ($d1 == 'eyes') {
                            $q = $this->db->select('*')->from('recruiter')->where('email', $email)->get();
                            $res = $q->row();
                            if ($res->pay == 'no') {
                                $j_arr = array(
                                    'staus' => 'true',
                                    // 'message'=>'please pay',
                                    'message' => 'Account is Sucessfully Created',
                                    'data' => $res,
                                );
                                $json_signup = json_encode($j_arr);
                                echo $json_signup;
                            } else {
                                $j_arr = array(
                                    'staus' => 'false',
									'type' => $name,
                                    'message' => 'email already exists',
                                    'data' => $res,
                                );
                                $json_signup = json_encode($j_arr);
                                echo $json_signup;
                            }
                        } else if ($d1 == 'myes') {
                            $q = $this->db->select('*')->from('recruiter')->where('mno', $mno)->get();
                            $res = $q->row();
                            $j_arr = array(
                                'staus' => 'false',
								'type' => $name,
                                'message' => 'mobile number already exists',
                                'data' => $res,
                            );
                            $json_signup = json_encode($j_arr);
                            echo $json_signup;
                        } else {
                            $q = $this->db->select('*')->from('recruiter')->where('email', $email)->where('mno', $mno)->get();
                            $res = $q->row();
                            print_r($res);
                        }
                    } else {
                        $ps = $this->input->post('ps');
                        $ps1 = md5($ps);
                        $data['ps'] = $ps1;
                        $data['ps2'] = $ps;
                        $email = $this->input->post('email');
                        $mno = $this->input->post('mno');
                        unset($data['rps']);
                        $d1 = $this->Common_model->signUp($data, $mno, $email, $name);
                        $p_info = $this->Common_model->select('jp_revenue');
                        $p_infi_plane = '';
                        foreach ($p_info as $p1) {
                            $p_infi_plane = $p1->condation;
                        }
                        if ($d1 == 1) {
                            $d1 = date('Y/m/d');
                            $arr = array('pay' => 'no',
                                'plan' => $p_infi_plane,
                                'pay_date' => '',
                                'show_on_reg' => 'no',
                            );
                            $res = $this->Common_model->updateData('recruiter', $arr, $email, 'email');

                            $email_info = $this->Common_model->select('jp_setting_email', '1', 'id');
                            $link = base_url('home/v/') . $mno . "/" . $name;
                            $this->load->library('email');
                            $config['mailtype'] = 'html';
                            $this->email->initialize($config);
                            $this->email->to($email);
                            $this->email->from($email_info->recruiter_email);
                            $this->email->subject($email_info->recruiter_subject);
                            $this->email->message("<div style='width:100%;height:100px;background:#5176E3'><br><center><img src='" . base_url('uploads/setting/logo_with_text.png') . "' alt='logo'></center></div><p><font size='2' color='#74787E'>" . $email_info->recruiter_veri_msg . "</font></p><br><br><a href='" . $link . "' style='color:red;'>Click Here</a><br><br><br><p><font size='4' color='#74787E'>Thank you</font></p><font color='#74787E'><p>Regards,</p><p>Job Portal</p></font>");
                            $this->email->send();
                            $this->session->set_flashdata('msg', 'vmsg');
                            $j_arr = array(
                                'staus' => 'true',
								'type' => $name,
                                'message' => 'Register',
                                'data' => '',
                            );
                            $json_signup = json_encode($j_arr);
                            echo $json_signup;
                        } else {
                            $j_arr = array(
                                'staus' => 'true',
                                'message' => 'not Register',
                                'data' => '',
                            );
                            $json_signup = json_encode($j_arr);
                            echo $json_signup;
                        }

                    }
                }
            } else {

                $ps = $this->input->post('ps');
                $ps1 = md5($ps);
                $data['ps'] = $ps1;
                $data['status'] = 'Active';
                $data['name'] = $this->input->post('name');
                $data['surname'] = $this->input->post('surname');
                $data['status'] = 'Active';
                $email = $this->input->post('email');
                $mno = $this->input->post('mno');
                unset($data['rps']);
                $d1 = $this->Common_model->signUp($data, $mno, $email, $name);
                $q = $this->db->select('*')->from('recruiter')->where('email', $email)->get();
                $res = $q->row();
                if ($d1 == 1) {
                    $email_info = $this->Common_model->select('jp_setting_email', '1', 'id');
                    $link = base_url('home/v/') . $mno . "/" . $name;
                    $this->load->library('email');
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $this->email->to($email);
                    $this->email->from($email_info->seeker_email);
                    $this->email->subject($email_info->seeker_subject);
                    $this->email->message("<div style='width:100%;height:100px;background:#5176E3'><br><center><img src='" . base_url('uploads/setting/logo_with_text.png') . "' alt='logo'></center></div><p><font size='2' color='#74787E'>" . $email_info->seeker_veri_msg . "</font></p><br><br><a href='" . $link . "' style='color:red;'>Click Here</a><br><br><br><p><font size='4' color='#74787E'>Thank you</font></p><font color='#74787E'><p>Regards,</p><p>Job Portal</p></font>");
                    $this->email->send();
                    $this->session->set_flashdata('msg', 'vmsg');
                    $j_arr = array(
                        'staus' => 'true',
                        'message' => 'Register',
						'type' => $name,
                        'data' => '',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                } else if ($d1 == 'eyes') {
                    $q = $this->db->select('*')->from('seeker')->where('email', $email)->get();
                    $res = $q->row();
                    $j_arr = array(
                        'staus' => 'false',
                        'message' => 'email already exists',
                        'data' => $res,
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                } else if ($d1 == 'myes') {
                    $q = $this->db->select('*')->from('seeker')->where('mno', $mno)->get();
                    $res = $q->row();
                    $j_arr = array(
                        'staus' => 'false',
                        'message' => 'mobile number already exists',
                        'data' => $res,
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                } else {
                    $j_arr = array(
                        'staus' => 'flase',
                        'message' => 'not Register',
                        'data' => '',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                }
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }
    // seeker
    public function newUserLogin()
    {
        $name = $this->input->post('type');
        $token = $this->input->post('token');

        if (!empty($this->input->post('email'))) {

            $email = $this->input->post('email');
            $ps = $this->input->post('ps');
            $res = $this->Common_model->select('jp_setting', '2', 'id');
            if (!empty($name)) {
                $email = $this->input->post('email');
                $ps1 = $this->input->post('ps');
                $ps = md5($ps1);

                $q = $this->Common_model->login($email, $ps, $name);
                if ($q) {
                    $tokrn_arr = array('token' => $token);
                    $this->Common_model->updateData($name, $tokrn_arr, $email, 'email');
                    $mno = $q->mno;
                    if ($name == 'recruiter') {

                        $q->ps = "r";
                        $rec_info = $this->Common_model->select('recruiter', $email, 'email');
                        $plan = $rec_info->show_on_reg;
                        if ($plan == 'no') {
                            if ($q->status != 'Active') {
                                $j_arr = array(
                                    'staus' => 'false',
                                    'message' => 'Account Disabled',
                                    'data' => '',
                                );
                                $json_single_job = json_encode($j_arr);
                                echo $json_single_job;
                            } else {

                                //$this->session->set_userdata($name,$email);
                                $j_arr = array(
                                    'staus' => 'true',
                                    'message' => 'Success',
                                    'base_url' => base_url(),
                                    'admob' => $res->add_mob_s,
                                    'data' => $q,
                                );
                                echo str_replace('null', '"0"', json_encode($j_arr));
                            }
                        } else {
                            $pay = $rec_info->pay;
                            if ($pay == 'yes') {
                                // if($q->veri!="yes")
                                // {
                                //     $j_arr=array(
                                //         'staus'=>'false',
                                //         'message'=>'please verify your email address',
                                //         'data'=>'',
                                //        );
                                //     $json_single_job=json_encode($j_arr);
                                //                    echo $json_single_job;
                                // }
                                // else
                                if ($q->status != 'Active') {
                                    $j_arr = array(
                                        'staus' => 'false',
                                        'message' => 'Account Disabled',
                                        'data' => '',
                                    );
                                    $json_single_job = json_encode($j_arr);
                                    echo $json_single_job;
                                } else {
                                    //$this->session->set_userdata($name,$email);
                                    $j_arr = array(
                                        'staus' => 'true',
                                        'message' => 'Success',
                                        'base_url' => base_url(),
                                        'admob' => $res->add_mob_s,
                                        'data' => $q,
                                    );
                                    //$json_single_job=json_encode($j_arr);
                                    //echo $json_single_job;
                                    echo str_replace('null', '"0"', json_encode($j_arr));
                                }
                            } else if ($pay == 'no') {
                                if ($q->status != 'Active') {
                                    $j_arr = array(
                                        'staus' => 'false',
                                        'message' => 'Account Disabled',
                                        'data' => '',
                                    );
                                    $json_single_job = json_encode($j_arr);
                                    echo $json_single_job;
                                } else {
                                    //$this->session->set_userdata($name,$email);
                                    $j_arr = array(
                                        'staus' => 'true',
                                        'message' => 'Success',
                                        'base_url' => base_url(),
                                        'admob' => $res->add_mob_s,
                                        'data' => $q,
                                    );
                                    // $json_single_job=json_encode($j_arr);
                                    //echo $json_single_job;
                                    echo str_replace('null', '"0"', json_encode($j_arr));

                                }

                            } else {
                                $j_arr = array(
                                    'staus' => 'false',
                                    'message' => 'Wrong User',
                                    'data' => '',
                                );
                                $json_single_job = json_encode($j_arr);
                                echo $json_single_job;
                            }
                        }
                    } else {
                        $tokrn_arr = array('token' => $token);
                        $this->Common_model->updateData('seeker', $tokrn_arr, $email, 'email');
                        
                        if ($q->status != 'Active') {
                            $j_arr = array(
                                'staus' => 'false',
                                'message' => 'Account Disabled',
                                'data' => '',
                            );
                            $json_single_job = json_encode($j_arr);
                            echo $json_single_job;
                        } else {
                            //$this->session->set_userdata($name,$email);
                            $j_arr = array(
                                'staus' => 'true',
                                'message' => 'Success',
                                'base_url' => base_url(),
                                'admob' => $res->add_mob_s,
                                'data' => $q,
                            );
                            //$json_single_job=json_encode($j_arr);
                            //echo $json_single_job;
                            echo str_replace('null', '"0"', json_encode($j_arr));
                        }
                    }

                } else {
                    $j_arr = array(
                        'staus' => 'false',
                        'message' => 'Wrong User',
                        'data' => '',
                    );
                    $json_single_job = json_encode($j_arr);
                    echo $json_single_job;
                }
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'post request is empty',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }

        } else {

            $mno = $this->input->post('mno');
            $res = $this->Common_model->select('jp_setting', '2', 'id');
            if (!empty($name)) {
                $mno = $this->input->post('mno');
                // $ps=md5($ps1);

                // $q=$this->Common_model->login($email,$ps,$name);
                $q = $this->Common_model->newLogin($mno, $name);
                if ($q) {
                    $mno = $q->mno;
                    if ($name == 'recruiter') {

                        $otp = mt_rand(1000, 9999);
                        $tokrn_arr = array('otp' => $otp);
                        $this->Common_model->updateData('recruiter', $tokrn_arr, $mno, 'mno');
                        // print_r($this->db->last_query());dei;
                        $q->ps = "r";
                        $rec_info = $this->Common_model->select('recruiter', $mno, 'mno');
                        $plan = $rec_info->show_on_reg;
                        if ($plan == 'no') {
                            // if($q->veri!="yes")
                            // {
                            //     $j_arr=array(
                            //         'staus'=>'false',
                            //         'message'=>'please verify your email address',
                            //         'data'=>'',
                            //        );
                            //     $json_single_job=json_encode($j_arr);
                            //           echo $json_single_job;
                            // }
                            // else
                            if ($q->status != 'Active') {
                                $j_arr = array(
                                    'staus' => 'false',
                                    'message' => 'Account Disabled',
                                    'data' => '',
                                );
                                $json_single_job = json_encode($j_arr);
                                echo $json_single_job;
                            } else {

                                $q = $this->Common_model->newLogin($mno, $name);
                                // print_r($q);dei;
                                //$this->session->set_userdata($name,$email);
                                $j_arr = array(
                                    'staus' => 'true',
                                    'message' => 'Success',
                                    'type' => $name,
                                    'base_url' => base_url(),
                                    'admob' => $res->add_mob_s,
                                    'otp' => $otp,
                                    'data' => $q,
                                );
                                // $json_single_job=json_encode($j_arr);
                                //echo $json_single_job;
                                echo str_replace('null', '"0"', json_encode($j_arr));

                            }
                        } else {
                            $pay = $rec_info->pay;
                            if ($pay == 'yes') {
                                // if($q->veri!="yes")
                                // {
                                //     $j_arr=array(
                                //         'staus'=>'false',
                                //         'message'=>'please verify your email address',
                                //         'data'=>'',
                                //        );
                                //     $json_single_job=json_encode($j_arr);
                                //                    echo $json_single_job;
                                // }
                                // else
                                if ($q->status != 'Active') {
                                    $j_arr = array(
                                        'staus' => 'false',
                                        'message' => 'Account Disabled',
                                        'type' => $name,
                                        'data' => '',
                                    );
                                    $json_single_job = json_encode($j_arr);
                                    echo $json_single_job;
                                } else {

                                    $q = $this->Common_model->newLogin($mno, $name);
                                    //$this->session->set_userdata($name,$email);
                                    $j_arr = array(
                                        'staus' => 'true',
                                        'message' => 'Success',
                                        'type' => $name,
                                        'base_url' => base_url(),
                                        'admob' => $res->add_mob_s,
                                        'otp' => $otp,
                                        'data' => $q,
                                    );
                                    //$json_single_job=json_encode($j_arr);
                                    //echo $json_single_job;
                                    echo str_replace('null', '"0"', json_encode($j_arr));
                                }
                            } else if ($pay == 'no') {
                                $data = array('mobile no' => $mno,
                                    'email' => $email,
                                );
                                $q = $this->Common_model->newLogin($mno, $name);
                                $j_arr = array(
                                    'staus' => 'true',
                                    // 'message'=>'please pay',
                                    'message' => 'Success',
                                    'type' => $name,
                                    'base_url' => base_url(),
                                    'admob' => $res->add_mob_s,
                                    'data' => $q,
                                );
                                //$json_single_job=json_encode($j_arr);
                                //echo $json_single_job;
                                echo str_replace('null', '"0"', json_encode($j_arr));

                            } else {
                                $j_arr = array(
                                    'staus' => 'false',
                                    'message' => 'Wrong User',
                                    'type' => $name,
                                    'data' => '',
                                );
                                $json_single_job = json_encode($j_arr);
                                echo $json_single_job;
                            }
                        }
                    } else {

                        $otp = mt_rand(1000, 9999);
                        $tokrn_arr = array('token' => $token, 'otp' => $otp);
                        $this->Common_model->updateData('seeker', $tokrn_arr, $mno, 'mno');
                        //  if($q->veri!="yes")
                        //  {
                        //     $j_arr=array(
                        //         'staus'=>'false',
                        //         'message'=>'please verify your email address',
                        //         'data'=>'',
                        //        );
                        //        $json_single_job=json_encode($j_arr);
                        //                 echo $json_single_job;
                        //  }
                        // else
                        if ($q->status != 'Active') {
                            $j_arr = array(
                                'staus' => 'false',
                                'message' => 'Account Disabled',
                                'type' => $name,
                                'data' => '',
                            );
                            $json_single_job = json_encode($j_arr);
                            echo $json_single_job;
                        } else {
                            $q = $this->Common_model->newLogin($mno, $name);
                            //$this->session->set_userdata($name,$email);
                            $j_arr = array(

                                'staus' => 'true',
                                'message' => 'Success',
                                'type' => $name,
                                'base_url' => base_url(),
                                'admob' => $res->add_mob_s,
                                'otp' => $otp,
                                'data' => $q,
                            );
                            //$json_single_job=json_encode($j_arr);
                            //echo $json_single_job;
                            echo str_replace('null', '"0"', json_encode($j_arr));
                        }
                    }

                } else {
                    $j_arr = array(
                        'staus' => 'false',
                        'message' => 'Wrong User',
                        'type' => $name,
                        'data' => '',
                    );
                    $json_single_job = json_encode($j_arr);
                    echo $json_single_job;
                }
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'post request is empty',
                    'type' => $name,
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }

        }

    }

    public function login()
    {
        $name = $this->input->post('type');
        // $email=$this->input->post('email');
        $token = $this->input->post('token');
        $mno = $this->input->post('email');
        $pass = $this->input->post('ps');
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        if (!empty($name)) {
            $mno = $this->input->post('email');
            // $ps=md5($ps1);

            // $q=$this->Common_model->login($email,$ps,$name);
            $q = $this->Common_model->newLogin($mno, $pass, $name);
            if ($q) {
                $mno = $q->mno;
                if ($name == 'recruiter') {

                    $otp = mt_rand(1000, 9999);
                    $tokrn_arr = array('token' => $token, 'otp' => $otp);
                    $this->Common_model->updateData('recruiter', $tokrn_arr, $mno, 'mno');
                    $q->ps = "r";
                    $rec_info = $this->Common_model->select('recruiter', $mno, 'mno');
					$plan = isset($rec_info->show_on_reg) ? $rec_info->show_on_reg : [];
                    if (empty($plan)) {
                        if ($q->status == 'Inactive') {
                            $j_arr = array(
                                'staus' => 'false',
                                'message' => 'Account Disabled',
                                'data' => '',
                            );
                            $json_single_job = json_encode($j_arr);
                            echo $json_single_job;
                        } else {

                            $q = $this->Common_model->newLogin($mno, $pass, $name);
                            // print_r($q);dei;
                            //$this->session->set_userdata($name,$email);
                            $j_arr = array(
                                'staus' => 'true',
                                'message' => 'Success',
                                'type' => $name,
                                'base_url' => base_url(),
                                'admob' => $res->add_mob_s,
                                'otp' => $otp,
                                'data' => $q,
                            );
                            // $json_single_job=json_encode($j_arr);
                            //echo $json_single_job;
                            echo str_replace('null', '"0"', json_encode($j_arr));

                        }
                    } else {
						
                        $pay = $rec_info->pay;
                        if ($pay == 'yes') {
                            // if($q->veri!="yes")
                            // {
                            //     $j_arr=array(
                            //         'staus'=>'false',
                            //         'message'=>'please verify your email address',
                            //         'data'=>'',
                            //        );
                            //     $json_single_job=json_encode($j_arr);
                            //                    echo $json_single_job;
                            // }
                            // else
                            if ($q->status != 'Active') {
                                $j_arr = array(
                                    'staus' => 'false',
                                    'message' => 'Account Disabled',
                                    'type' => $name,
                                    'data' => '',
                                );
                                $json_single_job = json_encode($j_arr);
                                echo $json_single_job;
                            } else {

                                $q = $this->Common_model->newLogin($mno, $pass, $name);
                                // $this->session->set_userdata($name, $email);
                                $j_arr = array(
                                    'staus' => 'true',
                                    'message' => 'Success',
                                    'type' => $name,
                                    'base_url' => base_url(),
                                    'admob' => $res->add_mob_s,
                                    'otp' => $otp,
                                    'data' => $q,
                                );
                                // $json_single_job=json_encode($j_arr);
                                // echo $json_single_job;
                                echo str_replace('null', '""', json_encode($j_arr));
                            }
                        } else if ($pay == 'no') {
                            $data = array('mobile no' => $mno,
                                'email' => $email,
                            );
                            $q = $this->Common_model->newLogin($mno, $name);
                            $j_arr = array(
                                'staus' => 'true',
                                'message' => 'please pay',
                                'type' => $name,
                                'base_url' => base_url(),
                                'admob' => $res->add_mob_s,
                                'data' => $q,
                            );
                            //$json_single_job=json_encode($j_arr);
                            //echo $json_single_job;
                            echo str_replace('null', '"0"', json_encode($j_arr));

                        } else {
                            $j_arr = array(
                                'staus' => 'false',
                                'message' => 'Wrong User',
                                'type' => $name,
                                'data' => '',
                            );
                            $json_single_job = json_encode($j_arr);
                            echo $json_single_job;
                        }
                    }
                } else {

                    $otp = mt_rand(1000, 9999);
                    $tokrn_arr = array('token' => $token, 'otp' => $otp);
                    $this->Common_model->updateData('seeker', $tokrn_arr, $mno, 'mno');
                    //  if($q->veri!="yes")
                    //  {
                    //     $j_arr=array(
                    //         'staus'=>'false',
                    //         'message'=>'please verify your email address',
                    //         'data'=>'',
                    //        );
                    //        $json_single_job=json_encode($j_arr);
                    //                 echo $json_single_job;
                    //  }
                    // else
                    if ($q->status != 'Active') {
                        $j_arr = array(
                            'staus' => 'false',
                            'message' => 'Account Disabled',
                            'type' => $name,
                            'data' => '',
                        );
                        $json_single_job = json_encode($j_arr);
                        echo $json_single_job;
                    } else {
                        $q = $this->Common_model->newLogin($mno, $pass, $name);
                        //$this->session->set_userdata($name,$email);
                        $j_arr = array(

                            'staus' => 'true',
                            'message' => 'Success',
                            'type' => $name,
                            'base_url' => base_url(),
                            'admob' => $res->add_mob_s,
                            'otp' => $otp,
                            'data' => $q,
                        );
                        //$json_single_job=json_encode($j_arr);
                        //echo $json_single_job;
                        echo str_replace('null', '"0"', json_encode($j_arr));
                    }
                }

            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'Invalid user or Wrong Id password',
                    'type' => $name,
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'type' => $name,
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function newlogin()
    {
        $name = $this->input->post('type');
        // $email=$this->input->post('email');
        $token = $this->input->post('token');
        $mno = $this->input->post('mno');
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        if (!empty($name)) {
            $mno = $this->input->post('mno');
            // $ps=md5($ps1);

            // $q=$this->Common_model->login($email,$ps,$name);
            $q = $this->Common_model->newLogin($mno, $name);

            //print_r($q);die;
            if ($q) {
                $mno = $q->mno;
                if ($name == 'recruiter') {

                    $otp = mt_rand(1000, 9999);
                    $tokrn_arr = array('otp' => $otp);
                    $this->Common_model->updateData('recruiter', $tokrn_arr, $mno, 'mno');

                    $q->ps = "r";
                    $rec_info = $this->Common_model->select('recruiter', $mno, 'mno');

                    //    print_r($rec_info);die;
                    $plan = $rec_info->show_on_reg;

                    if (empty($plan)) {
                        // if($q->veri!="yes")
                        // {
                        //     $j_arr=array(
                        //         'staus'=>'false',
                        //         'message'=>'please verify your email address',
                        //         'data'=>'',
                        //        );
                        //     $json_single_job=json_encode($j_arr);
                        //           echo $json_single_job;
                        // }
                        // else
                        if ($q->status == 'Inactive') {
                            $j_arr = array(
                                'staus' => 'false',
                                'message' => 'Account Disabled',
                                'data' => '',
                            );
                            $json_single_job = json_encode($j_arr);
                            echo $json_single_job;
                        } else {

                            $q = $this->Common_model->newLogin($mno, $name);
                            // print_r($q);dei;
                            //$this->session->set_userdata($name,$email);
                            $j_arr = array(
                                'staus' => 'true',
                                'message' => 'Success',
                                'type' => $name,
                                'base_url' => base_url(),
                                'admob' => $res->add_mob_s,
                                'otp' => $otp,
                                'data' => $q,
                            );
                            // $json_single_job=json_encode($j_arr);
                            //echo $json_single_job;
                            echo str_replace('null', '"0"', json_encode($j_arr));

                        }
                    } else {
                        $pay = $rec_info->pay;
                        if ($pay == 'yes') {
                            // if($q->veri!="yes")
                            // {
                            //     $j_arr=array(
                            //         'staus'=>'false',
                            //         'message'=>'please verify your email address',
                            //         'data'=>'',
                            //        );
                            //     $json_single_job=json_encode($j_arr);
                            //                    echo $json_single_job;
                            // }
                            // else
                            if ($q->status != 'Active') {
                                $j_arr = array(
                                    'staus' => 'false',
                                    'message' => 'Account Disabled',
                                    'type' => $name,
                                    'data' => '',
                                );
                                $json_single_job = json_encode($j_arr);
                                echo $json_single_job;
                            } else {

                                $q = $this->Common_model->newLogin($mno, $name);
                                //$this->session->set_userdata($name,$email);
                                $j_arr = array(
                                    'staus' => 'true',
                                    'message' => 'Success',
                                    'type' => $name,
                                    'base_url' => base_url(),
                                    'admob' => $res->add_mob_s,
                                    'otp' => $otp,
                                    'data' => $q,
                                );
                                //$json_single_job=json_encode($j_arr);
                                //echo $json_single_job;
                                echo str_replace('null', '"0"', json_encode($j_arr));
                            }
                        } else if ($pay == 'no') {
                            $data = array('mobile no' => $mno,
                                'email' => $email,
                            );
                            $q = $this->Common_model->newLogin($mno, $name);
                            $j_arr = array(
                                'staus' => 'true',
                                'message' => 'please pay',
                                'type' => $name,
                                'base_url' => base_url(),
                                'admob' => $res->add_mob_s,
                                'data' => $q,
                            );
                            //$json_single_job=json_encode($j_arr);
                            //echo $json_single_job;
                            echo str_replace('null', '"0"', json_encode($j_arr));

                        } else {
                            $j_arr = array(
                                'staus' => 'false',
                                'message' => 'Wrong User',
                                'type' => $name,
                                'data' => '',
                            );
                            $json_single_job = json_encode($j_arr);
                            echo $json_single_job;
                        }
                    }
                } else {

                    $otp = mt_rand(1000, 9999);
                    $tokrn_arr = array('token' => $token, 'otp' => $otp);
                    $this->Common_model->updateData('seeker', $tokrn_arr, $mno, 'mno');

                    //  if($q->veri!="yes")
                    //  {
                    //     $j_arr=array(
                    //         'staus'=>'false',
                    //         'message'=>'please verify your email address',
                    //         'data'=>'',
                    //        );
                    //        $json_single_job=json_encode($j_arr);
                    //                 echo $json_single_job;
                    //  }
                    // else
                    if ($q->status == 'Inactive') {
                        $j_arr = array(
                            'staus' => 'false',
                            'message' => 'Account Disabled',
                            'type' => $name,
                            'data' => '',
                        );
                        $json_single_job = json_encode($j_arr);
                        echo $json_single_job;
                    } else {
                        $q = $this->Common_model->newLogin($mno, $name);
                        //$this->session->set_userdata($name,$email);
                        $j_arr = array(

                            'staus' => 'true',
                            'message' => 'Success',
                            'type' => $name,
                            'base_url' => base_url(),
                            'admob' => $res->add_mob_s,
                            'otp' => $otp,
                            'data' => $q,
                        );
                        //$json_single_job=json_encode($j_arr);
                        //echo $json_single_job;
                        echo str_replace('null', '"0"', json_encode($j_arr));
                    }
                }

            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'Wrong User',
                    'type' => $name,
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'type' => $name,
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function otp_login()
    {
        // print_r($_POST);die;/
        $name = $this->input->post('type');
        $mno = $this->input->post('mno');
        $otp = $this->input->post('otp');
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        if (!empty($name)) {
            $mno = $this->input->post('mno');
            // $ps=md5($ps1);

            // $q=$this->Common_model->login($email,$ps,$name);
            $q = $this->Common_model->otplogin($mno, $otp, $name);
            // print_r($q);die;
            if ($q) {
                $mno = $q->mno;
                if ($name == 'recruiter') {

                    // $otp        = mt_rand(1000,9999);
                    // $tokrn_arr=array('token'=>$token,'otp'=>$otp);
                    $this->Common_model->updateData('recruiter', $tokrn_arr, $mno, 'mno');

                    $q->ps = "r";
                    $rec_info = $this->Common_model->select('recruiter', $mno, 'mno');
                    $plan = $rec_info->show_on_reg;
                    if ($plan == 'no') {
                        // if($q->veri!="yes")
                        // {
                        //     $j_arr=array(
                        //         'staus'=>'false',
                        //         'message'=>'please verify your email address',
                        //         'data'=>'',
                        //        );
                        //     $json_single_job=json_encode($j_arr);
                        //           echo $json_single_job;
                        // }
                        // else
                        if ($q->status != 'Active') {
                            $j_arr = array(
                                'staus' => 'false',
                                'message' => 'Account Disabled',
                                'data' => '',
                            );
                            $json_single_job = json_encode($j_arr);
                            echo $json_single_job;
                        } else {
                            //$this->session->set_userdata($name,$email);
                            $j_arr = array(
                                'staus' => 'true',
                                'message' => 'Success',
                                'base_url' => base_url(),
                                'admob' => $res->add_mob_s,
                                'otp' => $otp,
                                'data' => $q,
                            );
                            // $json_single_job=json_encode($j_arr);
                            //echo $json_single_job;
                            echo str_replace('null', '"0"', json_encode($j_arr));

                        }
                    } else {
                        $pay = $rec_info->pay;
                        if ($pay == 'yes') {
                            // if($q->veri!="yes")
                            // {
                            //     $j_arr=array(
                            //         'staus'=>'false',
                            //         'message'=>'please verify your email address',
                            //         'data'=>'',
                            //        );
                            //     $json_single_job=json_encode($j_arr);
                            //                    echo $json_single_job;
                            // }
                            // else
                            if ($q->status != 'Active') {
                                $j_arr = array(
                                    'staus' => 'false',
                                    'message' => 'Account Disabled',
                                    'data' => '',
                                );
                                $json_single_job = json_encode($j_arr);
                                echo $json_single_job;
                            } else {
                                //$this->session->set_userdata($name,$email);
                                $j_arr = array(
                                    'staus' => 'true',
                                    'message' => 'Success',
                                    'base_url' => base_url(),
                                    'admob' => $res->add_mob_s,
                                    'otp' => $otp,
                                    'data' => $q,
                                );
                                //$json_single_job=json_encode($j_arr);
                                //echo $json_single_job;
                                echo str_replace('null', '"0"', json_encode($j_arr));
                            }
                        } else if ($pay == 'no') {
                            $data = array('mobile no' => $mno,
                                'email' => $email,
                            );
                            $j_arr = array(
                                'staus' => 'true',
                                'message' => 'please pay',
                                'base_url' => base_url(),
                                'admob' => $res->add_mob_s,
                                'data' => $q,
                            );
                            //$json_single_job=json_encode($j_arr);
                            //echo $json_single_job;
                            echo str_replace('null', '"0"', json_encode($j_arr));

                        } else {
                            $j_arr = array(
                                'staus' => 'false',
                                'message' => 'Wrong User',
                                'data' => '',
                            );
                            $json_single_job = json_encode($j_arr);
                            echo $json_single_job;
                        }
                    }
                } else {

                    // $otp        = mt_rand(1000,9999);
                    // $tokrn_arr=array('token'=>$token,'otp'=>$otp);
                    $this->Common_model->updateData('seeker', $tokrn_arr, $mno, 'mno');
                    //  if($q->veri!="yes")
                    //  {
                    //     $j_arr=array(
                    //         'staus'=>'false',
                    //         'message'=>'please verify your email address',
                    //         'data'=>'',
                    //        );
                    //        $json_single_job=json_encode($j_arr);
                    //                 echo $json_single_job;
                    //  }
                    // else
                    if ($q->status != 'Active') {
                        $j_arr = array(
                            'staus' => 'false',
                            'message' => 'Account Disabled',
                            'data' => '',
                        );
                        $json_single_job = json_encode($j_arr);
                        echo $json_single_job;
                    } else {
                        //$this->session->set_userdata($name,$email);
                        $j_arr = array(

                            'staus' => 'true',
                            'message' => 'Success',
                            'base_url' => base_url(),
                            'admob' => $res->add_mob_s,
                            'otp' => $otp,
                            'data' => $q,
                        );
                        //$json_single_job=json_encode($j_arr);
                        //echo $json_single_job;
                        echo str_replace('null', '"0"', json_encode($j_arr));
                    }
                }

            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'invalid Otp',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

	public function login_with_otp() {
		$mobile = $this->input->post('mobile');
		$type = $this->input->post('type');

		$response = $this->db->where('mno', $mobile)->get($type)->row_array();
		if(!empty($response)) {
			$otp = rand(1111, 9999);
			$response = ['status' => true, 'message' => 'OTP sent success','type' => $type,  'otp' => "$otp", 'data' => $response];
		} else {
			$response = ['status' => false, 'message' => 'User not registered'];
		}
		echo json_encode($response);
		exit;
	}

	public function get_profile() {

	}

    public function my_applied_job()
    {
        $email = $this->input->post('email');
        if (!empty($email)) {
            // $my_app_job=$this->Common_model->my_applied_job('jp_applay_job',$email,'s_email');

            $row1 = $this->db->select('*')->from('jp_applay_job')->where('s_email', $email)->get();
            $my_app_job = $row1->result();
            // print_r($my_app_job);
            if ($my_app_job) {
                $arr = array();
                foreach ($my_app_job as $my_app_job1) {
                    // print_r($my_app_job1);die;
                    $job_id = $my_app_job1->job_id;
                    $s_email = $my_app_job1->s_email;
                    // $r_id=$my_app_job1->r_id;
                    $job1 = $this->db->select('*')->from('job_post')->where('id', $job_id)->get();
                    $job_info = $job1->result()[0];
                    // $job_info=$this->Common_model->select('job_post',$job_id,'id');
                    // print_r($this->db->last_query());
                    $r_id = $job_info->r_id;
                    // echo "<pre>",print_r($job_info);
                    // die();

                    $company = $this->db->query("SELECT company,img FROM  recruiter WHERE  email = '" . $r_id . "'")->row();
                    // print_r($this->db->last_query());
                    // print_r($company);die;
                    $job_info->company = $company->company;
                    $job_info->img = $company->img;
                    $arr[] = $job_info;

                }

                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => $arr,
                );
                $json_job = json_encode($j_arr);
                echo $json_job;
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'applied job not found',
                    'data' => '',
                );
                $json_job = json_encode($j_arr);
                echo $json_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }

    }

    //recruiter
    public function myjobs()
    {
        $email = $this->input->post('email');
        if (!empty($email)) {
            $job = $this->db->select('*')->from('job_post')->where('r_id', $email)->get();
            $myjob = $job->result();

            if (!empty($myjob)) {

                foreach ($myjob as $my_app_job1) {
                    $s_email = $my_app_job1->r_id;
                    // print_r($s_email);
                    $company = $this->db->query("SELECT company FROM  recruiter WHERE  email = '" . $s_email . "'")->row();
                    // print_r($company);die;
                    $my_app_job1->company = $company->company;
                    $arr[] = $my_app_job1;

                }

                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => $arr,
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'data_not_found',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }
    public function job_edit()
    {
        $id = $this->input->post('job_id');
        if (!empty($id)) {
            $job = $this->Common_model->select('job_post', $id, 'id');
            if (!empty($job)) {
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => $job,
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'data_not_found',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }
    public function view_applied_seeker()
    {
        $job_id = $this->input->post('job_id');
        if (!empty($job_id)) {
            $data = $this->Common_model->select('jp_applay_job');
            $arr_info = array();
            foreach ($data as $data1) {
                if ($data1->job_id == $job_id) {
                    $arr_info[] = $data1->s_email;
                }
            }
            $seeker_info = array();
            if (!empty($arr_info)) {
                foreach ($arr_info as $data1) {
                    $seeker_info[] = $this->Common_model->select('seeker', $data1, 'email');
                }
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => $seeker_info,
                );
                //$json_single_job=json_encode($j_arr);
                //echo $json_single_job;
                echo str_replace('null', '0', json_encode($j_arr));
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'not Found',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'Post Request not Found',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }

    }
    public function applied_seeker()
    {
        $email = $this->input->post('recruiter_email');
        if (!empty($email)) {
            $rec_data = $this->Common_model->select('recruiter', $email, 'email');

            if (!empty($rec_data)) {
                $rec_id = $rec_data->email;

                $data = $this->db->select('*')->from('jp_applay_job')->where('r_id', $rec_id)->get();
                //print_r($this->db->last_query());die;
                $a_seeker = $data->result();
                $seeker_info = array();
                foreach ($a_seeker as $a1) {
                    $job_id = $a1->job_id;
                    $email = $a1->s_email;
                    $s1 = $this->db->select(['id', 'name', 'mno', 'email', 'surname'])->from('seeker')->where('email', $email)->get();
                    $s12 = $s1->row();
                    $s12->job_id = $job_id;

                    $seeker_info[] = $s12;
                }
                //$a_seeker=$this->Common_model->select('jp_applay_job',$rec_id,'r_id');
                if (!empty($a_seeker)) {
                    $j_arr = array(
                        'staus' => 'true',
                        'message' => 'Success',
                        'data' => $seeker_info,
                    );
                    $json_single_job = json_encode($j_arr);
                    echo $json_single_job;
                } else {
                    $j_arr = array(
                        'staus' => 'false',
                        'message' => 'data_not_found',
                        'data' => '',
                    );
                    $json_single_job = json_encode($j_arr);
                    echo $json_single_job;
                }
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'data_not_found',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }

    }

    public function seeker_info() {
        $email = $this->input->post('seeker_email');
        if (!empty($email)) {
            $s_data = $this->db->where('email', $email)->or_where('id', $email)->get('seeker')->row_array();
            if (!empty($s_data)) {
                $s_data['img'] = base_url($s_data['img']);
                $s_data['resume'] = base_url($s_data['resume']);
                // $s_data['p_year'] = "";
                // $s_data['aofs'] = "";
                // $s_data['veri'] = "";
                // $s_data['status'] = "0";
                // $s_data['token'] = "";
                // $s_data['google_id'] = "";
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => $s_data,
                );
                // $json_single_job=json_encode($j_arr);
                // echo $json_single_job;
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'data_not_found',
                    'data' => '',
                );
                // $json_single_job=json_encode($j_arr);
                // echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            // $json_single_job=json_encode($j_arr);
        }

        echo json_encode($j_arr);
        exit;
    }

    public function recruiter_info()
    {
        $email = $this->input->post('recruiter_email');
        if (!empty($email)) {
            // $s_data = $this->Common_model->select('recruiter', $email, 'email');
            $s_data = $this->db->where('email', $email)->or_where('id', $email)->get('recruiter')->row_array();
            if (!empty($s_data)) {
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => $s_data,
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'data_not_found',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }
    public function seeker_profile()
    { //counter ps_reserve email all fileld for required seeker
        $res_new = $this->Common_model->select('jp_setting', '2', 'id');

        $data = $this->input->post();
        $ps = $this->input->post('ps');
        $mno = $this->input->post('mno');
        $email = $this->input->post('email');
        unset($data['email']);
        $ps2 = '';

        if (!empty($email)) {
            if (!empty($ps)) {
                if (preg_match('/^[a-f0-9]{32}$/', $ps)) {
                    $ps2 = $ps;
                } else {
                    $ps2 = md5($ps);
                }
                $data['ps'] = $ps2;
            } else {
                unset($data['ps']);
            }

            if (empty($_FILES)) {

                unset($data['rps']);
                $res = $this->Common_model->updateData('seeker', $data, $email, 'email');
                $seeker_info1 = $this->Common_model->select('seeker', $email, 'email');

                if ($res) {
                    $j_arr = array(
                        'staus' => 'true',
                        'base_url' => base_url(),
                        'admob' => $res_new->add_mob_s,
                        'message' => 'Success',
                        'data' => $seeker_info1,
                    );
                    $json_single_job = json_encode($j_arr);
                    echo $json_single_job;
                } else {
                    $j_arr = array(
                        'staus' => 'false',
                        'message' => 'not update',
                        'data' => '',
                    );
                    $json_single_job = json_encode($j_arr);
                    echo $json_single_job;
                }
            } else {
                $seeker_info = $this->Common_model->select('seeker', $email, 'email');

                $img = $seeker_info->resume;

                $config['upload_path'] = "./uploads/resume";
                $config['allowed_types'] = "pdf|docx";
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('resume')) {
                    if (!empty($img)) {
                        unlink('./' . $img);
                    }

                    $d1 = $this->upload->data();
                    $d2 = $d1['file_name'];
                    $d3 = 'uploads/resume/' . $d2;
                    $data['resume'] = $d3;

                    unset($data['rps']);

                    $res = $this->Common_model->updateData('seeker', $data, $email, 'email');
                    $seeker_info1 = $this->Common_model->select('seeker', $email, 'email');

                    if ($res) {
                        $j_arr = array(
                            'staus' => 'true',
                            'message' => 'Success',
                            'base_url' => base_url(),
                            'admob' => $res_new->add_mob_s,
                            'data' => $seeker_info1,
                        );
                        $json_single_job = json_encode($j_arr);
                        echo $json_single_job;
                    } else {
                        $j_arr = array(
                            'staus' => 'false',
                            'message' => 'not update',
                            'data' => '',
                        );
                        $json_single_job = json_encode($j_arr);
                        echo $json_single_job;
                    }
                } else {
                    $j_arr = array(
                        'staus' => 'false',
                        'message' => 'Uploaded file is not a valid resume file. Only PDF and DOC files are allowed',
                        'data' => '',
                    );
                    $json_single_job = json_encode($j_arr);
                    echo $json_single_job;
                }
            }
        }
    }

    public function job_post()
    {
        /*r_email */
        $r_data = $this->Common_model->select('jp_revenue');
        $s1 = $this->input->post('r_email');

        $data = $this->input->post();
        $desi = $this->input->post('designation');
        $sp = $this->input->post('specialization');

        $res = $this->Common_model->insert('job_post', $data);
        //print_r($this->db->last_query());die;
        //    print_r($res);die;

        if ($res) {
            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => 'job Post',
            );
            $json_signup = json_encode($j_arr);
            echo $json_signup;
        } else {
            $j_arr = array(
                'staus' => 'flase',
                'message' => 'job not post',
                'data' => '',
            );
            $json_signup = json_encode($j_arr);
            echo $json_signup;
        }

        //print_r($this->db->last_query());die;
    }
    public function update_job_post()
    {
        /*print_r($_POST);
        die();*/
        //$id=$this->input->post('id');
        $data = $this->input->post();
        if (!empty($data)) {
            $d = $this->input->post('lasr_date_application');
            $written_test = $this->input->post('written_test');
            $group_discussion = $this->input->post('group_discussion');
            $hr_round = $this->input->post('hr_round');
            $technical_round = $this->input->post('technical_round');
            $id = $this->input->post('id');
            //print_r($id);die;
            if (empty($written_test)) {
                $data['written_test'] = 'no';
            }
            if (empty($group_discussion)) {
                $data['group_discussion'] = 'no';
            }
            if (empty($hr_round)) {
                $data['hr_round'] = 'no';
            }
            if (empty($technical_round)) {
                $data['technical_round'] = 'no';
            }

            unset($data['job_id']);
            $up_res = $this->Common_model->updateData('job_post', $data, $id, 'id');
            if ($up_res) {
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'job  post Update',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            } else {
                $j_arr = array(
                    'staus' => 'flase',
                    'message' => 'job  post not update',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;

            }
            //    print_r($this->db->last_query());die;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }
    public function recruiter_pic_update()
    {
        $s1 = $this->input->post('r_email');
        if (!empty($s1)) {
            $res1 = $this->Common_model->select('recruiter', $s1, 'email');
            $img = $res1->img;

            $config['upload_path'] = "./uploads/user_pro_pic";
            $config['allowed_types'] = "jpg|jpeg|png";
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('img')) {
                if (!empty($img)) {
                    if ($img != "assets/images/user.svg") {
                        unlink('./' . $img);
                    }
                }
                $d1 = $this->upload->data();
                $d = $d1['file_name'];
                $d2 = 'uploads/user_pro_pic/' . $d;
                $data = array('img' => $d2);
                $res = $this->Common_model->updateData('recruiter', $data, $s1, 'email');

                $qualification = $this->Common_model->select('qualification');
                $location = $this->Common_model->select('location');
                //$area_of_sectors=$this->Common_model->select('area_of_sectors');
                $job_types = $this->Common_model->select('job_types');
                $email = $this->session->userdata('recruiter');
                if ($res) {
                    $j_arr = array(
                        'staus' => 'true',
                        'message' => 'Profile pic Update',
                        'data' => '',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                } else {
                    $j_arr = array(
                        'staus' => 'false',
                        'message' => 'Profile pic Not Update',
                        'data' => '',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;

                }
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'JPG And PNG Allow',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function check_new_apply()
    {

        $job_id = $this->input->post('job_id');

        $email = $this->input->post('s_email');

        $email_info = $this->Common_model->check_job($email, $job_id);

        if (!empty($email_info)) {
            $j_arr = array(
                'staus' => 'True',
                'message' => 'Already apply');
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'User not exits ',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }

    }
    public function pro_pic_upload()
    {
        $email = $this->input->post('s_email');
        if (!empty($email)) {
            $res1 = $this->Common_model->select('seeker', $email, 'email');
            $img = $res1->img;

            $config['upload_path'] = "./uploads/user_pro_pic";
            $config['allowed_types'] = "*";
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('img')) {
                if (!empty($img)) {
                    if ($img != "assets/images/user.svg") {
                        unlink('./' . $img);
                    }
                }
                $d1 = $this->upload->data();
                $d = $d1['file_name'];
                $d2 = 'uploads/user_pro_pic/' . $d;
                $data = array('img' => $d2);
                $res = $this->Common_model->updateData('seeker', $data, $email, 'email');

                $qualification = $this->Common_model->select('qualification');
                $location = $this->Common_model->select('location');
                $area_of_sectors = $this->Common_model->select('area_of_sectors');
                $job_types = $this->Common_model->select('job_types');
                if ($res) {
                    $j_arr = array(
                        'staus' => 'true',
                        'message' => 'Profile pic update',
                        'data' => '',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                } else {

                    $j_arr = array(
                        'staus' => 'false',
                        'message' => 'Profile pic not Update',
                        'data' => '',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                }
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'only jpg and png file Allow',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }
    public function forgot_password()
    {
        /* type emai */
        $name = $this->input->post('type');
        $email = $this->input->post('email');
        $data = $this->input->post();

        if (!empty($name) && !empty($email)) {
            $ps = rand(50000, 100000);
            $ps1 = md5($ps);
            $to_email_address = $email;
            $subject = "";
            $message = "";
            $headers = "";
            $email_info = $this->Common_model->select('jp_setting_email', '1', 'id');
            if ($name == 'seeker') {
                $subject = $email_info->seeker_subject;
                $message = $email_info->seeker_forgot_msg . " " . $ps;
                $headers = 'From:' . $email_info->seeker_email;
            } else if ($name == 'recruiter') {
                $subject = $email_info->seeker_subject;
                $message = $email_info->recruiter_forgot_msg . " " . $ps;
                $headers = 'From:' . $email_info->seeker_email;
            }
            mail($to_email_address, $subject, $message, $headers);

            $data2 = array('ps' => $ps1);
            $r1 = $this->Common_model->updateData($name, $data2, $email, 'email');
            if ($r1) {
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Please check your mail',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'email not exists',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }
    public function search_text()
    {
        $data = $this->input->post('search_txt');

        if (!empty($data)) {

            $res = $this->Common_model->search_text_s('job_post', 'recruiter', 'company', $data, 'job_location', 'qualification', 'technology', 'job_role', 'designation', 'area_of_sector', 'specialization', 'company');
            if ($res) {

                foreach ($res as $my_app_job1) {

                    $r_id = $my_app_job1->r_id;

                    $company = $this->db->query("SELECT company,img FROM  recruiter WHERE  email = '" . $r_id . "'")->row();

                    $my_app_job1->company = $company->company;
                    $my_app_job1->img = $company->img;

                }
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => $res,
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            } else {
                $j_arr = array(
                    'staus' => 'flase',
                    'message' => 'job not found',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function fetch()
    {
        $name = $this->input->post('keyword');
        if (!empty($name)) {
            $res = $this->Common_model->select($name);
            if ($res) {
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => $res,
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'Data Not Found',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    //recruiter profile percent

    function recruiterProfileCompletePercent(){
		// if($user_detail->name)
       $login_user_id = $this->session->userdata['user_id'];
       $user_detail =$this->Common_model->select_data('*', 'recruiter', ['id'=>$login_user_id]);
        // $login_user_id = $this->session;
        
        // die($login_user_id);
		$complete = 0;
		
			$profile_field = ['name','email','mno','org_type','location','address','website','company','img'];
		
		foreach($profile_field as $key => $value){
           
			$complete = (!empty($user_detail[0][$value]) and $user_detail[0][$value] != '' and !is_null($user_detail[0][$value])) ?$complete+1:$complete;
			
		}

		$all_field = count($profile_field);
		$percent = round(($complete*100)/$all_field);
        $j_arr = array(
            'staus' => 'true',
            'message' => 'Profile Completed Percent',
            'data' => $percent,
        );
        $percent = json_encode($j_arr);
        echo $percent;
	}

    function seekerProfileCompletePercent(){
		// if($user_detail->name)
       $login_user_id = $this->session->userdata['user_id'];
       $user_detail =$this->Common_model->select_data('*', 'seeker', ['id'=>$login_user_id]);
        // $login_user_id = $this->session;
        
        // die($login_user_id);
		$complete = 0;
		
			$profile_field = ['name','surname','email','city','mno','gender','excepted','current_address','location','job_type','job_role','designation','qua','keyskills','resume','specialization','age','notice_period','p_year'];
		
		foreach($profile_field as $key => $value){
           
			$complete = (!empty($user_detail[0][$value]) and $user_detail[0][$value] != '' and !is_null($user_detail[0][$value])) ?$complete+1:$complete;
			
		}

		$all_field = count($profile_field);
		$percent = round(($complete*100)/$all_field);
        $j_arr = array(
            'staus' => 'true',
            'message' => 'Profile Completed Percent',
            'data' => $percent,
        );
        $percent = json_encode($j_arr);
        echo $percent;
	}


    public function recruiter_profile_update()
    {

        //email all required field
        $s1 = $this->input->post('email');
        $data = $this->input->post();
        if (empty($_FILES)) {
            if (!empty($data)) {
                $r1 = $this->Common_model->select('recruiter', $s1, 'email');
                $res = $this->Common_model->updateData('recruiter', $data, $s1, 'email');

                if ($res) {
                    $j_arr = array(
                        'staus' => 'true',
                        'message' => 'Success',
                        'data' => 'update',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                } else {
                    $j_arr = array(
                        'staus' => 'flase',
                        'message' => 'not update',
                        'data' => '',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                }
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'post request is empty',
                    'data' => '',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;
            }
        } else {
            $res1 = $this->Common_model->select('recruiter', $s1, 'email');
            $img = $res1->img;
            $config['upload_path'] = "./uploads/user_pro_pic";
            $config['allowed_types'] = "*";

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('img')) {
                if (!empty($img)) {
                    if ($img != "assets/images/user.svg") {
                        unlink('./' . $img);
                    }
                }
                $d1 = $this->upload->data();
                $d = $d1['file_name'];
                $d2 = 'uploads/user_pro_pic/' . $d;
                $data['img'] = $d2;
                $r1 = $this->Common_model->select('recruiter', $s1, 'email');
                $res = $this->Common_model->updateData('recruiter', $data, $s1, 'email');
                if ($res) {
                    $j_arr = array(
                        'staus' => 'true',
                        'message' => 'Success',
                        'data' => 'update',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                } else {
                    $j_arr = array(
                        'staus' => 'flase',
                        'message' => 'not update',
                        'data' => '',
                    );
                    $json_signup = json_encode($j_arr);
                    echo $json_signup;
                }
            } else {
                $j_arr = array(
                    'staus' => 'flase',
                    'message' => 'only jpg and png file allow',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        }

    }
    public function fetch_all_cat()
    {
        $job_count = $this->Common_model->count_num('job_types', 'Active', 'status');
        $location_count = $this->Common_model->count_num('location', 'Active', 'status');
        $qualification_count = $this->Common_model->count_num('qualification', 'Active', 'status');
        $exp_count = $this->Common_model->count_num('experience', 'Active', 'status');
        $desi_count = $this->Common_model->count_num('designation', 'Active', 'status');
        $aofs_count = $this->Common_model->count_num('area_of_sectors', 'Active', 'status');
        $job_r_count = $this->Common_model->count_num('job_role', 'Active', 'status');
        $sp_count = $this->Common_model->count_num('specialization', 'Active', 'status');
        $expectedctc = $this->Common_model->count_num('expectedctc_tbl', 'Active', 'status');
        $currentctc = $this->Common_model->count_num('currentctc_tbl', 'Active', 'status');

        $location = array();
        $job_type = array();
        $qualification = array();
        $exp = array();
        $desi = array();
        $aofs = array();
        $job_r = array();
        $sp = array();
        $expectedctc = array();
        $currentctc = array();

        if ($location_count > 0) {
            $location = $this->Common_model->select('location', 'Active', 'status'); //Left Menu Value
        }
        if ($job_count > 0) {
            $job_type = $this->Common_model->select('job_types', 'Active', 'status'); //Left Menu Value
        }
        if ($qualification_count > 0) {
            $qualification = $this->Common_model->select('qualification', 'Active', 'status'); //Left Menu Value
        }
        if ($exp_count > 0) {
            $exp = $this->Common_model->select('experience', 'Active', 'status'); //Left Menu Value
        }
        if ($desi_count > 0) {
            $desi = $this->Common_model->select('designation', 'Active', 'status'); //Left Menu Value
        }
        if ($aofs_count > 0) {
            $aofs = $this->Common_model->select('area_of_sectors', 'Active', 'status'); //Left Menu Value
        }
        if ($job_r_count > 0) {
            $job_r = $this->Common_model->select('job_role', 'Active', 'status'); //Left Menu Value
        }
        if ($sp > 0) {
            $sp = $this->Common_model->select('specialization', 'Active', 'status'); //Left Menu Value
        }
        if ($expectedctc > 0) {
            $expectedctc = $this->Common_model->select('expectedctc_tbl', 'Active', 'status'); //Left Menu Value
        }
        if ($currentctc > 0) {
            $currentctc = $this->Common_model->select('currentctc_tbl', 'Active', 'status'); //Left Menu Value
        }
        $all_cat = array('location' => $location,
            'job_type' => $job_type,
            'qualification' => $qualification,
            'exp' => $exp,
            'desi' => $desi,
            'area_of_s' => $aofs,
            'job_role' => $job_r,
            'specialization' => $sp,
            'expectedctc' => $expectedctc,
            'currentctc' => $currentctc,
        );
        $j_arr = array(
            'staus' => 'true',
            'message' => 'Success',
            'data' => $all_cat,
        );
        $json_signup = json_encode($j_arr);
        echo $json_signup;
    }
    public function applay_job()
    {

        $data = [
            'job_id' => $_POST['job_id'],
            's_email' => $_POST['s_email'],
            'r_id' => $_POST['r_id'],
        ];
        // $data = escape_array($data);

        // print_r($data);die;
        $this->db->insert('jp_applay_job', $data);

        // print_r($this->db->last_query());die;
        $this->response['error'] = false;
        $this->response['message'] = 'Apply Successfully';
        // $this->response['data'] = array();
        print_r(json_encode($this->response));

    }

    public function left_filter()
    {
        $data = $this->input->post();
        $str = "";
        $d1 = $data['keyword'];
        $job_jt_q = '';
        $job_loc_q = '';
        $job_desi_q = '';
        $job_qua_q = '';
        $job_exp_q = '';
        $job_data = '';
        //print_r($d1);
        $d1 = json_decode($data['keyword']);
        $job_type1 = $d1->job_type;
        $job_location1 = $d1->job_location;
        $qualification1 = $d1->qualification;
        $experience1 = $d1->experience;
        $job_by_roles1 = $d1->job_by_roles;
        $specialization1 = $d1->specialization;

        $str = $str . implode(",", $job_type1);
        $str = $str . ',' . implode(",", $job_location1);
        $str = $str . ',' . implode(",", $qualification1);
        $str = $str . ',' . implode(",", $experience1);
        $str = $str . ',' . implode(",", $job_by_roles1);
        $str = $str . ',' . implode(",", $specialization1);

        $s1 = explode(",", $str);
        for ($i = 0; $i < sizeof($s1); $i++) {
            $exp = explode('_', $s1[$i]);
            $e1 = "";
            $data = "";
            if (sizeof($exp) == 2) {
                $e1 = $exp[1];
                $data = $exp[0];
                sizeof($exp);
            }
            if ($e1 == 'jt') {
                if ($job_jt_q == '') {
                    $job_jt_q .= " job_type  = '$data'";
                } else {
                    $job_jt_q .= "OR job_type = '$data'";
                    $job_jt_q = '(' . $job_jt_q . ')';
                }

            }

            if ($e1 == 'loc') {
                if ($job_loc_q == '') {
                    $job_loc_q .= " job_location = '$data'";
                } else {
                    $job_loc_q .= "OR job_location  = '$data'";
                    $job_loc_q = '(' . $job_loc_q . ')';
                }

            }
            if ($e1 == 'desi') {
                if ($job_desi_q == '') {
                    $job_desi_q .= "designation  = '$data'";
                } else {
                    $job_desi_q .= " OR designation  = '$data'";
                    $job_desi_q = '(' . $job_desi_q . ')';
                }

            }

            if ($e1 == 'qua') {
                if ($job_qua_q == '') {
                    $job_qua_q .= "qualification  = '$data'";
                } else {
                    $job_qua_q .= "OR qualification = '$data'";
                    $job_qua_q = '(' . $job_qua_q . ')';
                }

            }
            if ($e1 == 'exp') {
                if ($job_exp_q == '') {
                    $job_exp_q .= "exp  = '$data'";
                } else {
                    $job_exp_q .= " OR exp  = '$data'";
                    $job_exp_q = '(' . $job_exp_q . ')';
                }

            }
            if ($e1 == 'sp') {
                if ($job_sp_q == '') {
                    $job_sp_q .= " specialization  = '$data'";
                } else {
                    $job_sp_q .= "OR specialization = '$data'";
                    $job_sp_q = '(' . $job_sp_q . ')';
                }

            }
        }
        if ($job_jt_q != '') {
            $job_data = $job_jt_q;
        }
        if ($job_loc_q != '') {
            $job_data = $job_loc_q;
        }
        if ($job_desi_q != '') {
            $job_data = $job_desi_q;
        }
        if ($job_qua_q != '') {
            $job_data = $job_qua_q;
        }
        if ($job_exp_q != '') {
            $job_data = $job_exp_q;
        }
        if ($job_sp_q != '') {
            $job_data = $job_sp_q;
        }

        if ($job_jt_q != '' && $job_loc_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_loc_q;
        }
        if ($job_jt_q != '' && $job_desi_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_desi_q;
        }
        if ($job_jt_q != '' && $job_qua_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_qua_q;
        }
        if ($job_jt_q != '' && $job_exp_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_exp_q;
        }
        if ($job_loc_q != '' && $job_desi_q != '') {
            $job_data = $job_loc_q . ' AND ' . $job_desi_q;
        }
        if ($job_loc_q != '' && $job_qua_q != '') {
            $job_data = $job_loc_q . ' AND ' . $job_qua_q;
        }
        if ($job_loc_q != '' && $job_exp_q != '') {
            $job_data = $job_loc_q . ' AND ' . $job_exp_q;
        }
        if ($job_desi_q != '' && $job_qua_q != '') {
            $job_data = $job_desi_q . ' AND ' . $job_qua_q;
        }
        if ($job_desi_q != '' && $job_exp_q != '') {
            $job_data = $job_desi_q . ' AND ' . $job_exp_q;
        }

        if ($job_exp_q != '' && $job_sp_q != '') {
            $job_data = $job_exp_q . ' AND ' . $job_sp_q;
        }

        if ($job_desi_q != '' && $job_sp_q != '') {
            $job_data = $job_desi_q . ' AND ' . $job_sp_q;
        }

        if ($job_loc_q != '' && $job_sp_q != '') {
            $job_data = $job_loc_q . ' AND ' . $job_sp_q;
        }

        if ($job_jt_q != '' && $job_sp_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_sp_q;
        }

        if ($job_jt_q != '' && $job_loc_q != '' && $job_desi_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_loc_q . " AND " . $job_desi_q;
        }
        if ($job_desi_q != '' && $job_qua_q != '' && $job_exp_q != '') {
            $job_data = $job_desi_q . ' AND ' . $job_qua_q . " AND " . $job_exp_q;
        }

        if ($job_jt_q != '' && $job_loc_q != '' && $job_qua_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_loc_q . " AND " . $job_qua_q;
        }
        if ($job_jt_q != '' && $job_loc_q != '' && $job_exp_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_loc_q . " AND " . $job_exp_q;
        }

        if ($job_sp_q != '' && $job_qua_q != '' && $job_exp_q != '') {
            $job_data = $job_sp_q . ' AND ' . $job_qua_q . " AND " . $job_exp_q;
        }
        if ($job_jt_q != '' && $job_loc_q != '' && $job_sp_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_loc_q . " AND " . $job_sp_q;
        }

        if ($job_jt_q != '' && $job_loc_q != '' && $job_exp_q != '' && $job_desi_q != '' && $job_sp_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_loc_q . " AND " . $job_exp_q . " AND " . $job_desi_q . "AND " . $job_sp_q;
        }
        if ($job_jt_q != '' && $job_loc_q != '' && $job_desi_q != '' && $job_exp_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_loc_q . " AND " . $job_desi_q . " AND " . $job_exp_q;
        }

        if ($job_loc_q != '' && $job_desi_q != '' && $job_qua_q != '' && $job_exp_q != '' && $job_sp_q != '') {
            $job_data = $job_loc_q . ' AND ' . $job_desi_q . " AND " . $job_qua_q . " AND " . $job_exp_q . "AND " . $job_sp_q;
        }

        if ($job_jt_q != '' && $job_loc_q != ' ' && $job_desi_q != '' && $job_qua_q != '' && $job_exp_q != '' && $job_sp_q != '') {
            $job_data = $job_jt_q . ' AND ' . $job_loc_q . " AND " . $job_exp_q . " AND " . $job_desi_q . " AND " . $job_qua_q . "AND " . $job_sp_q;
        }
        $res = $this->Common_model->l_f1($job_data);

        if (!empty($res)) {
            foreach ($res as $my_app_job1) {
                $s_email = $my_app_job1->r_id;
                $company = $this->db->query("SELECT company,img FROM  recruiter WHERE  email = '" . $s_email . "'")->row();
                // print_r($job_info);die;
                $my_app_job1->company = $company->company;
                $my_app_job1->img = $company->img;
            }
        }
        // echo "<pre>";print_r($res);die;
        if ($res) {
            if ($res) {
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => $res,
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            } else {
                $j_arr = array(
                    'staus' => 'false',
                    'message' => 'data not found',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        }

    }
    public function language()
    {
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        $language = $res->language;
        $data = $this->Common_model->language_change('jp_language', $language, 'language_key');

        $arr = array();
        foreach ($data as $d1) {
            $arr[$d1->language_key] = $d1->$language;
        }
        $j_arr = array(
            'staus' => 'true',
            'message' => 'Success',
            'data' => $arr,
        );
        //$json_signup=json_encode($j_arr);
        //echo $json_signup;
        echo str_replace('null', '"0"', json_encode($j_arr));
    }
    public function send_notification($tokens, $message)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $tokens,
            'notification' => $message,
        );

        $headers = array(
            'Authorization:key =AIzaSyBO6mT5A6E21y7524xYmypmbAgOwVhJkG0',
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
    public function push($name, $desi)
    {
        $res = $this->Common_model->select('seeker');
        $tokens = array();
        foreach ($res as $r1) {
            $backup = $r1->token;
            if (!empty($backup)) {
                $tokens[] = $backup;
            }

        }
        /*$tokens="dDrGVz_m4-g:APA91bG7H2oIHnMiIlcF_C5qc9vtrqkZBxLCcMh2PsvkviUun9iTV_bTYgSmC62MwMQehmv6U3PrA79ZdHbT54Te_Oq3HKXYcoWv7bHUOTQqHOV49M7FaHu1lfkIBVtVpVuQsKuWQAt9";*/
        $message = array("body" => $desi,
            "title" => $name,
        );
        $message_status = $this->send_notification($tokens, $message);
    }
    public function payu_success()
    {
        $p_id = $this->input->post('id');
        if (isset($_POST['mihpayid'])) {
            $email = $this->input->post('email');
            //$ps= $this->session->userdata('pay_sessiion2');

            $p_info = $this->Common_model->select('jp_plans', $p_id, 'id');
            $p_infi_plane = $p_info->name;
            $p_infi_month = $p_info->duration;
            $d1 = date('Y/m/d');
            $arr = array('pay' => 'yes',
                'pay_date' => $d1,
                'plan' => $p_infi_plane,
                'month' => $p_infi_month,
                'show_on_reg' => 'yes',
            );
            $res = $this->Common_model->updateData('recruiter', $arr, $email, 'email');

            $mihpayid = $_POST['mihpayid'];
            $mode = $_POST['mode'];
            $status = $_POST['status'];
            $amount = $_POST['amount'];
            $arr = array('pay_id' => $mihpayid,
                'mode' => $mode,
                'status' => $status,
                'amount' => $amount,
                'email' => $email,
            );
            $res = $this->Common_model->insert('jp_payu', $arr);
            // echo "<Pre>";print_r($this->db->last_query());die;
            if ($res) {
                $this->session->set_flashdata('msg', 'Update');
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => 'pay Success',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            } else {
                $j_arr = array(
                    'staus' => 'cancel',
                    'message' => 'payment failed',
                    'data' => $res,
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        } else {
            $j_arr = array(
                'staus' => 'flase',
                'message' => 'post request not found',
                'data' => $res,
            );
            $json_signup = json_encode($j_arr);
            echo $json_signup;
        }
    }
    public function payu_cancel()
    {
        echo 'cancel';
        /*$j_arr=array(
    'staus'=>'flase',
    'message'=>'Payment Cancel',
    'data'=>$res,
    );
    $json_signup=json_encode($j_arr);
    echo $json_signup;*/
    }

    public function language_fatch_v($page_name)
    {
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        $language = $res->language;
        $data = $this->Common_model->language_change('jp_language', $language, 'language_key', $page_name, 'language_type');
        $data1 = $this->Common_model->language_change('jp_language', $language, 'language_key', 'menu_header', 'language_type');
        $this->default_languag_v = $language;
        $this->language_data_a_v = $data;
        $this->user_header1_v = $data1;
    }

    public function plans()
    {
        $plan_info = $this->Common_model->select('jp_plans', 'Active', 'status');
        if ($plan_info) {
            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => $plan_info,

            );            
        } else {
            $j_arr = array(
                'staus' => 'flase',
                'message' => 'datanot found',
                'data' => '',
            );
        }
        $json_signup = json_encode($j_arr);
        echo $json_signup;
        exit;
    }
    public function paypal_cancel()
    {
        $this->load->view('cancel');
    }
    public function paypal_Success()
    {
        $data = $this->input->post();
        $email = $this->input->post('email');
        $p_id = $this->input->post('p_id');
        $paypal = $this->session->userdata('paypal');
        unset($data['email']);
        unset($data['p_id']);
        unset($data['p_id']);
        if (isset($email)) {
            $this->Common_model->updateData('recruiter', $data, $email, 'email');
            $p_info = $this->Common_model->select('jp_plans', $p_id, 'id');
            $p_infi_plane = $p_info->name;
            $p_infi_month = $p_info->duration;
            $d1 = date('Y/m/d');
            $arr = array('pay' => 'yes',
                'pay_date' => $d1,
                'plan' => $p_infi_plane,
                'month' => $p_infi_month,
                'show_on_reg' => 'yes',
            );
            $res = $this->Common_model->updateData('recruiter', $arr, $email, 'email');
            if ($res) {
                $j_arr = array(
                    'staus' => 'Success',
                    'message' => 'payment Success',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            } else {
                $j_arr = array(
                    'staus' => 'cancel',
                    'message' => 'payment failed',
                    'data' => '',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        } else {
            $j_arr = array(
                'staus' => 'cancel',
                'message' => 'post request not found',
                'data' => '',
            );
            $json_signup = json_encode($j_arr);
            echo $json_signup;
        }

    }
    public function paypal_notify()
    {
        if (isset($_POST['payer_id'])) {
            $pd = $_POST['item_name'];
            $custom = $_POST['custom'];
            $payment_type = $_POST['payment_type'];
            $status = $_POST['payment_status'];
            $pay_amount = $_POST['mc_gross'];
            $arr = array('p_id' => $pd,
                'custom' => $custom,
                'payment_type' => $payment_type,
                'status' => $status,
                'pay_amount' => $pay_amount,
                'c1' => '1',
            );
            $this->Common_model->insert('jp_payment', $arr);
        } else {
            redirect('/');
        }
    }

    public function getNotification()
    {

        $_id = $this->input->post('id');
        $type = $this->input->post('type');

        if ($type == 'seeker') {
            $id = $_id;
            $res = $this->db->query("SELECT * FROM seeker WHERE id = '" . $id . "' ORDER BY id  DESC")->result();
            if (empty($res)) {
                echo json_encode(array(
                    'staus' => false,
                    'message' => 'Not Found',
                    'data' => [],
                ));
                die();
            }

            $date = $res[0]->insert_date;
        } elseif ($type == 'recruiter') {
            $id = $_id;
            $res = $this->db->query("SELECT * FROM recruiter WHERE id = '" . $id . "' ORDER BY id  DESC  ")->result();
            if (empty($res)) {
                echo json_encode(array(
                    'staus' => false,
                    'message' => 'Not Found',
                    'data' => [],
                ));
                die();
            }
            $date = $res[0]->insert_date;
            // echo "<pre>",print_r($res);
            // die();
        } else {
            $j_arr = array(
                'staus' => false,
                'message' => 'Not Found',
                'data' => [],
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
            die();
        }

        $res = $this->db->query("SELECT * FROM jp_notification WHERE notification_type = '$type' AND CAST(insert_date AS Datetime) >= '$date'  ORDER BY id  DESC ")->result();

        // print_r($this->db->last_query());die;
        $j_arr = array(
            'staus' => true,
            'message' => 'Success',
            'data' => $res,
        );
        $json_single_job = json_encode($j_arr);
        echo $json_single_job;

    }

    public function all_recruiter()
    {

        $s_data = $this->Common_model->select('recruiter');

        $q = $this->db->select('*')->from('recruiter')->where('status', 'Active')->get();

        $qres = $q->result();

        if (!empty($qres)) {

            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => $qres,
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'data_not_found',

            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }

    }

    public function all_seeker()
    {

        $s_data = $this->Common_model->select('seeker');
        if (!empty($s_data)) {
            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => $s_data,
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'data_not_found',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }

    }

// function getnewPage()
    // {
    //     $plan_info=$this->Common_model->select('jp_setting');
    //     echo "<pre>";print_r($plan_info);die;
    //     $plan_info->    terms_condition
    //     if($plan_info)fetch_all_cat
    //     {
    //                 $j_arr=array(
    //                                         'staus'=>'true',
    //                                         'message'=>'Success',
    //                                         'data'=>$plan_info,
    //                                         );
    //                                         $json_signup=json_encode($j_arr);
    //                                         echo $json_signup;
    //     }
    //     else
    //     {
    //             $j_arr=array(
    //                                         'staus'=>'flase',
    //                                         'message'=>'datanot found',
    //                                         'data'=>'',
    //                                         );
    //                                         $json_signup=json_encode($j_arr);
    //                                         echo $json_signup;
    //     }
    // }

    public function SocialLogin_post()
    {
        $first_name = strip_tags($this->post('name'));
        $email = strip_tags($this->post('email'));
        $social = strip_tags($this->post('social'));
        $facebookID = strip_tags($this->post('facebookID'));
        if (!empty($social)) {

            $userData = array(
                'firstname' => $first_name,
                'user_email' => ($email) ? $email : "",
                'social' => ($social) ? $social : "",
                'status' => 1,
                'facebookID' => ($facebookID) ? $facebookID : "",
            );

            if ($this->user->checkEmailAvailable($userData['user_email'])) {
                $query = $this->db->query("SELECT * FROM registers where user_email='" . $email . "'");
                $row = $query->row();
                $this->response([
                    'status' => true,
                    'data' => $row,
                    'message' => 'login Successfully.',
                ], REST_Controller::HTTP_OK);
            } else {

                $insert = $this->user->insert($userData);
                $query = $this->db->query("SELECT * FROM registers where facebookID='" . $facebookID . "'");
                $row = $query->row();

                if (!$insert['status']) {
                    $this->response([
                        'status' => true,
                        'message' => 'Login Successfully ',
                        'data' => $row,
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Unable to add',
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }

        } else {
            $this->response([
                'status' => false,
                'message' => 'Provide proper information ',
            ], REST_Controller::HTTP_OK);
        }

    }

    public function googleLogin()
    {

        $name = $this->input->post('type');
        $token = $this->input->post('token');
        $email = $this->input->post('email');
        $username = $this->input->post('name');
        $google_id = $this->input->post('google_id');
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        if (!empty($name) && !empty($email)) {
            $email = $this->input->post('email');

            $q = $this->Common_model->GooleLogin($email, $name);

            if (empty($q)) {

                $arrayName = array(
                    'name' => $username,
                    'email' => $email,
                    'google_id' => $google_id,
                );
                if ($name != 'recruiter') {
                    $arrayName['token'] = $token;
                }

                $this->db->insert($name, $arrayName);
                //print_r($this->db->last_query());die;
            }

            $q = $this->db->select('*')->from($name)->where('email', $email)->get();
            // print_r($q->row());die;
            $q = $q->row();
            $mno = $q->mno;

            if ($name == 'recruiter') {
                $q->ps = "r";
                $rec_info = $this->Common_model->select('recruiter', $email, 'email');
                $plan = $rec_info->show_on_reg;
                if ($plan == 'no') {
                    // if($q->veri!="yes")
                    // {
                    //     $j_arr=array(
                    //         'staus'=>'false',
                    //         'message'=>'please verify your email address',
                    //         'data'=>'',
                    //        );
                    //     $json_single_job=json_encode($j_arr);
                    //           echo $json_single_job;
                    // }
                    // else
                    //  if($q->status!='Active')
                    // {
                    //     $j_arr=array(
                    //         'staus'=>'false',
                    //         'message'=>'Account Disabled',
                    //         'data'=>'',
                    //        );
                    //  $json_single_job=json_encode($j_arr);
                    //           echo $json_single_job;
                    // }
                    // else
                    {
                        //$this->session->set_userdata($name,$email);
                        // $q=$this->db->select('*')->from($name)->where('email',$email)->get();
                        // $q->result();
                        $j_arr = array(
                            'staus' => 'true',
                            'message' => 'Success',
                            'base_url' => base_url(),
                            'admob' => '',
                            'data' => $q,
                        );
                        // $json_single_job=json_encode($j_arr);
                        //echo $json_single_job;
                        echo str_replace('null', '"0"', json_encode($j_arr));

                    }
                } else {
                    $pay = $rec_info->pay;
                    if ($pay == 'yes') {
                        // if($q->veri!="yes")
                        // {
                        //     $j_arr=array(
                        //         'staus'=>'false',
                        //         'message'=>'please verify your email address',
                        //         'data'=>'',
                        //        );
                        //     $json_single_job=json_encode($j_arr);
                        //                    echo $json_single_job;
                        // }
                        // else
                        //     if($q->status!='Active')
                        // {
                        //     $j_arr=array(
                        //         'staus'=>'false',
                        //         'message'=>'Account Disabled',
                        //         'data'=>'',
                        //        );
                        //     $json_single_job=json_encode($j_arr);
                        //                    echo $json_single_job;
                        // }
                        // else
                        // {
                        //$this->session->set_userdata($name,$email);
                        // $q=$this->db->select('*')->from($name)->where('email',$email)->get();

                        $j_arr = array(
                            'staus' => 'true',
                            'message' => 'Success',
                            'base_url' => base_url(),
                            'admob' => '',
                            'data' => $q,
                        );
                        //$json_single_job=json_encode($j_arr);
                        //echo $json_single_job;
                        echo str_replace('null', '"0"', json_encode($j_arr));
                        // }
                    } else if ($pay == 'no') {
                        $data = array('mobile no' => $mno,
                            'email' => $email,
                        );
                        $j_arr = array(
                            'staus' => 'true',
                            'message' => 'please pay',
                            'base_url' => base_url(),
                            'admob' => '',
                            'data' => $q,
                        );
                        //$json_single_job=json_encode($j_arr);
                        //echo $json_single_job;
                        echo str_replace('null', '"0"', json_encode($j_arr));

                    } else {
                        $j_arr = array(
                            'staus' => 'false',
                            'message' => 'Wrong User',
                            'data' => '',
                        );
                        $json_single_job = json_encode($j_arr);
                        echo $json_single_job;
                    }
                }
            } else {
                $tokrn_arr = array('token' => $token);
                $this->Common_model->updateData('seeker', $tokrn_arr, $email, 'email');
                //  if($q->veri!="yes")
                //  {
                //     $j_arr=array(
                //         'staus'=>'false',
                //         'message'=>'please verify your email address',
                //         'data'=>'',
                //        );
                //        $json_single_job=json_encode($j_arr);
                //                 echo $json_single_job;
                //  }
                // else
                //  if($q->status!='Active')
                // {
                //     $j_arr=array(
                //         'staus'=>'false',
                //         'message'=>'Account Disabled',
                //         'data'=>'',
                //        );
                //     $json_single_job=json_encode($j_arr);
                //              echo $json_single_job;
                // }
                // else
                // {
                //$this->session->set_userdata($name,$email);
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'base_url' => base_url(),
                    'admob' => $res->add_mob_s,
                    'data' => $q,
                );
                //$json_single_job=json_encode($j_arr);
                //echo $json_single_job;
                echo str_replace('null', '"0"', json_encode($j_arr));
                // }
            }

        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }

    }

    public function delete_job()
    {
        $job_id = $this->input->post('job_id');
        $recruiter_id = $this->input->post('recruiter_id');

        if (!empty($job_id) && !empty($recruiter_id)) {
            $this->db->delete('job_post', array('id' => $job_id, 'r_id' => $recruiter_id));

            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function Success_payment()
    {
        if (isset($_POST['mihpayid'])) {
            $email = $this->input->post('email');
            //$ps= $this->session->userdata('pay_sessiion2');
            $p_info = $this->Common_model->select('jp_revenue');
            $p_infi_plane = '';
            $p_infi_type = '';
            $p_infi_month = '';
            foreach ($p_info as $p1) {
                $p_infi_plane = $p1->condation;
                $p_infi_type = $p1->type;
                $p_infi_month = $p1->month;
            }
            $d1 = date('Y/m/d');
            $arr = array('pay' => 'yes',
                'pay_date' => $d1,
                'plan' => $p_infi_plane,
                'type' => $p_infi_type,
                'month' => $p_infi_month,
                'show_on_reg' => 'yes',
            );
            $res = $this->Common_model->updateData('recruiter', $arr, $email, 'email');

            $mihpayid = $_POST['mihpayid'];
            $mode = $_POST['mode'];
            $status = $_POST['status'];
            $amount = $_POST['amount'];
            $d1 = $_POST['date'];
            $arr = array(
                'p_id' => $mihpayid,
                'payment_type' => $mode,
                'status' => $status,
                'pay_amount' => $amount,
                'source' => 'Payumoney',
                'pay_date' => $d1,
                'email' => $email,
            );
            $res = $this->Common_model->insert('jp_payment', $arr);
            if ($res) {
                $this->session->set_flashdata('msg', 'Update');
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                    'data' => 'pay Success',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            } else {
                $j_arr = array(
                    'staus' => 'cancel',
                    'message' => 'payment failed',
                    'data' => $res,
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;
            }
        } else {
            $j_arr = array(
                'staus' => 'flase',
                'message' => 'post request not found',
                'data' => $res,
            );
            $json_signup = json_encode($j_arr);
            echo $json_signup;
        }
    }

    public function get_url()
    {
        $post_id = $this->input->post('post_id');
        // print_r($id);die;
        if (!empty($post_id)) {
            $setting_info = $this->Common_model->select('job_post', $post_id, 'id');

            if ($setting_info) {

                $id = $setting_info->id;

            }
            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'url' => 'https://alphawizztest.tk/jobportal/home/mypost/' . $id . '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function company_post()
    {
        $email = $this->input->post('email');
        //print_r($email);die;
        // print_r($id);die;
        if (!empty($email)) {
            $setting_info = $this->Common_model->get_all_data($email);
            //print_r($this->db->last_query());die;

            if ($setting_info) {

                $id = $setting_info->id;

            }
            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => $setting_info,
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function job_data_post()
    {
        $id = $this->input->post('id');
        //print_r($id);die;
        // print_r($id);die;
        if (!empty($id)) {
            $setting_info = $this->Common_model->get_job_data($id);
            //print_r($this->db->last_query());die;

            if ($setting_info) {

                $id = $setting_info->id;

            }
            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => $setting_info,
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function check_plan_new()
    {
        $r_id = $this->input->post('r_id');

        if (!empty($r_id)) {
            $recruiter = $this->Common_model->select('recruiter', $r_id, 'id');
            // print_r($setting_info);die;
            if ($recruiter->pay == 'yes') {
                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'Success',
                );
                $json_single_job = json_encode($j_arr);
                echo $json_single_job;

            } else {

                $j_arr = array(
                    'staus' => 'true',
                    'message' => 'please pay',
                );
                $json_signup = json_encode($j_arr);
                echo $json_signup;

            }

        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'post request is empty',
                'data' => '',
            );
            $json_single_job = json_encode($j_arr);
            echo $json_single_job;
        }
    }

    public function search_candidate_filter()
    {
        $data = $this->input->post();
        $str = "";
        $d1 = $data['keyword'];

        $job_jt_q = '';
        $job_loc_q = '';
        $job_desi_q = '';
        $job_qua_q = '';
        $job_exp_q = '';
        $job_sp_q = '';
        $job_data = '';

        $d1 = json_decode($data['keyword']);

        $job_type1 = $d1->job_type;
        $job_location1 = $d1->job_location;
        $job_roles1 = $d1->job_by_roles;
        $qualification1 = $d1->qualification;
        $experience1 = $d1->experience;
        $designation1 = $d1->designation;
        $specialization1 = $d1->specialization;

        $str = $str . implode(",", $job_type1);
        $str = $str . ',' . implode(",", $job_location1);
        $str = $str . ',' . implode(",", $qualification1);
        $str = $str . ',' . implode(",", $experience1);
        $str = $str . ',' . implode(",", $job_roles1);
        $str = $str . ',' . implode(",", $designation1);
        $str = $str . ',' . implode(",", $specialization1);

        $s1 = explode(",", $str);

        for ($i = 0; $i < sizeof($s1); $i++) {

            $exp = explode('_', $s1[$i]);
            $e1 = "";
            $data = "";
            if (sizeof($exp) == 2) {
                $e1 = $exp[1];
                $data = $exp[0];
                sizeof($exp);
            }
            if ($e1 == 'jt') {
                if ($job_jt_q == '') {
                    $job_jt_q .= " `job_type` LIKE '%" . $data . "%'  ";
                } else {
                    $job_jt_q .= "OR `job_type` LIKE '%" . $data . "%'  ";
                    $job_jt_q = '(' . $job_jt_q . ')';
                }

            }

            if ($e1 == 'jr') {
                if ($job_jr_q == '') {
                    $job_jr_q .= " `job_role` LIKE '%" . $data . "%'  ";
                } else {
                    $job_jr_q .= "OR `job_role` LIKE '%" . $data . "%' ";
                    $job_jr_q = '(' . $job_jr_q . ')';
                }

            }

            if ($e1 == 'loc') {
                if ($job_loc_q == '') {
                    $job_loc_q .= " `location` LIKE '%" . $data . "%' ";
                } else {
                    $job_loc_q .= "OR `location` LIKE '%" . $data . "%'";
                    $job_loc_q = '(' . $job_loc_q . ')';
                }

            }
            if ($e1 == 'desi') {
                if ($job_desi_q == '') {
                    $job_desi_q .= " `designation` LIKE '%" . $data . "%'  ";
                } else {
                    $job_desi_q .= " OR  `designation` LIKE '%" . $data . "%'";
                    $job_desi_q = '(' . $job_desi_q . ')';
                }

            }

            if ($e1 == 'qua') {
                if ($job_qua_q == '') {
                    $job_qua_q .= "`qua` LIKE '%" . $data . "%'  ";
                } else {
                    $job_qua_q .= "OR `qua` LIKE '%" . $data . "%' ";
                    $job_qua_q = '(' . $job_qua_q . ')';
                }

            }
            if ($e1 == 'exp') {
                if ($job_exp_q == '') {
                    $job_exp_q .= " `exp` LIKE '%" . $data . "%' ";
                } else {
                    $job_exp_q .= " OR `exp` LIKE '%" . $data . "%' ";
                    $job_exp_q = '(' . $job_exp_q . ')';
                }

            }

            if ($e1 == 'sp') {
                if ($job_sp_q == '') {
                    $job_sp_q .= "  `specialization` LIKE '%" . $data . "%'  ";
                } else {
                    $job_sp_q .= " OR `specialization` LIKE '%" . $data . "%'";
                    $job_sp_q = '(' . $job_sp_q . ')';
                }

            }
        }

        if ($job_jt_q != '') {
            $job_data = $job_jt_q;
        }

        if ($job_jr_q != '') {
            $job_data = $job_jr_q;
        }

        if ($job_loc_q != '') {
            $job_data = $job_loc_q;
        }
        if ($job_desi_q != '') {
            $job_data = $job_desi_q;
        }
        if ($job_qua_q != '') {
            $job_data = $job_qua_q;
        }
        if ($job_exp_q != '') {
            $job_data = $job_exp_q;
        }

        if ($job_sp_q != '') {
            $job_data = $job_sp_q;
        }

        if ($job_sp_q != '' && $job_jt_q != '') {
            $job_data = $job_sp_q . ' OR ' . $job_jt_q;
        }

        if ($job_sp_q != '' && $job_loc_q != '') {
            $job_data = $job_sp_q . ' OR ' . $job_loc_q;
        }

        if ($job_sp_q != '' && $job_desi_q != '') {
            $job_data = $job_sp_q . ' OR ' . $job_desi_q;
        }

        if ($job_sp_q != '' && $job_qua_q != '') {
            $job_data = $job_sp_q . ' OR ' . $job_qua_q;
        }

        if ($job_sp_q != '' && $job_exp_q != '') {
            $job_data = $job_sp_q . ' OR ' . $job_exp_q;
        }

        if ($job_jr_q != '' && $job_jt_q != '') {
            $job_data = $job_jr_q . ' OR ' . $job_jt_q;
        }

        if ($job_jr_q != '' && $job_loc_q != '') {
            $job_data = $job_jr_q . ' OR ' . $job_loc_q;
        }

        if ($job_jr_q != '' && $job_desi_q != '') {
            $job_data = $job_jr_q . ' OR ' . $job_desi_q;
        }

        if ($job_jr_q != '' && $job_qua_q != '') {
            $job_data = $job_jr_q . ' OR ' . $job_qua_q;
        }

        if ($job_jr_q != '' && $job_exp_q != '') {
            $job_data = $job_jr_q . ' OR ' . $job_exp_q;
        }

        if ($job_jt_q != '' && $job_loc_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_loc_q;
        }
        if ($job_jt_q != '' && $job_desi_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_desi_q;
        }
        if ($job_jt_q != '' && $job_qua_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_qua_q;
        }
        if ($job_jt_q != '' && $job_exp_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_exp_q;
        }
        if ($job_loc_q != '' && $job_desi_q != '') {
            $job_data = $job_loc_q . ' OR ' . $job_desi_q;
        }
        if ($job_loc_q != '' && $job_qua_q != '') {
            $job_data = $job_loc_q . ' OR ' . $job_qua_q;
        }
        if ($job_loc_q != '' && $job_exp_q != '') {
            $job_data = $job_loc_q . ' OR ' . $job_exp_q;
        }
        if ($job_desi_q != '' && $job_qua_q != '') {
            $job_data = $job_desi_q . ' OR ' . $job_qua_q;
        }
        if ($job_desi_q != '' && $job_exp_q != '') {
            $job_data = $job_desi_q . ' OR ' . $job_exp_q;
        }

        if ($job_jt_q != '' && $job_loc_q != '' && $job_desi_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_loc_q . " OR " . $job_desi_q;
        }
        if ($job_desi_q != '' && $job_qua_q != '' && $job_exp_q != '') {
            $job_data = $job_desi_q . ' OR ' . $job_qua_q . " OR " . $job_exp_q;
        }
        if ($job_jt_q != '' && $job_loc_q != '' && $job_qua_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_loc_q . " OR " . $job_qua_q;
        }
        if ($job_jt_q != '' && $job_loc_q != '' && $job_exp_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_loc_q . " OR " . $job_exp_q;
        }

        if ($job_jr_q != '' && $job_loc_q != '' && $job_exp_q != '') {
            $job_data = $job_jr_q . ' OR ' . $job_loc_q . " OR " . $job_exp_q;
        }

        if ($job_jr_q != '' && $job_jt_q != '' && $job_desi_q != '') {
            $job_data = $job_jr_q . ' OR ' . $job_jt_q . " OR " . $job_desi_q;
        }

        if ($job_jt_q != '' && $job_loc_q != '' && $job_exp_q != '' && $job_desi_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_loc_q . " OR " . $job_exp_q . " OR " . $job_desi_q;
        }
        if ($job_jt_q != '' && $job_loc_q != '' && $job_desi_q != '' && $job_exp_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_loc_q . " OR " . $job_desi_q . " OR " . $job_exp_q;
        }
        if ($job_loc_q != '' && $job_desi_q != '' && $job_qua_q != '' && $job_exp_q != '') {
            $job_data = $job_loc_q . ' OR ' . $job_desi_q . " OR " . $job_qua_q . " OR " . $job_exp_q;
        }

        if ($job_jr_q != '' && $job_desi_q != '' && $job_qua_q != '' && $job_exp_q != '') {
            $job_data = $job_jr_q . ' OR ' . $job_desi_q . " OR " . $job_qua_q . " OR " . $job_exp_q;
        }

        if ($job_jr_q != '' && $job_jt_q != '' && $job_desi_q != '' && $job_exp_q != '') {
            $job_data = $job_jr_q . ' OR ' . $job_jt_q . " OR " . $job_desi_q . " OR " . $job_exp_q;
        }

        if ($job_sp_q != '' && $job_desi_q != '' && $job_qua_q != '' && $job_exp_q != '') {
            $job_data = $job_sp_q . ' OR ' . $job_desi_q . " OR " . $job_qua_q . " OR " . $job_exp_q;
        }

        if ($job_sp_q != '' && $job_jt_q != '' && $job_desi_q != '' && $job_exp_q != '') {
            $job_data = $job_sp_q . ' OR ' . $job_jt_q . " OR " . $job_desi_q . " OR " . $job_exp_q;
        }

        if ($job_jt_q != '' && $job_loc_q != ' ' && $job_desi_q != '' && $job_qua_q != '' && $job_exp_q != '' && $job_jr_q != '' && $job_sp_q != '') {
            $job_data = $job_jt_q . ' OR ' . $job_loc_q . " OR " . $job_exp_q . " OR " . $job_desi_q . " OR " . $job_qua_q . " OR " . $job_jr_q . " OR " . $job_sp_q;
        }

        // print_r($job_data);die;
        $res = $this->Common_model->l_f12($job_data);
        //print_r($this->db->last_query());die;

        // if (!empty($res)) {
        // foreach($res as $my_app_job1)
        //     {
        //             $s_email=$my_app_job1->r_id;
        //             $company = $this->db->query("SELECT company,img FROM  recruiter WHERE  email = '".$s_email."'")->row();
        //              // print_r($job_info);die;
        //             $my_app_job1->company = $company->company;
        //             $my_app_job1->img = $company->img;
        //     }
        // }
        // echo "<pre>";print_r($res);die;

        if ($res) {
            $j_arr = array(
                'staus' => 'true',
                'message' => 'Success',
                'data' => $res,
            );
            $json_signup = json_encode($j_arr);
            echo $json_signup;
        } else {
            $j_arr = array(
                'staus' => 'false',
                'message' => 'data not found',
                'data' => '',
            );
            $json_signup = json_encode($j_arr);
            echo $json_signup;
        }

    }

    /**
     * Custom Api's 
     */
	public function job_post_lists() {
		$data = [];
		$data['job_types'] = $this->db->where('status','Active')->get('job_types')->result_array();
		$data['job_roles'] = $this->db->where('status','Active')->get('job_role')->result_array();
		$data['specializations'] = $this->db->where('status','Active')->get('specialization')->result_array();
		$data['qualifications'] = $this->db->where('status','Active')->get('qualification')->result_array();
		$data['designations'] = $this->db->where('status','Active')->get('designation')->result_array();
		$data['experiences'] = $this->db->where('status','Active')->get('experience')->result_array();
		$data['locations'] = $this->db->where('status','Active')->get('location')->result_array();
		$data['current_ctc'] = $this->db->where('status','Active')->get('currentctc_tbl')->result_array();
		$data['expectations'] = $this->db->where('status','Active')->get('expectedctc_tbl')->result_array();
		$data['notice_period'] = $this->db->where('status','1')->get('notice_periods')->result_array();
		$data['skills'] = $this->db->where('status','1')->get('skills')->result_array();

        $years = [];
		for ($i=1980; $i <= 2023; $i++) { 
            $years[] = $i;
        }
        $data['years'] = $years;
        
		$response = ['status' => 'true', 'data' => $data, 'message' => 'All job post lists'];
		echo json_encode($response);
		exit;
	}

	public function add_job() {
		// user_id
		// job_type:Full Time
		// designation:Manager
		// qualification:MBA/PGDM
		// passing_year:2022
		// experience:7+years
		// salary_range:yearly
		// min:100000
		// max:500000
		// no_of_vaccancies:5
		// job_role:Financial Services
		// end_date:2023-02-15
		// hiring_process:Written test,Group Discussion,Technical Round,Face2Face
        // location and description
		$post_data = [
			'user_id' => $this->input->post('user_id'),
			'job_type' => $this->input->post('job_type'),
			'designation' => $this->input->post('designation'),
			'qualification' => $this->input->post('qualification'),
			'passing_year' => $this->input->post('passing_year'),
			'experience' => $this->input->post('experience'),
			'salary_range' => $this->input->post('salary_range'),
			'min' => $this->input->post('min'),
			'max' => $this->input->post('max'),
			'no_of_vaccancies' => $this->input->post('no_of_vaccancies'),
			'job_role' => $this->input->post('job_role'),
			'end_date' => $this->input->post('end_date'),
			'hiring_process' => $this->input->post('hiring_process'),
			'location' => $this->input->post('location'),
			'description' => $this->input->post('description'),
			'specialization' => $this->input->post('specialization')
		];
		$id = $this->input->post('id');
		if($id != "") {
			$this->db->where('id', $id);
			if($this->db->update('recruiter_jobs', $post_data)) {
				$response = ['status' => 'true', 'data' => $post_data, 'message' => 'Job updated successfully'];
			} else {
				$response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
			}
		} else {
			if($this->db->insert('recruiter_jobs', $post_data)) {
				$id = $this->db->insert_id();
				$post_data['id'] = $id;
				$response = ['status' => 'true', 'data' => $post_data, 'message' => 'Job added successfully'];
			} else {
				$response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
			}
		}

		echo json_encode($response);
		exit;
	}

	public function job_lists() {
		$user_id = $this->input->post('user_id');
		$logged_id = $this->input->post('logged_id');

        $job_type = $this->input->post('job_type');
        $location = $this->input->post('location');
        $designation = $this->input->post('designation');
        $qualification = $this->input->post('qualification');
        $experience = $this->input->post('experience');
        $specialization = $this->input->post('specialization');

        if(isset($job_type) && $job_type != "") {
            $job_type = explode(',', $job_type);
            $this->db->where_in('recruiter_jobs.job_type', $job_type);
        }

        if(isset($location) && $location != "") {
            $location = explode(',', $location);
            $this->db->where_in('recruiter_jobs.location', $location);
        }

        if(isset($designation) && $designation != "") {
            $designation = explode(',', $designation);
            $this->db->where_in('recruiter_jobs.designation', $designation);
        }

        if(isset($qualification) && $qualification != "") {
            $qualification = explode(',', $qualification);
            $this->db->where_in('recruiter_jobs.qualification', $qualification);
        }

        if(isset($experience) && $experience != "") {
            $experience = explode(',', $experience);
            $this->db->where_in('recruiter_jobs.experience', $experience);
        }

        if(isset($specialization) && $specialization != "") {
            $specialization = explode(',', $specialization);
            $this->db->where_in('specialization', $specialization);
        }

		if($user_id != "") {
			$this->db->where('recruiter_jobs.user_id', $user_id);
		}
        $this->db->join('recruiter', 'recruiter.id = recruiter_jobs.user_id');
		$this->db->select('recruiter_jobs.*, recruiter.name as rec_name, recruiter.company as company_name');
		$data = $this->db->get('recruiter_jobs')->result_array();
        foreach ($data as $key => $value) {
            $data[$key]['is_applied'] = false;
            if(isset($logged_id) && $logged_id != "") {
                $data[$key]['is_applied'] = !empty($this->db->where(['user_id' => $logged_id, 'job_id' => $value['id']])->get('user_applied_job')->row_array()) ? true : false;
            }
        }
		$response = ['status' => 'true', 'data' => $data, 'message' => 'All job posts'];
		echo json_encode($response);
		exit;
	}

	public function view_job_post() {
		$id = $this->input->post('id');
		$this->db->where('recruiter_jobs.id', $id);

        $this->db->join('recruiter', 'recruiter.id = recruiter_jobs.user_id');
		$data = $this->db->select('recruiter_jobs.*, recruiter.name as rec_name, recruiter.company as company_name')->get('recruiter_jobs')->row_array();
		$response = ['status' => 'true', 'data' => $data, 'message' => 'Edit job posts'];
		echo json_encode($response);
		exit;
	}

    public function delete_job_post() {
		$id = $this->input->post('id');
		if($this->db->where('id', $id)->delete('recruiter_jobs')) {
            $response = ['status' => 'true', 'data' => [], 'message' => 'Post deleted success'];
        } else {
            $response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
        }
		echo json_encode($response);
		exit;
	}

    public function applied_lists() {

        $user_id = $this->input->post('user_id');
        $this->db->join('user_applied_job', 'user_applied_job.job_id = recruiter_jobs.id');
		$jobs = $this->db->where('recruiter_jobs.user_id', $user_id)->select('recruiter_jobs.*, user_applied_job.user_id as applier_id, user_applied_job.job_id as job_id')->get('recruiter_jobs')->result_array();
        $i = 0;
        $users = [];
        if(!empty($jobs)) {
            foreach ($jobs as $jkey => $job) {
                $users[$i]['job_id'] = $job['job_id'];
                $users[$i]['user'] = $this->db->where('id', $job['applier_id'])->get('seeker')->row_array();
                if(!empty($users[$i]['user'])) {
                    $users[$i]['user']['img'] = base_url($users[$i]['user']['img']);
                    $users[$i]['user']['resume'] = base_url($users[$i]['user']['resume']);
                }
                $i++;
            }
		    $response = ['status' => 'true', 'data' => $users, 'message' => 'Job applied success'];
        } else {
            $response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
        }
		echo json_encode($response);
		exit;
        // $data['users'] = [];
        // $applied_jobs = $this->db->where('job_id', $id)->get('user_applied_job')->result_array();
        // foreach ($applied_jobs as $jkey => $job) {
        //     $applied_jobs[$jkey] = $this->db->where('id', $job['user_id'])->get('seeker')->row_array();
        // }
    }

    public function update_seeker_profile() {
        $resume = "";
        // $image = "";
        $config['upload_path'] = "./uploads/resume";
        $config['allowed_types'] = "pdf|docx|png|jpg|jpeg";
        $this->load->library('upload', $config);
        // print_r($_FILES);die;
        if(isset($_FILES['resume'])) {
            if ($this->upload->do_upload('resume')) {
                if (!empty($img)) {
                    unlink('./' . $img);
                }
    
                $d1 = $this->upload->data();
                $d2 = $d1['file_name'];
                $d3 = 'uploads/resume/' . $d2;
                $resume = $d3;
            }
        }
        if(isset($_FILES['image'])) {
            if ($this->upload->do_upload('image')) {
                $d1 = $this->upload->data();
                $d2 = $d1['file_name'];
                $d3 = 'uploads/resume/' . $d2;
                $image = $d3;
            }else{
                $error = array('error' => $this->upload->display_errors('<div class="alert alert-danger">', '</div>'));
                print_r($error);die;

            }
        }


        $id = $this->input->post('id');
        $post_data = [
            'name' => $this->input->post('first_name'),
            'surname' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'gender' => $this->input->post('gender'),
            'qua' => $this->input->post('qualification'),
            'yp' => $this->input->post('year_of_passing'),
            'current_address' => $this->input->post('current_address'),
            'location' => $this->input->post('preferred_location'),
            'current' => $this->input->post('current_ctc'),
            'expected' => $this->input->post('expected_ctc'),
            'job_type' => $this->input->post('job_type'),
            'designation' => $this->input->post('designation'),
            'job_role' => $this->input->post('job_role'),
            'keyskills' => $this->input->post('key_skills'),
            'cgpa' => $this->input->post('percentage_cgpa'),
            'exp' => $this->input->post('work_experience'),
            'specialization' => $this->input->post('specialization'),
            'notice_period' => $this->input->post('notice_period'),
            'age' => $this->input->post('age'),
            'status' => $this->input->post('status'),
            'is_profile_updated' => 1
        ];
        // print_r($image);die;

        if($resume != "") {
            $post_data['resume'] = $resume;
        }

        if($image != "") {
            $post_data['img'] = $image;
        }
        // echo json_encode($post_data);exit;

        if($this->db->where('id', $id)->update('seeker', $post_data)) {
		    $response = ['status' => 'true', 'data' => $post_data, 'message' => 'Updated seeker profile'];
        } else {
		    $response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
        }
        echo json_encode($response);
        exit;
    }

    public function recruiter_profile() {
        $id = $this->input->post('id');
        if($resp = $this->db->where('id', $id)->get('recruiter')->row_array()) {
            $resp['img'] = base_url($resp['img']);
            // $resp['resume'] = base_url($resp['resume']);
		    $response = ['status' => 'true', 'data' => $resp, 'message' => 'Updated recruiter profile'];
        } else {
		    $response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
        }
        echo json_encode($response);
        exit;

    }

    public function update_recruiter_profile() {
        $image = "";
        $config['upload_path'] = "./uploads/resume";
        $config['allowed_types'] = "png|jpg|jpeg";
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image')) {
            if (!empty($img)) {
                unlink('./' . $img);
            }

            $d1 = $this->upload->data();
            $d2 = $d1['file_name'];
            $d3 = 'uploads/resume/' . $d2;
            $image = $d3;
        }

        $id = $this->input->post('id');
        $post_data = [
            'name' => $this->input->post('full_name'),
            'email' => $this->input->post('email'),
            'mno' => $this->input->post('mobile'),
            'org_type' => $this->input->post('org_type'),
            'address' => $this->input->post('current_address'),
            'location' => $this->input->post('preferred_location'),
            'website' => $this->input->post('website'),
            'company' => $this->input->post('company_name'),
            'des' => $this->input->post('description'),
            'is_profile_updated' => 1
        ];

        if($image != "") {
            $post_data['img'] = $image;
        }

        if($this->db->where('id', $id)->update('recruiter', $post_data)) {
		    $response = ['status' => 'true', 'data' => $post_data, 'message' => 'Updated recruiter profile'];
        } else {
		    $response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
        }
        echo json_encode($response);
        exit;
    }

    public function apply_job_post() {
        $post_id = $this->input->post('post_id');
        $user_id = $this->input->post('user_id');

        if($this->db->insert('user_applied_job', ['user_id' => $user_id, 'job_id' => $post_id])) {
		    $response = ['status' => 'true', 'data' => [], 'message' => 'Job applied success'];
        } else {
            $response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
        }
        echo json_encode($response);
        exit;
    }

    public function my_applied_jobs() {
        $user_id = $this->input->post('user_id');
        $this->db->select('user_applied_job.*')->where(['user_id' => $user_id]);
        if($jobs = $this->db->get('user_applied_job')->result_array()) {
            foreach ($jobs as $jkey => $job) {
                $jobs[$jkey]['user'] = $this->db->where('id', $job['user_id'])->get('seeker')->row_array();

                $this->db->join('recruiter', 'recruiter.id = recruiter_jobs.user_id');
		        $this->db->select('recruiter_jobs.*, recruiter.name as rec_name, recruiter.company as company_name');
                $jobs[$jkey]['job'] = $this->db->where('recruiter_jobs.id', $job['job_id'])->get('recruiter_jobs')->row_array();
            }
		    $response = ['status' => 'true', 'data' => $jobs, 'message' => 'Job applied success'];
        } else {
            $response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
        }
        echo json_encode($response);
        exit;
    }

    public function all_recruiters($id = "") {
        if($id!="") {
            $this->db->where('id', $id);
        }

        $search_text = $this->input->post('search');
        $logged_id = $this->input->post('logged_id');
        if(trim($search_text) != "") {
            $this->db->like('name', $search_text)->or_like('company', $search_text)->or_like('location', $search_text);
        }

        $data = $this->db->get('recruiter')->result_array();
        if(!empty($data)) {
            foreach ($data as $dkey => $dt) {
                $data[$dkey]['img'] = base_url($dt['img']);
                if($id!="") {
                    $this->db->join('recruiter', 'recruiter.id = recruiter_jobs.user_id');
                    $this->db->select('recruiter_jobs.*, recruiter.name as rec_name, recruiter.company as company_name');
                    $jobs = $this->db->where('recruiter_jobs.user_id', $id)->get('recruiter_jobs')->result_array();
                    foreach ($jobs as $jkey => $job) {
                        $jobs[$jkey]['is_applied'] = false;
                        if($logged_id != "") {
                            $jobs[$jkey]['is_applied'] = !empty($this->db->where(['user_id' => $logged_id, 'job_id' => $job['id']])->get('user_applied_job')->row_array()) ? true : false;
                        }
                    }
                    $data[$dkey]['job'] = $jobs;

                }
            }
		    $response = ['status' => 'true', 'data' => $data, 'message' => 'All recruiters'];
        } else {
            $response = ['status' => 'false', 'data' => [], 'message' => 'Something went wrong'];
        }
        echo json_encode($response);
        exit;
    }

    public function resent_otp($table = "seeker") {
        $mobile = $this->input->post('mobile');
        $otp = rand(1111, 9999);
        if($this->db->where('mno', $mobile)->get("$table")->row_array()) {
            $this->db->where('mno', $mobile)->update("$table", ['otp' => $otp]);
            $response = ['status' => 'true', 'data' => [], 'otp' => "$otp", 'message' => 'OTP sent success'];
        } else {
            $response = ['status' => 'false', 'data' => [], 'otp' => '', 'message' => 'Invalid user'];
        }
        echo json_encode($response);
        exit;
    }

    public function change_password($table = "seeker") {
        $mobile = $this->input->post('mobile');
        $old_password = $this->input->post('old_password');
        $password = $this->input->post('password');
        if($this->db->where(['mno' => $mobile, 'ps' => md5($old_password)])->get("$table")->row_array()) {
            $this->db->where('mno', $mobile)->update("$table", ['ps' => md5($password)]);
            $response = ['status' => 'true', 'data' => [], 'message' => 'Password updated success'];
        } else {
            $response = ['status' => 'false', 'data' => [], 'message' => 'Old password not matched'];
        }
        echo json_encode($response);
        exit;
    }

    public function search_candidate() {
        $job_type = $this->input->post('job_type');
        $location = $this->input->post('location');
        $designation = $this->input->post('designation');
        $qualification = $this->input->post('qualification');
        $experience = $this->input->post('experience');
        $specialization = $this->input->post('specialization');
        $skill = $this->input->post('skill');
        $job_role = $this->input->post('job_role');
        $expected_ctc = $this->input->post('expected_ctc');
        $notice_period = $this->input->post('notice_period');

        if(isset($job_type) && $job_type != "") {
            $job_type = explode(',', $job_type);
            $this->db->group_start()->where_in('job_type', $job_type)->group_end();
        }

        if(isset($location) && $location != "") {
            $location = explode(',', $location);
            $this->db->group_start()->where_in('location', $location)->group_end();
        }

        if(isset($designation) && $designation != "") {
            $designation = explode(',', $designation);
            $this->db->group_start()->where_in('designation', $designation)->group_end();
        }

        if(isset($qualification) && $qualification != "") {
            $qualification = explode(',', $qualification);
            $this->db->group_start()->where_in('qua', $qualification)->group_end();
        }

        if(isset($experience) && $experience != "") {
            $experience = explode(',', $experience);
            $this->db->group_start()->where_in('exp', $experience)->group_end();
        }

        if(isset($specialization) && $specialization != "") {
            $specialization = explode(',', $specialization);
            $this->db->group_start()->where_in('specialization', $specialization)->group_end();
        }

        if(isset($skill) && $skill != "") {
            // $skill = explode(',', $skill);
            $this->db->group_start()->where("FIND_IN_SET('$skill', keyskills)", null, false)->group_end();
        }

        if(isset($job_role) && $job_role != "") {
            $job_role = explode(',', $job_role);
            $this->db->group_start()->where_in('job_role', $job_role)->group_end();
        }
        if(isset($expected_ctc) && $expected_ctc != "") {
            $expected_ctc = explode(',', $expected_ctc);
            $this->db->group_start()->where_in('expected', $expected_ctc)->group_end();
        }
        if(isset($notice_period) && $notice_period != "") {
            $notice_period = explode(',', $notice_period);
            $this->db->group_start()->where_in('notice_period', $notice_period)->group_end();
        }

        $seekers = $this->db->get('seeker')->result_array();        
        if(!empty($seekers)) {
            foreach ($seekers as $skey => $seeker) {
                $seekers[$skey]['img'] = base_url($seekers[$skey]['img']);
                $seekers[$skey]['resume'] = base_url($seekers[$skey]['resume']);
            }
            $response = ['status' => 'true', 'data' => $seekers, 'message' => 'Seekers found'];
        } else {
            $response = ['status' => 'false', 'data' => [], 'message' => 'No Data found'];
        }
        echo json_encode($response);
        exit;
    }

    
  public function add_money_wallet()
  // user_id:200
  // amount:1000
  // transaction_id:120
  // type:credit/debit

    {

        $user_id=$_POST['user_id'];
        $amount=$_POST['amount'];
        $transaction_id=$_POST['transaction_id'];
        $type=$_POST['type'];


        $inser_array=array(
        'user_id'=>$user_id,
        'amount'=>$amount,
        'transaction_id'=>$transaction_id,
        'type'=>$type,

        );
        $inser=$this->db->insert("wallet_transactions",$inser_array);
        // print_r($inser_array[type]);die();
        $res = $this ->db->select('*')->where('id',$user_id)->get('recruiter');
        $ress = $res->result();
        // print_r($ress);die;
        $wallet_amount=$ress[0]->balance;

        $total=$wallet_amount+$amount;
        $minus_total=$wallet_amount-$amount;


        if ($inser == false) {
        
            $response = ['status' => 'false', 'data' => [], 'message' => 'No Data found'];

        } else {

            $response = ['status' => 'true', 'data' => $inser_array, 'message' => 'wallet transactions Added Successfully'];
        
        }
        
        if ($inser_array['type'] == "credit") {
        $this->db->set('balance',  $total, FALSE);
        } elseif ($inser_array['type'] == "debit") {
        $this->db->set('balance', $minus_total, FALSE);
        }
         $this->db->where('id', $user_id)->update('recruiter');
        //  print_r($this->db->last_query());die;
        
        echo json_encode($response);
        exit;
    }

    public function get_wallet_transaction()
    {
        $user_id = $this->input->post('user_id');
        $data = $this->db->where('user_id', $user_id)->get('wallet_transactions')->result_array();
       
        if($data){

            $response = ['status' => 'true', 'data' => $data, 'message' => 'Transaction Get Successfully'];

        }else{
            
            $response = ['status' => 'false', 'data' => [], 'message' => 'Data not found'];
        }
        echo json_encode($response);
        exit;
    }



}

// Forgot password - seeker / rec
// change password - seeker / rec - Done
// Search candidate - rec - Done
// resend OTP - seek / rec - Done
// Search recruiter / jobs

