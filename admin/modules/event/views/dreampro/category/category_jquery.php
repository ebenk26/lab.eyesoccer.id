<div id='boxjq'>
    <div id='boxtable'>
        <?php $this->load->view($this->config->item('base_theme').'/category/category_table'); ?>
    </div>
    
    <?php
        if($showpage > 1)
        {
            $sv = $this->library->sub_view();
            echo "<div id='pageself'>
                    <div id='showurl' value='news/category/pagetable".$sv->idstay."'></div>
                    <div id='showpage' value='$showpage'></div>
                    <div id='showoff' value='4'></div>
                    <div id='showrun' value='2'></div>
                    <div id='shownav'></div>
                  </div>";
        }
    ?>
</div>