<div class='boxtitle'><?php echo $title; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <a href="javascript:void(0)" id='button' onclick="actmenu('system/user/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open('system/user/update', array('name' => 'form_add', 'id' => 'form_add'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->user_id; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Username</label>
                            <input type='text' name='user_name' id='user_name' value='<?php echo $dt1->user_name; ?>' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Password</label>
                            <input type='password' name='user_pass' id='user_pass' class='cinput input_multi'>
                        </div>
                        <div class='mg-b10'>
                            <label>Fullname</label>
                            <input type='text' name='user_fname' id='user_fname' value='<?php echo $dt1->user_fname; ?>' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Mobile</label>
                            <input type='text' name='user_mobile' id='user_mobile' value='<?php echo $dt1->user_mobile; ?>' class='cinput input_multi' required>
                        </div>
                        <div class='pad-b20'>
                            <label>Email</label>
                            <input type='text' name='user_email' id='user_email' value='<?php echo $dt1->user_email; ?>' class='cinput input_multi' required>
                            <input type='hidden' name='temp_user_email' id='temp_user_email' value='<?php echo $dt1->user_email; ?>' class='cinput input_multi'>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <?php
                    if($this->session->userdata('user_level') == 'admin')
                    {
                ?>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Level User</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <select name='user_level' id='user_level' class='cinput select_multi'>
                            <option value='admin'>Admin</option>
                            <?php
                                $rm = $this->catalog->get_menu_roles();
                                foreach($rm as $r)
                                {
                                    if($dt1->user_level == $r->role_slug)
                                    {
                                        echo "<option value='$r->role_slug' selected>$r->role_name</option>";
                                    } else {
                                        echo "<option value='$r->role_slug'>$r->role_name</option>";
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
                    } else {
                        echo "<input type='hidden' name='user_level' value='$dt1->user_level'>";
                    }
                ?>
                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b18'>
                            <label>Active User</label>
                            <div class='layout-row'>
                                <select name='is_active' id='is_active' class='cinput select_router'>
                                <?php
                                    $is_active = array('Yes' => 1, 'No' => 0);
                                    foreach($is_active as $nm1 => $v1)
                                    {
                                        if($dt1->is_active == $v1)
                                        {
                                            echo "<option value='$v1' selected>$nm1</option>"; 
                                        } else {
                                            echo "<option value='$v1'>$nm1</option>"; 
                                        }
                                    }
                                ?>
                                </select>
                                <span class='flex'></span>
                                <input type='submit' value='Update' id='btn_submit' onclick="saveadd('system/user/update')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>