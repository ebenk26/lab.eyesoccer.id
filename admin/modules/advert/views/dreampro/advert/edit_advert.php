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
        <a href="javascript:void(0)" id='button' onclick="actmenu('advert/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('advert/update', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->ads_id; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='pad-b20'>
                            <label>Name</label>
                            <input type='text' name='title' id='title' value='<?php echo $dt1->title; ?>' class='cinput input_multi' required>
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
                                            if ($cat->note == $dt1->note) {
                                                echo "<option value='$cat->note;$cat->category_ads_id' selected>$cat->note</option>";
                                            } else {
                                                echo "<option value='$cat->note;$cat->category_ads_id'>$cat->note</option>";
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
                                if($dt1->url_pic)
                                {
                                    $url_pic = $this->library->picUrl($dt1->url_pic, $dt1->url_pic, FDEYEADS, 'medium');

                                    ?>
                                            <img src='<?php echo $url_pic; ?>' class='max-wd advert_pic'>
                                            <input type='hidden' name='advert_pic' class='advert_pic' value='<?php echo $dt1->url_pic; ?>'>
                                            <input type='hidden' name='temp_advert_pic' value='<?php echo $dt1->url_pic; ?>'>
                                            <a href="javascript:void(0)" class="btn_action advert_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.advert_pic')">
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
                        <div class='pad-b18'>
                            <div class='layout-row'>
                                <input type='submit' value='Update' id='btn_submit' onclick="saveaddmulti('advert/update')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>