<!-- add seeker popup start -->



<div class="modal-header">
    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
    <h4 class="modal-title">Update seeker</h4>
</div>
<form action="<?php echo base_url('admin/Updateseeker')?>" method="post" enctype="multipart/form-data" class="">
    <!-- <form id="f1" enctype="multipart/form-data" class="" > -->
    <input type="hidden" value="yes" name="veri" />

    <h5>Personal Details</h5>

    <div class="modal-body">
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Name</label>
                <input type="text" name="name" id="name" value="<?= $row['getseeker']->name?>" placeholder="Enter Name"
                    class="form-control" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Surname</label>
                <input type="text" name="surname" value="<?= $row['getseeker']->surname?>" id="name"
                    placeholder="Enter Name" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Email</label>
                <input type="email" name="email" id="email" value="<?= $row['getseeker']->email?>"
                    placeholder="Enter E-Mail" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Mobile No</label>
                <input type="number" name="mno" id="mno" value="<?= $row['getseeker']->mno?>"
                    placeholder="Enter Mobile Number" class="form-control"
                    pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$"
                    title="Enter Valid mobile number ex.9811111111" required>

            </div>
        </div>
        <input type="hidden" value="<?= $row['getseeker']->id?>" name="id" />
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Password</label>
                <input type="password" name="ps" id="ps" value="" placeholder="Enter Password" class="form-control" maxlenght="10">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Confirm Password</label>
                <input type="password" name="rps" id="rps" value="" placeholder="Confirm Password" class="form-control" maxlenght="10">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>High Qualification </label>
                <input type="text" name="qua" id="qua" value="<?= $row['getseeker']->qua?>"
                    placeholder="Enter Qualification" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Year of Passing </label>
                <input type="text" name="p_year" id="p_year" value="<?= $row['getseeker']->p_year?>"
                    placeholder="Year Of  Passing" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Current City </label>
                <input type="text" name="city" id="city" value="<?= $row['getseeker']->city?>" placeholder="City"
                    class="form-control" required>
            </div>
        </div>


        <div class="col-sm-4">
            <div class="hs_input">
                <label>Current Address </label>
                <input type="text" name="current_address" id="current_address"
                    value="<?= $row['getseeker']->current_address?>" class="form-control" required>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="hs_input">
                <label>Key Skills </label>
                <input type="text" name="keyskills" id="keyskills" value="<?= $row['getseeker']->keyskills?>"
                    class="form-control" required>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="hs_input">
                <label>CGPA </label>
                <input type="number" name="cgpa" id="cgpa" value="<?= $row['getseeker']->cgpa?>" class="form-control"
                    required>
            </div>
        </div>




        <div class="col-sm-12">

            <label>Gender</label>
            <br>
            <input type="radio" id="male" name="gender" <?=$row['getseeker']->gender == 'male' ? 'checked' : '';?>
                value="male" required>
            <label for="male">Male</label>

            <input type="radio" id="female" name="gender" <?=$row['getseeker']->gender == 'female' ? 'checked' : '';?>
                value="female" required>
            <label for="female">Female</label><br>

        </div>


        <hr>
        <br>
        <div class="col-sm-12">
            <div class="hs_input">
                <hr>
            </div>
        </div>

        <h5>Professional Details</h5>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Current CTC</label>
                <select class="form-control" aria-label="Default select example" name="current">
                    <option value="">Select All</option>
                    <?php foreach($row['currentctc'] as $new_currentctc){  ?>
                    <option value="<?php echo $new_currentctc->name;?>"
                        <?=$new_currentctc->name == $row['getseeker']->current ? ' selected="selected"' : '';?>>
                        <?php echo $new_currentctc->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Expected CTC</label>
                <select class="form-control" aria-label="Default select example" name="expected">
                    <option value="">Select All</option>
                    <?php foreach($row['expectedctc'] as $new_expectedctc){  ?>
                    <option value="<?php echo $new_expectedctc->name;?>"
                        <?=$new_expectedctc->name == $row['getseeker']->expected ? ' selected="selected"' : '';?>>
                        <?php echo $new_expectedctc->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Location</label>
                <select class="form-control" aria-label="Default select example" name="      location">
                  <option value="">Select All</option>
                  <?php foreach($row['location'] as $new_location){  ?>
                  <option value="<?php echo $new_location->name;?>"
                    <?= $new_location->name == $row['getseeker']->location ? ' selected="selected"' : ''; ?>>
                    <?php echo $new_location->name;?></option>
                  <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Job Role</label>
                <select class="form-control" aria-label="Default select example" name="job_role">
                    <option value="">Select All</option>
                    <?php foreach($row['job_role'] as $new_role){  ?>
                    <option value="<?php echo $new_role->name;?>"
                        <?=$new_role->name == $row['getseeker']->job_role ? ' selected="selected"' : '';?>>
                        <?php echo $new_role->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Job Type</label>
                <select class="form-control" aria-label="Default select example" name="job_type">
                    <option value="">Select All</option>
                    <?php foreach($row['job_types'] as $new_type){  ?>
                    <option value="<?php echo $new_type->name;?>"
                        <?=$new_type->name == $row['getseeker']->job_type ? ' selected="selected"' : '';?>>
                        <?php echo $new_type->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Designation</label>
                <select class="form-control" aria-label="Default select example" name="designation">
                    <option value="">Select All</option>
                    <?php foreach($row['designation'] as $new_designation){  ?>
                    <option value="<?php echo $new_designation->name;?>"
                        <?=$new_designation->name == $row['getseeker']->designation ? ' selected="selected"' : '';?>>
                        <?php echo $new_designation->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="hs_input">
                <label>experience</label>
                <select class="form-control" aria-label="Default select example" name="exp">
                    <option value="">Select All</option>
                    <?php foreach($row['experience'] as $new_experience){  ?>
                    <option value="<?php echo $new_experience->name;?>"
                        <?=$new_experience->name == $row['getseeker']->exp ? 'selected="selected"' : '';?>>
                        <?php echo $new_experience->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="hs_input">
                <label>Specialization</label>
                <select class="form-control" aria-label="Default select example" name="specialization">
                    <option value="">Select All</option>
                    <?php foreach($row['specialization'] as $new_specialization){  ?>
                    <option value="<?php echo $new_specialization->name;?>"
                        <?=$new_specialization->name == $row['getseeker']->specialization ? ' selected="selected"' : '';?>>
                        <?php echo $new_specialization->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="hs_input">
                <label>Upload Resume</label>
                <input type="file" id="myFile" name="resume" value=""><br>
                <?php if(isset($row['getseeker']->resume) && $row['getseeker']->resume != ""): ?>
                <a href="<?= base_url($row['getseeker']->resume) ?>" target="_blank"><img
                        src="<?= base_url('assets/images/pdf.png') ?>" alt="" width="250px"></a>
                <?php endif; ?>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="hs_input">
                <label>Upload Profile</label>
                <input type="file" id="myFile" name="profile" value=""><br>
                <?php if(isset($row['getseeker']->img) && $row['getseeker']->img != ""): ?>
                <a href="<?= base_url($row['getseeker']->img) ?>" target="_blank"><img
                        src="<?= base_url($row['getseeker']->img) ?>" alt="" width="250px"></a>
                <?php endif; ?>
            </div>

        </div>


        <input type="submit" name="btn" class="btn" value="Update" />
</form>


</div>
</div>
</div>
</div>
<!-- add seeker popup end -->
<div id="delete_seeker_popup" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Do you want to delete this seeker</h4>
            </div>
            <div class="modal-body">
                <?= form_open('admin/delete_seeker'); ?>
                <div class="hs_input">
                    <input type="hidden" name="id" id="disp_data" value="">
                </div>
                <input type="submit" name="sub" class="btn" value="Yes">
                <input type="button" class="btn" value="No" id="no_btn">
            </div>
            </form>

        </div>
    </div>
</div>