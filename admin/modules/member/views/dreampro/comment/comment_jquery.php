<div id='boxjq'>
    <div id='boxtable'>
        <?php $this->load->view($this->config->item('base_theme').'/comment/comment_table'); ?>
    </div>
    
    <?php
        if($showpage > 1)
        {
            echo "<div id='pageself'>
                    <div id='showurl' value='member/pagetable'></div>
                    <div id='showpage' value='$showpage'></div>
                    <div id='showoff' value='4'></div>
                    <div id='showrun' value='2'></div>
                    <div id='shownav'></div>
                  </div>";
        }
    ?>
</div>