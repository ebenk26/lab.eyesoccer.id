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
        <a href="javascript:void(0)" id='button' onclick="actmenu('news/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('news/update', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->eyenews_id; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Name</label>
                            <input type='text' name='title' id='title' value='<?php echo $dt1->title; ?>' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Meta Description</label>
                            <textarea name="meta_desc" id="meta_desc" class='cinput input_multi' rows="4" cols="80"  maxlength="255"><?php echo $dt1->meta_description; ?></textarea>
                            <div class="tx-right">
                                <span class="cl-red ff-12">Note : Maximum Character 255</span>
                            </div>
                        </div>
                        <div class='mg-b10'>
                            <label>Meta Keyword</label>
                            <textarea name="meta_keyword" id="meta_keyword" class='cinput input_multi' rows="4" cols="80"  maxlength="255"><?php echo $dt1->tag; ?></textarea>
                            <div class="tx-right">
                                <span class="cl-red ff-12">Example : Liga,Turnament,Kompetisi</span>
                            </div>
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
                        <div class='mg-b10'>
                            <label>Category</label>
                            <select name="category" id="category" class="cinput select_multi tx-cp" onchange="actchain('news/subcategory', 'category', 'subcategory')">
                                <option value="">- Select -</option>
                                <?php
                                    if($category)
                                    {
                                        foreach ($category->data as $cat) {
                                            if ($cat->news_type == $dt1->news_type) {
                                                echo "<option value='$cat->news_type_id;$cat->news_type' selected>$cat->news_type</option>";
                                            } else {
                                                echo "<option value='$cat->news_type_id;$cat->news_type'>$cat->news_type</option>";
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class='pad-b20'>
                            <label>Sub Category</label>
                            <select name="subcategory" id="subcategory" class="cinput select_multi tx-cp subcategory">
                                <option value="">- Select -</option>
                                <?php
                                    if($subcategory)
                                    {
                                        foreach ($subcategory->data as $cat) {
                                            if ($cat->sub_category_name == $dt1->sub_news_type) {
                                                echo "<option value='$cat->sub_news_id;$cat->sub_category_name' selected>$cat->sub_category_name</option>";
                                            } else {
                                                echo "<option value='$cat->sub_news_id;$cat->sub_category_name'>$cat->sub_category_name</option>";
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
                        <div class='mg-b10'>
                            <label>Credit</label>
                            <input type='text' name='credit' id='credit' value='<?php echo $dt1->credit; ?>' class='cinput input_multi'>
                        </div>
                        <div class='pad-b20'>
                            <input type='file' name='uploadfile' id='uploadfile' class='cinput input_multi'>
                            <?php
                                if($dt1->pic)
                                {
                                    $pic = $this->library->picUrl($dt1->pic, $dt1->url_pic, FDEYENEWS, 'medium');

                                    ?>
                                            <img src='<?php echo $pic; ?>' class='max-wd news_pic'>
                                            <input type='hidden' name='news_pic' class='news_pic' value='<?php echo $dt1->pic; ?>'>
                                            <input type='hidden' name='temp_news_pic' value='<?php echo $dt1->pic; ?>'>
                                            <a href="javascript:void(0)" class="btn_action news_pic disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.news_pic')">
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
                                <label>Recommended</label>
                                <span class='flex'></span>
                                <select name="recommended" id="recommended" class="cinput select_router tx-cp">
                                    <option value="1">- Select -</option>
                                    <?php
                                        $is_rec = array('Yes' => 2, 'No' => 1);
                                        foreach($is_rec as $nm1 => $v1)
                                        {
                                            if ($v1 == $dt1->recommended) {
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
                                <input type='submit' value='Update' id='btn_submit' onclick="saveaddmulti('news/update')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>