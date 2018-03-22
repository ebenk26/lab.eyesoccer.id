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
        <a href="javascript:void(0)" id='button' onclick="actmenu('video/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('video/update', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->eyetube_id; ?>'>
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
                                            if ($cat->category_eyetube_id == $dt1->category_eyetube_id) {
                                                echo "<option value='$cat->category_eyetube_id;$cat->category_name' selected>$cat->category_name</option>";
                                            } else {
                                                echo "<option value='$cat->category_eyetube_id;$cat->category_name'>$cat->category_name</option>";
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
                                if($dt1->thumb)
                                {
                                    $pic = $this->library->picUrl($dt1->thumb, $dt1->url_thumb, 'eyetube', 'medium');

                                    ?>
                                            <img src='<?php echo $pic; ?>' class='max-wd video_pic'>
                                            <input type='hidden' name='video_pic' class='video_pic' value='<?php echo $dt1->thumb; ?>'>
                                            <input type='hidden' name='temp_video_pic' value='<?php echo $dt1->thumb; ?>'>
                                            <a href="javascript:void(0)" class="btn_action video_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.video_pic')">
                                                <i class="fa fa-remove fa-fw"></i>Remove
                                            </a>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div class='boxtab pad-all mg-b20'>
                    <h1>Video</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <input type='file' name='uploadvideo' id='uploadvideo' class='cinput input_multi'>
                            <?php
                            if($dt1->video)
                            {
                                $pic = ($dt1->thumb) ? $this->library->picUrl($dt1->thumb, $dt1->url_thumb, 'eyetube', 'medium') : '';
                                $video = $this->library->picUrl($dt1->video, $dt1->url_video, 'eyetube');

                                ?>
                                    <video controlslist="nodownload" controls="controls" width="100%" class="wd-100 mg-t10 video_vid" poster="<?php echo $pic; ?>" style="max-width: none;">
                                        <source src="<?php echo $video; ?>" type="video/mp4">
                                    </video>
                                    <input type='hidden' name='video_vid' class='video_vid' value='<?php echo $dt1->video; ?>'>
                                    <input type='hidden' name='temp_video_vid' value='<?php echo $dt1->video; ?>'>
                                    <a href="javascript:void(0)" class="btn_action video_vid disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.video_vid')">
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
                            <label>Publish On Date</label>
                            <div class='layout-row'>
                                <?php $publish = ($dt1->publish_on) ?  date('d-m-Y H:i', strtotime($dt1->publish_on)) : date('d-m-Y H:i'); ?>
                                <input type='text' name='publish_date' id='publish_date' value='<?php echo $publish; ?>' class='cinput input_multi date_time mg-r10' required>
                                <span class='flex'></span>
                                <input type='submit' value='Update' id='btn_submit' onclick="saveaddmulti('video/update')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>