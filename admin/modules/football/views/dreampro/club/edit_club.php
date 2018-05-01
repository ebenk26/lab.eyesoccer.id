<div style='display: none;'><html><body></body></html></div>
<script>
    $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        $('.chosen-container').css({width: '100%'});
    });
</script>

<div class='boxtitle'><?php echo $title; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/club/view')">Back</a>

        <div id="boxtable" class="shadow">
            <ul class="tabs">
                <li><a href="javascript:void(0)" onclick="tabmenu(this.id)" id="tab-general" class="tab-active">General</a></li>
                <li><a href="javascript:void(0)" onclick="tabmenu(this.id)" id="tab-management">Management</a></li>
                <li><a href="javascript:void(0)" onclick="tabmenu(this.id)" id="tab-legalitas">Legalitas</a></li>
            </ul>
        </div>
        <div style='clear: both;'></div>
    </div>

    <?php echo form_open_multipart('football/club/update', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div id='tab-general'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Add New</h1>
                        <div class='pad-lr20 pad-b10'>
                            <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->id_club; ?>'>
                            <input type='hidden' name='val' value='true'>
                            <div class='mg-b10'>
                                <label>Name</label>
                                <input type='text' name='name' id='name' value='<?php echo $dt1->name; ?>' class='cinput input_multi' required>
                            </div>
                            <div class='mg-b10'>
                                <label>Nickname</label>
                                <input type='text' name='nickname' id='nickname' value='<?php echo $dt1->nickname; ?>' class='cinput input_multi'>
                            </div>
                            <div class='pad-b20'>
                                <label>Biography Club</label>
                                <textarea name='description' id='description' class='tiny-active' rows='15' cols='80' style='height: 300px;'><?php echo $dt1->description; ?></textarea>
                                <div id='is_description' style='display: none;'><?php echo $dt1->description; ?></div>
                            </div>
                            <div class='mg-b10'>
                                <label>Establish Date</label>
                                <input type='text' name='establish_date' id='establish_date'
                                       value='<?php echo ($dt1->establish_date) ? $dt1->establish_date : date('d-m-Y'); ?>'
                                       class='cinput input_multi birthday mg-r10'>
                            </div>
                            <div class='pad-b20'>
                                <label>Address</label>
                                <textarea name='address' id='address' class='cinput input_multi' rows='5'><?php echo $dt1->address; ?></textarea>
                            </div>
                            <div class='mg-b10'>
                                <label>Phone</label>
                                <input type='text' name='phone' id='phone' value='<?php echo $dt1->phone; ?>' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Fax</label>
                                <input type='text' name='fax' id='fax' value='<?php echo $dt1->fax; ?>' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Email</label>
                                <input type='email' name='email' id='email' value='<?php echo $dt1->email; ?>' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Website</label>
                                <input type='text' name='website' id='website' value='<?php echo $dt1->website; ?>' class='cinput input_multi'>
                            </div>
                        </div>
                    </div>
                </div>

                <div id='tab-management' class='disp-none'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Management</h1>
                        <div class='pad-lr20 pad-b10'>
                            <div class='mg-b10'>
                                <label>Owner Name</label>
                                <input type='text' name='owner' id='owner' value='<?php echo $dt1->owner; ?>' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Coach Name</label>
                                <input type='text' name='coach' id='coach' value='<?php echo $dt1->coach; ?>' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Manager Name</label>
                                <input type='text' name='manager' id='manager' value='<?php echo $dt1->manager; ?>' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Alumnus Name</label>
                                <input type='text' name='alumnus_name' id='alumnus_name' value='<?php echo $dt1->alumnus_name; ?>' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Supporter Name</label>
                                <input type='text' name='supporter_name' id='supporter_name' value='<?php echo $dt1->supporter_name; ?>' class='cinput input_multi'>
                            </div>
                        </div>
                    </div>
                </div>

                <div id='tab-legalitas' class='disp-none'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Legalitas</h1>
                        <div class='pad-lr20 pad-b10'>
                            <div class='mg-b10'>
                                <label>PT / Company Identity</label>
                                <input type='file' name='legal_pt' id='legal_pt' class='cinput input_multi'>
                                <?php
                                if($dt1->legalitas_pt)
                                {
                                    $pic = $this->library->picUrl($dt1->legalitas_pt, $dt1->url_pt, FDCLUB, 'medium');

                                    ?>
                                    <img src='<?php echo $pic; ?>' class='max-wd legalpt_pic'>
                                    <input type='hidden' name='legalpt_pic' class='legalpt_pic' value='<?php echo $dt1->legalitas_pt; ?>'>
                                    <input type='hidden' name='temp_legalpt_pic' value='<?php echo $dt1->legalitas_pt; ?>'>
                                    <a href="javascript:void(0)" class="btn_action legalpt_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.legalpt_pic')">
                                        <i class="fa fa-remove fa-fw"></i>Remove
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class='mg-b10'>
                                <label>Kemenham</label>
                                <input type='file' name='legal_kemenham' id='legal_kemenham' class='cinput input_multi'>
                                <?php
                                if($dt1->legalitas_kemenham)
                                {
                                    $pic = $this->library->picUrl($dt1->legalitas_kemenham, $dt1->url_kemenham, FDCLUB, 'medium');

                                    ?>
                                    <img src='<?php echo $pic; ?>' class='max-wd legalkemenham_pic'>
                                    <input type='hidden' name='legalkemenham_pic' class='legalkemenham_pic' value='<?php echo $dt1->legalitas_kemenham; ?>'>
                                    <input type='hidden' name='temp_legalkemenham_pic' value='<?php echo $dt1->legalitas_kemenham; ?>'>
                                    <a href="javascript:void(0)" class="btn_action legalkemenham_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.legalkemenham_pic')">
                                        <i class="fa fa-remove fa-fw"></i>Remove
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class='mg-b10'>
                                <label>NPWP</label>
                                <input type='file' name='legal_npwp' id='legal_npwp' class='cinput input_multi'>
                                <?php
                                if($dt1->legalitas_npwp)
                                {
                                    $pic = $this->library->picUrl($dt1->legalitas_npwp, $dt1->url_npwp, FDCLUB, 'medium');

                                    ?>
                                    <img src='<?php echo $pic; ?>' class='max-wd legalnpwp_pic'>
                                    <input type='hidden' name='legalnpwp_pic' class='legalnpwp_pic' value='<?php echo $dt1->legalitas_npwp; ?>'>
                                    <input type='hidden' name='temp_legalnpwp_pic' value='<?php echo $dt1->legalitas_npwp; ?>'>
                                    <a href="javascript:void(0)" class="btn_action legalnpwp_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.legalnpwp_pic')">
                                        <i class="fa fa-remove fa-fw"></i>Remove
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class='mg-b10'>
                                <label>Dirut</label>
                                <input type='file' name='legal_dirut' id='legal_dirut' class='cinput input_multi'>
                                <?php
                                if($dt1->legalitas_dirut)
                                {
                                    $pic = $this->library->picUrl($dt1->legalitas_dirut, $dt1->url_dirut, FDCLUB, 'medium');

                                    ?>
                                    <img src='<?php echo $pic; ?>' class='max-wd legaldirut_pic'>
                                    <input type='hidden' name='legaldirut_pic' class='legaldirut_pic' value='<?php echo $dt1->legalitas_dirut; ?>'>
                                    <input type='hidden' name='temp_legaldirut_pic' value='<?php echo $dt1->legalitas_dirut; ?>'>
                                    <a href="javascript:void(0)" class="btn_action legaldirut_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.legaldirut_pic')">
                                        <i class="fa fa-remove fa-fw"></i>Remove
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Logo Club</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <input type='file' name='uploadfile' id='uploadfile' class='cinput input_multi'>
                            <?php
                            if($dt1->logo)
                            {
                                $pic = $this->library->picUrl($dt1->logo, $dt1->url_logo, FDCLUB, 'medium');

                                ?>
                                <img src='<?php echo $pic; ?>' class='max-wd logo_pic'>
                                <input type='hidden' name='logo_pic' class='logo_pic' value='<?php echo $dt1->logo; ?>'>
                                <input type='hidden' name='temp_logo_pic' value='<?php echo $dt1->logo; ?>'>
                                <a href="javascript:void(0)" class="btn_action logo_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.logo_pic')">
                                    <i class="fa fa-remove fa-fw"></i>Remove
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Stadium</h1>
                    <div class='pad-lr20 pad-b10'>
                        <div class='mg-b10'>
                            <label>Stadion</label>
                            <input type='text' name='stadium' id='stadium' value='<?php echo $dt1->stadium; ?>' class='cinput input_multi'>
                        </div>
                        <div class='mg-b10'>
                            <label>Alamat Stadion</label>
                            <input type='text' name='stadium_address' id='stadium_address' value='<?php echo $dt1->stadium_address; ?>' class='cinput input_multi'>
                        </div>
                        <div class='mg-b10'>
                            <label>Kapasitas Stadion</label>
                            <input type='text' name='stadium_capacity' id='stadium_capacity' value='<?php echo $dt1->stadium_capacity; ?>' class='cinput input_multi'>
                        </div>
                        <div class='mg-b10'>
                            <label>Jadwal Latihan</label>
                            <input type='text' name='training_schedule' id='training_schedule' value='<?php echo $dt1->training_schedule; ?>' class='cinput input_multi' placeholder="Example: Jumat 13:00-14:30 WIB">
                        </div>
                    </div>
                </div>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Competition/League</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Competition</label>
                            <!--<select name="competition" id="competition" class="cinput select_multi tx-cp" onchange="actchain('football/club/subcompetition', 'competition', 'league')">-->
                            <select name="id_competition" id="id_competition" class="cinput select_multi tx-cp competition" required>
                                <option value="">- Select -</option>
                                <?php
                                if($competition)
                                {
                                    foreach ($competition->data as $com) {
                                        if ($dt1->id_competition == $com->id_competition) {
                                            echo "<option value='$com->id_competition' selected>$com->competition</option>";
                                        } else {
                                            echo "<option value='$com->id_competition'>$com->competition</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class='pad-b20'>
                            <label>League</label>
                            <select name="id_league" id="id_league" class="cinput select_multi tx-cp league">
                                <option value="">- Select -</option>
                                <?php
                                if($league)
                                {
                                    foreach ($league->data as $lea) {
                                        if ($dt1->id_league == $lea->id_league) {
                                            echo "<option value='$lea->id_league' selected>$lea->league</option>";
                                        } else {
                                            echo "<option value='$lea->id_league'>$lea->league</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Provinsi</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Provinsi</label>
                            <select name="id_provinsi" id="provinsi" class="cinput select_multi tx-cp" onchange="actchain('football/club/subprovinsi', 'provinsi', 'kabupaten')">
                                <option value="">- Select -</option>
                                <?php
                                if($provinsi)
                                {
                                    foreach ($provinsi->data as $pro) {
                                        if ($dt1->id_provinsi == $pro->IDProvinsi) {
                                            echo "<option value='$pro->IDProvinsi' selected>$pro->nama</option>";
                                        } else {
                                            echo "<option value='$pro->IDProvinsi'>$pro->nama</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class='pad-b20'>
                            <label>Kabupaten</label>
                            <select name="id_kabupaten" id="kabupaten" class="cinput select_multi tx-cp kabupaten">
                                <option value="">- Select -</option>
                                <?php
                                if($kabupaten)
                                {
                                    foreach ($kabupaten->data as $pro) {
                                        if ($dt1->id_kabupaten == $pro->IDKabupaten) {
                                            echo "<option value='$pro->IDKabupaten' selected>$pro->nama</option>";
                                        } else {
                                            echo "<option value='$pro->IDKabupaten'>$pro->nama</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
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
                        <div class='mg-b10'>
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
                        <div class='mg-b18'>
                            <div class='layout-row'>
                                <label>National</label>
                                <span class='flex'></span>
                                <select name="is_national" id="is_national" class="cinput select_router tx-cp">
                                    <option>- Select -</option>
                                    <?php
                                    $is_act = array('Yes' => 1, 'No' => 0);
                                    foreach($is_act as $nm1 => $v1)
                                    {
                                        if ($dt1->is_national == $v1) {
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
                                <span class="flex"></span>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/club/update')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='clean'></div>
        </div>
    </div>
</div>