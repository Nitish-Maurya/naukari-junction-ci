<div class="col-md-12">
<?php
$img=$res->logo_img;;
$img2='';
if($img)
{
	$img2=base_url().$img;
}
else
{
	$img2=base_url('assets/images/logo_with_text.png');
}
?>
	<div class="jp_header_wrapper">
		<div class="jp_logo">
			<a href="<?= base_url('/recruiter') ?>"><img class="img-responsive" src="<?= $img2; ?>"  alt=""></a>
		</div>
		<div class="jp_header_right">
			<div class="jp_nav">
				<ul>
					<li><a href="<?= base_url('/recruiter'); ?>" id="" ><?= $controller->set_language('my_jobs1'); ?></a></li>
					<li><a href="<?= base_url('recruiter/post_jobs'); ?>" id=""><?= $controller->set_language('post_a_job1'); ?></a></li>
				</ul>
			</div>
			<div class="jp_profile_dd jp_dropdown_wrapper dropdown_right">
				<div class="icon has_image">
				<?php
				$s1=$this->session->userdata('recruiter');
				$res2=$this->Common_model->select('recruiter',$s1,'email');
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
					<img class="img-responsive" src="<?= $imgf; ?>" alt="upload profile Image" />
					
				</div>
				<label>
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="512px" height="512px" viewbox="0 0 48.4 48.4" style="enable-background:new 0 0 48.4 48.4;" xml:space="preserve"><g><path d="M48.4,24.2c0-1.8-1.297-3.719-2.896-4.285s-3.149-1.952-3.6-3.045c-0.451-1.093-0.334-3.173,0.396-4.705 c0.729-1.532,0.287-3.807-0.986-5.08c-1.272-1.273-3.547-1.714-5.08-0.985c-1.532,0.729-3.609,0.848-4.699,0.397 s-2.477-2.003-3.045-3.602C27.921,1.296,26,0,24.2,0c-1.8,0-3.721,1.296-4.29,2.895c-0.569,1.599-1.955,3.151-3.045,3.602 c-1.09,0.451-3.168,0.332-4.7-0.397c-1.532-0.729-3.807-0.288-5.08,0.985c-1.273,1.273-1.714,3.547-0.985,5.08 c0.729,1.533,0.845,3.611,0.392,4.703c-0.453,1.092-1.998,2.481-3.597,3.047S0,22.4,0,24.2s1.296,3.721,2.895,4.29 c1.599,0.568,3.146,1.957,3.599,3.047c0.453,1.089,0.335,3.166-0.394,4.698s-0.288,3.807,0.985,5.08 c1.273,1.272,3.547,1.714,5.08,0.985c1.533-0.729,3.61-0.847,4.7-0.395c1.091,0.452,2.476,2.008,3.045,3.604 c0.569,1.596,2.49,2.891,4.29,2.891c1.8,0,3.721-1.295,4.29-2.891c0.568-1.596,1.953-3.15,3.043-3.604 c1.09-0.453,3.17-0.334,4.701,0.396c1.533,0.729,3.808,0.287,5.08-0.985c1.273-1.273,1.715-3.548,0.986-5.08 c-0.729-1.533-0.849-3.61-0.398-4.7c0.451-1.09,2.004-2.477,3.603-3.045C47.104,27.921,48.4,26,48.4,24.2z M24.2,33.08 c-4.91,0-8.88-3.97-8.88-8.87c0-4.91,3.97-8.88,8.88-8.88c4.899,0,8.87,3.97,8.87,8.88C33.07,29.11,29.1,33.08,24.2,33.08z" fill="#393939"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
				</label>
				<div class="jp_dropdown">
					<div class="jp_dropdown_inner">
						<ul>
							<?php if(isset($_SESSION['chat_system']) && $_SESSION['chat_system'] == 'true'){?>
								<li><a href="<?= base_url('recruiter/my_chats')?>"><?= $controller->set_language('chat_text'); ?> <span class="chatCountHeader"></span> </a></li>
							<?php } ?>
							<li><a href="<?= base_url('recruiter/recruiter_profile')?>" id=""><?= $controller->set_language('r_profile_setting'); ?></a></li>
							<li><a href="<?= base_url('recruiter/logout'); ?>" id="logout"><?= $controller->set_language('r_logout'); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="jp_nav_toggle">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
</div>