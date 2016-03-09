<div class="modal-body">
    <div class="container">
    <div class="row">
        <div class="col-lg-6 col-sm-6 ">
            <h1>Add User</h1>

            <?php
            $attributes = array("class" => "form-horizontal", "id" => "user_add", "name" => "user_add");
            //input here the next location when click insert1
            echo form_open("access_control/addUser", $attributes);?>
            <fieldset>

                <div class="form-group form-group-sm">
                    <div class="row colbox">

                        <div class="col-lg-4 col-sm-4">
                            <label for="firstname" class="control-label">First Name:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="firstname" name="firstname" placeholder="First name" type="text" class="form-control"  value="<?php echo set_value('firstname'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('firstname'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="middlename" class="control-label">Middle Name:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="middlename" name="middlename" placeholder="Middle name" type="text" class="form-control"  value="<?php echo set_value('middlename'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('middlename'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="surname" class="control-label">Sur Name:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="surname" name="surname" placeholder="Sur name" type="text" class="form-control"  value="<?php echo set_value('surname'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('surname'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="extensionname" class="control-label">Extension Name:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="extensionname" name="extensionname" placeholder="Extension name" type="text" class="form-control"  value="<?php echo set_value('extensionname'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('extensionname'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="position" class="control-label">Position:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="position" name="position" placeholder="Position" type="text" class="form-control"  value="<?php echo set_value('position'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('position'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="designation" class="control-label">Designation:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="designation" name="designation" placeholder="Designation" type="text" class="form-control"  value="<?php echo set_value('designation'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('designation'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="contactno" class="control-label">Contact No:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="contactno" name="contactno" placeholder="Contact No" type="text" class="form-control"  value="<?php echo set_value('contactno'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('contactno'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="username" class="control-label">Username:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="username" name="username" placeholder="Username" type="text" class="form-control"  value="<?php echo set_value('username'); ?>" required />
                            <span class="text-danger"><?php echo form_error('username'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="pword" class="control-label">Password:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="password" name="password" placeholder="Password" type="password" class="form-control"  value="<?php echo set_value('password'); ?>" required/>
                            <span class="text-danger"><?php echo form_error('password'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="e_add" class="control-label">Email Address:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="e_add" name="e_add" placeholder="Email Address" type="text" class="form-control"  value="<?php echo set_value('e_add'); ?>" required/>
                            <span class="text-danger"><?php echo form_error('e_add'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="row colbox">
                        <div class="col-lg-4 col-sm-4">
                            <label for="userlevelid" class="control-label">User Level:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <select name="userlevelid" id="userlevelid" class="form-control"">
                            <option value="0">-Please select-</option>
                            <?php foreach($userlist as $userlistselect): ?>
                                <option value="<?php echo $userlistselect->userlevelid; ?>"
                                    <?php if(isset($_SESSION['userlist'])) {
                                        if($userlistselect->userlevelid == $userlistselect->userlevelid) {
                                            echo " selected";
                                        }
                                    } ?>
                                >
                                    <?php echo $userlistselect->userlevelname; ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="row colbox">
                        <div class="col-lg-4 col-sm-4">
                            <label for="regionlist" class="control-label">Region:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <select name="regionlist" id="regionlist" class="form-control">
                                <option value="0">Choose Region</option>
                                <?php foreach($regionlist as $regionselect): ?>
                                    <option value="<?php echo $regionselect->region_code; ?>"
                                        <?php if(isset($_SESSION['region'])) {
                                            if($regionselect->region_code == $_SESSION['region']) {
                                                echo " selected";
                                            }
                                        } ?>
                                    >
                                        <?php echo $regionselect->region_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="row colbox">
                        <div class="col-lg-4 col-sm-4">
                            <label for="regionlist" class="control-label">Activated:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <select class="selectpicker" name="status">
                                <option data-icon="fa fa-check" value="1">Yes</option>
                                <option data-icon="fa fa-close" value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                        <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Insert" />
                        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Reset" />
                    </div>
                </div>

                <div>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
                <br>
            </fieldset>
            <?php echo form_close(); ?>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
</div>
    </div>
