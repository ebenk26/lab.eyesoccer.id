<link rel="stylesheet" href="<?php echo base_url("assets/js/colorpicker/css/colorpicker.css"); ?>" type="text/css" />
<script type="text/javascript" src="<?php echo base_url("assets/js/colorpicker/js/colorpicker.js"); ?>"></script>

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
        <a href="javascript:void(0)" id='button' onclick="actmenu('market/store/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('/market/store/save', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New Store</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Store Name</label>
                            <input type='text' name='name' id='name' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Email</label>
                            <input type='text' name='email' id='username' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Telephone</label>
                            <input type='number' name='phone' id='phone' class='cinput input_multi'>
                        </div>
                        <div class='mg-b10'>
                            <label>Handphone</label>
                            <input type='number' name='mobile' id='mobile' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10 pos-rel wd-100'>
                            <label>Club</label>
                            <input type="text" class="input_multi" id="id_club_0" name="id_club" value="" autocomplete="off" onkeyup="autocommulti('market/store/autoclub/id_club/0')" placeholder="Search team in here...">
                            <input type="hidden" name="id_club_id" id="id_club_id_0">
                            <div id="boxresult" class="showhide_0" style="display: none;"><div class="result_0"></div></div>
                        </div>
                        <div class='pad-b20'>
                            <label>Address</label>
                            <textarea name="address" id="address" class='cinput input_multi' rows="4" cols="80" maxlength="255"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Access</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Username Store</label>
                            <input type='text' name='username' id='username' class='cinput input_multi'>
                        </div>
                        <div class='pad-b20'>
                            <label>Password</label>
                            <input type='password' name='password' id='password' class='cinput input_multi'>
                        </div>
                    </div>
                </div>
                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Picture</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Logo Store</label>
                            <input type='file' name='uploadfile1' id='pic' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>KTP Owner</label>
                            <input type='file' name='uploadfile2' id='ktp' class='cinput input_multi' required>
                        </div>
                        <div class='pad-b20'>
                            <label>NPWP Owner</label>
                            <input type='file' name='uploadfile3' id='npwp' class='cinput input_multi'>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Other</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Main Color</label>
                            <input type='text' name='color' id='color' class='cinput input_multi colorcode'>
                        </div>
                        <div class='mg-b10'>
                            <label>Margin</label>
                            <input type='number' name='margin' id='margin' class='cinput input_multi'>
                        </div>
                        <div class='pad-b18'>
                            <label>Established Date</label>
                            <div class='layout-row'>
                                <input type='text' name='estdate' id='estdate' value='<?php echo date('d-m-Y H:i'); ?>' class='cinput input_multi date_time mg-r10'>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('store/save')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>