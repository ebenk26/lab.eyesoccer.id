<div class='boxtitle'><?php echo $title; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <a href="javascript:void(0)" id='button' onclick="actmenu('system/notif/view')">Back</a>
        
        <?php $this->load->view('system/'.$this->config->item('base_theme').'/language/language_tab'); ?>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open('system/notif/save', array('name' => 'form_add', 'id' => 'form_add'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Add New</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='val' value='true'>
                        <div class='mg-b10'>
                            <label>Subject</label>
                            <?php 
                                if($numrows > 1)
                                {
                                    $x = 0;
                                    $lang = '';
                                    foreach($language as $l)
                                    {
                                        $lang[] = $l->lang_code;
                                        
                                        if($x > 0)
                                        {
                                            $display = "style='display: none;'";
                                        } else {
                                            $display = "";
                                        }
                                        
                                        echo "<div id='tab-$l->language_name' $display><input type='text' name='notif_name_$x' id='notif_name_$x' class='cinput input_multi' required></div>";
                                        
                                        $x++;
                                    }
                                    $lang = implode(",", $lang);
                                    
                                    echo "<input type='hidden' name='language_row' id='language_row' value='$numrows'>";
                                    echo "<input type='hidden' name='lang_code' id='lang_code' value='$lang'>";
                                } else {
                                    echo "<input type='text' name='notif_name' id='notif_name' class='cinput input_multi' required>";
                                }
                            ?>
                        </div>
                        <div class='pad-b20'>
                            <label>Message</label>
                            <?php 
                                if($numrows > 1)
                                {
                                    $x = 0;
                                    foreach($language as $l)
                                    {
                                        if($x > 0)
                                        {
                                            $display = "style='display: none;'";
                                        } else {
                                            $display = "";
                                        }
                                        
                                        echo "<div id='tab-$l->language_name' $display>
                                                <textarea name='notif_desc_$x' id='notif_desc_$x' class='tiny-active' rows='15' cols='80' style='height: 300px;'></textarea>
                                              </div>";
                                        
                                        $x++;
                                    }
                                } else {
                                    echo "<textarea name='notif_desc' id='notif_desc' class='tiny-active' rows='15' cols='80' style='height: 300px;'></textarea>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Type</h1>
                    <div class='pad-lr20'>
                        <div class='pad-b20'>
                            <select name='notif_type' id='notif_type' class='cinput select_multi tx-cp' required>
                            <option value=''>- Select -</option>
                            <?php
                                foreach($this->enum->notif as $v1)
                                {
                                    $nm = $this->library->clear_sym($v1);
                                    echo "<option value='$v1'>$nm</option>";    
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
                                <span class='flex'></span>
                                <input type='submit' value='Save' id='btn_submit' onclick="saveadd('system/notif/save')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>
        </div>
    </div>
</div>