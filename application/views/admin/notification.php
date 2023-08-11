<?php
include('common/header.php');
$msg=$this->session->flashdata('msg');
if(isset($msg))
{
	?>
<div class="hs_alert_wrapper open_alert  hs_success msg1"> <!-- use this classes here - "open_alert" and "hs_success" and "hs_error"  -->
    <div class="hs_alert_inner">
        <p> <span class="icon"></span>1 Recruiter <?= $msg ?></p>
    </div>
</div>
<?php
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Notification</h3>
        </div>
         <div class="row">
			<div class="col-md-8">
				<form id="notification_send_form">
				<input type="hidden" name="date1" value="<?= date("jS  F Y "); ?>">
				<div class="hs_input">
					<label>Type</label>
				    <select class="form-control" name='notification_type'>
						<option value="seeker">Seeker</option>
						<option value="recruiter">Recruiter</option>
					</select>
				</div>
				<div class="hs_input">
					<label>Title</label>
				   <input type="text" id="title" name="title"  class="form-control settingsfields" id="title" placeholder="Enter Title" />
				</div>
				<div class="hs_input">
					<label>Message</label>
				   <textarea name="message" id="message" class="form-control"></textarea>
				</div>
				</form>
				<div class="col-md-12">
					<button onclick="notification_send();" class="btn theme_btn">Send</button>
				</div>
			</div>
		</div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>All Notification </h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Notification Type</th>
                        <th>Title </th>
                        <th>Message</th>
						<th>Date</th>
						 <th>Action</th>

                    </tr>
                </thead>
                <tbody>
					<?php
					if(isset($res))
					{
						$i=1;
						foreach($res as $r1)
						{
							?>		
					 <tr>
                        <td><?= $i++; ?></td>
                        
                        <td><?= $r1->notification_type; ?></td>
                        <td><?= $r1->title; ?></td>
						<td><?= $r1->message; ?></td>
						<td><?= $r1->date1; ?></td>
						 <td width="200">
							<!-- <a  class="btn" title="Delete" onclick="delete_notification(<?= $r1->id;  ?>)" ><i class="fa fa-trash" aria-hidden="true"></i></a> -->
							<a class="btn" title="Delete" onclick="delete_conform(<?= $r1->id;  ?>,'jp_notification')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
					
                     </tr>
					 <?php
						}
					}
					?>
				</tbody>
            </table>
        </div>
    </div>
</div>
<div id="delete_jp_notification_popup" class="modal" role="dialog">
   	<div class="modal-dialog">
      	<div class="modal-content">
         	<div class="modal-header">
            	<button  type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Do you want to delete this notification</h4>
         	</div>
         	<div class="modal-body">
         		<!-- <form action="https://alphawizztest.tk/jobportal/admin/delete_seeker" method="POST" > -->
         			<form action="<?= site_url('admin/delete_notification')?>" method="post" accept-charset="utf-8">
		            <div class="hs_input">
		               <input type="hidden" name="id" id="disp_data" value="">
		            </div>
            		<input type="submit" name="sub" class="btn" value="Yes">
            		<input type="button"  class="btn" value="No" id="no_btn">
       
         	</div>
      	</div>
   	</div>
</div>
<?php
include('common/footer.php');
?>
