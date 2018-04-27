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
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/clubcareer/view?id=<?php echo $dt1->id_club?>')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('football/clubcareer/update?id='.$dt1->id_club, array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20' style="padding-bottom: 10px;">
                        <input type='hidden' name='val' value='true'>
                        <input type='hidden' name='id_career' value='<?php echo $dt1->id_career?>'>
                        <div class='mg-b10'>
                            <label>Bulan</label>
							<select name="month" id="month" class="cinput select_multi tx-cp competition" required>
                                <option value="">- Pilih Bulan -</option>
                                <?php
									$month = array('januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember');
									foreach ($month as $mt) {
										if ($mt == $dt1->month) {
											echo "<option value='$mt' selected>$mt</option>";
										} else {
											echo "<option value='$mt'>$mt</option>";
										}
									}
                                ?>
                            </select>
                        </div>
                        <div class='mg-b10'>
                            <label>Tahun</label>
                            <input type='number' name='year' id='year' class='cinput input_multi' required value="<?php echo $dt1->year; ?>">
                        </div>
						<div class='mg-b10'>
                            <label>Turnamen</label>
                            <input type='text' name='tournament' id='tournament' class='cinput input_multi' required value="<?php echo $dt1->tournament; ?>">
                        </div>
						<div class='mg-b10'>
                            <label>Peringkat</label>
                            <input type='number' name='rank' id='rank' class='cinput input_multi' value="<?php echo $dt1->rank; ?>">
                        </div>
						<div class='mg-b10'>
                            <label>Pelatih</label>
                            <input type='text' name='coach' id='coach' class='cinput input_multi' value="<?php echo $dt1->coach; ?>">
                        </div>
                    </div>
                </div>
            </div>
			
			<div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
							<input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/clubcareer/update/?id=<?php echo $dt1->id_club?>')">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>