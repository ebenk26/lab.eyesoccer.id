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
        <a href="javascript:void(0)" id='button' onclick="actmenu('event/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('event/update', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->id_event; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Name</label>
                            <input type='text' name='title' id='title' value='<?php echo $dt1->title; ?>' class='cinput input_multi' required>
                        </div>
                        <div class='pad-b20'>
                            <label>Description</label>
                            <textarea name='description' id='description' class='tiny-active' rows='15' cols='80' style='height: 300px;'><?php echo $dt1->description; ?></textarea>
                            <div id='is_description' style='display: none;'><?php echo $dt1->description; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
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
                                            if ($cat->category_name == $dt1->category_name) {
                                                echo "<option value='$cat->id_event_category' selected>$cat->category_name</option>";
                                            } else {
                                                echo "<option value='$cat->id_event_category'>$cat->category_name</option>";
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Picture</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <input type='file' name='uploadfile' id='uploadfile' class='cinput input_multi'>
                            <?php
                                if($dt1->pic)
                                {
                                    $pic = $this->library->picUrl($dt1->pic, $dt1->url_pic, 'eyevent', 'medium');

                                    ?>
                                            <img src='<?php echo $pic; ?>' class='max-wd event_pic'>
                                            <input type='hidden' name='event_pic' class='event_pic' value='<?php echo $dt1->pic; ?>'>
                                            <input type='hidden' name='temp_event_pic' value='<?php echo $dt1->pic; ?>'>
                                            <a href="javascript:void(0)" class="btn_action event_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.event_pic')">
                                                <i class="fa fa-remove fa-fw"></i>Remove
                                            </a>
                                    <?php
                                }
                            ?>
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
                                            if ($v1 == $dt1->is_event) {
                                                echo "<option value='$v1' selected>$nm1</option>";
                                            } else {
                                                echo "<option value='$v1'>$nm1</option>";
                                            }
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
                                    <option value="1">- Select -</option>
                                    <?php
                                        $is_mat = array('Yes' => 1, 'No' => 0);
                                        foreach($is_mat as $nm1 => $v1)
                                        {
                                            if ($v1 == $dt1->is_match) {
                                                echo "<option value='$v1' selected>$nm1</option>";
                                            } else {
                                                echo "<option value='$v1'>$nm1</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='pad-b18'>
                            <label>Publish On Date</label>
                            <div class='layout-row'>
                                <?php $publish = ($dt1->publish_on) ?  date('d-m-Y H:i', strtotime($dt1->publish_on)) : date('d-m-Y H:i'); ?>
                                <input type='text' name='publish_date' id='publish_date' value='<?php echo $publish; ?>' class='cinput input_multi date_time mg-r10' required>
                                <span class='flex'></span>
                                <input type='submit' value='Update' id='btn_submit' onclick="saveaddmulti('event/update')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>