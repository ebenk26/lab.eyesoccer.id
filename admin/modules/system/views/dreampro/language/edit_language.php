<div class='boxtitle'><?php echo $title; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <a href="javascript:void(0)" id='button' onclick="actmenu('system/language/view')">Back</a>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open('system/language/update', array('name' => 'form_add', 'id' => 'form_add'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->language_id; ?>'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Name</label>
                            <input type='text' name='language_name' id='country_name_100' value='<?php echo $dt1->language_name; ?>' class='cinput input_multi'
                            onkeyup='autocommulti("system/language/autocountry/country_name/100")' placeholder="Type in search..." required>
                            <div id='boxresult' class='showhide_100'><div class='country result_100'></div></div>
                        </div>
                        <div class='pad-b20' id='table_language'>
                            <label>ISO Code</label>
                            <input type='text' name='lang_code' id='language_code_99' value='<?php echo $dt1->lang_code; ?>' class='cinput input_multi'
                            onkeyup='autocommulti("system/language/autoiso/language_code/99")' placeholder="Type in search..." required>
                            <div id='boxresult' class='showhide_99'><div class='iso result_99'></div></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Action</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b18'>
                            <label>Active Language</label>
                            <div class='layout-row'>
                                <select name='is_active' id='is_active' class='cinput select_router'>
                                <?php
                                    $is_active = array('Yes' => 'yes', 'No' => 'no');
                                    foreach($is_active as $nm1 => $v1)
                                    {
                                        if($dt1->is_active == $v1)
                                        {
                                            echo "<option value='$v1' selected>$nm1</option>"; 
                                        } else {
                                            echo "<option value='$v1'>$nm1</option>"; 
                                        }
                                    }
                                ?>
                                </select>
                                <span class='flex'></span>
                                <input type='submit' value='Update' id='btn_submit' onclick="saveadd('system/language/update')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>