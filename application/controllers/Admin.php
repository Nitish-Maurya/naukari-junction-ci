<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{

    public function index()
    {
        $this->load->view('admin/common/header_auth');
        $this->load->view('admin/login');
        $this->load->view('admin/common/footer_auth');
    }
    public function signUp($name)
    {

        $data = $this->input->post();
        // pritn_r($data);
        if (isset($data)) {
            if ($name == 'recruiter') {

                $plan = $this->Common_model->select('jp_revenue');
                foreach ($plan as $p1) {

                    $data = $this->input->post();
                    $plan_name = $this->input->post('plan');
                    $ps = $this->input->post('ps');
                    $send_detail = $this->input->post('send_detail');
                    $ps1 = md5($ps);
                    $data['ps'] = $ps1;
                    $email = $this->input->post('email');
                    $data['ps2'] = $this->input->post('ps');
                    $website = $this->input->post('website');
                    $location = $this->input->post('location');
                    $company = $this->input->post('company');
                    $type = $this->input->post('type');

                    $mno = $this->input->post('mno');
                    unset($data['rps']);
                    unset($data['send_detail']);
                    $d1 = $this->Common_model->signUp($data, $mno, $email, $name);
                    $p_info = $this->Common_model->select('jp_revenue');
                    $p_infi_plane = '';
                    foreach ($p_info as $p1) {
                        $p_infi_plane = $p1->condation;
                    }
                    $plan_info = $this->Common_model->select('jp_plans', $plan_name, 'name');
                    $p_month = $plan_info->duration;
                    if ($d1 == 1) {
                        $d1 = date('Y/m/d');
                        $arr = array('pay' => 'yes',
                            'pay_date' => $d1,
                            'show_on_reg' => 'no',
                            'month' => $p_month,
                        );
                        $res = $this->Common_model->updateData('		', $arr, $email, 'email');
                        if (!empty($send_detail)) {
                            $email_info = $this->Common_model->select('jp_setting_email', '1', 'id');
                            $to_email_address = $email;
                            $subject = $email_info->recruiter_subject;
                            $message = "Website Link :" . base_url() . "\nE-Mail :" . $email . "\nPassword :" . $ps;
                            $headers = 'From:' . $email_info->recruiter_email;
                            mail($to_email_address, $subject, $message, $headers);
                        }
                        $this->session->set_flashdata('msg', 'Added');
                        echo "Ok";
                    } else {
                        echo $d1;
                    }

                }
            } else {
                $data = $this->input->post();
                $ps = $this->input->post('ps');
                $send_detail = $this->input->post('send_detail');
                $ps1 = md5($ps);
                $data['ps'] = $ps1;
                $email = $this->input->post('email');
                $location = $this->input->post('location');
                $company = $this->input->post('company');
                $website = $this->input->post('website');
                $mno = $this->input->post('mno');

                // if(preg_match("/^\d+\.?\d*$/",$mno) && strlen($mno)==10){

                //     print_r('ok');die;
                // }else{

                //     print_r('not');die;

                // }
                // die;
                unset($data['rps']);
                unset($data['send_detail']);
                //print_r($data);
                $d1 = $this->Common_model->signUp($data, $mno, $email, $name);
                if ($d1 == 1) {
                    if (!empty($send_detail)) {
                        $email_info = $this->Common_model->select('jp_setting_email', '1', 'id');
                        $to_email_address = $email;
                        $subject = $email_info->seeker_subject;
                        $message = "Website Link :" . base_url() . "\nE-Mail :" . $email . "\nPassword :" . $ps;
                        $headers = 'From:' . $email_info->seeker_email;
                        mail($to_email_address, $subject, $message, $headers);
                    }
                    $this->session->set_flashdata('msg', 'Added');
                    echo "Ok";
                } else {
                    echo $d1;
                }
            }
        }
    }
    public function dashboard()
    {
        $this->load->view('admin/common/header');
        $seeker = $this->Common_model->row_count('seeker');
        $recruiter = $this->Common_model->row_count('recruiter');
        $location = $this->Common_model->row_count('location');
        $area_of_sectors = $this->Common_model->row_count('area_of_sectors');
        $specialization = $this->Common_model->row_count('specialization');
        $qualification = $this->Common_model->row_count('qualification');
        $job_role = $this->Common_model->row_count('job_role');
        $job_types = $this->Common_model->row_count('job_types');
        $designation = $this->Common_model->row_count('designation');
        $experience = $this->Common_model->row_count('experience');
        $this->load->view('admin/dashboard', ['seeker' => $seeker, 'recruiter' => $recruiter, 'location' => $location, 'area_of_sectors' => $area_of_sectors, 'specialization' => $specialization, 'qualification' => $qualification, 'job_role' => $job_role, 'job_types' => $job_types, 'designation' => $designation, 'experience' => $experience]);
        $this->load->view('admin/common/footer');
    }
    public function seekers()
    {
        $row = $this->Common_model->select('seeker');
        $this->load->view('admin/common/header');
        $this->load->view('admin/seekers', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function add_seekers()
    {
        $row['seeker'] = $this->Common_model->select('seeker', 'Active', 'status');
        $row['location'] = $this->Common_model->select('location', 'Active', 'status');
        $row['job_role'] = $this->Common_model->select('job_role', 'Active', 'status');
        $row['currentctc'] = $this->Common_model->select('currentctc_tbl', 'Active', 'status');
        $row['expectedctc'] = $this->Common_model->select('expectedctc_tbl', 'Active', 'status');
        $row['specialization'] = $this->Common_model->select('specialization', 'Active', 'status');
        $row['job_types'] = $this->Common_model->select('job_types', 'Active', 'status');
        $row['designation'] = $this->Common_model->select('designation', 'Active', 'status');
        $row['location'] = $this->Common_model->select('location', 'Active', 'status');
        $row['qualification'] = $this->Common_model->select('qualification', 'Active', 'status');
        $row['experience'] = $this->Common_model->select('experience', 'Active', 'status');

        $this->load->view('admin/common/header');
        $this->load->view('admin/add_seekers', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }

    public function addseekerALL()
    {

        //

        $resume_file1 = $_FILES['resume']['name'];
        if (!empty($resume_file1)) {

            $email = $this->input->post("email");

            // $seeker_info=$this->Common_model->select('seeker',$email,'email');
            $seeker_info = $this->db->query("SELECT * FROM seeker WHERE email = '" . $email . "'")->row();

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
                $resume = $d3;

                // unset($data['rps']);

            } else {
                echo "Uploaded file is not a valid resume file. Only PDF and DOC files are allowed";
            }

        } else {
            $resume = '';
        }

        // echo "<pre>";print_r($resume);die;

        $email = $this->input->post("email");

        $query = $this->db->query("SELECT * FROM  seeker  WHERE email = '" . $email . "'")->row();
        // echo "<pre>";print_r($query);die;
        if (!empty($query)) {

            $this->session->set_flashdata("success_req", '<div class="alert alert-warning alert-dismissible" role="alert">

                                <i class="fa fa-warning"></i>
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                       <strong>Warning!</strong> this email is already exists...
                                        </div>');
            redirect("Admin/seekers");
        }

        $ps = $this->input->post('ps');
        $ps1 = md5($ps);

        $data = array(
            "name" => $this->input->post("name"),
            "surname" => $this->input->post("surname"),
            "email" => $this->input->post("email"),
            "mno" => $this->input->post("mno"),
            "ps" => $ps1,
            "ps2" => $ps,
            "qua" => $this->input->post("qua"),
            "p_year" => $this->input->post("p_year"),
            "gender" => $this->input->post("gender"),
            "current_address" => $this->input->post("current_address"),
            "keyskills" => $this->input->post("keyskills"),
            "cgpa" => $this->input->post("cgpa"),

            "city" => $this->input->post("city"),
            "current" => $this->input->post("current"),
            "expected" => $this->input->post("expected"),
            "location" => $this->input->post("location"),
            "job_role" => $this->input->post("job_role"),
            "job_type" => $this->input->post("job_type"),
            "designation" => $this->input->post("designation"),
            "specialization" => $this->input->post("specialization"),
            "exp" => $this->input->post("exp"),
            "resume" => $resume,
        );

        // print_r($data);
        $this->load->model("common_model");
        $insert = $this->common_model->insert('seeker', $data);
        // print_r('ok');die;

        if ($insert) {
            $this->session->set_flashdata("success_req", '<div class="alert alert-success alert-dismissible" role="alert">
                                <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your request added successfully...
                            </div>');
            redirect('admin/seekers');
        } else {
            $this->session->set_flashdata("error", '<div class="alert alert-success alert-dismissible" role="alert">
                                <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your category not added...
                           </div>');
            redirect('admin/seekers');
        }

    }

    public function delete_seeker()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $seeker_info = $this->Common_model->select('seeker', $id, 'id');
            $seeker_email = $seeker_info->email;
            $applay_job_delete = $this->Common_model->delete('jp_applay_job', $seeker_email, 's_email');
            $res = $this->Common_model->delete('seeker', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/seekers');
        }
    }
    public function update_seeker($name)
    {
        $id = $this->input->post('id');
        $seeker_info = $this->Common_model->select('seeker', $id, 'id');
        $this->load->view('admin/module/seeker_update_popup', ['seeker_info' => $seeker_info]);
    }
    public function update_seeker1()
    {
        $data = $this->input->post();
        $email = $this->input->post('email');
        $update_res = $this->Common_model->updateData('seeker', $data, $email, 'email');
        if ($update_res) {
            echo "update";
        } else {
            echo "Not Update";
        }
    }
    public function allseekerExport($status = '')
    {
        $file_type = 'csv';
        //$getRecordListing = $this->dynamic_model->getdatafromtable('registers');
        $getRecordListing = $this->Common_model->select('seeker');
        // if(empty($getRecordListing)){
        //       redirect('admin/registers');
        //   }

        //Code for CSV output
        $csvOutput = "";
        $file = 'App-Seeker-List';

        $header = array(
            'Job Seeker Id',
            'Name',
            'Email',
            'Phone',
            'Status',

        );

        //Code for make header of CSV file
        for ($head = 0; $head < count($header); $head++) {
            $csvOutput .= $header[$head] . ",";
        }

        $csvOutput .= "\n";
        //Code for make rows of CSV file
        foreach ($getRecordListing as $key => $recordData) {
            $status = ($recordData->status == 'Active') ? 'Active' : 'Deactive';

            $csvOutput .= $recordData->id . ",";
            $csvOutput .= $recordData->name . ",";
            $csvOutput .= $recordData->email . ",";
            $csvOutput .= $recordData->mno . ",";

            $csvOutput .= $status . ",";
            $csvOutput .= "\n";
        }

        $filename = $file . "-" . date("Y-m-d", time());

        header('Content-Type: text/csv; charset=utf-8');
        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: csv" . date("Y-m-d") . "." . $file_type);
        header("Content-disposition: filename=" . $filename . "." . $file_type);

        // print chr(255) . chr(254).mb_convert_encoding($csvOutput, 'UTF-16LE', 'UTF-8');
        print $csvOutput;
        exit;
    }
    public function recruiters()
    {
        $row = $this->Common_model->select('recruiter');
        $plan_info = $this->Common_model->getdatafromtable('jp_plans', array('status' => 'Active'));
        //    print_r($plan_info);die;
        //$this->load->view('admin/common/header');
        $this->load->view('admin/recruiters', ['row' => $row, 'plan_info' => $plan_info]);
        //$this->load->view('admin/common/footer');
    }
    public function recruiter_data_fetch()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $rec_info = $this->Common_model->select('recruiter', $id, 'id');
            $plan = $this->Common_model->select('jp_plans', 'Active', 'status');
            // print_r($plan);die();
            $this->load->view('admin/module/rec_update_pop', ['rec_info' => $rec_info, 'plan' => $plan]);
        }

    }
    public function posted_jobs($rec_id)
    {
        $rec_info = $this->Common_model->select('recruiter', $rec_id, 'id');
        $email = $rec_info->email;
        $name = $rec_info->name;
        $jobs = $this->Common_model->select('recruiter_jobs', $rec_id, 'user_id');
		
        if ($jobs) {
            $this->load->view('admin/posted_jobs', ['jobs' => $jobs, 'name' => $name]);
        } else {
            $this->load->view('admin/posted_jobs', ['jobs' => [], 'name' => $name]);
        }
    }
    public function rec_update1()
    {
        $data = $this->input->post();
        if (isset($data)) {
            $id = $this->input->post('id');
            unset($data['id']);
            $res = $this->Common_model->updateData('recruiter', $data, $id, 'id');
            $this->session->set_flashdata('msg', 'Updated');
            if ($res) {

                echo "Update";
            } else {
                echo "Not Update";
            }
        }
    }
    public function delete_recruiters()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $recruiter_info = $this->Common_model->select('recruiter', $id, 'id');
            $recruiter_email = $recruiter_info->email;
            $job_post_count = $this->Common_model->row_count('job_post', $recruiter_email, 'r_id');
            if ($job_post_count > 0) {
                $delete_job = $this->Common_model->delete('job_post', $recruiter_email, 'r_id');
            }
            $job_applay_count = $this->Common_model->row_count('jp_applay_job', $id, 'r_id');
            if ($job_applay_count > 0) {
                $applay_job_delete = $this->Common_model->delete('jp_applay_job', $id, 'r_id');
            }
            $res = $this->Common_model->delete('recruiter', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/recruiters');
        }
    }
    public function location()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('location');
        $this->load->view('admin/location', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_location()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('location', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/location');
        }
    }
    public function update($name = '')
    {

        $id = $this->input->post('id');
        if (isset($id)) {
            $this->session->set_flashdata('msg', 'Updated');
            $loc_data = $this->Common_model->select($name, $id, 'id');
            $row = $this->Common_model->select($name);
            ?>
			<input type="hidden" name="id" id="d" value="<?=$loc_data->id;?>">
			<input type="hidden" name="tbl_name" value="<?=$name;?>">
			<input type="text" name="name" id="<?=$name . "id"?>" class="form-control" value="<?=$loc_data->name?>" />
			<?php
}
    }
    public function update_data()
    {
        $data = $this->input->post();
        if (isset($data)) {
            $id = $this->input->post('id');
            $tbl_name = $this->input->post('tbl_name');
            unset($data['id']);
            unset($data['tbl_name']);
            $row = $this->Common_model->select($tbl_name);

            if ($this->Common_model->updateData($tbl_name, $data, $id, 'id')) {
                $this->session->set_flashdata('msg', 'Updated');
                echo "update";

            } else {
                echo "Not Update";
            }
        }
    }
    public function area_of_sectors()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('area_of_sectors');
        $this->load->view('admin/area_of_sectors', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_aofs()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $res = $this->Common_model->delete('area_of_sectors', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/area_of_sectors');
        }
    }
    public function specialization()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('specialization');
        $this->load->view('admin/specialization', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_specialization()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('specialization', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/specialization');
        }
    }
    public function qualification()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('qualification');
        $this->load->view('admin/qualification', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_qualification($id = '')
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('qualification', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/qualification');
        }
    }
    public function job_role()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('job_role');
        $this->load->view('admin/job_role', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_job_role()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('job_role', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/job_role');
        }
    }

    public function current_ctc()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('currentctc_tbl');
        $this->load->view('admin/current_ctc', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function expected_ctc()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('expectedctc_tbl');
        $this->load->view('admin/expected_ctc', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }

    public function delete_current()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('currentctc_tbl', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/current_ctc');
        }
    }
    public function delete_expected()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('expectedctc_tbl', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/expected_ctc');
        }
    }

    public function job_types()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('job_types');
        $this->load->view('admin/job_types', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_job_type()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('job_types', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/job_types');
        }
    }
    public function designation()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('designation');
        $this->load->view('admin/designation', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_designation()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('designation', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/designation');
        }
    }
    public function experience()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('experience');
        $this->load->view('admin/experience', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_experience()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        if (isset($id)) {
            $res = $this->Common_model->delete('experience', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            $url = "admin/experience";
            redirect('admin/experience');
        }
    }
    public function add($name = '')
    {
        $data = $this->input->post();
        if (!empty($data)) {
            $n1 = $this->input->post('name');
            $check = $this->Common_model->count_num($name, $n1, 'name');
            if ($check == 0) {
                $res = $this->Common_model->insert($name, $data);
                if ($res) {
                    $this->session->set_flashdata('msg', 'Added');
                    echo "insert";
                } else {
                    echo "Not Insert";
                }
            } else {
                echo "already_exists";
            }
        }
    }
    public function login()
    {
        $email = $this->input->post('email');
        $ps = $this->input->post('ps');
        if (!empty($email)) {
            if (!empty($this->input->post('remember'))) {

                $em = array(
                    'name' => 'e1',
                    'value' => $email,
                    'expire' => '604800',
                );
                $this->input->set_cookie($em);
                $p = array(
                    'name' => 'p1',
                    'value' => $ps,
                    'expire' => '604800',
                );
                $this->input->set_cookie($p);
            }

            $this->load->model('admin/Admin_model');
            $r1 = $this->Admin_model->login($email, $ps);
            $this->session->set_flashdata('login', 'Success');
            if ($r1 > 0) {
                $this->session->set_userdata('uname', $email);
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('msg', 'wrong User');
                redirect('admin/');
            }

        } else {
            $this->session->set_flashdata('msg1', 'fill');
            redirect('admin/');
        }

    }
    public function footer_link()
    {
        $data = $this->input->post();
        $id = $this->input->post('id');
        unset($data['id']);
        if (!empty($data)) {
            $up_res = $this->Common_model->updateData('jp_setting_footer', $data, $id, 'id');
            if ($up_res) {
                echo "update";
            } else {
                echo "Not Update";
            }
        }
    }
    public function footer_update()
    {
        $id = $this->input->post('id');
        $footer_info = $this->Common_model->select('jp_setting_footer', $id, 'id');
        $this->load->view('admin/module/footer_link_update_pop', ['footer_info' => $footer_info]);
    }
    public function website_setting()
    {
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        $res2 = $this->Common_model->select('jp_revenue', '1', 'id');
        $admin_info = $this->Common_model->select('admin', '1', 'id');
        $email_info = $this->Common_model->select('jp_setting_email', '1', 'id');
        $footer_info = $this->Common_model->select('jp_setting_footer');
        $language_name = $this->Common_model->select('jp_language_name');
        $info = $this->Common_model->select('jp_setting', '2', 'id');
        $this->load->view('admin/common/header');
        $this->load->view('admin/site_setting', ['language_name' => $language_name, 'footer_info' => $footer_info, 'res' => $res, 'res2' => $res2, 'admin_info' => $admin_info, 'email_info' => $email_info, 'info' => $info]);
        $this->load->view('admin/common/footer');
    }
    public function delete_language()
    {
        $language_name = $this->input->post('del_language');
        $info = $this->Common_model->select('jp_setting', '2', 'id');
        $l1 = $info->language;
        $arr = array('language' => 'english');
        if ($language_name == 'english') {
            $this->session->set_flashdata('msg', 'deng');
            redirect('admin/website_setting');
        } else {
            if ($l1 == $language_name) {
                $this->Common_model->updateData('jp_setting', $arr, '2', 'id');
                $this->Common_model->delete('jp_language_name', $language_name, 'name');
                $res = $this->Common_model->col_drop('jp_language', $language_name);
                if ($res == "delete") {
                    $this->session->set_flashdata('msg', 'Deleted');
                    redirect('admin/website_setting');
                } else {
                    $this->session->set_flashdata('msg', 'nDeleted');
                    redirect('admin/website_setting');
                }
            } else {
                $this->Common_model->delete('jp_language_name', $language_name, 'name');
                $res = $this->Common_model->col_drop('jp_language', $language_name);
                if ($res == "delete") {
                    $this->session->set_flashdata('msg', 'Deleted');
                    redirect('admin/website_setting');
                } else {
                    $this->session->set_flashdata('msg', 'nDeleted');
                    redirect('admin/website_setting');
                }
            }
        }

    }
    public function credentials_update()
    {
        $data = $this->input->post();
        if (!empty($data)) {
            $old_ps = $this->input->post('hide_pass');
            $old_ps2 = $this->input->post('old_ps');
            $uname = $this->input->post('uname');
            $uname = $this->input->post('un');
            unset($data['hide_pass']);
            unset($data['un']);
            unset($data['old_ps']);
            unset($data['cps']);
            $this->session->set_userdata('uname', $uname);
            if ($old_ps != $old_ps2) {
                echo "psn";
            } else {
                $update_res = $this->Common_model->updateData('admin', $data, $uname, 'uname');
                if ($update_res) {
                    echo "Update";
                } else {
                    echo "Not Update";
                }
            }
        }
    }
    public function email_credentials()
    {
        $data = $this->input->post();
        $res = $this->Common_model->updateData('jp_setting_email', $data, '1', 'id');
        if ($res) {
            echo "update";
        } else {
            echo "Credentials Not update";
        }
    }
    public function meta_information()
    {
        $data = $this->input->post();
        if (!empty($data)) {
            if ($this->Common_model->updateData('jp_setting', $data, '2', 'id')) {
                echo "Insert";
            } else {
                echo "Not Insert";
            }

        }
    }
    public function plans()
    {
        $this->load->view('admin/common/header');
        $plans_list = $this->Common_model->select('jp_plans');
        $this->load->view('admin/plans', ['row' => $plans_list]);
        $this->load->view('admin/common/footer');

    }
    public function create_plane()
    {
        $data = $this->input->post();
        if (!empty($data)) {
            $name = $this->input->post('name');
            $plan_duration_count = $this->input->post('plan_duration_count');
            $plan_duration_type = $this->input->post('plan_duration_type');
            $check_status = $this->db->select('*')->from('jp_plans')->where('name', $name)->get();
            $num_r = $check_status->num_rows();
            $duration = '';
            if ($num_r > 0) {
                echo "Yes";
            } else {
                if ($plan_duration_type == "Days") {
                    $duration = $plan_duration_count * 1;
                } else if ($plan_duration_type == "Weeks") {
                    $duration = $plan_duration_count * 7;
                } else if ($plan_duration_type == "Months") {
                    $duration = $plan_duration_count * 30;
                } else if ($plan_duration_type == "Years") {
                    $duration = $plan_duration_count * 365;
                } else {}
                $data['duration'] = $duration;

                $res = $this->Common_model->insert('jp_plans', $data);
                if ($res) {
                    $this->session->set_flashdata('msg', 'Created');

                    echo "add";
                } else {
                    echo "Not Add";
                }
            }
        }
    }
    public function delete_plan()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('jp_plans', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/plans');
        }
    }
    public function update_plan()
    {
        $id = $this->input->post('id');
        $plan_info = $this->Common_model->select('jp_plans', $id, 'id');

        $this->load->view('admin/module/plan_update_pop', ['plan_info' => $plan_info]);

    }
    public function update_plan1()
    {
        $name = $this->input->post('name');
        $data = $this->input->post();
        $id = $this->input->post('id_p');
        $condation1 = $this->input->post('condation11');
        unset($data['condation11']);
        unset($data['id_p']);
        $data['condation1'] = $condation1;
        $plan_duration_count = $this->input->post('plan_duration_count');
        $plan_duration_type = $this->input->post('plan_duration_type');
        $duration = '';
        if ($plan_duration_type == "Days") {
            $duration = $plan_duration_count * 1;
        } else if ($plan_duration_type == "Weeks") {
            $duration = $plan_duration_count * 7;
        } else if ($plan_duration_type == "Months") {
            $duration = $plan_duration_count * 30;
        } else if ($plan_duration_type == "Years") {
            $duration = $plan_duration_count * 365;
        } else {}
        $data['duration'] = $duration;
        $update_res = $this->Common_model->updateData('jp_plans', $data, $id, 'id');
        if ($update_res) {
            echo "update";
        } else {
            echo "Not Update";
        }
    }
    public function setting()
    {
        if (!empty($_FILES['favicon_img']['name']) || !empty($_FILES['logo_img']['name']) || !empty($_FILES['bg_img']['name']) || !empty($_FILES['contect_img']['name']) || !empty($_FILES['about_img']['name']) || !empty($_FILES['main_loder']['name'])) {
            $fevi = $_FILES['favicon_img']['name'];
            $logo_img = $_FILES['logo_img']['name'];
            $bg_img = $_FILES['bg_img']['name'];
            $contect_img = $_FILES['contect_img']['name'];
            $about_img = $_FILES['about_img']['name'];
            $main_loder = $_FILES['main_loder']['name'];
            if (!empty($fevi)) {

                $config['upload_path'] = "./uploads/setting";
                $config['allowed_types'] = "jpg|png|jpeg";
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('favicon_img')) {
                    $res1 = $this->Common_model->select('jp_setting', 2, 'id');
                    $img = $res1->fevi;
                    if (!empty($img)) {
                        unlink('./' . $img);
                    }
                    $d1 = $this->upload->data();
                    $d2 = $d1['file_name'];
                    $d3 = 'uploads/setting/' . $d2;
                    $arr = array('fevi' => $d3);
                    if ($this->Common_model->updateData('jp_setting', $arr, '2', 'id')) {
                        echo "update";
                    } else {
                        echo "Favicon not updated";
                    }
                } else {
                    echo "Favicon Only JPG And PNG File Allowed";
                }
            }
            if (!empty($logo_img)) {
                $config['upload_path'] = "./uploads/setting";
                $config['allowed_types'] = "jpg|png|jpeg";
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('logo_img')) {
                    $res1 = $this->Common_model->select('jp_setting', 2, 'id');
                    $img = $res1->logo_img;
                    if (!empty($img)) {
                        unlink('./' . $img);
                    }
                    $d1 = $this->upload->data();
                    $d2 = $d1['file_name'];
                    $d3 = 'uploads/setting/' . $d2;
                    $arr = array('logo_img' => $d3);
                    if ($this->Common_model->updateData('jp_setting', $arr, '2', 'id')) {
                        echo "update";
                    } else {
                        $this->session->set_flashdata('msg', 'nup');
                        $url = "admin/website_setting";
                        redirect('admin/website_setting');
                    }
                } else {
                    echo "Logo Only JPG And PNG File Allowed";
                }
            }
            if (!empty($bg_img)) {
                $res1 = $this->Common_model->select('jp_setting', 2, 'id');
                $img = $res1->bg_img;
                /*if(!empty($img))
                {
                unlink(base_url($img));

                }*/
                $config['upload_path'] = "./uploads/setting";
                $config['allowed_types'] = "jpg|png|jpeg";
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('bg_img')) {
                    $d1 = $this->upload->data();
                    $d2 = $d1['file_name'];
                    $d3 = 'uploads/setting/' . $d2;
                    $arr = array('bg_img' => $d3);
                    if ($this->Common_model->updateData('jp_setting', $arr, '2', 'id')) {
                        echo "update";
                    } else {
                        echo "Background Image Not updated";
                    }
                } else {
                    echo "Background Image Only JPG And PNG File Allowed";
                }
            } else if (!empty($contect_img)) {
                $config['upload_path'] = "./uploads/setting";
                $config['allowed_types'] = "jpg|png|jpeg";
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('contect_img')) {
                    $res1 = $this->Common_model->select('jp_setting', 2, 'id');
                    $img = $res1->contect_img;
                    if (!empty($img)) {
                        unlink('./' . $img);
                    }
                    $d1 = $this->upload->data();
                    $d2 = $d1['file_name'];
                    $d3 = 'uploads/setting/' . $d2;
                    $arr = array('contect_img' => $d3);
                    if ($this->Common_model->updateData('jp_setting', $arr, '2', 'id')) {
                        echo "update";
                    } else {
                        echo "Contect Us Image not updated";
                    }
                } else {
                    echo "Contect us Image Only JPG And PNG File Allowed";
                }
            } else if (!empty($about_img)) {
                $config['upload_path'] = "./uploads/setting";
                $config['allowed_types'] = "jpg|png|jpeg";
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('about_img')) {
                    $res1 = $this->Common_model->select('jp_setting', 2, 'id');
                    $img = $res1->about_img;
                    if (!empty($img)) {
                        unlink('./' . $img);
                    }
                    $d1 = $this->upload->data();
                    $d2 = $d1['file_name'];
                    $d3 = 'uploads/setting/' . $d2;
                    $arr = array('about_img' => $d3);
                    if ($this->Common_model->updateData('jp_setting', $arr, '2', 'id')) {
                        echo "update";
                    } else {
                        echo "About Us Image  not updated";
                    }
                } else {
                    echo "About us Image Only JPG And PNG File Allowed";
                }
            } else if (!empty($main_loder)) {
                $config['upload_path'] = "./uploads/setting";
                $config['allowed_types'] = "svg|png|gif";
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('main_loder')) {
                    $res1 = $this->Common_model->select('jp_setting', 2, 'id');
                    $img = $res1->main_loder;
                    if (!empty($img)) {
                        unlink('./' . $img);
                    }
                    $d1 = $this->upload->data();
                    $d2 = $d1['file_name'];
                    $d3 = 'uploads/setting/' . $d2;
                    $arr = array('main_loder' => $d3);
                    if ($this->Common_model->updateData('jp_setting', $arr, '2', 'id')) {
                        echo "update";
                    } else {
                        echo "Site Loader  not updated";
                    }
                } else {
                    echo "Site Loader Only GIF AND SVG File Allowed";
                }
            }
        } else {
            echo "Please select image";
        }
    }
    public function revenue()
    {
        $arr = $this->input->post();
        if (!empty($arr)) {
            if (array_key_exists('condation', $arr)) {
                if ($arr['condation'] == 'number_job_post') {
                    $arr['value2'] = "";

                } else if ($arr['condation'] == 'num_of_resume_download') {
                    $arr['value1'] = "";

                } else if ($arr['condation'] == 'applay_both_condation') {

                } else {
                    echo "";
                }
                $a = array('type1' => 'xd');
                $this->db->where('id', '1');
                $res = $this->db->update('jp_revenue', $arr);
                if ($res) {
                    echo "Update";
                } else {
                    echo "Not uPDATE";
                }
            } else {
                echo "not";
            }
        }
    }

    public function revenue2()
    {
        $arr = $this->input->post();
        if (!empty($arr)) {
            if (array_key_exists('condation', $arr)) {
                if ($arr['condation'] == 'number_job_post') {
                    $arr['value2'] = "";

                } else if ($arr['condation'] == 'num_of_resume_download') {
                    $arr['value1'] = "";

                } else if ($arr['condation'] == 'applay_both_condation') {

                } else {
                    echo "";
                }
                $a = array('type1' => 'xd');
                $this->db->where('id', '1');
                $res = $this->db->update('jp_revenue', $arr);
                if ($res) {
                    echo "Update";
                } else {
                    echo "Not uPDATE";
                }
            } else {
                echo "not";
            }
        }
    }
    public function google_code()
    {
        $data = $this->input->post();
        if (!empty($data)) {
            unset($data[0]);
            $update_data_res = $this->Common_model->updateData('jp_setting', $data, '2', 'id');
            if ($update_data_res) {
                echo "Update";
            } else {
                echo "Data Not Update";
            }
        }
    }
    public function cookie_text_s()
    {
        $data = $this->input->post();
        if (!empty($data)) {
            unset($data[0]);
            $update_data_res = $this->Common_model->updateData('jp_setting', $data, '2', 'id');
            if ($update_data_res) {
                echo "Update";
            } else {
                echo "Data Not Update";
            }
        }
    }
    public function status_change($tbl_name = '')
    {
        $id = $this->input->post('id');
        $status1 = $this->input->post('status1');
        if (isset($id)) {
            $s1 = array('status' => $status1);
            $res = $this->Common_model->updateData($tbl_name, $s1, $id, 'id');
            if ($res) {
                echo "Update";
            } else {
                echo "Not Update";
            }
        }

    }
    //language
    public function add_language()
    {
        $addnewlanguage = $this->input->post('addnewlanguage');
        $alter_res = $this->Common_model->alter_table('jp_language', $addnewlanguage);
        $data_arr = array('name' => $addnewlanguage);
        $this->Common_model->insert('jp_language_name', $data_arr);
        if ($alter_res) {
            echo "Add";
        } else {
            echo "not add";
        }

    }
    public function language_add()
    {
        $language_info = $this->Common_model->select('jp_language', 'home_page', 'language_type');
        $language_menu_info = $this->Common_model->select('jp_language', 'menu_header', 'language_type');
        $language_my_applied_job = $this->Common_model->select('jp_language', 'user_profile_page', 'language_type');
        $language_login_page = $this->Common_model->select('jp_language', 'login_page', 'language_type');
        $language_register_page = $this->Common_model->select('jp_language', 'register_page', 'language_type');
        $language_req_herder_page = $this->Common_model->select('jp_language', 'recruiter_header', 'language_type');
        $language_req_profile_page = $this->Common_model->select('jp_language', 'recruiter_profile_page', 'language_type');
        $language_recruiter_home = $this->Common_model->select('jp_language', 'recruiter_home', 'language_type');
        $language_job_post_page = $this->Common_model->select('jp_language', 'job_post_page', 'language_type');
        $language_validation_page = $this->Common_model->select('jp_language', 'validation', 'language_type');
        $language_job_single_page = $this->Common_model->select('jp_language', 'single_job', 'language_type');
        $language_my_applied_job_page = $this->Common_model->select('jp_language', 'my_applied_job_page', 'language_type');
        $language_applied_seeker_page = $this->Common_model->select('jp_language', 'applied_seeker', 'language_type');
        $language_seeker_info = $this->Common_model->select('jp_language', 'seeker_info', 'language_type');
        $language_applied_job_info = $this->Common_model->select('jp_language', 'applied_job_info', 'language_type');
        $language_revenue_plans = $this->Common_model->select('jp_language', 'revenue_plans', 'language_type');
        $language_payment = $this->Common_model->select('jp_language', 'payment', 'language_type');
        $language_term = $this->Common_model->select('jp_language', 'compliamce', 'language_type');
        $language_name = $this->Common_model->select('jp_language_name');
        $this->load->view('admin/common/header');
        $data['language_info'] = $language_info;
        $data['language_name'] = $language_name;
        $data['language_menu_info'] = $language_menu_info;
        $data['language_my_applied_job'] = $language_my_applied_job;
        $data['language_login_page'] = $language_login_page;
        $data['language_register_page'] = $language_register_page;
        $data['language_req_herder_page'] = $language_req_herder_page;
        $data['language_req_profile_page'] = $language_req_profile_page;
        $data['language_job_post_page'] = $language_job_post_page;
        $data['language_job_single_page'] = $language_job_single_page;
        $data['language_validation_page'] = $language_validation_page;
        $data['language_my_applied_job_page'] = $language_my_applied_job_page;
        $data['language_applied_seeker_page'] = $language_applied_seeker_page;
        $data['language_seeker_info'] = $language_seeker_info;
        $data['language_applied_job_info'] = $language_applied_job_info;
        $data['language_revenue_plans'] = $language_revenue_plans;
        $data['language_payment'] = $language_payment;
        $data['language_term'] = $language_term;
        $data['language_recruiter_home'] = $language_recruiter_home;
        $this->load->view('admin/language_add', $data);
        $this->load->view('admin/common/footer');
    }
    public function language_update_pop()
    {
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $res = $this->Common_model->select('jp_language', $id, 'language_id');
        $update_data = $res->$field;
        $this->load->view('admin/module/language_update_pop', ['name' => $update_data, 'id' => $id, 'field' => $field]);
    }
    public function languageUpdatefinal()
    {
        $data = $this->input->post();
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        unset($data['id']);
        unset($data['field']);
        unset($data['id_web']);
        unset($data['id_db']);
        $res = $this->Common_model->updateData('jp_language', $data, $id, 'language_id');
        if ($res) {
            echo "Update";
        } else {
            echo "Not Update";
        }

    }
    public function change_language()
    {
        $data = $this->input->post('language_name');
        $arr = array('language' => $data);
        $res = $this->Common_model->updateData('jp_setting', $arr, '2', 'id');
        if ($res) {
            echo "update";
        } else {
            echo "not update";
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('uname');
        $this->session->set_flashdata('logout', 'logout');
        $url = "admin/";
        redirect('admin/');
    }
    public function compliamce_pages()
    {
        $this->load->view('admin/common/header');
        $setting_info = $this->Common_model->select('jp_setting', '2', 'id');
        $row = $this->Common_model->select('jp_contect_us');
        $this->load->view('admin/compliamce_pages', ['setting_info' => $setting_info, 'row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function privacy_policy_set()
    {
        $editor_data = $this->input->post('tc');
        $field = $this->input->post('field');
        $date_type = $this->input->post('date_type');
        $arr = array();
        if ($field == 'terms_condition' || $field == 'privacy_policy') {
            $arr = array($field => $editor_data, $date_type => date("jS  F Y "));
        } else {
            $arr = array($field => $editor_data);
        }
        // print_r($arr);die;
        $res = $this->Common_model->updateData('jp_setting', $arr, '2', 'id');
        if ($res) {
            echo "Update";
        } else {
            echo "Not Update";
        }

    }
    public function ads_integration()
    {
        $a = $this->db->get('jp_custom_ads');
        $ads = $a->row();
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        $data['ads'] = $ads;
        $data['res'] = $res;
        $this->load->view('admin/common/header');
        $this->load->view('admin/ads_integration', $data);
        $this->load->view('admin/common/footer');
    }
    public function payment()
    {
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        $this->load->view('admin/common/header');
        $this->load->view('admin/payment', ['res' => $res]);
        $this->load->view('admin/common/footer');
    }
    public function payment_method_update()
    {
        $data = $this->input->post();
        $res = $this->Common_model->updateData('jp_setting', $data, '2', 'id');
        if ($res) {
            echo "Insert";
        } else {
            echo "not insert";
        }

    }
    public function custon_add_update()
    {
        $data = $this->input->post();
        $img = $_FILES['add_img']['name'];
        $home_page = $this->input->post('home_page');
        $single_page_top = $this->input->post('single_page_top');
        $single_page_bottom = $this->input->post('single_page_bottom');
        $both_page = $this->input->post('both_page');
        $link1 = $this->input->post('link1');
        if (!array_key_exists('home_page', $data)) {
            $data['home'] = 'no';
        }
        if (!array_key_exists('single_page_top', $data)) {
            $data['single_page_top'] = 'no';
        }
        if (!array_key_exists('single_page_bottom', $data)) {
            $data['single_page_bottom'] = 'no';
        }
        if (!array_key_exists('both_page', $data)) {
            $data['both_page'] = 'no';
        }
        $custom_ads_info = $this->Common_model->select('jp_custom_ads', '1', 'id');
        $image = $custom_ads_info->add_img;
        if (empty($img)) {
            if ($image) {
                $res = $this->Common_model->updateData('jp_custom_ads', $data, '1', 'id');
                if ($res) {
                    echo "Update";
                } else {
                    echo "Not Update";
                }
            } else {
                $config['allowed_types'] = 'jpg|png|jpeg';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('add_img')) {
                    $data1 = $this->upload->data();
                    $d2 = $data1['file_name'];
                    $d3 = 'uploads/ads/' . $d2;
                    $data['add_img'] = $d3;
                    $res = $this->Common_model->updateData('jp_custom_ads', $data, '1', 'id');
                    if ($res) {
                        echo "Update";
                    } else {
                        echo "Not Update";
                    }

                } else {
                    echo "jpg_png";
                }

            }
        } else {
            $config['upload_path'] = './uploads/ads';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('add_img')) {
                $data1 = $this->upload->data();
                $d2 = $data1['file_name'];
                $d3 = 'uploads/ads/' . $d2;
                $data['add_img'] = $d3;
                $res = $this->Common_model->updateData('jp_custom_ads', $data, '1', 'id');
                if ($res) {
                    echo "Update";
                } else {
                    echo "Not Update";
                }

            } else {
                echo "jpg_png";
            }
        }
        /*'home_page',:home_page,'single_page_top':single_page_top,'single_page_bottom':single_page_bottom,'both_page':both_page,'link':link1*/
    }
    public function notification()
    {

        // $data['res']=$this->Common_model->select('jp_notification') order_by("id","desc");
        $data['res'] = $this->db->query('SELECT * FROM jp_notification ORDER BY id DESC')->result();

        $this->load->view('admin/notification', $data);
    }
    public function delete_notification($id = '')
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('jp_notification', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/notification');
        }
    }
    public function send_notification()
    {
        $data = $this->input->post();
        $title = $this->input->post('title');
        $message = $this->input->post('message');
        $notification_type = $this->input->post('notification_type');

        if (!empty($message)) {

            $res = $this->Common_model->select($notification_type);
            $tokens = array();
            foreach ($res as $r1) {
                $backup = $r1->token;
                if (!empty($backup)) {
                    $tokens[] = $backup;
                }

            }
            $message = array(
                "body" => $message,
                "title" => $title,
                "notification_type" => $notification_type,
            );
            $t = array_unique($tokens);
            $t2 = implode(" ", $t);
            $t3 = explode(" ", $t2);
            $message_status = $this->send_notification1($t3, $message, $notification_type);
            $res = $this->Common_model->insert('jp_notification', $data);
            if ($res) {
                // $this->push($title, $message, $notification_type);
                echo "Insert";
            } else {
                echo "Not Insert";
            }
        }
    }
    public function send_notification1($tokens, $message, $notification_type = '')
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $tokens,
            'notification' => $message,
            'notification_type' => $notification_type,
        );

        $headers = array(
            'Authorization:key =AAAAjbnnjmo:APA91bEhva7-YuNdygbwldoC-KwibNq-Jn-FFQOqEIy9F3HllzkPdog4AjaiQudqJm5WT_8lghNAp2pnWxnW9FFu5Wy1Kp3v_wgiKeeQCq6n7AyzJsBvyaH6dmBBJBHDKwY3jfzZbQGj',
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
    public function push($name, $desi, $type)
    {
        $res = $this->Common_model->select($type);
        $tokens = array();
        foreach ($res as $r1) {
            $backup = $r1->token;
            if (!empty($backup)) {
                $tokens[] = $backup;
            }

        }
        $message = array(
            "body" => $desi,
            "title" => $name,
            "type" => $type,
        );
        $t = array_unique($tokens);
        $t2 = implode(" ", $t);
        $t3 = explode(" ", $t2);
        $message_status = $this->send_notification1($t3, $message);

    }
    public function transaction()
    {
        $this->load->view('admin/common/header');
        $res = $this->Common_model->select('jp_payment');
        $this->load->view('admin/transaction', ['row' => $res]);
        $this->load->view('admin/common/footer');
    }
    public function social_login()
    {
        $this->load->view('admin/common/header');
        $res = $this->Common_model->select('jp_setting', '2', 'id');
        $this->load->view('admin/social_login', ['social_info' => $res]);
        $this->load->view('admin/common/footer');
    }
    public function google_login_information()
    {
        $data = $this->input->post();
        $res = $this->Common_model->updateData('jp_setting', $data, '2', 'id');
        if ($res) {
            echo "Insert";
        } else {
            echo "not insert";
        }

    }

    public function chat_system_update()
    {
        $data = array('chat_system' => $_POST['check']);
        $res = $this->Common_model->updateData('jp_setting', $data, '2', 'id');
        if ($res) {
            echo "1";
        } else {
            echo "0";
        }

    }

    public function review()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('jp_review');
        $this->load->view('admin/review', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    // function edit_seekers($id){
    //         $data["getseeker"] = $this->db->query("select * from `seeker` WHERE id=".$id)->row();
    //      //echo "<pre>";print_r($data);die;
    //      $this->load->view('admin/editseekers',$data);
    // }

    public function edit_seekers($id = "")
    {

        $row['seeker'] = $this->Common_model->select('seeker', 'Active', 'status');
        $row['location'] = $this->Common_model->select('location', 'Active', 'status');
        $row['job_role'] = $this->Common_model->select('job_role', 'Active', 'status');
        $row['job_types'] = $this->Common_model->select('job_types', 'Active', 'status');

        $row['designation'] = $this->Common_model->select('designation', 'Active', 'status');
        $row['specialization'] = $this->Common_model->select('specialization', 'Active', 'status');
        $row['currentctc'] = $this->Common_model->select('currentctc_tbl', 'Active', 'status');
        $row['expectedctc'] = $this->Common_model->select('expectedctc_tbl', 'Active', 'status');
        $row['experience'] = $this->Common_model->select('experience', 'Active', 'status');

        $row["getseeker"] = $this->db->query("select * from `seeker` WHERE id=" . $id)->row();

        //echo "<pre>";print_r($row);die;
        $this->load->view('admin/common/header');
        $this->load->view('admin/editseekers', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }

    public function Updateseeker()
    {

        // print_r($_POST);die;
        $resume_file1 = $_FILES['resume']['name'];

        if (!empty($resume_file1)) {

            $id = $this->input->post("id");
            $seeker_info = $this->db->query("SELECT * FROM seeker WHERE  id='" . $id . "'")->row();

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
                $resume = $d3;

                // unset($data['rps']);

            } else {
                echo "Uploaded file is not a valid resume file. Only PDF and DOC files are allowed";
            }

        } else {
            $resume = '';
        }
        // print_r($resume_file1);die;

        if (!empty($_FILES['profile']['name'])) {

            $config['upload_path'] = './uploads/profile';

            $config['allowed_types'] = 'img|jpg|jpeg|png|gif';

            $config['file_name'] = time() . rand(10000, 99999) . ".jpg";
            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            if ($this->upload->do_upload('profile')) {

                $uploadData1 = $this->upload->data();

                $profile_data = $uploadData1['file_name'];

            } else {

                $profile_data = '';

            }

        }

        $ps = $this->input->post('ps');
        $ps1 = md5($ps);

        $data = array(
            "name" => $this->input->post("name"),
            "surname" => $this->input->post("surname"),
            "email" => $this->input->post("email"),
            "mno" => $this->input->post("mno"),
            "qua" => $this->input->post("qua"),
            "p_year" => $this->input->post("p_year"),
            "gender" => $this->input->post("gender"),
            "city" => $this->input->post("city"),
            "current_address" => $this->input->post("current_address"),

            "current" => $this->input->post("current"),
            "expected" => $this->input->post("expected"),
            "location" => $this->input->post("location"),
            "keyskills" => $this->input->post("keyskills"),
            "cgpa" => $this->input->post("cgpa"),

            "job_role" => $this->input->post("job_role"),
            "job_type" => $this->input->post("job_type"),
            "designation" => $this->input->post("designation"),
            "specialization" => $this->input->post("specialization"),
            "exp" => $this->input->post("exp"),
        );
		if(isset($resume) && $resume != "") {
			$data['resume'] = $resume;
		}

		if(isset($profile_data) && $profile_data != "") {
			$data['profile'] = $profile_data;
		}

		if($ps != "") {
			$data['ps'] = $ps1;
			$data['ps2'] = $ps;
		}

        $id = $this->input->post("id");

        $this->load->model("common_model");
        $insert = $this->Common_model->updateData('seeker', $data, $id, 'id');
        // print_r($this->db->last_query());die;

        if ($insert) {
            $this->session->set_flashdata("message", '<div class="alert alert-success alert-dismissible" role="alert">
                                <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your request added successfully...
                            </div>');
            redirect('admin/seekers');
        } else {
            $this->session->set_flashdata("error", '<div class="alert alert-success alert-dismissible" role="alert">
                                <i class="fa fa-check"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Success!</strong> Your category not added...
                           </div>');
            redirect('admin/seekers');
        }

    }

	public function notice_periods()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('notice_periods');
        $this->load->view('admin/notice_periods', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_notice_period()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('notice_periods', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/notice_periods');
        }
    }

	public function skills()
    {
        $this->load->view('admin/common/header');
        $row = $this->Common_model->select('skills');
        $this->load->view('admin/skills', ['row' => $row]);
        $this->load->view('admin/common/footer');
    }
    public function delete_skill()
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $res = $this->Common_model->delete('skills', $id, 'id');
            $this->session->set_flashdata('msg', 'Deleted');
            redirect('admin/skills');
        }
    }

}
