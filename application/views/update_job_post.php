<?php include('common/head-section.php'); ?>
<div class="alert_close jp_alert_wrapper jp_error msg">
	<div class="jp_alert_inner">
			<p class="ng-binding">Please Profile Update</p>
	</div>
</div>
<?php
if(isset($msg))
{
	?>
<script>
$('.msg').addClass('alert_open');
$(".ng-binding").text("Enter Percentage/CGPA");
</script>
<?php
}
?>
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
                    <h3 id=""><?= $controller->set_language('edit_job_post_heading'); ?></h3>
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
				<? form_open('api/update_job_post') ?>
				   <div class="jp_job_box">
                        <div class="row">
						 <form id="f1">
						   <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_type'); ?></label>
                                    <form id="f1">
									<input type="hidden" name="r_id" value="<?= $s1 ?>">
									<input type="hidden" name="id" value="<?= $job_post_info->id; ?>">
									<input type="hidden" name="post_date" value="<?= date("jS  F Y "); ?>">
									<select name="job_type" id="job_type" class="form-control">
										<?php
										foreach($job_types as $jt)
										{
										?>
										<option <?php if($jt->name==$job_post_info->job_type){ echo "selected"; } ?>  value="<?= $jt->name; ?>"><?= $jt->name; ?></option>
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
                                        <?php
										foreach($designation as $desic)
										{
										?>
										<option <?php if($desic->name==$job_post_info->designation){ echo "selected"; } ?>  value="<?= $desic->name; ?>"><?= $desic->name; ?></option>
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
                                        <?php
										foreach($q as $q1)
										{
										?>
										<option <?php if($q1->name==$job_post_info->qualification){ echo "selected"; } ?> value="<?= $q1->name; ?>"><?= $q1->name; ?></option>
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
                                        <?php
										foreach($loc as $loc1)
										{
										?>
										<option <?php if($loc1->name==$job_post_info->job_location){ echo "selected"; } ?> value="<?= $loc1->name; ?>"><?= $loc1->name; ?></option>
										<?php
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('p_year'); ?></label>
                                    <input type="text" value="<?= $job_post_info->year_of_passing ?>" name="year_of_passing" id="year_of_passing" class="datepicker_pyear form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_cgpa'); ?></label>
                                    <input type="text" name="pre_cgpa" value="<?=$job_post_info->pre_cgpa; ?>" id="per_cgpa" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('sp'); ?></label>
                                    <select name="specialization" id="specialization" class="form-control">
										<?php
										foreach($spec as $spec1)
										{
										?>
										<option <?php if($spec1->name==$job_post_info->specialization){ echo "selected"; } ?>  value="<?= $spec1->name; ?>"><?= $spec1->name; ?></option>
										<?php
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_aofs'); ?></label>
                                    <select name="area_of_sector" id="area_of_sector" class="form-control">
                                        <?php
										foreach($aofs as $aofs1)
										{
										?>
										<option <?php if($aofs1->name==$job_post_info->area_of_sector){ echo "selected"; } ?> value="<?= $aofs1->name; ?>"><?= $aofs1->name; ?></option>
										<?php
										}
										?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_exp'); ?></label>
                                    <select name="exp" id="exp" class="form-control">
									<?php
									foreach($experience as $exp)
									{
									?>
                                        <option <?php if($exp->name==$job_post_info->exp){ echo "selected"; } ?>  value="<?= $exp->name;  ?>"><?= $exp->name;  ?></option>
                                    <?php
									}
									?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('num_if_v'); ?></label>
                                    <input type="text"  name="number_of_vacancies" id="specialization" value="<?= $job_post_info->number_of_vacancies; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('last_date_of_a'); ?></label>
                                    <input type="text" placeholder="yyyy-mm-dd" value="<?= $job_post_info->lasr_date_application; ?>"  name="lasr_date_application" id="lasr_date_application" class="datepicker1 form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
						         <div class="jp_input_wrapper">
                                    <label  id=""><?= $controller->set_language('tech'); ?></label>
                                    <input type="text" name="technology" placeholder="(ex. Java , C++ etc)" value="<?= $job_post_info->technology; ?>" id="technology" class="form-control" />
                                </div>
                            </div>
							<div class="col-md-3">
							 <div class="jp_input_wrapper">
							 <label id=""><?= $controller->set_language('h_pro'); ?></label>
							 <div class="jp_checkbox">
                                    <input type="checkbox" <?php if($job_post_info->written_test=='Yes') { echo 'checked';  } ?> name="written_test" value="Yes" id="written_test" />
                                    <label for="written_test" id=""><?= $controller->set_language('r_j__written_test_k'); ?></label>
                              </div>
							  <div class="jp_checkbox">
                                    <input type="checkbox" <?php if($job_post_info->group_discussion=='Yes') { echo 'checked';  } ?>  name="group_discussion" value="Yes" id="group_discussion" />
                                    <label for="group_discussion" id=""><?= $controller->set_language('r_j__gtoup_d_k'); ?></label>
                              </div>
							  <div class="jp_checkbox">
                                    <input type="checkbox" <?php if($job_post_info->technical_round=='Yes') { echo 'checked';  } ?>  name="technical_round" value="Yes" id="technical_round" />
                                    <label for="technical_round" id=""><?= $controller->set_language('r_j__r_round_k'); ?></label>
                              </div>
							  <div class="jp_checkbox">
                                    <input type="checkbox" <?php if($job_post_info->hr_round=='Yes') { echo 'checked';  } ?> id="hr_round" name="hr_round" value="Yes">
                                    <label for="hr_round" id=""><?= $controller->set_language('r_j__hr_round_k'); ?></label>
                             </div> 
							  </div>
							</div>
							 <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('job_desc1'); ?></label>
                                    <textarea name="job_desc" class="form-control"><?= $job_post_info->job_desc; ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="jp_input_wrapper">
                                    <label id="s_range"><?= $controller->set_language('meta_keyword1'); ?></label>
                                    <select name="salary_range" id="salary_range" class="form-control">
                                        <option <?php if($job_post_info->salary_range=='Per Year') { echo "selected"; } ?> value="Per Year" id=""><?= $controller->set_language('per_year1'); ?></option>
                                        <option <?php if($job_post_info->salary_range=='Per Month') { echo "selected"; } ?> value="Per Month" id=""><?= $controller->set_language('per_month'); ?></option>
                                        <option <?php if($job_post_info->salary_range=='Per Day') { echo "selected"; } ?> value="Per Day" id=""><?= $controller->set_language('per_day'); ?></option>
                                        <option value="Per Hour" <?php if($job_post_info->salary_range=='Per Hour') { echo "selected"; } ?> id=""><?= $controller->set_language('per_hour'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('min1'); ?></label>
                                    <input type="text" value="<?= $job_post_info->min; ?>"  id="min" name="min" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('max1'); ?></label>
                                    <input type="text" name="max" value="<?= $job_post_info->max; ?>" id="max" class="form-control" />
                                </div>
                            </div>
							<div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('meta_desc1'); ?></label>
                                    <textarea name="meta_desc" id="meta_desc" class="form-control"><?= $job_post_info->meta_desc; ?></textarea>
                                </div>
                            </div>
							<div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('meta_keyword1'); ?></label>
                                    <textarea placeholder="ex . job name , location etc" name="meta_keyword" id="meta_keyword" class="form-control"><?= $job_post_info->meta_keyword; ?></textarea>
                                </div>
                            </div>
							 <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label id=""><?= $controller->set_language('aname'); ?></label>
                                    <input type="text" name="author" value="<?= $job_post_info->author; ?>" id="author" class="form-control" />
									</form>
                                </div>
                            </div>
							</form>
                            <div class="col-md-12 text-center">
								<input type="submit"  class="jp_btn" id="post_update_btn" Value="<?= $controller->set_language('edit_job_btn'); ?>" />
                            </div>
                        </div>
						
                    </div>
					<?= form_close(); ?>
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
<input type="hidden" name="job_up_success1" id="job_post_success1" value="<?= $controller->set_language_v('job_up_success'); ?>" class="form-control">
<input type="hidden" name="job_not_up1" id="job_not_post1" value="saddwqq" class="form-control">
<?php include('common/footer_recruiter.php'); ?>
<a href="#" id="jp_backToTop" title="Back to top">&uarr;</a>
</body>
</html>