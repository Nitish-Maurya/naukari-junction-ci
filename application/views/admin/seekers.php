<?php
   $msg=$this->session->flashdata('msg');
   if(isset($msg))
   {
?>
	<div class="hs_alert_wrapper open_alert  hs_success msg1">
	   <!-- use this classes here - "open_alert" and "hs_success" and "hs_error"  -->
	   <div class="hs_alert_inner">
	      <p> <span class="icon"></span>1 Seeker <?= $msg ?></p>
	   </div>
	</div>
<?php
   }
?>

<div class="row">
   	<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
      <div class="hs_heading medium">
         <h3>All Seekers (<?= $this->Common_model->row_count('seeker'); ?>)
         </h3>
      </div>
  	</div>
  	<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 text-right">
         <div class="toolbar">
            <div class="export-btn">
        		<a href="<?= site_url('admin/add_seekers')?>" class="btn" data-toggle="modal">Add new</a>
               	<a id="exportBtn2" href="<?php echo base_url();?>/admin/allseekerExport" class="btn bg-green btn-flat download_btn">
                  	<i class="fa fa-cloud-download"></i> Download
                  <div class="ripple-container"></div>
               	</a>
            </div>
         </div>
      </div>
</div>
<div class="hs_datatable_wrapper table-responsive">
   <table class="hs_datatable table table-bordered">
      	<thead>
	     	<tr>
	            <th>S.No</th>
	            <th>First Name</th>
				<th>Last Name</th>
	            <th>Email</th>
				<th>Password</th>
	            <th>Mobile</th>
	            <th>Status</th>
	            <th>Action</th>
	     	</tr>
      	</thead>
      	<tbody>
         	<?php
	            if(isset($row))
	            {
	            	$i=1;
	            	foreach($row as $r1)
	            	{

					
    		?>		
         		<tr>
            		<td><?= $i++; ?></td>
		            <td width="200">
		               <div class="hs_user">
		                  <div class="user_name">
		                     <p><?= $r1->name; ?></p>
		                  </div>
		               </div>
		            </td>
					<td width="200">
		               <div class="hs_user">
		                  <div class="user_name">
		                     <p><?= $r1->surname; ?></p>
		                  </div>
		               </div>
		            </td>
            		<td><?= $r1->email; ?></td>
					<td><?= $r1->ps2; ?></td>
            		<td><?= $r1->mno; ?></td>
		            <td>
		               <select id="seeker<?= $r1->id; ?>" onchange="seeker_status(<?=  $r1->id; ?>)">
		                  <option <?php  if($r1->status=='Active') { echo "selected"; } ?> >Active</option>
		                  <option <?php  if($r1->status=='Inactive') { echo "selected"; } ?> >Inactive</option>
		               </select>
		            </td>
		            <td width="200">
		               <a  class="btn" href="<?= site_url('admin/edit_seekers/')?><?= $r1->id?>" title="Edit" data-name="Dentist" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
		               <a  class="btn" title="Delete" onclick="delete_conform(<?= $r1->id;  ?>,'seeker')" ><i class="fa fa-trash" aria-hidden="true"></i></a>
					 
		            </td>
         		</tr>
         	<?php
            		}
            	}
            ?>
      </tbody>
   </table>
</div>
<!-- add seeker popup start -->
<div id="add_seeker_popup" class="modal fade" role="dialog">
   <div class="modal-dialog">
      	<div class="modal-content">
	     	<div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h4 class="modal-title">Add new seeker</h4>
	     	</div>
         	<form id="f1">
            	<input type="hidden" value="yes" name="veri" />
        		<div class="modal-body">
	               	<div class="hs_input">
	                  <label>Name</label>
	                  <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control">
	               	</div>
	               	<div class="hs_input">
	                  <label>Email</label>
	                  <input type="email" name="email" id="email" placeholder="Enter E-Mail" class="form-control">
	               	</div>
	               	<div class="hs_input">
	                  <label>Mobile No</label>
	                  <input type="number" name="mno" id="mno"   placeholder="Enter Mobile Number" class="form-control" pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$" title="Enter Valid mobile number ex.9811111111" required>
	               	</div>
	               	<div class="hs_input">
	                  <label>Password</label>
	                  <input type="password" name="ps" id="ps" placeholder="Enter Password" class="form-control">
	               	</div>
	               	<div class="hs_input">
	                  <label>Confirm Password</label>
	                  <input type="password" name="rps" id="rps" placeholder="Confirm Password" class="form-control">
	               	</div>
           			<div class="hs_input">
              			<div class="hs_checkbox">
                 			<input type="checkbox" id="send_detail" value='yes' name="send_detail">
             				<label for="send_detail">Send this details to this Seeker's Email</label>
              			</div>
              		</div>
              	</div>
         	</form>
     	</div>
     	<input type="button" name="btn" class="btn" id="seeker_add" value="Save" title="Save" />
 	</div>
</div>
   
<!-- add seeker popup end -->
<div id="delete_seeker_popup" class="modal" role="dialog">
   	<div class="modal-dialog">
      	<div class="modal-content">
         	<div class="modal-header">
            	<button  type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Do you want to delete this seeker</h4>
         	</div>
         	<div class="modal-body">
         		<!-- <form action="<?= site_url('admin/delete_seeker'); ?>" method="POST" > -->
         			<?= form_open('admin/delete_seeker'); ?>
		            <div class="hs_input">
		               <input type="hidden" name="id" id="disp_data" value="">
		            </div>
            		<input type="submit" name="sub" class="btn" value="Yes">
            		<input type="button"  class="btn" value="No" id="no_btn">
       
         	</div>
      	</div>
   	</div>
</div>
<!-- update seeker popup start -->
<div id="update_seeker_popup" class="modal" role="dialog">
   	<div class="modal-dialog">
      	<div class="modal-content">
         	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal">&times;</button>
            	<h4 class="modal-title">Show Password</h4>
         	</div>
         	<div id="data_disp">
            	<div class="modal-body">
               		<form id="update_seeker_form">
	                  	<input type="hidden" value="yes" name="veri" />
	                 
	                  	<div class="hs_input">
	                     	<label>Email</label>
	                     	<input type="text" name="email" id="us_email" placeholder="Enter E-Mail" value="" class="form-control">
	                  	</div>
	                  	<div class="hs_input">
	                     	<label>Password</label>
	                     	<input type="text" name="mno" value="" id="us_mno" placeholder="Enter Mobile Number" class="form-control">
	                  	</div>
	                  
               		</form>
            	</div>
         	</div>
      	</div>
   	</div>
</div>



<script>
   $(function() {
       $("#booking-modal").iziModal({
           radius: 5,
           padding: 20,
           closeButton: true,           
           title: 'Booking Order',           
           headerColor: '#002e5b',        
           bodyOverflow: true,
           arrowKeys: false,
       });
   })
   
   $(document).on('click', '.booking_order', function (event) {
   event.preventDefault();
   
   var product = $(this).attr('data-seller');

   var product_id =  $(this).attr("data-id");

   var seller_name =  $(this).attr("data-sellername");

   
  
   $('#product').val(product);

   $('#product_id').val(product_id);

   $('#sellername').val(seller_name);
   
   $('#booking-modal').iziModal('open');
   });
</script>
<!-- update  seeker popup end -->