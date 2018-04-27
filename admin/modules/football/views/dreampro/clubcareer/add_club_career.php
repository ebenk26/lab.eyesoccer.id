<script>
    $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        $('.chosen-container').css({width: '100%'});
    });
</script>

<div class='boxtitle'><?php echo $title; ?><?php echo ' &rsaquo; '.$club->name; ?> </div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/clubcareer/view/?id=<?php echo $_GET['id']?>')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('football/clubcareer/save?id='.$club->id_club, array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20' style="padding-bottom: 10px;">
                        <input type='hidden' name='val' value='true'>
                        <input type='hidden' name='id_club' value='<?php echo $club->id_club?>'>
                        <div class='mg-b10'>
                            <label>Bulan</label>
                            <select name="month" id="month" class="cinput select_multi tx-cp competition" required>
                                <option value="">- Pilih Bulan -</option>
                                <option value="januari">Januari</option>
                                <option value="februari">Februari</option>
                                <option value="maret">Maret</option>
                                <option value="april">April</option>
                                <option value="mei">Mei</option>
                                <option value="juni">Juni</option>
                                <option value="juli">Juli</option>
                                <option value="agustus">Agustus</option>
                                <option value="september">September</option>
                                <option value="oktober">Oktober</option>
                                <option value="november">November</option>
                                <option value="desember">Desember</option>
                            </select>
                        </div>
                        <div class='mg-b10'>
                            <label>Tahun</label>
                            <input type='number' name='year' id='year' class='cinput input_multi' required>
                        </div>
						<div class='mg-b10'>
                            <label>Turnamen</label>
                            <input type='text' name='tournament' id='tournament' class='cinput input_multi' required>
                        </div>
						<div class='mg-b10'>
                            <label>Peringkat</label>
                            <input type='number' name='rank' id='rank' class='cinput input_multi'>
                        </div>
						<div class='mg-b10'>
                            <label>Pelatih</label>
                            <input type='text' name='coach' id='coach' class='cinput input_multi'>
                        </div>
                    </div>
                </div>
            </div>
			
			<div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
							<input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/clubcareer/save?id=<?php echo $club->id_club?>')">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>