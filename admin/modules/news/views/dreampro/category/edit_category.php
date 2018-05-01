<div style='display: none;'><html><body></body></html></div>

<script>
    $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        $('.chosen-container').css({width: '100%'});
    });
</script>

<div class='boxtitle'><?php echo $title; ?> <?php echo (isset($sub) AND isset($_GET['id'])) ? '&rsaquo; '.$sub->news_type : ''; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <?php
            $sv = $this->library->sub_view();
            $id = (isset($_GET['id'])) ? 'sub_news_id' : 'news_type_id';
            $name = (isset($_GET['id'])) ? 'sub_category_name' : 'news_type';
        ?>
        <a href="javascript:void(0)" id='button' onclick="actmenu('news/category/view<?php echo $sv->idstay; ?>')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open_multipart('news/category/update'.$sv->idstay, array('name' => 'form_addmulti', 'id' => 'form_addmulti'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->$id; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='pad-b20'>
                            <label>Name</label>
                            <input type='text' name='title' id='title' value='<?php echo $dt1->$name; ?>' class='cinput input_multi' required>
                        </div>
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
                                <input type='submit' value='Update' id='btn_submit' onclick="saveaddmulti('news/category/update<?= $sv->idstay; ?>')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>