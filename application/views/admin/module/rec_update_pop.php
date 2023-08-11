<?php
if(isset($rec_info))
{
?>
        
<form id="update_rec_form">
<input  type="hidden" name='id' value="<?= $rec_info->id; ?>">
					<div class="hs_input">
				<label>I'M</label>
        </div>
		<!-- <div class="hs_radio_list">
				<div class="hs_radio">		
						<input type="radio" id="employer"  class="employer" name="type" <?php if($rec_info->type=='employer') { echo "checked"; } ?>  value="employer" >		
						<label for="p_yes">Employer</label>	
				</div>	
				<div class="hs_radio">
						<input type="radio" class="pn" <?php if($rec_info->type=='consultant') { echo "checked"; } ?> id="consultant" name="type"  value="consultant" />
						<label for="p_no">Consultant</label>	
				</div>
		</div> -->
	
		<div class="hs_radio_list">
				<div class="hs_radio">		
						<input type="radio" id="p_yes" onclick="plan_show();" class="py" name="type" <?php if($rec_info->type=='company') { echo "checked"; } ?>  value="company" >		
						<label for="p_yes">Employer</label>	
				</div>	
				<div class="hs_radio">
						<input type="radio" class="pn" <?php if($rec_info->type=='consultancy') { echo "checked"; } ?> onclick="plan_hide();" id="p_no" name="type"  value="consultancy" />
						<label for="p_no">Consultant</label>	
				</div>
		</div>
		<div class="hs_input">
					 <label>E-Mail</label>
                    <input disabled type="text" name="email" id="email" class="form-control" value="<?= $rec_info->email; ?>" >
        </div>
         <div class="hs_input">
                    <label>Company Name</label>
                    <input type="text" name="company" id="company" class="form-control" value="<?= $rec_info->company; ?>">
                </div>
                <div class="hs_input">
                    <label>Website</label>
                    <input type="text" name="website" id="website"  class="form-control" value="<?= $rec_info->website; ?>">
                </div>
		<div class="hs_input">
				<label>Payment Done</label>
        </div>
		<div class="hs_radio_list">
				<div class="hs_radio">		
						<input type="radio" id="p_yes" onclick="plan_show();" class="py" name="pay" <?php if($rec_info->pay=='yes') { echo "checked"; } ?>  value="yes" >		
						<label for="p_yes">Yes</label>	
				</div>	
				<div class="hs_radio">
						<input type="radio" class="pn" <?php if($rec_info->pay!='yes') { echo "checked"; } ?> onclick="plan_hide();" id="p_no" name="pay"  value="no" />
						<label for="p_no">No</label>	
				</div>
		</div>
		 <div class="hs_input">
                    <label>Location</label>
                    <input type="text" name="location" id="location" placeholder="Enter Location" class="form-control" value="<?= $rec_info->location; ?>">
                </div>
				
				
		<div class="hs_input" id="plans">
					 <label>Plan</label>
					<select name="plan" class="form-control">
					<?php
					foreach($plan as $plan_single)
					{
					?>
						<option <?php if($rec_info->plan==$plan_single->name) { echo "selected"; } ?> ><?= $plan_single->name ?></option>
					<?php } ?>
					 </select>
                    
        </div>
		<div class="hs_input" id="mon">
					 <label>Month</label>
					<select class="form-control" name="month" >	
						<option  <?php if($rec_info->month=='1') { echo "selected"; } ?> value="1" >1 Month</option>	
						<option <?php if($rec_info->month=='2') { echo "selected"; } ?> value="2">2 Month</option>	
						<option <?php if($rec_info->month=='3') { echo "selected"; } ?> value="3">3 Month</option>
						<option <?php if($rec_info->month=='4') { echo "selected"; } ?> value="4">4 Month</option>	
						<option <?php if($rec_info->month=='5') { echo "selected"; } ?> value="5">5 Month</option>	
						<option <?php if($rec_info->month=='6') { echo "selected"; } ?> value="6">6 Month</option>	
						<option <?php if($rec_info->month=='7') { echo "selected"; } ?> value="7">7 Month</option>	
						<option <?php if($rec_info->month=='8') { echo "selected"; } ?> value="8">8 Month</option>	
						<option <?php if($rec_info->month=='9') { echo "selected"; } ?> value="9">9 Month</option>	
						<option <?php if($rec_info->month=='10') { echo "selected"; } ?> value="10">10 Month</option>	
						<option <?php if($rec_info->month=='11') { echo "selected"; } ?> value="11">11 Month</option>	
						<option <?php if($rec_info->month=='12') { echo "selected"; } ?> value="12">12 Month</option>	
						</select> 
					</div>

					<input type="button" class="btn" onclick="update_recr();" id="update_rec" value="Update">

						
		</form>
		
	
		<!-- <script>
			$(".datepicker").click(function(){
				$(this).datepicker('show');
			});
		</script> -->
<?php
}
?>