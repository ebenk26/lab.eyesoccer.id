

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
        <a href="javascript:void(0)" id='button' onclick="actmenu('match/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('match/save', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-12 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Category</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <label>Category</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-lg-6 col-md-6 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Team A</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Pilih Team A</label>
                            <input type="text" class="input_multi" id="team_0" name="team_a" value="" autocomplete="off" onkeyup="autocommulti('event/match/autoteam/team/0')" placeholder="Search team in here..." required="">
                            <input type="hidden" name="team_a_id" id="team_id_0">
                            <div id="boxresult" class="showhide_0" style="display: none;"><div class="result_0"></div></div>
                        </div>
                        <div class='pad-b20'>
                            <label>Score Team A</label>
                            <input type="number" name="score_a" id="score_a" class="input_multi" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-lg-6 col-md-6 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Team B</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Pilih Team B</label>
                            <input type="text" class="input_multi" id="team_1" name="team_b" value="" autocomplete="off" onkeyup="autocommulti('event/match/autoteam/team/1')" placeholder="Search team in here..." required="">
                            <input type="hidden" name="team_b_id" id="team_id_1">
                            <div id="boxresult" class="showhide_1" style="display: none;"><div class="result_1"></div></div>
                        </div>
                        <div class='pad-b20'>
                            <label>Score Team B</label>
                            <input type="number" name="score_b" id="score_b" class="input_multi" min="0">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-6 col-md-6 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Category</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <label>Category</label>
                            <select name="category" id="category" class="cinput select_multi tx-cp">
                                <option value="">- Select -</option>
                                <?php
                                    if($category)
                                    {
                                        foreach ($category->data as $cat) {
                                            echo "<option value='$cat->id_event_category'>$cat->category_name</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- <div class='pad-b20'>
                            <label>Sub Category</label>
                            <select name="subcategory" id="subcategory" class="cinput select_multi tx-cp subcategory">
                                <option value="">- Select -</option>
                            </select>
                        </div> -->
                    </div>
                </div>
                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Picture</h1>
                    <div class='pad-lr20'>
                        <!-- <div class='mg-b10'>
                            <label>Credit</label>
                            <input type='text' name='credit' id='credit' class='cinput input_multi'>
                        </div> -->
                        <div class='pad-b20'>
                            <input type='file' name='uploadfile' id='uploadfile' class='cinput input_multi'>
                        </div>
                    </div>
                </div>
                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <div class='layout-row'>
                                <label> 
                                    Big Event
                                </label>
                                <span class='flex'></span>
                                <select name="is_event" id="is_event" class="cinput select_router tx-cp">
                                    <option>- Select -</option>
                                    <?php
                                        $is_ev = array('Yes' => 1, 'No' => 0);
                                        foreach($is_ev as $nm1 => $v1)
                                        {
                                            echo "<option value='$v1'>$nm1</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='mg-b10'>
                            <div class='layout-row'>
                                <label> 
                                    Show Match
                                </label>
                                <span class='flex'></span>
                                <select name="is_match" id="is_match" class="cinput select_router tx-cp">
                                    <option>- Select -</option>
                                    <?php
                                        $is_mat = array('Yes' => 1, 'No' => 0);
                                        foreach($is_mat as $nm1 => $v1)
                                        {
                                            echo "<option value='$v1'>$nm1</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='pad-b18'>
                            <label>Publish On Date</label>
                            <div class='layout-row'>
                                <input type='text' name='publish_date' id='publish_date' value='<?php echo date('d-m-Y H:i'); ?>' class='cinput input_multi date_time mg-r10' required>
                                <span class='flex'></span>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('match/save')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>