<script>
    $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        $('.chosen-container').css({width: '100%'});
    });
</script>

<div class='boxtitle'><?php echo $title; ?> <?php echo (isset($sub) AND isset($_GET['id'])) ? '&rsaquo; '.$sub->name : ''; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <?php $sv = $this->library->sub_view(); ?>
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/player/view<?php echo $sv->idstay; ?>')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('football/player/save'.$sv->idstay, array('name' => 'form_addmulti', 'id' => 'form_addmulti'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Name</label>
                            <input type='text' name='name' id='name' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Nickname</label>
                            <input type='text' name='nickname' id='nickname' class='cinput input_multi'>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Gender</label>
                                    <select name="gender" class="cinput input_multi">
                                        <option value=''>- Select -</option>
                                        <option value='1'>Laki-laki</option>
                                        <option value='2'>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Nationality</label>
                                    <input type='text' name='nationality' id='nationality' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Height (cm)</label>
                                    <input type='number' name='height' id='height' class='cinput input_multi'>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Weight (kg)</label>
                                    <input type='number' name='weight' id='weight' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Birth Place</label>
                                    <input type='text' name='birth_place' id='birth_place' class='cinput input_multi'>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Birth Date</label>
                                    <input type='text' name='birth_date' id='birth_date' class='cinput input_multi date_time mg-r10' value='<?php echo date('d-m-Y'); ?>'>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Father</label>
                                    <input type='text' name='father' id='father' class='cinput input_multi'>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Mother</label>
                                    <input type='text' name='mother' id='mother' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div class="mg-b10">
                            <label>Favorite Club</label>
                            <input type='text' name='fav_club' id='fav_club' class='cinput input_multi'>
                        </div>
                        <div class="mg-b10">
                            <label>Favorite Player</label>
                            <input type='text' name='fav_player' id='fav_player' class='cinput input_multi'>
                        </div>
                        <div class="pad-b20">
                            <label>Favorite Coach</label>
                            <input type='text' name='fav_coach' id='fav_coach' class='cinput input_multi'>
                        </div>
                        <div class='pad-b20'>
                            <label>Description</label>
                            <textarea name='description' id='description' class='tiny-active' rows='15' cols='80' style='height: 300px;'></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>On Club</h1>
                    <div class='pad-lr20'>
                        <?php
                            if (isset($_GET['id'])) {
                                ?> <input type="hidden" name="team_a_id" value="<?= $_GET['id']; ?>"> <?php
                            } else {
                                ?>
                                <div class='mg-b10 pos-rel wd-100'>
                                    <label>Current Club</label>
                                    <input type="text" class="input_multi" id="team_a_0" name="team_a" value="" autocomplete="off" onkeyup="autocommulti('football/player/autoteam/team_a/0')" placeholder="Search team in here..." required="">
                                    <input type="hidden" name="team_a_id" id="team_a_id_0">
                                    <div id="boxresult" class="showhide_0" style="display: none;"><div class="result_0"></div></div>
                                </div>
                                <?php
                            }
                        ?>
                        <div class="mg-b10">
                            <label>Position A</label>
                            <select name="position_a" class="cinput input_multi">
                                <option value="">- Select Position -</option>
                                <?php
                                if($position)
                                {
                                    foreach ($position->data as $dt) {
                                        echo "<option value='$dt->id_position'>$dt->position</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mg-b10">
                            <label>Position B</label>
                            <select name="position_b" class="cinput input_multi">
                                <option value="">- Select Position -</option>
                                <?php
                                if($position)
                                {
                                    foreach ($position->data as $dt) {
                                        echo "<option value='$dt->id_position'>$dt->position</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Contract Start</label>
                                    <input type='number' name='contract_start' id='contract_start' class='cinput input_multi' placeholder='eg:1200000'>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Contract End</label>
                                    <input type='number' name='contract_end' id='contract_end' class='cinput input_multi' placeholder='eg:2000000'>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Foot</label>
                                    <select name="id_foot" class="cinput input_multi">
                                        <option value="">- Select -</option>
                                        <?php
                                        if($foot)
                                        {
                                            foreach ($foot->data as $dt) {
                                                echo "<option value='$dt->id_foot'>$dt->foot</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Back Number</label>
                                    <input type='text' name='back_number' id='back_number' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div class="pad-b20">
                            <label>Level</label>
                            <select name="id_level" class="cinput input_multi">
                                <option value="">- Select Level -</option>
                                <?php
                                if($level)
                                {
                                    foreach ($level->data as $dt) {
                                        echo "<option value='$dt->id_level'>$dt->level</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Contact</h1>
                    <div class='pad-lr20'>
                        <div class="mg-b10">
                            <label>Phone</label>
                            <input type='text' name='phone' id='phone' class='cinput input_multi'>
                        </div>
                        <div class="mg-b10">
                            <label>Mobile</label>
                            <input type='text' name='mobile' id='mobile' class='cinput input_multi'>
                        </div>
                        <div class="pad-b20">
                            <label>Email</label>
                            <input type='email' name='email' id='email' class='cinput input_multi'>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Photo</h1>
                    <div class='pad-lr20'>
                        <div class="pad-b20">
                            <input type='file' name='uploadfile' id='uploadfile' class='cinput input_multi'>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <div class='layout-row'>
                                <label>Verification</label>
                                <span class='flex'></span>
                                <select name="is_verify" id="is_verify" class="cinput select_router tx-cp">
                                    <option>- Select -</option>
                                    <?php
                                    $is_act = array('Yes' => 1, 'No' => 0);
                                    foreach($is_act as $nm1 => $v1)
                                    {
                                        echo "<option value='$v1'>$nm1</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='mg-b18'>
                            <div class='layout-row'>
                                <label>Active</label>
                                <span class='flex'></span>
                                <select name="is_active" id="is_active" class="cinput select_router tx-cp">
                                    <option>- Select -</option>
                                    <?php
                                    $is_act = array('Yes' => 1, 'No' => 0);
                                    foreach($is_act as $nm1 => $v1)
                                    {
                                        echo "<option value='$v1'>$nm1</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='pad-b18'>
                            <div class='layout-row'>
                                <span class='flex'></span>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/player/save<?= $sv->idstay; ?>')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
        
    </div>
</div>