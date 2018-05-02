<div style='display: none;'><html><body></body></html></div>
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

    <?php echo form_open_multipart('football/player/update'.$sv->idstay, array('name' => 'form_addmulti', 'id' => 'form_addmulti'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->id_player; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Name</label>
                            <input type='text' name='name' id='name' value='<?php echo $dt1->name; ?>' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Nickname</label>
                            <input type='text' name='nickname' id='nickname' value='<?php echo $dt1->nickname; ?>' class='cinput input_multi'>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Gender</label>
                                    <select name="gender" class="cinput input_multi">
                                        <option value=''>- Select -</option>
                                        <?php
                                            $gender = array('Laki-laki' => 1, 'Perempuan' => 2);
                                            foreach ($gender as $nm => $v) {
                                                if ($dt1->gender == $v) {
                                                    echo "<option value='$v' selected>$nm</option>";
                                                } else {
                                                    echo "<option value='$v'>$nm</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Nationality</label>
                                    <input type='text' name='nationality' id='nationality' value='<?php echo $dt1->nationality; ?>' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Height (cm)</label>
                                    <input type='number' name='height' id='height' value='<?php echo $dt1->height; ?>' class='cinput input_multi'>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Weight (kg)</label>
                                    <input type='number' name='weight' id='weight' value='<?php echo $dt1->weight; ?>' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Birth Place</label>
                                    <input type='text' name='birth_place' id='birth_place' value='<?php echo $dt1->birth_place; ?>' class='cinput input_multi'>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Birth Date</label>
                                    <input type='text' name='birth_date' id='birth_date' class='cinput input_multi date_time mg-r10'
                                           value='<?php echo ($dt1->birth_date) ? date('d-m-Y', strtotime($dt1->birth_date)) : date('d-m-Y'); ?>'>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Father</label>
                                    <input type='text' name='father' id='father' value='<?php echo $dt1->father; ?>' class='cinput input_multi'>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Mother</label>
                                    <input type='text' name='mother' id='mother' value='<?php echo $dt1->mother; ?>' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div class="mg-b10">
                            <label>Favorite Club</label>
                            <input type='text' name='fav_club' id='fav_club' value='<?php echo $dt1->fav_club; ?>' class='cinput input_multi'>
                        </div>
                        <div class="mg-b10">
                            <label>Favorite Player</label>
                            <input type='text' name='fav_player' id='fav_player' value='<?php echo $dt1->fav_player; ?>' class='cinput input_multi'>
                        </div>
                        <div class="pad-b20">
                            <label>Favorite Coach</label>
                            <input type='text' name='fav_coach' id='fav_coach' value='<?php echo $dt1->fav_coach; ?>' class='cinput input_multi'>
                        </div>
                        <div class='pad-b20'>
                            <label>Description</label>
                            <textarea name='description' id='description' class='tiny-active' rows='15' cols='80' style='height: 300px;'><?php echo $dt1->description; ?></textarea>
                            <div id='is_description' style='display: none;'><?php echo $dt1->description; ?></div>
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
                                    <input type="text" class="input_multi" id="team_a_0" name="team_a" value='<?php echo $dt1->club; ?>' autocomplete="off" onkeyup="autocommulti('football/player/autoteam/team_a/0')" placeholder="Search team in here..." required="">
                                    <input type="hidden" name="team_a_id" id="team_a_id_0" value='<?php echo $dt1->id_club; ?>' >
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
                                        if ($dt1->position_a == $dt->id_position) {
                                            echo "<option value='$dt->id_position' selected>$dt->position</option>";
                                        } else {
                                            echo "<option value='$dt->id_position'>$dt->position</option>";
                                        }
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
                                        if ($dt1->position_b == $dt->id_position) {
                                            echo "<option value='$dt->id_position' selected>$dt->position</option>";
                                        } else {
                                            echo "<option value='$dt->id_position'>$dt->position</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Contract Start</label>
                                    <input type='number' name='contract_start' id='contract_start' value='<?php echo $dt1->contract_start; ?>' class='cinput input_multi' placeholder='eg:1200000'>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Contract End</label>
                                    <input type='number' name='contract_end' id='contract_end' value='<?php echo $dt1->contract_end; ?>' class='cinput input_multi' placeholder='eg:2000000'>
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
                                                if ($dt1->id_foot == $dt->id_foot) {
                                                    echo "<option value='$dt->id_foot' selected>$dt->foot</option>";
                                                } else {
                                                    echo "<option value='$dt->id_foot'>$dt->foot</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Back Number</label>
                                    <input type='text' name='back_number' id='back_number' value='<?php echo $dt1->back_number; ?>' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div class="pad-b20">
                            <label>Level</label>
                            <select name="id_level" class="cinput input_multi tx-cp">
                                <option value="">- Select Level -</option>
                                <?php
                                if($level)
                                {
                                    foreach ($level->data as $dt) {
                                        if ($dt1->id_level == $dt->id_level) {
                                            echo "<option value='$dt->id_level' selected>$dt->level</option>";
                                        } else {
                                            echo "<option value='$dt->id_level'>$dt->level</option>";
                                        }
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
                            <input type='text' name='phone' id='phone' value='<?php echo $dt1->phone; ?>' class='cinput input_multi'>
                        </div>
                        <div class="mg-b10">
                            <label>Mobile</label>
                            <input type='text' name='mobile' id='mobile' value='<?php echo $dt1->mobile; ?>' class='cinput input_multi'>
                        </div>
                        <div class="pad-b20">
                            <label>Email</label>
                            <input type='email' name='email' id='email' value='<?php echo $dt1->email; ?>' class='cinput input_multi'>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Photo</h1>
                    <div class='pad-lr20'>
                        <div class="pad-b20">
                            <input type='file' name='uploadfile' id='uploadfile' class='cinput input_multi'>
                            <?php
                            if($dt1->pic)
                            {
                                $pic = $this->library->picUrl($dt1->pic, $dt1->url_pic, FDPLAYER, 'medium');

                                ?>
                                <img src='<?php echo $pic; ?>' class='max-wd photo_pic'>
                                <input type='hidden' name='photo_pic' class='photo_pic' value='<?php echo $dt1->pic; ?>'>
                                <input type='hidden' name='temp_photo_pic' value='<?php echo $dt1->pic; ?>'>
                                <a href="javascript:void(0)" class="btn_action photo_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.photo_pic')">
                                    <i class="fa fa-remove fa-fw"></i>Remove
                                </a>
                                <?php
                            }
                            ?>
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
                                        if ($dt1->is_verify == $v1) {
                                            echo "<option value='$v1' selected>$nm1</option>";
                                        } else {
                                            echo "<option value='$v1'>$nm1</option>";
                                        }
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
                                        if ($dt1->is_active == $v1) {
                                            echo "<option value='$v1' selected>$nm1</option>";
                                        } else {
                                            echo "<option value='$v1'>$nm1</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='pad-b18'>
                            <div class='layout-row'>
                                <span class='flex'></span>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/player/update<?= $sv->idstay; ?>')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='clean'></div>
        </div>

    </div>
</div>