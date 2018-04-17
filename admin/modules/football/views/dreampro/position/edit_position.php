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
            $id ='id_position';
            $position ='position';
        ?>
        <a href="javascript:void(0)" id='button' onclick="actmenu('football/position/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open('football/position/update', array('name' => 'form_add', 'id' => 'form_add'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->id_position; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='pad-b20'>
                            <label>Name position</label>
                            <input type='text' name='position' id='position' value='<?php echo $dt1->position; ?>' class='cinput input_multi' required>
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
                                    <input type='submit' value='Update' id='btn_submit' onclick="saveadd('football/position/update')">
                                </div>
                            </div>
                        </div>
                    </div>
                
                <div class='clean'></div>
            </div>
        </div>
    </div>
</div>