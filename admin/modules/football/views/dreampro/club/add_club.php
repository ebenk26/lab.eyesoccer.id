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
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('football/club/save', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20' style="padding-bottom: 10px;">
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Nama</label>
                            <input type='text' name='name' id='name' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Nama Panggilan</label>
                            <input type='text' name='nickname' id='nickname' class='cinput input_multi'>
                        </div>
						<div class='mg-b10'>
                            <label>Logo Klub</label>
                            <input type='file' name='uploadfile' id='uploadfile' class='cinput input_multi' required>
                        </div>
						<div class='pad-b20'>
                            <label>Biografi Klub</label>
                            <textarea name='description' id='description' class='tiny-active' rows='10' cols='70' style='height: 100px;'></textarea>
                        </div>
						<div class='pad-b20'>
                            <label>Alamat Klub</label>
                            <textarea name='address' id='address' class='tiny-active' rows='10' cols='70' style='height: 100px;'></textarea>
                        </div>
                        <div class='mg-b10'>
                            <label>Nomor Telepon</label>
                            <input type='number' name='phone' id='phone' class='cinput input_multi'>
                        </div>
						<div class='mg-b10'>
                            <label>Fax</label>
                            <input type='text' name='phone' id='phone' class='cinput input_multi'>
                        </div>
						<div class='mg-b10'>
                            <label>Email</label>
                            <input type='text' name='phone' id='phone' class='cinput input_multi'>
                        </div>
						<div class='mg-b10'>
                            <label>Stadion</label>
                            <input type='text' name='stadium' id='stadium' class='cinput input_multi'>
                        </div>
						<div class='mg-b10'>
                            <label>Alamat Stadion</label>
                            <input type='text' name='stadium_address' id='stadium_address' class='cinput input_multi'>
                        </div>
						<div class='mg-b10'>
                            <label>Kapasitas Stadion</label>
                            <input type='text' name='stadium_capacity' id='stadium_capacity' class='cinput input_multi'>
                        </div>
						<div class='mg-b10'>
                            <label>Website</label>
                            <input type='text' name='website' id='website' class='cinput input_multi'>
                        </div>
						<div class='mg-b10'>
                            <label>Jadwal Latihan</label>
                            <input type='text' name='training_schedule' id='training_schedule' class='cinput input_multi' placeholder="contoh: Jumat 13:00-14:30 WIB">
                        </div>
						<div class='mg-b10'>
                            <label>Nama Alumnus</label>
                            <input type='text' name='alumnus_name' id='alumnus_name' class='cinput input_multi' placeholder="contoh: Joko, Arman, Anton">
                        </div>
                    </div>
                </div>
            </div>
            
			<div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Managemen & Legalitas</h1>
                    <div class='pad-lr20'>
						<div class='pad-b20'>
							<label>Nama Direktur</label>
                            <div class='layout-row'>
                                <input type='text' name='legalitas_dirut' id='legalitas_dirut' class='cinput input_multi'>
                            </div>
                        </div>
						<div class='pad-b20'>
							<label>Nama Pelatih</label>
                            <div class='layout-row'>
                                <input type='text' name='coach' id='coach' class='cinput input_multi'>
                            </div>
                        </div>
						<div class='pad-b20'>
							<label>Nama Manager</label>
                            <div class='layout-row'>
                                <input type='text' name='manager' id='manager' class='cinput input_multi'>
                            </div>
                        </div>
						<div class='pad-b20'>
							<label>Nama Suporter</label>
                            <div class='layout-row'>
                                <input type='text' name='supporter_name' id='supporter_name' class='cinput input_multi'>
                            </div>
                        </div>
						<div class='pad-b20'>
							<label>Nama Pemilik</label>
                            <div class='layout-row'>
                                <input type='text' name='owner' id='owner' class='cinput input_multi'>
                            </div>
                        </div>
						<div class='pad-b20'>
							<label>Legalitas Perusahaan</label>
                            <div class='layout-row'>
                                <input type='text' name='legalitas_pt' id='legalitas_pt' class='cinput input_multi'>
                            </div>
                        </div>
						<div class='pad-b20'>
							<label>SK Kemenham</label>
                            <div class='layout-row'>
                                <input type='text' name='legalitas_kemenham' id='legalitas_kemenham' class='cinput input_multi'>
                            </div>
                        </div>
						<div class='pad-b20'>
							<label>NPWP</label>
                            <div class='layout-row'>
                                <input type='text' name='legalitas_npwp' id='legalitas_npwp' class='cinput input_multi'>
                            </div>
                        </div>
						<div class='pad-b20'>
							<label>Tanggal Didirikan</label>
                            <div class='layout-row'>
                                <input type='text' name='establish_date' id='establish_date' value='<?php echo date('d-m-Y H:i'); ?>' class='cinput input_multi date_time mg-r10' required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Kompetisi/Liga</h1>
					<div class='pad-lr20'>
                        <div class='mg-b10'>
							<label>Tipe Kompetisi</label>
                            <!--<select name="competition" id="competition" class="cinput select_multi tx-cp" onchange="actchain('football/club/subcompetition', 'competition', 'league')">-->
							<select name="id_competition" id="id_competition" class="cinput select_multi tx-cp competition" required>
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
							<label>Tipe Liga</label>
                            <select name="id_league" id="id_league" class="cinput select_multi tx-cp league">
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
			</div>
			<div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Provinsi</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Provinsi</label>
                            <select name="IDProvinsi" id="IDProvinsi" class="cinput select_multi tx-cp" onchange="actchain('football/club/subkabupaten', 'provinsi', 'kabupaten')">
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
                            <select name="kabupaten" id="kabupaten" class="cinput select_multi tx-cp kabupaten">
                                <option value="">- Select -</option>
                            </select>
                        </div>
                    </div>
                </div>
				
				<div class='boxtab pad-all mg-b20'>
                    <h1>Data</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
							<label>Verifikasi</label>
                            <select name="is_verify" id="is_verify" class="cinput select_multi tx-cp">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
						<div class='pad-b20'>
							<label>Aktivasi</label>
                            <select name="is_active" id="is_active" class="cinput select_multi tx-cp">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
						<div class='pad-b20'>
							<label>Nasional</label>
                            <select name="is_national" id="is_national" class="cinput select_multi tx-cp">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
							<input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/club/save')">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>