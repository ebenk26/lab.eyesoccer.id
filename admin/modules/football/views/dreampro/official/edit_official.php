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
        <?php
            $sv = $this->library->sub_view();
            $id = 'id_official';
            $name = 'name';
        ?>
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/official/view<?php echo $sv->idstay; ?>')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('football/official/update'.$sv->idstay, array('name' => 'form_addmulti', 'id' => 'form_addmulti'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->id_official; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Name</label>
                            <input type='text' name='name' id='name' class='cinput input_multi' value="<?= $dt1->name; ?>">
                        </div>
                        <div class='mg-b10 pos-rel wd-100'>    
                            <label>Current Club</label>
                            <input type="text" class="input_multi" id="team_a_0" name="team_a" value="<?= $dt1->club; ?>" autocomplete="off" onkeyup="autocommulti('football/official/autoteam/team_a/0')" placeholder="Search team in here...">
                            <input type="hidden" name="team_a_id" id="team_a_id_0" value="<?= $dt1->id_club; ?>">
                            <div id="boxresult" class="showhide_0" style="display: none;"><div class="result_0"></div></div>
                        </div>
                        <div class='mg-b10'>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Position</label>
                                    <input type='text' name='position' id='position' class='cinput input_multi' value="<?= $dt1->position; ?>">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>License</label>
                                    <input type='text' name='license' id='license' class='cinput input_multi' value="<?= $dt1->license; ?>">
                                </div>
                            </div>
                        </div>
                        <div class='mg-b10'>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Identity Number</label>
                                    <input type='text' name='no_identity' id='no_identity' class='cinput input_multi' value="<?= $dt1->no_identity; ?>">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Nationality</label>
                                    <input type='text' name='nationality' id='nationality' class='cinput input_multi' value="<?= $dt1->nationality; ?>">
                                </div>
                            </div>
                        </div>
                        <div class='mg-b10'>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Email</label>
                                    <input type='text' name='email' id='email' class='cinput input_multi' value="<?= $dt1->email; ?>">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Phone</label>
                                    <input type='text' name='phone' id='phone' class='cinput input_multi' value="<?= $dt1->phone; ?>">
                                </div>
                            </div>
                        </div>
                        <div class='pad-b20'>
                            <label>Address</label>
                            <textarea name='address' id='address' class='tiny-active' rows='15' cols='80' style='height: 300px;'><?= $dt1->address; ?></textarea>
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
                            <input type='text' name='birth_place' id='birth_place' class='cinput input_multi' value="<?= $dt1->birth_place; ?>">
                        </div>
                        <div class='pad-b20'>
                            <label>Date</label>
                            <input type='text' name='birth_date' id='birth_date' value='<?php echo date('Y-m-d', strtotime($dt1->birth_date)); ?>' class='cinput input_multi date_time mg-r10'>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <input type='file' name='uploadfile' id='uploadfile' class='cinput input_multi'>
                            <?php
                                if($dt1->pic)
                                {
                                    $pic = $this->library->picUrl($dt1->pic, $dt1->url_pic, FDOFFICIAL, 'medium');

                                    ?>
                                            <img src='<?php echo $pic; ?>' class='max-wd offc_pic'>
                                            <input type='hidden' name='offc_pic' class='offc_pic' value='<?php echo $dt1->pic; ?>'>
                                            <input type='hidden' name='temp_news_pic' value='<?php echo $dt1->pic; ?>'>
                                            <a href="javascript:void(0)" class="btn_action offc_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.offc_pic')">
                                                <i class="fa fa-remove fa-fw"></i>Remove
                                            </a>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class='pad-b20'>
                            <div class='layout-row'>
                                <span class='flex'></span>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('football/official/save')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>