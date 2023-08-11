<?php
if(!empty($jobs))
{
?>
<ul>
<?php
foreach($jobs as $job)
{	
						$data=$this->Common_model->select('recruiter',$job->r_id,'email');	
						$data2=$data->name;	
						$string = str_replace(' ', '-',$data2);
						$string = str_replace('#', '-',$string);
						$string = str_replace('@', '-',$string);
						$sp=strtolower($job->specialization);
						$sp2=str_replace(' ', '-', $sp);
						$location=strtolower($job->job_location);
						$location2=str_replace(' ', '-',$location);	
	
	?>
							<li>
								<a href="<?= base_url('Home/user_jobsingle/'.$job->id.'/'.$sp2.'-'.'jobs-in-'.$string.'-'.$location2) ?>">
									<div class="jpsr_item">
										<div class="jpsr_title">
											<span class="title"><?= $job->specialization; ?></span>
											<span class="skills"><?= $job->technology; ?></span>
										</div>
										<div class="jpsr_location">
											<span><img src="http://pixelpages.net/job_portal/assets/images/location.svg" alt=""/> <?= $job->job_location; ?></span>
										</div>
									</div>
								</a>
							</li>
	<?php
}
}
else
{
	                echo $controller->set_language('filter_error');
}
?>
</ul>
</ul>