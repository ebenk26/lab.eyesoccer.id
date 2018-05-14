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
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/clubgallery/view<?php echo $sv->idstay; ?>')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('football/clubgallery/save'.$sv->idstay, array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <input type='hidden' name='val' value='true'>
                    <input type='hidden' name='id_club' value='<?php echo (isset($_GET['id'])) ? $_GET['id'] : 0; ?>'>
                    <div class='pad-lr20'>
                        <div class='row'>
                            <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-l pad-r" for="zupload">
                                <div class="mg-l5 mg-r5">
                                    <div class="zbox pos-rel mg-b10">
                                        <div id='zfiles' class="zfiles">
                                            <span class="img" style="background-image: url(<?php echo base_url("assets/images/upfile.png"); ?>)"></span>
                                            <label for="zupload">Choose a file or drag it here</label>
                                        </div>
                                        <input type="file" name="uploadtemp[]" id="zupload" style="display: none" multiple>
                                        <input type="hidden" name="is_default" id="is_default">
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class='zbox-images row'></div>
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
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/clubgallery/save<?= $sv->idstay; ?>')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>