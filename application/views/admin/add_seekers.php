<!-- add seeker popup start -->



<div class="modal-header">
    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
    <h4 class="modal-title">Add new seeker</h4>
</div>
<?php  if(isset($error)){ echo $error; }
                        echo $this->session->flashdata('success_req'); 
                    ?>
<form action="<?php echo base_url('admin/addseekerALL')?>" method="post" enctype="multipart/form-data" class="">
    <!-- <form id="f1" enctype="multipart/form-data" class="" > -->
    <input type="hidden" value="yes" name="veri" />
    <h5>Personal Details</h5>

    <div class="modal-body">
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Name</label>
                <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Surname</label>
                <input type="text" name="surname" id="name" placeholder="Enter Name" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Enter E-Mail" class="form-control" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Mobile No</label>
                <input type="number" name="mno" id="mno" placeholder="Enter Mobile Number" class="form-control"
                    pattern="^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$"
                    title="Enter Valid mobile number ex.9811111111" required>

            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Password</label>
                <input type="password" name="ps" id="ps" placeholder="Enter Password" class="form-control"
                    maxlenght="10" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Confirm Password</label>
                <input type="password" name="rps" id="rps" placeholder="Confirm Password" class="form-control"
                    maxlenght="10" required>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Highest Qualification </label>
                <select class="form-control" aria-label="Default select example" name="qua">
                    <option value="qua">Select All</option>
                    <?php foreach($row['qualification'] as $new_qualification){  ?>
                    <option value="<?php echo $new_qualification->name;?>"><?php echo $new_qualification->name;?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>





        <div class="col-sm-4">
            <div class="hs_input">
                <label>Year of Passing </label>
                <select class="form-control" aria-label="Default select example" name="p_year" id="p_year">
                    <option value="select year">Select Year</option>
                    <option value="2000">2000</option>
                    <option value="2001">2001</option>
                    <option value="2002">2002</option>
                    <option value="2003">2003</option>
                    <option value="2004">2004</option>
                    <option value="2005">2005</option>
                    <option value="2006">2006</option>
                    <option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
        </div>



        <div class="col-sm-4">
            <div class="hs_input">
                <label>Current City </label>
                <select class="form-control" aria-label="Default select example" name="city">
                    <option value="">Select All</option>
                    <?php foreach($row['location'] as $new_location){  ?>
                    <option value="<?php echo $new_location->name;?>"><?php echo $new_location->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="hs_input">
                <label>Current Address</label>
                <input type="text" name="current_address" id="current_address" placeholder="Enter Current Address"
                    class="form-control" required>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="hs_input">
                <label>Key Skills</label>
                <input type="text" name="keyskills" id="keyskills" placeholder="Enter key skills" class="form-control"
                    required>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="hs_input">
                <label>CGPA</label>
                <input type="number" name="cgpa" id="cgpa" placeholder="Enter key cgpa" class="form-control" required>
            </div>
        </div>

        <div class="col-sm-12">
            <label>Gender</label>
            <br>
            <input type="radio" id="male" name="gender" value="male" required>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female" required>
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
                    <option value="<?php echo $new_currentctc->name;?>"><?php echo $new_currentctc->name;?></option>
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
                    <option value="<?php echo $new_expectedctc->name;?>"><?php echo $new_expectedctc->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="hs_input">
                <label>Location</label>
                <select class="form-control" aria-label="Default select example" name="location">
                    <option value="">Select All</option>
                    <?php foreach($row['location'] as $new_location){  ?>
                    <option value="<?php echo $new_location->name;?>"><?php echo $new_location->name;?></option>
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
                    <option value="<?php echo $new_role->name;?>"><?php echo $new_role->name;?></option>
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
                    <option value="<?php echo $new_type->name;?>"><?php echo $new_type->name;?></option>
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
                    <option value="<?php echo $new_designation->name;?>"><?php echo $new_designation->name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="hs_input">
                <label>experience</label>
                <select class="form-control" aria-label="Default select example" name="exp">
                    <option>Select All</option>
                    <?php foreach($row['experience'] as $new_experience){  ?>
                    <option value="<?php echo $new_experience->name;?>"><?php echo $new_experience->name;?></option>
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
                    <option value="<?php echo $new_specialization->name;?>"><?php echo $new_specialization->name;?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="hs_input">
                <label>Upload Resume</label>
                <input type="file" id="myFile" name="resume"><br>

            </div>
        </div>

        <div class="col-sm-12">
            <div class="hs_input">
                <div class="hs_checkbox">
                    <input type="checkbox" id="send_detail" value='yes' name="send_detail">
                    <label for="send_detail">Send this details to this Seeker's Email</label>
                </div>
            </div>
            <input type="submit" name="btn" class="btn" value="Save" />
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