<div class='boxtitle'><?php echo $title; ?></div>
<div id='boxmessage'></div>

<div id='boxbutton'> 
    <a href="javascript:void(0)" id='button' onclick="openform('system/role/add')">Add New</a>
    
    <div class='search'>
        <label>Search By</label>
        <select name='cselect' class='cinput inselect'>
            <?php
                $field = array('role_name' => 'Name');
                foreach($field as $n1 => $v1)
                {
                    echo "<option value='$n1'>$v1</option>";
                }
            ?>
        </select>
        <input type='text' name='csearch' class='cinput insearch' placeholder='Search...' onkeyup="actsearch('system/role/search')">
    </div>
    
    <div style='clear: both;'></div>
</div>

<div id='boxaction'>
    <div class='action'>
        <select name='caction' class='caction inselect'>
            <option value=''>- Select -</option>
            <?php
                $sort = array('Delete' => '1');
                foreach($sort as $n2 => $v2)
                {
                    echo "<option value='$v2'>$n2</option>";
                }
            ?>
        </select>
    </div>
    <a href="javascript:void(0)" id='button' onclick="actcheck('system/role/checked')">Action</a>
    
    <div class='limit'>
        <label>Limit</label>
        <select name='climit' class='climit inselect' onchange="actlimit('system/role/view')">
            <?php
                $l1 = array('10','25','50','100','150','200');
                foreach($l1 as $v3)
                {
                    if($this->session->userdata('limit_'.$prefix) == $v3)
                    {
                        echo "<option value='$v3' selected>$v3</option>";
                    } else {
                        echo "<option value='$v3'>$v3</option>";
                    }
                }
            ?>
        </select>
    </div>
    <div style='clear: both;'></div>
</div>

<div id='boxjq'>
    <div id='boxtable'>
        <?php $this->load->view($this->config->item('base_theme').'/role/role_table'); ?>
    </div>
    
    <?php
        if($showpage > 1)
        {
            echo "<div id='pageself'>
                    <div id='showurl' value='system/role/pagetable'></div>
                    <div id='showpage' value='$showpage'></div>
                    <div id='showoff' value='4'></div>
                    <div id='showrun' value='2'></div>
                    <div id='shownav'></div>
                  </div>";
        }
    ?>
</div>