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
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/playerachieve/view<?php echo $sv->idstay; ?>')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('football/playerachieve/save'.$sv->idstay, array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <input type='hidden' name='id_player' value='<?php echo (isset($_GET['id'])) ? $_GET['id'] : 0; ?>'>
                        <div class='mg-b10'>
                            <label>Year</label>
                            <input type='number' name='year' id='year' class='cinput input_multi' required>
                        </div>
						<div class='mg-b10'>
                            <label>Tournament</label>
                            <input type='text' name='tournament' id='tournament' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Country</label>
                            <input type='text' name='country' id='country' class='cinput input_multi' required>
                        </div>
						<div class='mg-b10'>
                            <label>Rank</label>
                            <input type='number' name='rank' id='rank' class='cinput input_multi'>
                        </div>
                        <div class='pad-b20'>
                            <label>Appreciation</label>
                            <input type='text' name='appreciation' id='appreciation' class='cinput input_multi' required>
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
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/playerachieve/save<?= $sv->idstay; ?>')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>