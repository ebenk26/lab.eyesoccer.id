<div style='display: none;'><html><body></body></html></div>

<div class='boxtitle'><?php echo $title; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>
    <div id='boxbutton'>
        <a href="javascript:void(0)" id='button' onclick="actmenu('system/notif/view')">Back</a>
        
        <?php $this->load->view('system/'.$this->config->item('base_theme').'/language/language_tab'); ?>
        
        <div style='clear: both;'></div>
    </div>
    
    <?php echo form_open('system/notif/update', array('name' => 'form_add', 'id' => 'form_add'));?>
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                <div class='boxtab pad-all mg-b20'>
                    <h1>Edit</h1>
                    <div class='pad-lr20'>
                        <input type='hidden' name='idx' id='idx' value='<?php echo $dt1->notif_id; ?>'>
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
                                        $trans = $this->catalog->get_translation(array('element_type' => 'notif_notif',
                                                                                        'element_id' => $dt1->notif_id,
                                                                                        'lang_code' => $l->lang_code,
                                                                                        'row' => true));
                                        !empty($trans->text_title) ? $text_title = $trans->text_title : $text_title = '';
                                        !empty($trans->text_title_seo) ? $text_title_seo = $trans->text_title_seo : $text_title_seo = '';
                                        
                                        if($x > 0)
                                        {
                                            $display = "style='display: none;'";
                                        } else {
                                            $display = "";
                                        }
                                        
                                        echo "<div id='tab-$l->language_name' $display>
                                                <input type='text' name='notif_name_$x' id='notif_name_$x' value='$text_title' class='cinput input_multi' required>
                                                <input type='hidden' name='link_seo[]' id='link_seo_$x' value='$text_title_seo'>
                                              </div>";
                                        
                                        $x++;
                                    }
                                    $lang = implode(",", $lang);
                                    
                                    echo "<input type='hidden' name='language_row' id='language_row' value='$numrows'>";
                                    echo "<input type='hidden' name='lang_code' id='lang_code' value='$lang'>";
                                } else {
                                    echo "<input type='text' name='notif_name' id='notif_name' value='$dt1->notif_name' class='cinput input_multi' required>";
                                    echo "<input type='hidden' name='link_seo' id='link_seo' value='$dt1->text_title_seo'>";
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
                                        $trans = $this->catalog->get_translation(array('element_type' => 'notif_notif',
                                                                                        'element_id' => $dt1->notif_id,
                                                                                        'lang_code' => $l->lang_code,
                                                                                        'row' => true));
                                        !empty($trans->text_desc) ? $text_desc = $trans->text_desc : $text_desc = '';
                                        
                                        if($x > 0)
                                        {
                                            $display = "style='display: none;'";
                                        } else {
                                            $display = "";
                                        }
                                        
                                        echo "<div id='tab-$l->language_name' $display>
                                                <textarea name='notif_desc_$x' id='notif_desc_$x' class='tiny-active' rows='15' cols='80' style='height: 300px;'></textarea>
                                                <div id='is_notif_desc_$x' style='display: none;'>".str_replace("~", "'", $text_desc)."</div>
                                              </div>";
                                        
                                        $x++;
                                    }
                                } else {
                                    echo "<textarea name='notif_desc' id='notif_desc' class='tiny-active' rows='15' cols='80' style='height: 300px;'></textarea>";
                                    echo "<div id='is_notif_desc' style='display: none;'>".str_replace("~", "'", $dt1->notif_desc)."</div>";
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
                                    if($dt1->notif_type== $v1)
                                    {
                                        echo "<option value='$v1' selected>$nm</option>"; 
                                    } else {
                                        echo "<option value='$v1'>$nm</option>"; 
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
                                <span class='flex'></span>
                                <input type='submit' value='Update' id='btn_submit' onclick="saveadd('system/notif/update')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='clean'></div>            
        </div>
    </div>
</div>