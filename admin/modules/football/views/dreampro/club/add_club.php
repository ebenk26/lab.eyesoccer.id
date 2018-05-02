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
    
    <?php echo form_open_multipart('football/club/save', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div id='tab-general'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Add New</h1>
                        <div class='pad-lr20 pad-b10'>
                            <input type='hidden' name='val' value='true'>
                            <div class='mg-b10'>
                                <label>Name</label>
                                <input type='text' name='name' id='name' class='cinput input_multi' required>
                            </div>
                            <div class='mg-b10'>
                                <label>Nickname</label>
                                <input type='text' name='nickname' id='nickname' class='cinput input_multi'>
                            </div>
                            <div class='pad-b20'>
                                <label>Biography Club</label>
                                <textarea name='description' id='description' class='tiny-active' rows='15' cols='80' style='height: 300px;'></textarea>
                            </div>
                            <div class='mg-b10'>
                                <label>Establish Date</label>
                                <input type='text' name='establish_date' id='establish_date' value='<?php echo date('d-m-Y'); ?>' class='cinput input_multi birthday mg-r10'>
                            </div>
                            <div class='pad-b20'>
                                <label>Address</label>
                                <textarea name='address' id='address' class='cinput input_multi' rows='5'></textarea>
                            </div>
                            <div class='mg-b10'>
                                <label>Phone</label>
                                <input type='text' name='phone' id='phone' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Fax</label>
                                <input type='text' name='fax' id='fax' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Email</label>
                                <input type='email' name='email' id='email' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Website</label>
                                <input type='text' name='website' id='website' class='cinput input_multi'>
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
                                <input type='text' name='owner' id='owner' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Coach Name</label>
                                <input type='text' name='coach' id='coach' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Manager Name</label>
                                <input type='text' name='manager' id='manager' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Alumnus Name</label>
                                <input type='text' name='alumnus_name' id='alumnus_name' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Supporter Name</label>
                                <input type='text' name='supporter_name' id='supporter_name' class='cinput input_multi'>
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
                            </div>
                            <div class='mg-b10'>
                                <label>Kemenham</label>
                                <input type='file' name='legal_kemenham' id='legal_kemenham' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>NPWP</label>
                                <input type='file' name='legal_npwp' id='legal_npwp' class='cinput input_multi'>
                            </div>
                            <div class='mg-b10'>
                                <label>Dirut</label>
                                <input type='file' name='legal_dirut' id='legal_dirut' class='cinput input_multi'>
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
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Stadium</h1>
                    <div class='pad-lr20 pad-b10'>
                        <div class='mg-b10'>
                            <label>Stadium Name</label>
                            <input type='text' name='stadium' id='stadium' class='cinput input_multi'>
                        </div>
                        <div class='mg-b10'>
                            <label>Stadium Address</label>
                            <input type='text' name='stadium_address' id='stadium_address' class='cinput input_multi'>
                        </div>
                        <div class='mg-b10'>
                            <label>Stadium Capacity</label>
                            <input type='text' name='stadium_capacity' id='stadium_capacity' class='cinput input_multi'>
                        </div>
                        <div class='mg-b10'>
                            <label>Training Schedule</label>
                            <input type='text' name='training_schedule' id='training_schedule' class='cinput input_multi' placeholder="Example: Jumat 13:00-14:30 WIB">
                        </div>
                    </div>
                </div>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Competition/League</h1>
					<div class='pad-lr20'>
                        <div class='mg-b10'>
							<label>Competition</label>
                            <!--<select name="competition" id="competition" class="cinput select_multi tx-cp" onchange="actchain('football/club/subcompetition', 'competition', 'league')">-->
							<select name="id_competition" id="competition" class="cinput select_multi tx-cp" required>
                                <option value="">- Select -</option>
                                <?php
                                    if($competition)
                                    {
                                        foreach ($competition->data as $cat) {
                                            echo "<option value='$cat->id_competition'>$cat->competition</option>";
                                        }
                                    }
                                ?>
                            </select>
						</div>
						<div class='pad-b20'>
							<label>League</label>
                            <select name="id_league" id="league" class="cinput select_multi tx-cp league">
                                <option value="">- Select -</option>
								<?php
                                    if($league)
                                    {
                                        foreach ($league->data as $lea) {
                                            echo "<option value='$lea->id_league'>$lea->league</option>";
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
                                    foreach ($provinsi->data as $cat) {
                                        echo "<option value='$cat->IDProvinsi'>$cat->nama</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class='pad-b20'>
                            <label>Kabupaten</label>
                            <select name="id_kabupaten" id="kabupaten" class="cinput select_multi tx-cp kabupaten">
                                <option value="">- Select -</option>
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
                                        echo "<option value='$v1'>$nm1</option>";
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
                                        echo "<option value='$v1'>$nm1</option>";
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
                                        echo "<option value='$v1'>$nm1</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='pad-b18'>
                            <div class='layout-row'>
                                <span class="flex"></span>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/club/save')">
                            </div>
                        </div>
                    </div>
                </div>
			</div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>