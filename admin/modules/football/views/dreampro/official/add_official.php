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
        <?php $sv = $this->library->sub_view(); ?>
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/official/view<?php echo $sv->idstay; ?>')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('football/official/save'.$sv->idstay, array('name' => 'form_addmulti', 'id' => 'form_addmulti'));?>
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
                        <?php
                            if (isset($_GET['id'])) {
                                ?> <input type="hidden" name="team_a_id" value="<?= $_GET['id']; ?>"> <?php
                            } else {
                                ?>
                                <div class='mg-b10 pos-rel wd-100'>
                                    <label>Current Club</label>
                                    <input type="text" class="input_multi" id="team_a_0" name="team_a" value="" autocomplete="off" onkeyup="autocommulti('football/official/autoteam/team_a/0')" placeholder="Search team in here..." required="">
                                    <input type="hidden" name="team_a_id" id="team_a_id_0">
                                    <div id="boxresult" class="showhide_0" style="display: none;"><div class="result_0"></div></div>
                                </div>
                                <?php
                            }
                        ?>
                        <div >
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Position</label>
                                    <input type='text' name='position' id='position' class='cinput input_multi' required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>License</label>
                                    <input type='text' name='license' id='license' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Identity Number</label>
                                    <input type='text' name='no_identity' id='no_identity' class='cinput input_multi'>
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
                                    <label>Email</label>
                                    <input type='email' name='email' id='email' class='cinput input_multi'>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mg-b10">
                                    <label>Phone</label>
                                    <input type='text' name='phone' id='phone' class='cinput input_multi'>
                                </div>
                            </div>
                        </div>
                        <div class='pad-b20'>
                            <label>Address</label>
                            <textarea name='address' id='address' class='cinput input_multi' rows=5'></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Place & Birth Date</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Place</label>
                            <input type='text' name='birth_place' id='birth_place' class='cinput input_multi'>
                        </div>
                        <div class='pad-b20'>
                            <label>Date</label>
                            <input type='text' name='birth_date' id='birth_date' value='<?php echo date('d-m-Y'); ?>' class='cinput input_multi birthday' required>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Photo</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <input type='file' name='uploadfile' id='uploadfile' class='cinput input_multi'>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b18'>
                            <div class='layout-row'>
                                <span class='flex'></span>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/official/save<?= $sv->idstay; ?>')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>