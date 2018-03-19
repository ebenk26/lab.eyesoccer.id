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
    
    <?php echo form_open_multipart('advert/save', array('name' => 'form_addmulti', 'id' => 'form_addmulti')); ?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Title</label>
                            <input type='text' name='title' id='title' class='cinput input_multi' required>
                        </div>
                        <div class='mg-b10'>
                            <label>Thumb</label>
                            <textarea name="slug" id="slug" class='cinput input_multi' rows="4" cols="80" maxlength="255"></textarea>
                            <div class="tx-right">
                                <span class="cl-red ff-12"></span>
                            </div>
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
                            <select name="note" id="note" class="cinput select_multi tx-cp" >
                                <option value="">- Select -</option>
                                <?php
                                    if($category)
                                    {
                                        foreach ($category->data as $cat) {
                                            echo "<option value='$cat->note'>$cat->note</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                
             
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b18'>
                            <div class='layout-row'>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveaddmulti('advert/save')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>