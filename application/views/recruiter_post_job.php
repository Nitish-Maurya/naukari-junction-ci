<?php include('common/head-section.php'); ?>
<div class="alert_close jp_alert_wrapper jp_error msg">
	<div class="jp_alert_inner">
			<p class="ng-binding">Please Profile Update</p>
	</div>
</div>
<div class="jp_sidebar_close"></div>
<!-- header start -->
<div class="jp_header" <?php include('module/bg_img.php'); ?>>
    <div class="container">
        <div class="row">
            <?php include('common/header_recruiter.php');
			$s1=$this->session->userdata('recruiter');
			?>   
            <div class="col-md-12">
                <div class="jp_page_title">
                    <h3 id=""><?= $controller->set_language('job_post_heading1'); ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- header end -->

<div class="jp_main_wrapper">
   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <div class="jp_postJob_wrapper">
				<? form_open('Recruiter/job_post') ?>
				<form id="f1">
				<input type="hidden" name="pay_count" value="<?= $pay_count2; ?>">
				<input type="hidden" name="r_id" value="<?= $s1 ?>">
				<input type="hidden" name="post_date" value="<?= date("jS  F Y "); ?>">
				   <div class="jp_job_box">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_type'); ?></label>
                                    <select name="job_type" id="job_type" class="form-control">
                                        <option value="<?= $controller->set_language('job_post_select'); ?>" id="select_keyword"><?= $controller->set_language('job_post_select'); ?></option>
										<?php
										foreach($job_types as $jt)
										{
										?>
										<option value="<?= $jt->name; ?>"><?= $jt->name; ?></option>
										<?php
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('desi'); ?></label>
                                    <select name="designation" id="designation" class="form-control">
										<option value="<?= $controller->set_language('job_post_select'); ?>" id="select_keyword1"><?= $controller->set_language('job_post_select'); ?></option>
                                        <?php
										foreach($designation as $desi)
										{
										?>
										<option value="<?= $desi->name; ?>"><?= $desi->name; ?></option>
										<?php
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('qua'); ?></label>
                                    <select name="qualification" id="qualification" class="form-control">
                                        <option value="<?= $controller->set_language('job_post_select'); ?>" id="select_keyword2"><?= $controller->set_language('job_post_select'); ?></option>
										<?php
										foreach($q as $q1)
										{
										?>
										<option value="<?= $q1->name; ?>"><?= $q1->name; ?></option>
										<?php
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_location'); ?></label>
									<select name="job_location" id="job_location" class="form-control">
                                        <option value="<?= $controller->set_language('job_post_select'); ?>" id="select_keyword3"><?= $controller->set_language('job_post_select'); ?></option>
										<?php
										foreach($loc as $loc1)
										{
										?>
										<option value="<?= $loc1->name; ?>"><?= $loc1->name; ?></option>
										<?php
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('p_year'); ?></label>
                                    <input type="text" name="year_of_passing" placeholder="yyyy-mm-dd" id="year_of_passing" class="form-control datepicker_pyear" />
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_cgpa'); ?></label>
                                    <input type="text" name="pre_cgpa" id="per_cgpa" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('sp'); ?></label>
                                    <select name="specialization" id="specialization" class="form-control">
										<option value="<?= $controller->set_language('job_post_select'); ?>" id="select_keyword4"><?= $controller->set_language('job_post_select'); ?></option>
										<?php
										foreach($spec as $spec1)
										{
										?>
										<option value="<?= $spec1->name; ?>"><?= $spec1->name; ?></option>
										<?php
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_aofs'); ?></label>
                                    <select name="area_of_sector" id="area_of_sector" class="form-control">
                                        <option value="<?= $controller->set_language('job_post_select'); ?>" id="select_keyword5"><?= $controller->set_language('job_post_select'); ?></option>
										<?php
										foreach($aofs as $aofs1)
										{
										?>
										<option value="<?= $aofs1->name; ?>"><?= $aofs1->name; ?></option>
										<?php
										}
										?>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_exp'); ?></label>
                                    <select name="exp" id="exp" class="form-control">
									<option value="<?= $controller->set_language('job_post_select'); ?>" id="select_keyword6"><?= $controller->set_language('job_post_select'); ?></option>
									<?php
									foreach($experience as $exp)
									{
									?>
                                        <option value="<?= $exp->name; ?>"><?= $exp->name; ?></option>
									<?php
									}
									?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('num_if_v'); ?></label>
                                    <input type="text" name="number_of_vacancies" id="specialization" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('last_date_of_a'); ?></label>
                                    <input type="text" name="lasr_date_application" id="lasr_date_application" class="form-control datepicker1" placeholder="yyyy-mm-dd" />
                                </div>
                            </div>
							 <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id="">JOb ROle</label>
                                    <!-- <input type="text" name="technology"  id="technology" class="form-control" /> -->
                                    <select name="technology" id="technology" class="form-control">
									<option value="<?= $controller->set_language('job_post_select'); ?>" id="select_keyword6"><?= $controller->set_language('job_post_select'); ?></option>
									<?php
									foreach($job_role as $exp)
									{
									?>
                                        <option value="<?= $exp->name; ?>"><?= $exp->name; ?></option>
									<?php
									}
									?>
                                    </select>
                                </div>
                            </div>
							<div class="col-md-3">
							 <div class="jp_input_wrapper">
							 <label id=""><?= $controller->set_language('h_pro'); ?></label>
							 <div class="jp_checkbox">
                                    <input type="checkbox" name="written_test" value="Yes" id="written_test" />
                                    <label for="written_test" id=""><?= $controller->set_language('r_j__written_test_k'); ?></label>
                              </div>
							  <div class="jp_checkbox">
                                    <input type="checkbox" name="group_discussion" value="Yes" id="group_discussion" />
                                    <label for="group_discussion" id=""><?= $controller->set_language('r_j__gtoup_d_k'); ?></label>
                              </div>
							  <div class="jp_checkbox">
                                    <input type="checkbox" name="technical_round" value="Yes" id="technical_round" />
                                    <label for="technical_round" id=""><?= $controller->set_language('r_j__r_round_k'); ?></label>
                              </div>
							  <div class="jp_checkbox">
                                    <input type="checkbox" id="hr_round" name="hr_round" value="Yes">
                                    <label for="hr_round" id=""><?= $controller->set_language('r_j__hr_round_k'); ?></label>
                             </div> 
							  </div>
							</div>
                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_desc1'); ?></label>
                                    <textarea name="job_desc" id="job_desc" class="form-control"></textarea>
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('s_range'); ?></label>
                                    <select name="salary_range" id="salary_range" class="form-control">
                                        <option value="<?= $controller->set_language('job_post_select'); ?>" id="select_keyword7"><?= $controller->set_language('job_post_select'); ?></option>
                                        <option value="<?= $controller->set_language('per_year1'); ?>" id=""><?= $controller->set_language('per_year1'); ?></option>
                                        <option value="<?= $controller->set_language('per_month'); ?>" id=""><?= $controller->set_language('per_month'); ?></option>
                                        <option value="<?= $controller->set_language('per_day'); ?>" id=""><?= $controller->set_language('per_day'); ?></option>
                                        <option value="<?= $controller->set_language('per_hour'); ?>" id=""><?= $controller->set_language('per_hour'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('min1'); ?></label>
                                    <input type="text" id="min" name="min" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('max1'); ?></label>
                                    <input type="text" name="max" id="max" class="form-control" />
                                </div>
                            </div>
							<div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('meta_desc1'); ?></label>
                                    <textarea name="meta_desc" id="meta_desc" class="form-control"></textarea>
                                </div>
                            </div>
							<div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('meta_keyword1'); ?></label>
                                    <textarea  name="meta_keyword" id="meta_keyword" class="form-control"></textarea>
                                </div>
                            </div>
							 <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('aname'); ?></label>
                                    <input type="text" name="author" id="author" class="form-control" />
                                </div>
                            </div>
							</form>
                            <div class="col-md-12 text-center">
                                <input type="button" id="pbtn" class="jp_btn" id="" value="<?= $controller->set_language('job_post_btn'); ?>"  />
                            </div>
                        </div>
						
                    </div>
					
               </div>
			  
           </div>
       </div>
   </div>
</div>
<input type="hidden" name="pyear_empty" id="pyear_empty" value="<?= $controller->set_language_v('validation_pyeat'); ?>" class="form-control">
<input type="hidden" name="job_type_empty" id="job_type_empty" value="<?= $controller->set_language_v('job_type_select'); ?>" class="form-control">
<input type="hidden" name="desi_empty" id="desi_empty" value="<?= $controller->set_language_v('select_desi'); ?>" class="form-control">
<input type="hidden" name="loc_empty" id="loc_empty" value="<?= $controller->set_language_v('select_job_loc'); ?>" class="form-control">
<input type="hidden" name="q_empty" id="q_empty" value="<?= $controller->set_language_v('validation_select_qua'); ?>" class="form-control">
<input type="hidden" name="sp_empty" id="sp_empty" value="<?= $controller->set_language_v('select_sp'); ?>" class="form-control">
<input type="hidden" name="aofs_empty" id="aofs_empty" value="<?= $controller->set_language_v('validation_select_aofs'); ?>" class="form-control">
<input type="hidden" name="exp_empty" id="exp_empty" value="<?= $controller->set_language_v('select_exp'); ?>" class="form-control">
<input type="hidden" name="s_range_empty" id="s_range_empty" value="<?= $controller->set_language_v('select_r_range'); ?>" class="form-control">
<input type="hidden" name="cgpa_empty" id="cgpa_empty" value="<?= $controller->set_language_v('enter_per_cgpa'); ?>" class="form-control">
<input type="hidden" name="invelid_cpga" id="invelid_cpga" value="<?= $controller->set_language_v('invelid_per_cgpa'); ?>" class="form-control">
<input type="hidden" name="tech_empty" id="tech_empty" value="<?= $controller->set_language_v('enter_tech'); ?>" class="form-control">
<input type="hidden" name="num_v_empty" id="num_v_empty" value="<?= $controller->set_language_v('enter_number_of_v'); ?>" class="form-control">
<input type="hidden" name="meta_desc_empty" id="meta_desc_empty" value="<?= $controller->set_language_v('enter_meta_desc'); ?>" class="form-control">
<input type="hidden" name="meta_k_empty" id="meta_k_empty" value="<?= $controller->set_language_v('enter_meta_key'); ?>" class="form-control">
<input type="hidden" name="j_desc_empty" id="j_desc_empty" value="<?= $controller->set_language_v('enter_job_desc'); ?>" class="form-control">
<input type="hidden" name="min_selary_empty" id="min_selary_empty" value="<?= $controller->set_language_v('enter_min_s'); ?>" class="form-control">
<input type="hidden" name="maxs_empty" id="maxs_empty" value="<?= $controller->set_language_v('enter_max_S'); ?>" class="form-control">
<input type="hidden" name="min_less_max" id="min_less_max" value="<?= $controller->set_language_v('min_less_max'); ?>" class="form-control">
<input type="hidden" name="max_selary_num" id="max_selary_num" value="<?= $controller->set_language_v('max_s_num'); ?>" class="form-control">
<input type="hidden" name="min_selary_num" id=" min_selary_num" value="<?= $controller->set_language_v(' min_s_num'); ?>" class="form-control">
<input type="hidden" name="job_post_limit_out" id="job_post_limit_out" value="<?= $controller->set_language_v('job_post_limit_out'); ?>" class="form-control">
<input type="hidden" name="plan_exp" id="plan_exp" value="<?= $controller->set_language_v('plan_exp'); ?>" class="form-control">
<input type="hidden" name="job_post_success" id="job_post_success" value="<?= $controller->set_language_v('job_post_success'); ?>" class="form-control">
<input type="hidden" name="job_not_post" id="job_not_post" value="<?= $controller->set_language_v('job_not_post'); ?>" class="form-control">
<?php include('common/footer_recruiter.php'); ?>
<a href="#" id="jp_backToTop" title="Back to top">&uarr;</a>
</body>
</html>