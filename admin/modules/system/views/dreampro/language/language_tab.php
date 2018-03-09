<?php
    if($numrows > 1)
    {
        echo "<ul style='float: right;'>";
        $i = 0;
        $lang = '';
        foreach($language as $l)
        {
            $img = '<img src="'.$this->config->item('base_static')."/flags/$l->lang_code.png".'">';
            $lang[] = array('language_name' => $l->language_name);
            
            if($i > 0)
            {
                $active = "";
            } else {
                $active = "class='flag-active'";
            }
            
            echo "<li><a href='javascript:void(0)' onclick='tabflag(this.id)' id='tab-$l->language_name' $active>$img</a></li>";
            
            $i++;
        }
        echo "</ul>";
    }
?>