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
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/foot/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open('football/foot/update', array('name' => 'form_add', 'id' => 'form_add'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->id_foot; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='pad-b20'>
                            <label>Name</label>
                            <input type='text' name='foot' id='foot' value='<?php echo $dt1->foot; ?>' class='cinput input_multi' required>
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
                                    <input type='submit' value='Update' id='btn_submit' onclick="saveadd('football/foot/update')">
                                </div>
                            </div>
                        </div>
                    </div>
            
                <div class='clean'></div>
                </div>
            </div>
        </div>
    </div>
</div>