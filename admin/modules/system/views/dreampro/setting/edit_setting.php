<div style='display: none;'><html><body></body></html></div>

<div class='boxtitle'><?php echo $title; ?></div>
<div id='boxmessage'></div>

<div id='boxjq'>    
    <?php echo form_open_multipart('system/setting/update', array('name' => 'form_addmulti', 'id' => 'form_addmulti'));?>
    <div id='boxbutton'>
        <div id='boxtable' class='mg-all shadow'>
            <ul class='tabs'>
                <li><a href='javascript:void(0)' onclick='tabmenu(this.id)' id='tab-website' class='tab-active'>Website</a></li>
                <li><a href='javascript:void(0)' onclick='tabmenu(this.id)' id='tab-post'>Post</a></li>
                <li><a href='javascript:void(0)' onclick='tabmenu(this.id)' id='tab-google'>Google</a></li>
                <li><a href='javascript:void(0)' onclick='tabmenu(this.id)' id='tab-social-login'>Social API</a></li>
                <li><a href='javascript:void(0)' onclick='tabmenu(this.id)' id='tab-smtp-mail'>SMTP</a></li>
                <li><a href='javascript:void(0)' onclick='tabmenu(this.id)' id='tab-textcode'>Textcode</a></li>
                <li><a href='javascript:void(0)' onclick='tabmenu(this.id)' id='tab-textnotif'>Textnotif</a></li>
            </ul>
            
            <input type='hidden' name='idx' id='idx' value='1'>
            <input type='hidden' name='val' value='true'>
            <div style='clear: both;'></div>
        </div>
    </div>
        
    <div id='boxtable' class='shadow'>
        <div class='row'>
            <div id='tab-website'>
                <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Web Detail</h1>
                        <div class='pad-lr20'>
                            <div class='mg-b10'>
                                <label>Web Name</label>
                                <input type='text' name='web_name' id='web_name' value='<?php echo $dt1->web_name; ?>' class='cinput input_multi' required>
                            </div>
                            <div class='mg-b10'>
                                <label>Web Tagline</label>
                                <input type='text' name='web_tagline' id='web_tagline' value='<?php echo $dt1->web_tagline; ?>' class='cinput input_multi' required>
                            </div>
                            <div class='mg-b10'>
                                <label>Meta Keyword</label>
                                <textarea name='web_keyword' id='web_keyword' class='cinput input_multi' rows='5' cols='80' required><?php echo $dt1->web_keyword; ?></textarea>
                            </div>
                            <div class='pad-b20'>
                                <label>Meta Description</label>
                                <textarea name='web_desc' id='web_desc' class='cinput input_multi' rows='5' cols='80' required><?php echo $dt1->web_desc; ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Web Contact</h1>
                        <div class='pad-lr20'>
                            <div class='mg-b10'>
                                <label>Address</label>
                                <textarea name='web_address' id='web_address' class='cinput input_multi' rows='5' cols='80' required><?php echo $dt1->web_address; ?></textarea>
                            </div>
                            <div class='mg-b10'>
                                <label>Contact</label>
                                <input type='text' name='web_contact' id='web_contact' value='<?php echo $dt1->web_contact; ?>' class='cinput input_multi' required>
                            </div>
                            <div class='mg-b10'>
                                <label>Email Contact</label>
                                <input type='text' name='web_mail_contact' id='web_mail_contact' value='<?php echo $dt1->web_mail_contact; ?>' class='cinput input_multi' required>
                            </div>
                            <div class='pad-b20'>
                                <label>Email Invoice</label>
                                <input type='text' name='web_mail_invoice' id='web_mail_invoice' value='<?php echo $dt1->web_mail_invoice; ?>' class='cinput input_multi' required>
                            </div>
                            <div class='pad-b20'>
                                <label>Email No Reply</label>
                                <input type='text' name='web_mail_noreply' id='web_mail_noreply' value='<?php echo $dt1->web_mail_noreply; ?>' class='cinput input_multi' required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Logo</h1>
                        <div class='pad-lr20'>
                            <div class='pad-b20'>
                                <input type='file' name='uploadfile[]' id='uploadfile' class='cinput input_multi'>
                                <input type='hidden' name='web_logo[]' class='web_logo' value='<?php echo $dt1->web_logo; ?>'>
                                <input type='hidden' name='temp_web_logo[]' value='<?php echo $dt1->web_logo; ?>'>
                                <?php
                                    if($dt1->web_logo)
                                    {
                                ?>
                                        <img src='<?php echo $this->config->item('base_static')."/images/$dt1->web_logo/medium"; ?>' class='max-wd web_logo'>
                                        
                                        <a href="javascript:void(0)" class="btn_action web_logo disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.web_logo')">
                                            <i class="fa fa-remove fa-fw"></i>Remove
                                        </a> 
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Favicon</h1>
                        <div class='pad-lr20'>
                            <div class='pad-b20'>
                                <input type='file' name='uploadfile[]' id='uploadfile' class='cinput input_multi'>
                                <input type='hidden' name='web_logo[]' class='web_favicon' value='<?php echo $dt1->web_favicon; ?>'>
                                <input type='hidden' name='temp_web_logo[]' value='<?php echo $dt1->web_favicon; ?>'>
                                <?php
                                    if($dt1->web_favicon)
                                    {
                                ?>
                                        <img src='<?php echo $this->config->item('base_static')."/images/$dt1->web_favicon"; ?>' class='max-wd web_favicon'>
                                        <a href="javascript:void(0)" class="btn_action web_favicon disp-block mg-t10" style="font-size: 18px;" onclick="remove_value('.web_favicon')">
                                            <i class="fa fa-remove fa-fw"></i>Remove
                                        </a> 
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class='clean'></div>
            </div>
            
            <div id='tab-post' style='display: none;'>
                <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Show Posting</h1>
                        <div class='pad-lr20'>
                            <div class='mg-b10'>
                                <label>Post Home</label>
                                <input type='text' name='post_home' id='post_home' value='<?php echo $dt1->post_home; ?>' class='cinput input_multi' required>
                            </div>
                            <div class='pad-b20'>
                                <label>Post Category</label>
                                <input type='text' name='post_category' id='post_category' value='<?php echo $dt1->post_category; ?>' class='cinput input_multi' required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class='clean'></div>
            </div>
            
            <div id='tab-google' style='display: none;'>
                <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Google Verify</h1>
                        <div class='pad-lr20'>
                            <div class='pad-b20'>
                                <input type='text' name='google_verify' id='google_verify' value='<?php echo $dt1->google_verify; ?>' class='cinput input_multi'>
                            </div>
                        </div>
                    </div>
                    
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Google Captcha</h1>
                        <div class='pad-lr20'>
                            <div class='mg-b10'>
                                <label>Site Key</label>
                                <input type='text' name='google_captcha[site]' value='<?php echo (isset($captcha->site)) ? $captcha->site : ''; ?>' class='cinput input_multi'>
                            </div>
                            <div class='pad-b20'>
                                <label>Secret Key</label>
                                <input type='text' name='google_captcha[secret]' value='<?php echo (isset($captcha->secret)) ? $captcha->secret : ''; ?>' class='cinput input_multi'>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class='col-lg-4 col-md-12 col-sm-4 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Google Analytics</h1>
                        <div class='pad-lr20'>
                            <div class='pad-b20'>
                                <textarea name='google_analytics' id='google_analytics' class='cinput input_multi' rows='8' cols='80' required><?php echo isset($dt1->google_analytics) ? str_replace("~","'",$dt1->google_analytics) : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Google Maps</h1>
                        <div class='pad-lr20'>
                            <div class='pad-b20'>
                                <textarea name='google_maps' id='google_maps' class='cinput input_multi' rows='8' cols='80'><?php echo isset($dt1->google_maps) ? str_replace("~","'",$dt1->google_maps) : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class='clean'></div>
            </div>
            
            <div id='tab-social-login' style='display: none;'>
                <div class='col-lg-6 col-md-12 col-sm-6 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Facebook</h1>
                        <div class='pad-lr20'>
                            <div class='mg-b10'>
                                <label>App Id</label>
                                <input type='text' name='sm_app[fb][id]' value='<?php echo (isset($sosmed->fb->id)) ? $sosmed->fb->id : ''; ?>' class='cinput input_multi'>
                            </div>
                            <div class='pad-b20'>
                                <label>App Secret</label>
                                <input type='text' name='sm_app[fb][ss]' value='<?php echo (isset($sosmed->fb->ss)) ? $sosmed->fb->ss : ''; ?>' class='cinput input_multi'>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class='col-lg-6 col-md-12 col-sm-6 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Twitter</h1>
                        <div class='pad-lr20'>
                            <div class='mg-b10'>
                                <label>Cunsumer Key</label>
                                <input type='text' name='sm_app[tw][id]' value='<?php echo (isset($sosmed->tw->id)) ? $sosmed->tw->id : ''; ?>' class='cinput input_multi'>
                            </div>
                            <div class='pad-b20'>
                                <label>Cunsumer Secret</label>
                                <input type='text' name='sm_app[tw][ss]' value='<?php echo (isset($sosmed->tw->ss)) ? $sosmed->tw->ss : ''; ?>' class='cinput input_multi'>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class='clean'></div>
            </div>
            
            <div id='tab-smtp-mail' style='display: none;'>
                <div class='col-lg-8 col-md-12 col-sm-8 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>SMPT Mail</h1>
                        <div class='pad-lr20'>
                            <div class='mg-b10'>
                                <label>SMTP Host</label>
                                <input type='text' name='smtp_host' id='smtp_host' value='<?php echo $dt1->smtp_host; ?>' class='cinput input_multi' required>
                            </div>
                            <div class='mg-b10'>
                                <label>SMTP Port</label>
                                <input type='text' name='smtp_port' id='smtp_port' value='<?php echo $dt1->smtp_port; ?>' class='cinput input_multi' required>
                            </div>
                            <div class='mg-b10'>
                                <label>SMTP Username</label>
                                <input type='text' name='smtp_user' id='smtp_user' value='<?php echo $dt1->smtp_user; ?>' class='cinput input_multi'>
                            </div>
                            <div class='pad-b20'>
                                <label>SMTP Password</label>
                                <input type='text' name='smtp_pass' id='smtp_pass' value='<?php echo $dt1->smtp_pass; ?>' class='cinput input_multi'>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class='clean'></div>
            </div>
            
            <div id='tab-textcode' style='display: none;'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Textcode</h1>
                        <div class='pad-lr20'>
                            <div class='mg-b10 textflag'>
                                <?php 
                                    if($numrows > 1)
                                    {
                                        $x = 0;
                                        $lang = '';
                                        foreach($language as $l)
                                        {
                                            $display = ($x > 0) ? "style='display: none; padding: 0;'" : "style='padding: 0;'";
                                            
                                            $lang[] = $l->lang_code;
                                            echo "<div class='btn' id='tab-$l->language_name' $display>
                                                    <a href='javascript:void(0)' class='btn_action' id='$l->lang_code' onclick='xtextcode_lang(this.id);' style='font-size: 25px;'>
                                                        <i class='fa fa-plus-circle fa-fw'></i>
                                                    </a>
                                                  </div>";
                                            
                                            $x++;
                                        }
                                        $lang = implode(",", $lang);
                                        
                                        echo "<input type='hidden' name='language_row' id='language_row' value='$numrows'>";
                                        echo "<input type='hidden' name='lang_code' id='lang_code' value='$lang'>";
                                    } else {
                                        echo "<a href='javascript:void(0)' class='btn_action' onclick='xtextcode_lang();' style='font-size: 25px;'>
                                                    <i class='fa fa-plus-circle fa-fw'></i>
                                                </a>";
                                    }
                                    
                                    $this->load->view('system/'.$this->config->item('base_theme').'/language/language_tab');
                                ?>
                                
                                <div style='clear: both;'></div>
                            </div>
                            
                            <div class='pad-b20'>
                                <div id='xtext' style='display: none;'><?php echo $textcode; ?></div>
                                <?php 
                                    if($numrows > 1)
                                    {
                                        $x = 0;
                                        $lang = '';
                                        foreach($language as $l)
                                        {
                                            if($x > 0)
                                            {
                                                $display = "style='display: none;'";
                                            } else {
                                                $display = "";
                                            }
                                            
                                            echo "<div id='tab-$l->language_name' $display><div id='table_textcode_$l->lang_code' ></div></div>";
                                            
                                            $x++;
                                        }
                                    } else {
                                        echo "<div id='table_textcode'></div>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id='tab-textnotif' style='display: none;'>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <div class='boxtab pad-all mg-b20'>
                        <h1>Textnotif</h1>
                        <div class='pad-lr20'>
                            <div class='mg-b10 textflag'>
                                <?php 
                                    if($numrows > 1)
                                    {
                                        $x = 0;
                                        $lang = '';
                                        foreach($language as $l)
                                        {
                                            $display = ($x > 0) ? "style='display: none; padding: 0;'" : "style='padding: 0;'";
                                            
                                            $lang[] = $l->lang_code;
                                            echo "<div class='btn' id='tab-$l->language_name' $display>
                                                    <a href='javascript:void(0)' class='btn_action' id='$l->lang_code' onclick='xtextnotif_lang(this.id);' style='font-size: 25px;'>
                                                        <i class='fa fa-plus-circle fa-fw'></i>
                                                    </a>
                                                  </div>";
                                            
                                            $x++;
                                        }
                                        $lang = implode(",", $lang);
                                        
                                        echo "<input type='hidden' name='language_row' id='language_row' value='$numrows'>";
                                        echo "<input type='hidden' name='lang_code' id='lang_code' value='$lang'>";
                                    } else {
                                        echo "<a href='javascript:void(0)' class='btn_action' onclick='xtextnotif_lang();' style='font-size: 25px;'>
                                                    <i class='fa fa-plus-circle fa-fw'></i>
                                                </a>";
                                    }
                                    
                                    $this->load->view('system/'.$this->config->item('base_theme').'/language/language_tab');
                                ?>
                                
                                <div style='clear: both;'></div>
                            </div>
                            
                            <div class='pad-b20'>
                                <div id='xnotif' style='display: none;'><?php echo $textnotif; ?></div>
                                <?php 
                                    if($numrows > 1)
                                    {
                                        $x = 0;
                                        $lang = '';
                                        foreach($language as $l)
                                        {
                                            if($x > 0)
                                            {
                                                $display = "style='display: none;'";
                                            } else {
                                                $display = "";
                                            }
                                            
                                            echo "<div id='tab-$l->language_name' $display><div id='table_textnotif_$l->lang_code' ></div></div>";
                                            
                                            $x++;
                                        }
                                    } else {
                                        echo "<div id='table_textnotif'></div>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id='boxsubmit'>
        <input type='submit' value='Update' id='btn_submit' onclick="saveaddmulti('system/setting/update')">
    </div>
</div>

<script>
    $(document).ready(function(){
        if ($('#xtext').html() != '') {
            <?php
            if($numrows > 1)
            {
            ?>
                edit_xtextcode_lang();
            <?php
            } else {
            ?>
                edit_xtextcode();
            <?php
            }
            ?>
        }
        
        if ($('#xnotif').html() != '') {
            <?php
            if($numrows > 1)
            {
            ?>
                edit_xtextnotif_lang();
            <?php
            } else {
            ?>
                edit_xtextnotif();
            <?php
            }
            ?>
        }
    });
</script>