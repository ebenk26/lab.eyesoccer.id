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
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/clubcareer/view<?php echo $sv->idstay; ?>')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('football/clubcareer/update'.$sv->idstay, array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <input type='hidden' name='idx' value='<?php echo $dt1->id_career?>'>
                        <input type='hidden' name='id_club' value='<?php echo (isset($_GET['id'])) ? $_GET['id'] : 0; ?>'>
                        <div class='mg-b10'>
                            <label>Month</label>
							<select name="month" id="month" class="cinput select_multi tx-cp competition" required>
                                <option value="">- Select -</option>
                                <?php
                                    foreach ($this->library->monthDate() as $m) {
                                        if ($this->library->monthFixed($dt1->month) == $m) {
                                            echo "<option value='$m' selected>$m</option>";
                                        } else {
                                            echo "<option value='$m'>$m</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class='mg-b10'>
                            <label>Year</label>
                            <input type='number' name='year' id='year' class='cinput input_multi' required value="<?php echo $dt1->year; ?>">
                        </div>
						<div class='mg-b10'>
                            <label>Tournament</label>
                            <input type='text' name='tournament' id='tournament' class='cinput input_multi' required value="<?php echo $dt1->tournament; ?>">
                        </div>
						<div class='mg-b10'>
                            <label>Rank</label>
                            <input type='number' name='rank' id='rank' class='cinput input_multi' value="<?php echo $dt1->rank; ?>">
                        </div>
						<div class='pad-b20'>
                            <label>Coach</label>
                            <input type='text' name='coach' id='coach' class='cinput input_multi' value="<?php echo $dt1->coach; ?>">
                        </div>
                    </div>
                </div>
            </div>
			
			<div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b18'>
                            <div class='layout-row'>
                                <span class='flex'></span>
							    <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/clubcareer/update<?= $sv->idstay; ?>')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>