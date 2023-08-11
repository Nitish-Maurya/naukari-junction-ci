<?php include('common/head-section.php'); ?>
<div class="alert_close jp_alert_wrapper jp_error msg">
    <div class="jp_alert_inner">
            <p class="ng-binding"><?= $controller->set_language('profile_update_err'); ?></p>
    </div>
</div>
<div class="jp_sidebar_close"></div>
<!-- header start -->
<div class="jp_header" <?php include('module/bg_img.php'); ?>>
    <div class="container">
        <div class="row">
            <?php
				include('common/header_user.php');  
				$name=$res1->name;
				$name_array=explode(" ",$name)
			?>		
				
				<div class="col-md-12">
                <div class="jp_page_title">
                    <h3><?= $name_array[0]."  " ?> <?= $controller->set_language('u_profile_keyword') ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="jp_main_wrapper">
    <div class="jp_profile_wrapper">
        <div class="container">
            <div class="row">
                <div class="jp_job_box">
                   <div class="col-md-4">
                        <div class="jp_profile_image">
                            <div class="image">
                                <?php
                                $img1=$res2->img;
                                $gid=$res2->google_id;
                                $imgf='';
                                //$check=strrpos($img1,"https://");
                                if (filter_var($img1, FILTER_VALIDATE_URL)) {
                                     $imgf=$img1;
                                } else {
                                    $imgf=base_url().$img1;
                                }
                               ?>
                                <img src="<?= $imgf; ?>" alt="">
                                
                               <div class="overlay">
                                    <form id="f2">
                                        <input type="file" name="img"  id="img"  onchange="user_image_upload()">
                                   </form>
                                    <svg x="0px" y="0px" viewbox="0 0 471.2 471.2" style="enable-background:new 0 0 471.2 471.2;" xml:space="preserve" width="512px" height="512px"><g><g><path d="M457.7,230.15c-7.5,0-13.5,6-13.5,13.5v122.8c0,33.4-27.2,60.5-60.5,60.5H87.5c-33.4,0-60.5-27.2-60.5-60.5v-124.8 c0-7.5-6-13.5-13.5-13.5s-13.5,6-13.5,13.5v124.8c0,48.3,39.3,87.5,87.5,87.5h296.2c48.3,0,87.5-39.3,87.5-87.5v-122.8 C471.2,236.25,465.2,230.15,457.7,230.15z" fill="#FFFFFF"/><path d="M159.3,126.15l62.8-62.8v273.9c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5V63.35l62.8,62.8c2.6,2.6,6.1,4,9.5,4 c3.5,0,6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1l-85.8-85.8c-2.5-2.5-6-4-9.5-4c-3.6,0-7,1.4-9.5,4l-85.8,85.8 c-5.3,5.3-5.3,13.8,0,19.1C145.5,131.35,154.1,131.35,159.3,126.15z" fill="#FFFFFF"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                </div>
                            </div>
                            <p></p>
                            <h3><?= $res1->name; ?></h3>
                            <span style ="margin-left:34%;margin-top:8%"><?= $complete_profile ?> % Complete</span>
                        </div>
                    </div>
					<div class="col-md-8">
						<h3 class="jp_title_medium" ><?= $controller->set_language('user_personal_details') ?></h3>	  
					   <? form_open_multipart('Home/
					   '); ?>
						
					  <div class="row">
                            <div class="col-md-12">
								<input  type="hidden" id="counter1" name="counter1" value="<?= $res1->counter ?>" />
                                 <form id="f1" name="f1"> 
								 <input type="hidden" value="1" name="counter">
								<div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_name') ?></label>
                                    <input type="text" name="name" value="<?= $res1->name; ?>" id="name" class="form-control">
                                </div>        
                            </div>
                             <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_surename') ?></label>
                                    <input type="text" value="<?= $res1->surname; ?>" id="surname" name="surname" class="form-control">
                                </div>        
                            </div>
                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_mno') ?></label>
                                    <input type="text" value="<?= $res1->mno; ?>" id="mno" name="mno" class="form-control">
                                </div>        
                            </div>
                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_address') ?></label>
                                    <textarea rows="3"  name="current_address" id="current_address" class="form-control"><?= $res1->current_address; ?></textarea>
                                </div>        
                            </div>
                            

                            <div class="clearfix"></div><br><br>

                            <div class="col-md-12">
                                <h3 class="jp_title_medium" ><?= $controller->set_language('user_location') ?></h3>
                            </div>

                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_location') ?></label>
                                    <select name="location" id="location " class="form-control">
                                        <option <?php if(is_null($res1->location ))  { echo "selected"; } ?> value=""><?= $controller->set_language('user_p_select') ?></option>
										<?php
										foreach($location1 as $loc)
										{
										?>
											<option value="<?= $loc->name; ?>" <?php if($res1->location == $loc->name){ echo "selected"; } ?> ><?= $loc->name; ?></option>
											<?php
										}
										?>
                                    </select>
                                </div>        
                            </div>
                            
                            <!--  <div class="clearfix"></div><br><br>

                            <div class="col-md-12">
                                <h3 class="jp_title_medium" ><?= $controller->set_language('user_job_type') ?></h3>
                            </div> -->

                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_job_type') ?></label>
                                    <select name="job_type" id="job_type" class="form-control">
                                        <option <?php if(is_null($res1->job_type))  { echo "selected"; } ?> value=""><?= $controller->set_language('user_p_select') ?></option>
                                        <?php
                                        foreach($job_type as $type)
                                        {
                                        ?>
                                            <option value="<?= $type->name; ?>" <?php if($res1->job_type == $type->name){ echo "selected"; } ?> ><?= $type->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>        
                            </div>
                             <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('job_role') ?></label>
                                    <select name="job_role" id="job_role" class="form-control">
                                        <option <?php if(is_null($res1->job_role))  { echo "selected"; } ?> value=""><?= $controller->set_language('user_p_select') ?></option>
                                        <?php
                                        foreach($job_role as $role)
                                        {
                                        ?>
                                            <option value="<?= $role->name; ?>" <?php if($res1->job_role == $role->name){ echo "selected"; } ?> ><?= $role->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>        
                            </div>
                            
                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_qualification') ?></label>
                                    <select name="qua" id="qua" class="form-control">
									   <option <?php if(is_null($res1->qua))  { echo "selected"; } ?> value=""><?= $controller->set_language('user_p_select') ?></option>
                                       <?php
										foreach($qualification as $q)
										{
											?>
											<option value="<?= $q->name ?>"<?php if($q->name==$res1->qua){ echo "selected"; } ?>><?= $q->name; ?></option>
											<?php
										}
										?>
                                    </select>
                                </div>        
                            </div>
                            
                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_passing_year') ?></label>
                                    <input type="text" value="<?= $res1->p_year; ?>" name="p_year" id="p_year" placeholder="yyyy-mm-dd" class="datepicker_pyear1 form-control">
                                </div>        
                            </div>
                           <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_currentctc') ?></label>
                                    <select name="current" id="current" class="form-control">
                                        <option <?php if(is_null($res1->current))  { echo "selected"; } ?> value=""><?= $controller->set_language('user_p_select') ?></option>
                                        <?php
                                        foreach($currentctc as $ctc)
                                        {
                                        ?>
                                            <option value="<?= $ctc->name; ?>" <?php if($res1->current == $ctc->name){ echo "selected"; } ?> ><?= $ctc->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>        
                            </div>
                             <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_expectedctc') ?></label>
                                    <select name="expected" id="expected" class="form-control">
                                        <option <?php if(is_null($res1->expected))  { echo "selected"; } ?> value=""><?= $controller->set_language('user_p_select') ?></option>
                                        <?php
                                        foreach($expectedctc as $ctc)
                                        {
                                        ?>
                                            <option value="<?= $ctc->name; ?>" <?php if($res1->expected == $ctc->name){ echo "selected"; } ?> ><?= $ctc->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>        
                            </div>
                             <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('designation') ?></label>
                                    <select name="designation" id="designation" class="form-control">
                                        <option <?php if(is_null($res1->designation))  { echo "selected"; } ?> value=""><?= $controller->set_language('user_p_select') ?></option>
                                        <?php
                                        foreach($designation as $new_designation)
                                        {
                                        ?>
                                            <option value="<?= $new_designation->name; ?>" <?php if($res1->designation == $new_designation->name){ echo "selected"; } ?> ><?= $new_designation->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>        
                            </div>
                             <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('specialization') ?></label>
                                    <select name="specialization" id="specialization" class="form-control">
                                        <option <?php if(is_null($res1->specialization))  { echo "selected"; } ?> value=""><?= $controller->set_language('user_p_select') ?></option>
                                        <?php
                                        foreach($specialization as $new_specialization)
                                        {
                                        ?>
                                            <option value="<?= $new_specialization->name; ?>" <?php if($res1->specialization == $new_specialization->name){ echo "selected"; } ?> ><?= $new_specialization->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>        
                            </div>



                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_cgpa') ?></label>
                                    <input type="text" value="<?= $res1->cgpa; ?>" id="cgpa" name="cgpa" class="form-control">
                                </div>        
                            </div>
                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_aofs') ?></label>
                                    <select name="aofs" id="aofs" class="form-control">
									   <option <?php if(is_null($res1->aofs))  { echo "selected"; } ?> value=""><?= $controller->set_language('user_p_select') ?></option>
									   <?php
										foreach($area_of_sectors1 as $area_sectors)
										{
											?>
											<option value="<?= $area_sectors->name?>"<?php if($area_sectors->name==$res1->aofs){ echo "selected"; } ?>><?= $area_sectors->name; ?></option>
											<?php
										}
										?>
                                    </select>
                                </div>        
                            </div>
							<?php $male_k=strtolower($controller->set_language('male_keyword')); 
								  $female_k=strtolower($controller->set_language('female_keyword'));
							
							?>
							<div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('gender_keyword') ?></label>
									<?php  ?>
                                    <div class="jp_radio_list">
										<div class="jp_radio">
                                            <input <?php if($res1->gender==$male_k) { echo "checked"; } ?> type="radio" value="<?php echo $male_k; ?>" name="gender" id="male">
                                            <label for="male"><?php echo $controller->set_language('male_keyword'); ?></label>
                                        </div>
                                        <div class="jp_radio">
                                            <input type="radio" <?php if($res1->gender==$female_k) { echo "checked"; } ?>  value="<?= $female_k; ?>" name="gender" id="female" >
                                            <label for="female"><?= $controller->set_language('female_keyword') ?></label>
                                        </div>
                                    </div>
                                </div>        
                            </div>
                          <!--   <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_exp') ?></label>
                                    <div class="jp_radio_list">
                                        <?php if($res1->exp==$controller->set_language('exp_keyword')){
											?>
										<div class="jp_radio">
                                            <input type="radio" value="<?= $controller->set_language('fresher_keyword') ?>" name="exp" id="Freasher">
                                            <label for="Freasher"><?= $controller->set_language('fresher_keyword') ?></label>
                                        </div>
                                        <div class="jp_radio">
                                            <input type="radio"  value="<?= $controller->set_language('exp_keyword') ?>" name="exp" id="Experienced " checked>
                                            <label for="Experienced "><?= $controller->set_language('exp_keyword') ?> </label>
                                        </div>
										<?php
										}
										else
										{
											?>
											<div class="jp_radio">
                                            <input type="radio" value="<?= $controller->set_language('fresher_keyword') ?>" name="exp" id="Freasher"  checked>
                                            <label for="Freasher"><?= $controller->set_language('fresher_keyword') ?></label>
											</div>
											<div class="jp_radio">
												<input type="radio" value="<?= $controller->set_language('exp_keyword') ?>" name="exp" id="Experienced ">
												<label for="Experienced "><?= $controller->set_language('exp_keyword') ?> </label>
											</div>
											<?php
										}
										?>
                                    </div>
                                </div>        
                            </div>
 -->
                            <div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_resume') ?></label>
                                    <input type="file" value="c:\abc.jp"  name="resume" id="re" class="form-control">
									<p><?= $controller->set_language('pdf_doc_msg') ?></p>
                                </div>        
                            </div>
							<?php 
							$resume=$res1->resume;
								if(isset($resume))
								{
								?>
								<div class="col-md-12">
                                <div class="jp_input_wrapper">
                                    <p><a href="<?= '../'.$resume; ?>" class="jp_download_link" target="_blank"><span></span><?= $controller->set_language('user_resume_download') ?></a></p>
                                </div>        
                            </div>
                        </div>
								<?php
								}
							?>
							
                        
                        <div class="clearfix"></div><br><br>
                        <h3 class="jp_title_medium" id="user_password_change"></h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_ps') ?></label>
                                    <input type="hidden" name="ps_reserve" id="ps_reserve" value="<?= $res1->ps; ?>">
									<input type="password" name="ps" id="ps" value="" class="form-control">
                                </form>
								
								</div>
								
                            </div>
                            <div class="col-md-6">
                                <div class="jp_input_wrapper">
                                    <label><?= $controller->set_language('user_cps') ?></label>
                                    <input type="password" name="rps" id="rps" value="" class="form-control">
								
							</div>
							
                            </div>							
                        </div>
                    <div class="jp_input_wrapper">
						<button  id="proup_btn" class="jp_btn"><?= $controller->set_language('u_p_save_btn') ?></button>
					</div>   
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
	
</div>
<input type="hidden" name="" id="name_empty" value="<?= $controller->set_language_v('validation_name_empty'); ?>" class="form-control">
<input type="hidden" name="mno_empty" id="mno_empty" value="<?= $controller->set_language_v('validation_mno_empty'); ?>" class="form-control">
<input type="hidden" name="p_loc_select" id="p_loc_select" value="<?= $controller->set_language_v('validation_select_plocation'); ?>" class="form-control">
<input type="hidden" name="qua_select" id="qua_select" value="<?= $controller->set_language_v('validation_select_qua'); ?>" class="form-control">
<input type="hidden" name="aofs_select" id="aofs_select" value="<?= $controller->set_language_v('validation_select_aofs'); ?>" class="form-control">
<input type="hidden" name="cps_empty" id="cps_empty" value="<?= $controller->set_language_v('validation_cps_empty'); ?>" class="form-control">
<input type="hidden" name="valid_mno" id="valid_mno" value="<?= $controller->set_language_v('validation_mno_exists'); ?>" class="form-control">
<input type="hidden" name="c_add_empty" id="c_add_empty" value="<?= $controller->set_language_v('c_address'); ?>" class="form-control">
<input type="hidden" name="p_year_empty" id="p_year_empty" value="<?= $controller->set_language_v('validation_pyeat'); ?>" class="form-control">
<input type="hidden" name="cgpa_empty" id="cgpa_empty" value="<?= $controller->set_language_v('validation_enter_cgpa'); ?>" class="form-control">
<input type="hidden" name="valid_cgpa" id="valid_cgpa" value="<?= $controller->set_language_v('validation_v_cgpa'); ?>" class="form-control">
<input type="hidden" name="ps_not" id="ps_not" value="<?= $controller->set_language_v('validation_ps_not'); ?>" class="form-control">
<input type="hidden" name="ps_short" id="ps_short" value="<?= $controller->set_language_v('validation_password_short'); ?>" class="form-control">
<input type="hidden" name="select_resume_file" id="select_resume_file" value="<?= $controller->set_language_v('validation_select_resume'); ?>" class="form-control">
<input type="hidden" name="profile_update" id="profile_update" value="<?= $controller->set_language_v('validation_profile_success'); ?>" class="form-control">
<input type="hidden" name="profile_not_update" id="profile_not_update" value="<?= $controller->set_language_v('pro_not_up'); ?>" class="form-control">
<?php include('common/footer_user.php'); ?>
<a href="#" id="jp_backToTop" title="Back to top">&uarr;</a>
</body>
</html>
<?php
$msg=$this->session->flashdata('pupdate');
if(isset($msg))
{
    ?>
    <script>
    $('document').ready(function(){
        $('.msg').addClass('alert_open');
        setInterval(function(){ $('.msg').removeClass('alert_open'); }, 3000);
    });
    </script>
    <?php
}
?>