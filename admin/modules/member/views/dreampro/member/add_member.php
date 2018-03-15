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
    
    <?php echo form_open_multipart('news/save', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
    
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New User</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Username</label>
                            <input type='text' name='username' id='title' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Nama Depan</label>
                            <input type="text" name="fist_name" class="cinput input_multi" required>
                        </div>
                        <div class='mg-b10'>
                            <label>Nama Belakang</label>
                            <input type="text" name="last_name" class="cinput input_multi" required>
                        </div>
                        <div class='pad-b20'>
                            <label>Email </label>
                            <input type="text" name="email" class="cinput input_multi" required>
                        </div>  
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Active </h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Category</label>
                            <select name="category" id="category" class="cinput select_multi tx-cp" onchange="actchain('news/subcategory', 'category', 'subcategory')">
                                <option value="">- Select -</option>
                                <?php
                                    if($category)
                                    {
                                        foreach ($category->data as $cat) {
                                            echo "<option value='$cat->news_type_id'>$cat->news_type</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class='pad-b20'>
                            <label>Sub Category</label>
                            <select name="subcategory" id="subcategory" class="cinput select_multi tx-cp subcategory">
                                <option value="">- Select -</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class='boxtab pad-all mg-b20'>
                    <h1>Picture</h1>
                    <div class='pad-lr20'>
                        <div class='mg-b10'>
                            <label>Credit</label>
                            <input type='text' name='credit' id='credit' class='cinput input_multi'>
                        </div>
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
                                <label>Recommended</label>
                                <span class='flex'></span>
                                <select name="recommended" id="recommended" class="cinput select_router tx-cp">
                                    <option value="1">- Select -</option>
                                    <?php
                                        $is_rec = array('Yes' => 2, 'No' => 1);
                                        foreach($is_rec as $nm1 => $v1)
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
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('news/save')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>